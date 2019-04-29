<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 15:18
 */

namespace app\money\controller;

use think\Controller;
use think\Loader;

class Pay extends Controller
{
    public function pagePay()
    {
        Loader::import('demo.index',EXTEND_PATH,'.php');
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($_POST['out_trade_no']);
        //订单名称，必填
        $subject = trim($_POST['subject']);
        //付款金额，必填 
        $total_amount = trim($_POST['total_amount']);
        //商品描述，可空
        //$body = trim($_POST['body']);
        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        // $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $aop = new \AlipayTradeService();
        /**
         *      * pagePay 电脑网站支付请求
         *      * @param $builder 业务参数，使用buildmodel中的对象生成。
         *      * @param $return_url 同步跳转地址，公网可以访问
         *      * @param $notify_url 异步通知地址，公网可以访问
         *      * @return $response 支付宝返回的信息
         *     */
        $response = $aop->pagePay($payRequestBuilder, config('alipay.return_url'), config('alipay.notify_url'));
    }

    //回调地址
    public function notify_url()
    {
        $arr = $_POST;
        $alipaySevice = new \AlipayTradeService();
        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);

        if ($result) {

            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";//请不要修改或删除
        } else {
            //验证失败
            echo "fail";

        }
    }
}