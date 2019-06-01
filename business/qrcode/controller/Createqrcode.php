<?php
namespace app\qrcode\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:二维码生成类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Createqrcode.php 2018-07-22 10:48:00 $
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
class Createqrcode extends CommonBase
{
    public $ConfigQrData='';//二维码配置信息
    public function _initialize(){
        parent::_initialize();
        $this->ConfigQrData=\think\Config::get('data.qr_data');
        $this->assign("ConfigQrData",$this->ConfigQrData);
    }

    /**
     * @描述：二维码生成主页页面
     */
    public function  add(){
        $ModelProduct=Db::name('product');

        //加入权限 begin
        $_whereIn=[];
        //商家管理员
        if(Session::get('admin_data_type')=='2') {
            $_whereIn['admin_id']=['in', $this->CommBusinesIDs];
        }
        //业务员
        if(Session::get('admin_data_type')=='1' and Session::get('admin_role_id')=='2'){
            $_whereIn['admin_id']=['in', $this->CommBusinesIDs];
        }
        //加入权限 end

        $_where="1";
        if($_where=='1'){$_where='';}
        $listProduct=$ModelProduct->where($_where)
            ->where($_whereIn)
            ->order('create_time DESC')
            ->select();
        $region = Db::name('region')->where('area_type',2)->field('area_name,area_code')->select();
        $this->assign('region',$region);
        $this->assign("listProduct",$listProduct);
        return $this->fetch();
    }

    /**
     * @描述：添加提交
     */
    public function insert(){
        set_time_limit(0);
        $param = $this->request->post();
        $ModelProduct=Db::name('product');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelAdmin=Db::name('admin');

        $product_id=htmlspecialchars(isset($param['product_id']) ? trim($param['product_id']) : '');
        $integral_num=htmlspecialchars(isset($param['integral_num']) ? trim($param['integral_num']) : '');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $level=htmlspecialchars(isset($param['level']) ? trim($param['level']) : 'L');
        $size=htmlspecialchars(isset($param['size']) ? intval($param['size']) : 1);
        $product_code_num=htmlspecialchars(isset($param['product_code_num']) ? intval($param['product_code_num']) : 1);
        $market_time=isset($param['market_time']) ? trim($param['market_time']) : date('Y-m-d');
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $listing_province=htmlspecialchars(isset($param['sheng']) ? trim($param['sheng']) : '');
        $listing_city=htmlspecialchars(isset($param['city']) ? trim($param['city']) : '');
        $listing_district=htmlspecialchars(isset($param['qu']) ? trim($param['qu']) : '');
        $listing_nation=empty($listing_province) ? '' : '1';
        $manufacture_date=isset($param['manufacture_date']) ? strtotime($param['manufacture_date']) : '0';
        $production_batch=htmlspecialchars(isset($param['production_batch']) ? trim($param['production_batch']) : '');
        $business_enterprise=htmlspecialchars(isset($param['business_enterprise']) ? trim($param['business_enterprise']) : '');
        $contacts=htmlspecialchars(isset($param['contacts']) ? trim($param['contacts']) : '');
        $tel=htmlspecialchars(isset($param['tel']) ? trim($param['tel']) : '');
        $gettime=time();
        $admin_id=Session::get('adminid') ;
        $market_time=strtotime($market_time);
        //提交类型(0:普通提交；1：生成并下载(TXT)；)
        $actionType=isset($param['actionType']) ? intval($param['actionType']) : 0;
        if($actionType == 1 or $actionType == 2){
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
        }

        if(empty($product_id) or empty($title)
        ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }

        //二维码生成处理  begin
        //临时图片的存放目录
        $_dateYMD=date('Ymd');
        $PNG_TEMP_DIR=config('upload_config.upload_root').'qrcode/'.$product_id.'/';
        //创建目录
        if (!file_exists($PNG_TEMP_DIR)) {  mkdir($PNG_TEMP_DIR);  }
        $PNG_TEMP_DIR=$PNG_TEMP_DIR.$_dateYMD.'/';
        if (!file_exists($PNG_TEMP_DIR)) {  mkdir($PNG_TEMP_DIR);  }

        //目录
        $PNG_WEB_DIR = config('upload_config.upload_root').'qrcode/'.$product_id.'/'.$_dateYMD.'/';
        include_once './extend/lib/qrcode/qrlib.php';

        // 开启事务
        Db::startTrans();
        //处理表单
        $errorCorrectionLevel = 'L';
        if (in_array($level, array('L','M','Q','H')))
            $errorCorrectionLevel = $level;

        $matrixPointSize = 4;
        $matrixPointSize = min(max((int)$size, 1), 10);

        //积分码的总积分
        $num = $product_code_num*$integral_num;
        $product_code_id=my_returnUUID();
        $data=array(
            'product_code_id'=>$product_code_id,
            'product_id'=>$product_id,
            'title'=>$title,
            'manufacture_date'=>$manufacture_date,
            'production_batch'=>$production_batch,
            'market_time'=>$market_time,
            'product_code_begin'=>1,
            'product_code_end'=>$product_code_num,
            'product_code_num'=>$product_code_num,
            'listing_nation'=>$listing_nation,
            'listing_province'=>$listing_province,
            'listing_city'=>$listing_city,
            'listing_district'=>$listing_district,
            'business_enterprise'=>$business_enterprise,
            'contacts'=>$contacts,
            'tel'=>$tel,
            'admin_id'=>$admin_id,
            'data_desc'=>$data_desc,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
            'integral_num'=>$integral_num,
            'num'=>$num,
        );
        $ReturnID=$ModelProductCode->insert($data);
        if(!$ReturnID){
            Db::rollback();//事务回滚
            echo 'error:操作失败！';
            exit;
        }
        $qrurl_data=$this->ConfigQrData['web_host'].'pro/';

        //有提交生成数据
        /*for($i=1; $i<=$product_code_num; $i++){
            $_product_code_info_id=my_returnUUID();
            $_qrurl_data=$qrurl_data.$_product_code_info_id;
            $filename = $PNG_TEMP_DIR.'sy'.md5($_qrurl_data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

            //产品暗码(16位，大写)
            $_code_cipher=substr(md5($product_id.my_returnUUID()),8,16);
            $_code_cipher=strtoupper($_code_cipher);
            $data_product_code_info=array(
                'product_code_info_id'=>$_product_code_info_id,
                'product_code_id'=>$product_code_id,
                'product_id'=>$product_id,
                'images'=>substr($filename,1),
                'code_plain'=>$i,
                'code_cipher'=>$_code_cipher,
                'admin_id'=>$admin_id,
                'create_time'=>$gettime,
                'update_time'=>$gettime,
            );
            $ModelProductCodeInfo->insert($data_product_code_info);

            $_msg=QRcode::png($_qrurl_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        }*/
        $fileContent='';
        $dataAll=array();
        for ($i=1; $i<=$product_code_num; $i++){
            $_product_code_info_id=my_returnUUID();
            $_compress_code=substr(md5($_product_code_info_id),8,16);
            $_qrurl_data=$qrurl_data.$_compress_code;
            $filename = $PNG_TEMP_DIR.'sy'.md5($_qrurl_data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

            //产品暗码(16位，大写)
            $_code_cipher=substr(md5($product_id.my_returnUUID()),8,16);
            $_code_cipher=strtoupper($_code_cipher);
            $data_product_code_info=array(
                'product_code_info_id'=>$_product_code_info_id,
                'product_code_id'=>$product_code_id,
                'product_id'=>$product_id,
                'images'=>substr($filename,1),
                'code_plain'=>$i,
                'code_cipher'=>$_code_cipher,
                'admin_id'=>$admin_id,
                'qr_level'=>$errorCorrectionLevel,
                'qr_size'=>$matrixPointSize,
                'compress_code'=>$_compress_code,
                'create_time'=>$gettime,
                'update_time'=>$gettime,
                'integral_num'=>$integral_num,
                'num'=>$num,
            );
            $data_product_code_info['images']='';
            if($actionType == 1) {
                $str=$_qrurl_data;
            }else if($actionType == 2){
                $str=$_code_cipher;
            }else{
                $str=$_qrurl_data;
            }
            if($actionType == 1 or $actionType == 2){
                //$data_product_code_info['qr_open_time']=$gettime;
                //$data_product_code_info['data_status']=1;
            }
            array_push($dataAll,$data_product_code_info);
            if($i % 1000 == 0 or $i == $product_code_num){
                $ReturnID=$ModelProductCodeInfo->insertAll($dataAll);
                $dataAll=array();
                if(!$ReturnID){
                    Db::rollback();//事务回滚
                    echo 'error:操作失败！';
                    exit;
                }
            }
            //2018-12-10 改成查询时生成
            //$_msg=QRcode::png($_qrurl_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            $fileContent .= $str . "\r\n";
        }
        //二维码生成处理 end
        Db::commit();//提交事务
        if($actionType == 1 or $actionType == 2) {
            $filename = $title . '_' . $product_code_num . ".txt";
            $encoded_filename = urlencode($filename);
            $encoded_filename = str_replace("+", "%20", $encoded_filename);
            if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
                header('Content-Disposition:  attachment; filename="' . $encoded_filename . '"');
            } elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {
                header('Content-Disposition: attachment; filename*="utf8' . $filename . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $filename . '"');
            }
            echo "$fileContent";
        }else {
            if ($ReturnID) {
                $this->success("操作成功", url("productcode/index"), 3);
            } else {
                $this->error("操作失败", url("productcode/index"), 3);
            }
        }
        exit;
    }
    /**
     * @描述：查询省下面的市
     */
    public function shi()
    {
        $param = $this->request->post();
       $shi = Db::name('region')
           ->where('area_parent_id',isset($param['shi']['area_code']) ? $param['shi']['area_code'] : $param['shi'])
           ->field('area_name,area_code')
           ->select();
       return json($shi);

    }

}