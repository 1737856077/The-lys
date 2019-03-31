<?php
namespace app\order\controller;
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
use app\common\controller\CommonBase;
class Preorder extends CommonBase
{
    /**
     * @描述：初始化函数
     */
    public function  _initialize(){
        parent::_initialize();

        // 打印模式
        $this->assign("ConfigPreorderPrintMode", \think\Config::get('data.preorder_print_mode'));
        // 排序方式
        $this->assign("ConfigPreorderPrintSort", \think\Config::get('data.preorder_print_sort'));
    }

    /**
     * @desc: 显示下单信息
     */
    public function index(){
        $param = $this->request->param();
        $templateId=intval(isset($param['templateId']) ? trim($param['templateId']) : '0');
        if(!$templateId){echo '非法操作！';exit;}
        $this->assign("memberid",Session::get('memberid'));

        // 查询模版信息
        $ModelTemplate=Db::name('template');
        $ModelTemplateContent=Db::name('template_content');
        $ModelPaper=Db::name('paper');

        $getoneTemplate=$ModelTemplate->where("template_id='$templateId'")->find();
        $getoneTemplateContent=$ModelTemplateContent->where("template_id='$getoneTemplate[template_id]'")->find();
        $this->assign("getoneTemplate",$getoneTemplate);
        $this->assign("getoneTemplateContent",$getoneTemplateContent);

        // 查询纸张信息
        $listPaper=$ModelPaper->where("data_status='1'")->order('sort_rank ASC,id ASC')->select();
        $this->assign("listPaper",$listPaper);

        return $this->fetch();
    }

    /**
     * @desc: 提交订单
     */
    public function suborder(){
        $param = $this->request->post();
        $memberid=intval(isset($param['memberid']) ? trim($param['memberid']) : '0');
        $templateId=intval(isset($param['templateId']) ? trim($param['templateId']) : '0');
        $printNum=intval(isset($param['printNum']) ? trim($param['printNum']) : '0');
        $printMode=intval(isset($param['printMode']) ? trim($param['printMode']) : '0');
        $printSort=intval(isset($param['printSort']) ? trim($param['printSort']) : '0');
        $paperId=intval(isset($param['paperId']) ? trim($param['paperId']) : '0');
        $gettime=time();

        if(!$memberid or !$printNum or !$templateId or !$paperId ){
            echo '<script language="javascript">alert("参数错误！");history.go(-1);</script>';
            exit;
        }

        $ModelMember=Db::name('member');
        $ModelTemplate=Db::name('template');
        $ModelTemplateContent=Db::name('template_content');
        $ModelPaper=Db::name('paper');

        $getoneMember=$ModelMember->where("member_id='$memberid'")->find();
        $getoneTemplate=$ModelTemplate->where("template_id='$templateId'")->find();
        $getoneTemplateContent=$ModelTemplateContent->where("template_id='$templateId'")->find();
        $getonePaper=$ModelPaper->where("id='$paperId'")->find();
        if(empty($getoneMember) or empty($getoneTemplate) or empty($getoneTemplateContent) or empty($getonePaper) ){
            echo '<script language="javascript">alert("参数错误！");history.go(-1);</script>';
            exit;
        }
        //计算费用
        $_priceTotal = 0.00;
        $_price = 0.00;
        // 用户自定义的纸张，后台手动计算价格
        if($getonePaper['data_type'] == 1){
            $_price = 0.00;
        }else{
            if($printNum > 500){
                $_price = $getonePaper['price_three'];
            }else if($printNum > 100){
                $_price = $getonePaper['price_two'];
            }else{
                $_price = $getonePaper['price_one'];
            }
        }
        // 计算总费用
        $_priceTotal=price($printNum*$_price,2);

        // 开启事务
        Db::startTrans();
        //Db::rollback();//事务回滚
        // 1\insert order 订单表==写入订单表
        $dataOrder=array('order_no'=>$order_no,
            'template_id'=>$getoneTemplate['template_id'],
            'template_title'=>$getoneTemplate['title'],
            'print_num'=>$printNum,
            'price'=>$_priceTotal,
            'name'=>$getoneMember['real_name'],
            'email'=>$getoneMember['email'],
            'moblie'=>$getoneMember['mobile'],
            'score_pay'=>$_priceTotal,
            'score_real_pay'=>$_priceTotal,
            'member_id'=>$getoneMember['member_id'],
            'username'=>$getoneMember['username'],
            'pay_flag'=>'1',
            'paper_size_long'=>$getoneTemplateContent['paper_size_long'],
            'paper_size_wide'=>$getoneTemplateContent['paper_size_wide'],
            'paper_size_unit'=>$getoneTemplateContent['paper_size_unit'],
            'paper_direction'=>$getoneTemplateContent['paper_direction'],
            'print_mode'=>$printMode,
            'print_sort'=>$printSort,
            'down_pdf'=>$getoneTemplate['pdf'],
            'create_time'=>$gettime,
            'update_time'=>$gettime
            );

        //提交事务
        Db::commit();
        exit;
    }
}