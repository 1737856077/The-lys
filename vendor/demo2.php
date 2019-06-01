<?php

require_once 'SendRedPackData.php';
require_once 'RedPackException.php';

class wxRedPack {

    //配置参数
    const MCHID = "1452483602";
    const APPID = "wxb8d7d0f77e16a9fe";
    const KEY = "4d0902b58cb9e19563e43e9c1e5b8a1f";
    const SSLCERT_PATH = "/www/wwwroot/tzs.sindns.com/static/apiclient_cert.pem";//证书地址   *****   此处要写服务器绝对路径
    const SSLKEY_PATH = "/www/wwwroot/tzs.sindns.com/static/apiclient_key.pem";//证书地址

    //发送参数
    public static $send_name = "蝌蚪溯源";                                          //商户名称
    //public static $re_openid = "o5xBK6FEaMybXEY0YtJQnkLDIxlQ";                  //openid
    public static $total_amount = "1000";                                          //红包金额
    public static $total_num = "5";                                             //红包发放总人数
    public static $amt_type = "ALL_RAND";                                             //红包金额设置方式
    public static $wishing = "happy new year!^_^";                              //红包祝福语
    public static $client_ip = "0.0.0.0";                                       //调用接口的机器Ip地址
    public static $act_name = "恭喜发财";                                //活动名称
    public static $remark = "可分享好友领取哦";                              //备注信息

    public function sendredpack() {
        $openid = trim($_POST['openid']);
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack";
        $input = new SendRedPackData();
        $input->SetNonce_str(self::getNonceStr());
        $input->SetMchBillNo(self::getMchBillNo());
        $input->SetMchId(self::MCHID);
        $input->SetWxAppId(self::APPID);
        $input->SetSendName(self::$send_name);
        $input->SetOpenId($openid);
        $input->SetTotalAmount(self::$total_amount);
        $input->SetTotalNum(self::$total_num);
        $input->SetAmt_type(self::$amt_type);
        $input->SetWishing(self::$wishing);
        $input->SetSpbillCreateIp($_SERVER['REMOTE_ADDR']); //终端ip	
        $input->SetActName(self::$act_name);
        $input->SetRemark(self::$remark);
        $input->SetSign(self::KEY);
        $xml = $input->ToXml();
//        $startTimeStamp = self::getMillisecond(); //请求开始时间
        $response = self::postXmlCurl($xml, $url, true);
        $result = self::xmlToArray($response);
        return $result;
    }

    /**
     * 
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 生成商户订单号
     * @param type $len
     * @return type
     */
    public static function getMchBillNo() {
        $string = md5(uniqid());
        return mb_substr($string, 0, 28, 'UTF-8');
    }

    /**
     * 以post方式提交xml到对应的接口url
     * 
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30) {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($useCert == true) {
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, self::SSLCERT_PATH);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, self::SSLKEY_PATH);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new RedPackException("curl出错，错误码:$error");
        }
    }
    /**
     * 获取毫秒级别的时间戳
     */
    private static function getMillisecond() {
        //获取毫秒的时间戳
        $time = explode(" ", microtime());
        $time = $time[1] . ($time[0] * 1000);
        $time2 = explode(".", $time);
        $time = $time2[0];
        return $time;
    }

    //将XML转为array
    public static function xmlToArray($xml) {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

}

header('Content-type: application/json');
$wxRedPack = new wxRedPack();
$result = $wxRedPack->sendredpack();
echo '红包发送成功，请在公众号领取';
/*echo json_encode($result);exit;
var_dump($result);*/
