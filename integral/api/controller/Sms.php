<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/8
 * Time: 13:36
 */
namespace app\api\controller;
use app\common\controller\CommonApi;
use think\Db;
use think\Session;

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

// 加载区域结点配置
Config::load();
class Sms extends CommonApi
{
    /**
     * Sms 初始化操作
     * */
//    public function _initialize()
//    {
//        parent::_initialize();
//        //    $this->sms=$sms;
//        $accessKeyId="6456457897447";
//        $accessKeySecret="66666664444444";
//        // 短信API产品名
//        $product = "Dysmsapi";
//        // 短信API产品域名
//        $domain = "dysmsapi.aliyuncs.com";
//        // 暂时不支持多Region
//        $region = "cn-hangzhou";
//        // 服务结点
//        $endPointName = "cn-hangzhou";
//        // 初始化用户Profile实例
//        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
//        // 增加服务结点
//
//        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
//
//        // 初始化AcsClient用于发起请求
//        $this->acsClient = new DefaultAcsClient($profile);
//
//    }



    public function get_code_by_phone() {
        /**验证手机号**/
        $phone      = htmlspecialchars(isset($this->request->param()['phone'])?$this->request->param()['phone']:'');
        $is_phone = preg_match('/^1[34578]\d{9}$/', $phone) ? 1 : '';
        if (!$is_phone) {
            $this->return_msg(400,   '请输入正确的手机号');
        }
        /*********** 检测手机号/邮箱是否存在  ***********/
//        $this->check_exist($phone);
        /*********** 检查验证码请求频率 30秒一次  ***********/
        if (session("?" . $phone . '_last_send_time')) {
            if (time() - session($phone . '_last_send_time') < 1) {
                $this->return_msg(400,   '手机验证码,每30秒只能发送一次!');
            }
        }
        /*********** 生成验证码  ***********/
        $code = $this->make_code(6);

        /**********验证手机是否存在*********/
        $this->check_exist($phone);
        /*********** 使用session存储验证码, 方便比对, md5加密   ***********/
        $md5_code = md5($phone . '_' . md5($code));
        session($phone . '_code', $md5_code);
        /*********** 使用session存储验证码的发送时间  ***********/
        session($phone . '_last_send_time', time());
        /*********** 发送验证码  ***********/
            $this->sendSms($phone, $code);

    }

    /**
     * 判断手机号是否存在
     * $phone int [需要验证的手机号]
     */
    public function check_exist($phone) {
        $phone_res = Db::name('member')->where('moblie', $phone)->find();
        if ($phone_res){
            $this->return_msg(400, '此手机号已被占用!');
        }
    }

    /**
     * 生成验证码
     * @param  int [验证码位数]
     * @return int [验证码]
     */
    public function make_code($num) {
        $max = pow(10, $num) - 1;
        $min = pow(10, $num - 1);
        return rand($min, $max);
    }
    static $acsClient = null;

    /**检测验证码是否正确
     * @param $phone int [手机号]
     * @param $cod  int [验证码]
     */
    public function check_code($phone, $code) {
        /*********** 检测是否超时  ***********/
        $last_time = session($phone . '_last_send_time');
        if (!$code){
            $this->return_msg(400, '请输入验证码');
        }
        if (time() - $last_time > 600) {
            $this->return_msg(400, '验证超时,请在一分钟内验证!');
        }
        /*********** 检测验证码是否正确  ***********/
        $md5_code = md5($phone . '_' . md5($code));
        if (session($phone . "_code") !== $md5_code) {
            $this->return_msg(400, '验证码不正确!');
        }else{
            $this->return_msg(200, 'ok');
        }
        /*********** 不管正确与否,每个验证码只验证一次  ***********/
        session($phone . '_code', null);
    }
    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient() {
        //产品名称:云通信短信服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = "LTAIfzdHZarb46bK"; // AccessKeyId

        $accessKeySecret = "6BD8dBSsASIa6a3qKplsE4hCpPKUpQ"; // AccessKeySecret

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if(static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public static function sendSms($phone, $code) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，设置短信接收号码
        $request->setPhoneNumbers("$phone");

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
            $request->setSignName("蝌蚪溯源");

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode("SMS_164930098");

        // 可选，设置模板参数, 假如模板中存在变SignName 量需要替换则为必填项
        $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
            "code"=>"$code",
            "product"=>"dsd"
        ), JSON_UNESCAPED_UNICODE));

        // 可选，设置流水号
        $request->setOutId("yourOutId");
        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        $request->setSmsUpExtendCode("1234567");

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);
        if ($acsResponse->Code=="OK"){
            return_msg(200,"验证码发送成功请在1分钟之内验证");
        }else{
            return_msg(400,"每天最多5条");
        }
    }


}