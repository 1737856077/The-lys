<?php
namespace app\money\controller;
use think\Controller;
use think\Db;
use think\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/23
 * Time: 14:03
 */

class Pay extends Controller
{
    /**
     * @return 支付接口
     */
    public function pay()
    {
        $aop = new AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = 'your app_id';
        $aop->rsaPrivateKey = '请填写开发者私钥去头去尾去回车，一行字符串';
        $aop->alipayrsaPublicKey='请填写支付宝公钥，一行字符串';
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='GBK';
        $aop->format='json';
        $request = new AlipayTradeWapPayRequest ();
        $request->setBizContent("{" .
            "\"body\":\"对一笔交易的具体描述信息。如果是多种商品，请将商品描述字符串累加传给body。\"," .
            "\"subject\":\"大乐透\"," .
            "\"out_trade_no\":\"70501111111S001111119\"," .
            "\"timeout_express\":\"90m\"," .
            "\"time_expire\":\"2016-12-31 10:05\"," .
            "\"total_amount\":9.00," .
            "\"auth_token\":\"appopenBb64d181d0146481ab6a762c00714cC27\"," .
            "\"goods_type\":\"0\"," .
            "\"passback_params\":\"merchantBizType%3d3C%26merchantBizNo%3d2016010101111\"," .
            "\"quit_url\":\"http://www.taobao.com/product/113714.html\"," .
            "\"product_code\":\"QUICK_WAP_WAY\"," .
            "\"promo_params\":\"{\\\"storeIdType\\\":\\\"1\\\"}\"," .
            "\"extend_params\":{" .
            "\"sys_service_provider_id\":\"2088511833207846\"," .
            "\"hb_fq_num\":\"3\"," .
            "\"hb_fq_seller_percent\":\"100\"," .
            "\"industry_reflux_info\":\"{\\\\\\\"scene_code\\\\\\\":\\\\\\\"metro_tradeorder\\\\\\\",\\\\\\\"channel\\\\\\\":\\\\\\\"xxxx\\\\\\\",\\\\\\\"scene_data\\\\\\\":{\\\\\\\"asset_name\\\\\\\":\\\\\\\"ALIPAY\\\\\\\"}}\"," .
            "\"card_type\":\"S0JP0000\"" .
            "    }," .
            "\"enable_pay_channels\":\"pcredit,moneyFund,debitCardExpress\"," .
            "\"disable_pay_channels\":\"pcredit,moneyFund,debitCardExpress\"," .
            "\"store_id\":\"NJ_001\"," .
            "\"specified_channel\":\"pcredit\"," .
            "\"business_params\":\"{\\\"data\\\":\\\"123\\\"}\"," .
            "\"ext_user_info\":{" .
            "\"name\":\"李明\"," .
            "\"mobile\":\"16587658765\"," .
            "\"cert_type\":\"IDENTITY_CARD\"," .
            "\"cert_no\":\"362334768769238881\"," .
            "\"min_age\":\"18\"," .
            "\"fix_buyer\":\"F\"," .
            "\"need_check_info\":\"F\"" .
            "    }" .
            "  }");
        $result = $aop->pageExecute ( $request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }
    }

}