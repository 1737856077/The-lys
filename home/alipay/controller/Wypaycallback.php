<?php
namespace app\alipay\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:用户缴费支付完成后开发者系统接受支付结果通知的回调地址处理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Wypaycallback.php 2018-04-06 14:58:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Loader;
use \app\common\controller\CommonBase;
use lib\AlipaySDK\AopClient;
use lib\AlipaySDK\SignData;
class Wypaycallback extends CommonBase
{
    public function index(){
        $param = $this->request->param();
        PublicLogWrite('log.txt','Wypaycallback.php2--'.json_encode($param));
        //exit;
        // 开启事务
        Db::startTrans();
        //提交支付宝，创建小区
        $app_id=config('wuye.app_id');//
        $rsaPrivateKey=config('wuye.rsaPrivateKey');//请填写开发者私钥去头去尾去回车，一行字符串
        $alipayrsaPublicKey=config('wuye.alipayrsaPublicKey');//请填写支付宝公钥，一行字符串
        $url=config('wuye.url');

        $aop = new AopClient ();
        $aop->gatewayUrl = $url;
        $aop->appId = $app_id;
        $aop->rsaPrivateKey = $rsaPrivateKey;//请填写开发者私钥去头去尾去回车，一行字符串
        $aop->alipayrsaPublicKey=$alipayrsaPublicKey;//请填写支付宝公钥，一行字符串
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='utf-8';
        $aop->format='json';
        $result=$aop->rsaCheckV2($param,null);

        $bizContent = "";
        if($result){
            PublicLogWrite('log.txt','rsaCheckV2-ok');
        }
        //验签成功
        /*if($result){*/
            //echo "成功";
            $ModelBillDetailsNotify=Db::name('bill_details_notify');
            $ModelBillDetails=Db::name('bill_details');
            $ModelCompany=Db::name('company');

            $bizContent = "{\"econotify\":\"success\"}";

            //1、判断订单号det_list字段、total_amount是否确实为该订单包含的缴费明细项编号汇总（det_list字段）的实际金额。
            //查看订单是一条还是多条
            $return_det_list=explode('|',$param['det_list']);
            $return_det_list=implode("','",$return_det_list);
            //PublicLogWrite('log.txt','return_det_list-打印'.$return_det_list);
            $listBillDetails=$ModelBillDetails->where("bill_entry_id IN ('".$return_det_list."')")->select();
            //PublicLogWrite('log.txt','listBillDetails-打印'.$ModelBillDetails->getLastSql());
            //2、校验通知中的seller_id 是否是实际物业收款账号。
            $countCompany=$ModelCompany->where("user_id='$param[seller_id]'")->count();
            if(!$countCompany){
                Db::rollback();//事务回滚
                PublicLogWrite('log.txt','物业收款账号seller_id-错误'.json_encode($param));
            }
            //验证订单号
            if(!count($listBillDetails)){
                Db::rollback();//事务回滚
                PublicLogWrite('log.txt','订单号det_list-错误'.json_encode($param));
            }
            //统计总金额
            $sumBillDetailsAmountTotal=$ModelBillDetails->where("bill_entry_id IN ('".$return_det_list."')")->sum('bill_entry_amount');
            //PublicLogWrite('log.txt','sumBillDetailsAmountTotal-打印'.$ModelBillDetails->getLastSql());
            if($sumBillDetailsAmountTotal!=$param['total_amount']){
                Db::rollback();//事务回滚
                PublicLogWrite('log.txt','订单金额total_amount-错误'.json_encode($param));
            }

            //插入回调通知表
            $gettime=time();

            $data=$param;
            unset($data['charset']);
            unset($data['service']);
            unset($data['sign']);
            unset($data['sign_type']);
            unset($data['_request_path']);

            $data['create_time']=$gettime;
            $data['update_time']=$gettime;
            $returnID=$ModelBillDetailsNotify->insert($data);

            if(!$returnID){
                Db::rollback();//事务回滚
                PublicLogWrite('log.txt','Wypaycallback-新增失败：wy_bill_details_notify账单支付异步通知信息记录表'.json_encode($returnID));
            }

            foreach ($listBillDetails as $key=>$val){
                $getoneBillDetails=$val;
                //查看是否已对过账
                if($getoneBillDetails['bill_status']!='FINISH_PAYMENT'){
                    //TRADE_SUCCESS：交易支付成功；TRADE_FINISHED：交易结束，不可退款；
                    if($param['trade_status']=='TRADE_FINISHED' or $param['trade_status']=='TRADE_SUCCESS' ){

                        $dataBillDetails=array('bill_status'=>'FINISH_PAYMENT',
                            'pay_time'=>$data['gmt_payment'],
                            'update_time'=>$gettime,
                        );
                        $returnID=$ModelBillDetails->where("bill_entry_id='$getoneBillDetails[bill_entry_id]'")->update($dataBillDetails);

                        if($returnID===false){
                            Db::rollback();//事务回滚
                            PublicLogWrite('log.txt','Wypaycallback-更新失败：wy_bill_details账单详细表'.json_encode($returnID));
                        }
                    }else{
                        PublicLogWrite('log.txt','交易状态错误-'.json_encode($param));
                    }
                }else{
                    PublicLogWrite('log.txt','订单已更新过-bill_status'.json_encode($param));
                }
            }



        /*} else {
            Db::rollback();//事务回滚
            PublicLogWrite('log.txt','rsaCheckV2-error'.json_encode($result));
            //echo "失败";
        }*/
        $encryptAndSign=$aop->encryptAndSign($bizContent,null,$rsaPrivateKey,'utf-8',false,true);
        /*$encryptAndSign=str_replace('<?xml version="1.0" encoding="utf-8"?>','',$encryptAndSign);*/
        echo $encryptAndSign;
        PublicLogWrite('log.txt','encryptAndSign-'.$encryptAndSign);
        Db::commit();//提交事务

    }

    public function testrsa(){
        $josn='{"gmt_create":"2018-05-18 22:07:07","det_list":"WY20180510155813KRGU929133","charset":"UTF-8","notify_time":"2018-05-18 22:07:12","gmt_payment":"2018-05-18 22:07:12","sign":"PiFEFTxXfBBKDd65vaxmif4OYaaj2AcTzUzsQ94fSsCPZFDoXi\/TEg6Y3WgoqwP8+Lgsa0MxIDYQdmQ2swMuDNWb2bdzhI62MAyEhAXl\/\/ejj4WmNDfYa7ly\/kzbUPRYC3jXav8FCPbTIJEepnRpAKMG8JqPuELVGcGaezryV14=","body":"A543WP1B54101020008020804|A543WP1B54101|ad2367566353fe7cb095c7eaa64f7158","buyer_user_id":"2088202373710542","fund_bill_list":"[{\"amount\":\"0.01\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","total_amount":"0.01","service":"alipay.industry.car.appid.invoke","refund_fee":"0","trade_status":"TRADE_SUCCESS","trade_no":"2018051821001004540546901531","buyer_logon_id":"814***@qq.com","receipt_amount":"0.01","sign_type":"RSA","seller_id":"2088621215884140","_request_path":"https:\/\/zhihuiwuye.sindns.com\/index.php\/alipay\/wypaycallback\/index"}';
        $param=json_decode($josn);
        $param=(Array)$param;
        //$param['fund_bill_list']=json_decode($param['fund_bill_list']);
        //$param['fund_bill_list']=(Array)$param['fund_bill_list'];
        //$param['fund_bill_list'][0]=(Array)$param['fund_bill_list'][0];
        //print_r($param);exit;

        $app_id=config('wuye.app_id');//
        $rsaPrivateKey=config('wuye.rsaPrivateKey');//请填写开发者私钥去头去尾去回车，一行字符串
        //$alipayrsaPublicKey=config('wuye.alipayrsaPublicKey');//请填写支付宝公钥，一行字符串
        $alipayrsaPublicKey='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';
        $url=config('wuye.url');

        $aop = new AopClient ();
        $aop->gatewayUrl = $url;
        $aop->appId = $app_id;
        $aop->rsaPrivateKey = $rsaPrivateKey;//请填写开发者私钥去头去尾去回车，一行字符串
        $aop->alipayrsaPublicKey=$alipayrsaPublicKey;//请填写支付宝公钥，一行字符串
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='utf-8';
        $aop->format='json';
        $result=$aop->rsaCheckV1($param,null,'RSA');
        //PublicLogWrite('log.txt',json_encode($result));
        $bizContent = "";
        //echo $result;exit;
        //验签成功
        if($result){
            echo 1;
        }else{
            echo 0;
        }
        $bizContent = "{\"econotify\":\"success\"}";
        echo $aop->encryptAndSign($bizContent,$alipayrsaPublicKey,$rsaPrivateKey,'utf-8',false,true);

    }

    public function testpost(){
        $url='/index.php/alipay/wypaycallback/index';
        $data='{"gmt_create":"2018-05-20 12:00:43","det_list":"WY20180510155907DTJP625127","charset":"UTF-8","notify_time":"2018-05-20 12:00:52","gmt_payment":"2018-05-20 12:00:51","sign":"ESe9lYCg4CQ5gVZXaemHvfjYWYcvHpz6ro5B3rGmiXc5krOI8abv0XEc5v9P1Vc+eBULC+IBvzEOrc5DrmOJFta2nqp840ONQ+eE3IW6ey58Uwa0pF82dzXTwQL6NF4KFYZxc2Shp19b1Iqfh6+lTSLWPyXgzE3v2ACOlv5GpDY=","body":"A543WP1B54101020008020804|A543WP1B54101|ad2367566353fe7cb095c7eaa64f7158","buyer_user_id":"2088202373710542","fund_bill_list":"[{\"amount\":\"0.01\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","total_amount":"0.01","service":"alipay.industry.car.appid.invoke","refund_fee":"0","trade_status":"TRADE_SUCCESS","trade_no":"2018052021001004540554245890","buyer_logon_id":"814***@qq.com","receipt_amount":"0.01","sign_type":"RSA","seller_id":"2088621215884140","_request_path":"https:\/\/zhihuiwuye.sindns.com\/index.php\/alipay\/wypaycallback\/index"}';
        echo '['.$this->PostSend($url,json_decode($data)).']';
        exit;
    }

    //模拟POST提交
    public function PostSend($url,$data,$method="POST"){
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, $method );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $tmpInfo = curl_exec ( $ch );
        if (curl_errno ( $ch )) {
            return curl_error ( $ch );
        }
        curl_close ( $ch );
        return $tmpInfo;
    }
}