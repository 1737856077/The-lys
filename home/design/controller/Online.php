<?php
namespace app\design\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-用户注册
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Register.php 2019-02-28 19:32:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;
//use think\response\Xml;
class Online extends CommonBaseHome
{
    /**
     * @描述：初始化函数
    */
    public function  _initialize(){
        parent::_initialize();

        if(!Session::has('username') and !Session::has('adminname')){
            echo "<script language=\"javascript\">alert(\"请登录！\");window.open('/index.php/member/register/login','_top');</script>";
        }
        $adminId = intval(isset($_POST['adminId']) ? $_POST['adminId'] : (isset($_GET['adminId']) ? $_GET['adminId'] : 0)) ;
        // 查看是否管理员编辑或新增
        if($adminId){
            if($adminId!=Session::get('adminid')){
                echo "<script language=\"javascript\">alert(\"请登录！\");window.open('/index.php/member/register/login','_top');</script>";
            }
        }
    }

    public function index(){
        $param = $this->request->param();
        // 取得模版ID
        $templateId = intval(isset($param['templateId']) ? $param['templateId'] : 0) ;
        $adminId = intval(isset($param['adminId']) ? $param['adminId'] : 0) ;
        $this->assign("templateId",$templateId);
        $this->assign("adminId",$adminId);

        $modelTemplate=Db::name('template');
        $modelTemplateContent=Db::name('template_content');
        $getoneTemplate=$getoneTemplateContent=array();
        // 初始化模版信息
        if($templateId){
            $getoneTemplate=$modelTemplate->where("template_id='$templateId'")->find();
            if(empty($getoneTemplate)){
                echo '数据错误！'; exit;
            }
            $getoneTemplateContent=$modelTemplateContent->where("template_id='$templateId'")->find();
        }

        $memberId = Session::get('memberid');
        $this->assign("memberId",$memberId);
        $this->assign("getoneTemplate",$getoneTemplate);
        $this->assign("getoneTemplateContent",$getoneTemplateContent);
        return $this->fetch();
    }

    public function save(){
        $param = $this->request->post();
        $templateId = intval(isset($param['templateId']) ? $param['templateId'] : 0) ;
        $adminId = intval(isset($param['adminId']) ? $param['adminId'] : 0) ;
        $memberId = intval(isset($param['memberId']) ? $param['memberId'] : 0) ;
        $templateXML = isset($param['templateXML']) ? $param['templateXML'] : '' ;
        print_r($templateXML);
        exit;
        $templateImg = isset($param['templateImg']) ? $param['templateImg'] : '' ;
        $templatePdf = isset($param['templatePdf']) ? $param['templatePdf'] : '' ;
        $templateLabelShape = intval(isset($param['templateLabelShape']) ? $param['templateLabelShape'] : 0) ;
        $templateLabelSizeWide = intval(isset($param['templateLabelSizeWide']) ? $param['templateLabelSizeWide'] : 0) ;
        $templateLabelSizeHeight = intval(isset($param['templateLabelSizeHeight']) ? $param['templateLabelSizeHeight'] : 0) ;
        $graphDataPng = isset($param['graphDataPng']) ? $param['graphDataPng'] : '' ;
        $title = htmlspecialchars(isset($param['title']) ? $param['title'] : 'test') ;
        $title = 'test';
        $gettime=time();
        //print_r($param);
        //exit;
        if((!$adminId and !$memberId) or empty($title)){
            echo '<script language="javascript">alert("参数错误，请重新提交！");history.go(-1);</script>';
            exit;
        }
        $modelTemplate=Db::name('template');
        $modelTemplateContent=Db::name('template_content');

        // 统计二维码、条形码个数(rounded:一维码；triangle：二维码；)
        //rounded:一维码；
        $qrOneTotal = 0;
        //triangle：二维码；
        $qrTwoTotal = 0;
        // 解析XML begin
        $pXML = xml_parser_create();
        xml_parse_into_struct($pXML, $templateXML, $valsXML, $indexXML);
        xml_parser_free($pXML);
        foreach ($valsXML as $key=>$val){
            if($val['level'] == 3){
                if(isset($val['attributes'])) {
                    //print_r($val['attributes']);
                    $_attributes=$val['attributes'];
                    if(isset($_attributes['STYLE'])){
                        $_style= $_attributes['STYLE'];
                        if(!empty($_style)){
                            if(substr_count($_style,';')){
                                $_style=explode(';',$_style);
                                foreach ($_style as $k=>$v){
                                    if(substr_count($v,'=')) {
                                        $_shape = explode('=', $v);
                                        if ($_shape[0] == 'shape') {
                                            //echo $_shape[1];
                                            if($_shape[1] == 'rounded'){
                                                $qrOneTotal++;
                                            }else if($_shape[1] == 'triangle'){
                                                $qrTwoTotal++;
                                            }
                                        }
                                    }
                                }
                            }else{
                                if(substr_count($_style,'=')) {
                                    $_shape = explode('=', $_style);
                                    if ($_shape[0] == 'shape') {
                                        //echo $_shape[1];
                                        if($_shape[1] == 'rounded'){
                                            $qrOneTotal++;
                                        }else if($_shape[1] == 'triangle'){
                                            $qrTwoTotal++;
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            }
        }
        // 解析XML end

        // 查看是管理员还是会员
        // 模版分类（0：公共模版；1：定制模版）
        $template_code=my_returnUUID();
        $data_type = $adminId>0 ? 1 : 0;
        $img = base64_image_content($graphDataPng, "static/uploads/template/".date('Ymd').'/');
        $code_type = 0;
        if($qrOneTotal and $qrTwoTotal){
            $code_type = 2;
        }else if($qrTwoTotal){
            $code_type = 0;
        }else if($qrOneTotal){
            $code_type = 1;
        }
        $bar_code_total = $qrOneTotal + $qrTwoTotal;

        // 更新
        if($templateId){
            $data = array(
                'title' => $title,
                'img' => $img,
                'bar_code_total' => $bar_code_total,
                'code_type' => $code_type,
                'pdf' => $templatePdf,
                'xml' => $templateXML,
                'update_time' => $gettime,
            );
            $modelTemplate->where("template_id='$templateId'")->update($data);

        }else {/*insert*/

            $data = array(
                'template_code' => $template_code,
                'title' => $title,
                'img' => $img,
                'member_id' => $memberId,
                'admin_id' => $adminId,
                'bar_code_total' => $bar_code_total,
                'code_type' => $code_type,
                'pdf' => $templatePdf,
                'xml' => $templateXML,
                'data_type' => $data_type,
                'data_status' => 1,
                'create_time' => $gettime,
                'update_time' => $gettime,
            );
            $templateId = $modelTemplate->insertGetId($data);
        }


        $this->success("操作成功","/index.php/index/templates/content".'?template_id='.$templateId,3);
        exit;
    }
}
?>