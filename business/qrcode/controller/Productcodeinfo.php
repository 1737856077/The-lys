<?php
namespace app\qrcode\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品-二维码详细信息类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Productcodeinfo.php 2018-07-22 15:52:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonBase;
use lib\qrcode\QRcode;
use lib\qrcode\QRtools;
class Productcodeinfo extends CommonBase
{
    public $ConfigQrData='';//二维码配置信息
    public function _initialize(){
        parent::_initialize();
        $this->ConfigQrData=\think\Config::get('data.qr_data');
        $this->assign("ConfigQrData",$this->ConfigQrData);
    }
    /**
     * @描述：信息列表页面
     */
    public function index(){
        $param = $this->request->param();
        //查询
        $product_code_id = isset($param['product_code_id']) ? trim(htmlspecialchars(urldecode($param['product_code_id']))) : '' ;
        $search_code_plain = isset($param['search_code_plain']) ? trim(htmlspecialchars(urldecode($param['search_code_plain']))) : '' ;
        $search_code_cipher = isset($param['search_code_cipher']) ? trim(htmlspecialchars(urldecode($param['search_code_cipher']))) : '' ;
        $search_code_cipher=strtoupper($search_code_cipher);
        if(empty($product_code_id)){echo 'param error!';exit;}

        $paramUrl='';
        $this->assign("product_code_id",$product_code_id);
        $this->assign("search_code_plain",$search_code_plain);
        $this->assign("search_code_cipher",$search_code_cipher);

        $ModelProduct=Db::name('product');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelAdmin=Db::name('admin');

        //查询产品码信息
        $getoneProductCode=$ModelProductCode->where("product_code_id='$product_code_id'")->find();
        $this->assign("getoneProductCode",$getoneProductCode);
        if(empty($getoneProductCode)){echo 'param error!';exit;}

        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCode[product_id]'")->find();
        $this->assign("getoneProduct",$getoneProduct);
        if(empty($getoneProduct)){echo 'param error!';exit;}

        $_where="1";
        $_where .= " AND product_code_id='$product_code_id' ";
        if(!empty($search_code_plain)){  $_where .= " AND code_plain='$search_code_plain' ";    }
        if(!empty($search_code_cipher)){  $_where .= " AND code_cipher='$search_code_cipher' ";    }

        if($_where=='1'){$_where='';}
        $count = $ModelProductCodeInfo->where($_where)
            ->count();

        $resultArr=array();
        $List=$ModelProductCodeInfo->where($_where)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();
        //查看二维码图片是否已生成
        //二维码生成处理  begin
        //临时图片的存放目录
        $_dateYMD=date('Ymd');
        $PNG_TEMP_DIR=config('upload_config.upload_root').'qrcode/'.$getoneProductCode['product_id'].'/';
        //创建目录
        if (!file_exists($PNG_TEMP_DIR)) {  mkdir($PNG_TEMP_DIR);  }
        $PNG_TEMP_DIR=$PNG_TEMP_DIR.$_dateYMD.'/';
        if (!file_exists($PNG_TEMP_DIR)) {  mkdir($PNG_TEMP_DIR);  }

        //目录
        $PNG_WEB_DIR = config('upload_config.upload_root').'qrcode/'.$getoneProductCode['product_id'].'/'.$_dateYMD.'/';
        include_once './extend/lib/qrcode/qrlib.php';

        $qrurl_data=$this->ConfigQrData['web_host'].'integral.php/index/index/index?code_info_id=';
        $_List=array();
        foreach ($List as $key=>$value){
            $errorCorrectionLevel=empty($value['qr_level']) ? 'L' : $value['qr_level'] ;
            $matrixPointSize=empty($value['qr_size']) ? 1 : $value['qr_size'];
            if(empty($value['images'])){
                //重新生成二维码图片
                $_product_code_info_id=my_returnUUID();
                $_qrurl_data=$qrurl_data.$value['compress_code'];
                $filename = $PNG_TEMP_DIR.'sy'.md5($_qrurl_data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                $_msg=QRcode::png($_qrurl_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                //更新images内容
                $_images = substr($filename,1);
                $ModelProductCodeInfo->where("product_code_info_id='$value[product_code_info_id]'")->update(array('images'=>$_images));
                $value['images']=$_images;
            }
            $_List[]=$value;
        }
        //二维码生成处理  end
        $this->assign("count",$count);
        $this->assign("list",$_List);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }

    /**
     * @描述：开启二维码-操作处理
     */
    public function savestatus(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        $ModelProduct=Db::name('product');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $gettime=time();
        $_data=array('data_status'=>'1',
            "qr_open_time"=>$gettime,
            "update_time"=>$gettime);

        $getone = $ModelProductCodeInfo->where("product_code_info_id='$id'")->find();
        if($param["action"]=="checkStatus"){//设置状态
            $Status=isset($param['Status']) ? intval($param['Status']) : 1 ;
            $ModelProductCodeInfo->where("product_code_info_id='$id'")->update($_data);
        }
        //全选 all
        if($param["action"]=="save"){
            $sqt=isset($param['sqt']) ? $param['sqt'] : array();
            $IDs=isset($param['IDs']) ? $param['IDs'] : array();
            $SortRank=isset($param['SortRank']) ? $param['SortRank'] : array();
            $checkclass=$param['checkclass'];

            if($checkclass=="31"){//开启二维码
                if(count($sqt)){
                    foreach($sqt as $id){
                        $ModelProductCodeInfo->where("product_code_info_id='$id'")->update($_data);
                    }
                }
            }/*else if($checkclass=="32"){//取消开启二维码
                if(count($sqt)){
                    foreach($sqt as $id){
                        $ModelProductCodeInfo->where("product_code_info_id='$id'")->setField('data_status',"0");
                    }
                }

            }*/
            if(count($sqt)) {
                $getone = $ModelProductCodeInfo->where("product_code_info_id='$sqt[0]'")->find();
            }else{
                echo '<script language="javascript">alert("未选择数据！请选择数据后再操作");history.go(-1);</script>';
            }
        }
        $this->success("操作成功",url("productcodeinfo/index").'?product_code_id='.$getone['product_code_id'],3);
        exit;
    }

    /**
     * @描述：下载TXT
     */
    public function downloadtxt(){
        set_time_limit(0);
        $param = $this->request->param();
        //查询
        $product_code_id = isset($param['product_code_id']) ? trim(htmlspecialchars(urldecode($param['product_code_id']))) : '' ;
        $actionType = isset($param['actionType']) ? intval($param['actionType']) : '1' ;
        if(empty($product_code_id)){echo 'param error!';exit;}
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");

        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        //取得sy_product_code 产品码表
        $getoneProductCode=$ModelProductCode->where("product_code_id='$product_code_id'")->find();
        if(empty($getoneProductCode)){
            echo '数据错误[ProductCode]!';exit;
        }
        //所有此product_code_id下的所有码
        $product_code_num=$count=$ModelProductCodeInfo->where("product_code_id='$product_code_id'")->count();
        $list=$ModelProductCodeInfo->where("product_code_id='$product_code_id'")->order('id ASC')->select();
        $qrurl_data=$this->ConfigQrData['web_host'].'integral.php/index/index/index?code_info_id=';

        $fileContent='';
        foreach ($list as $key=>$value){
            $_qrurl_data=$qrurl_data.$value['compress_code'];
            if($actionType == 2){
                $str = $value['code_cipher'];
            }else {
                $str = $_qrurl_data;
            }
            $fileContent.=$str."\r\n";
        }

        $filename = $getoneProductCode['title'].'_'.$product_code_num.".txt";
        $encoded_filename = urlencode($filename);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']) ) {
            header('Content-Disposition:  attachment; filename="' . $encoded_filename . '"');
        } elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition: attachment; filename*="utf8' .  $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename="' .  $filename . '"');
        }
        echo "$fileContent";
        exit;
    }

    /**
     * @描述：下载TXT
     */
    public function comupdatecode(){
        set_time_limit(0);
        $ModelProductCodeInfo=Db::name('product_code_info');
        $list=$ModelProductCodeInfo->where("compress_code=''")->select();
        foreach ($list as $key=>$value){
            $ModelProductCodeInfo->where("product_code_info_id='$value[product_code_info_id]'")
                ->update(array('compress_code'=>substr(md5($value['product_code_info_id']),8,16)));
        }
        echo 'ok['.count($list).']';
    }
}