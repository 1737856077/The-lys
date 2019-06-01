<?php
/**
 * @desc:公用签名方法
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * Date: 2019/4/22
 * Time: 14:02
 * @id:CommonSign.php
 */

namespace app\common\controller;

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
class CommonSign extends Controller
{
    // 私钥
    public $privatekey = '';
    // 是否开启IP访问限制
    private $ip_limit = false;
    // 允许访问的IP列表
    private $ip_allow = array(
        '111.11.111.111', // 局域网ip
        '111.11.111.112', // 任务服务器
        '111.11.111.113', // 代理IP
    );

    /**
     * @desc 接受参数处理
     */
    public function dealParam(){
        //接受header参数--系统参数
        $systemParam=$this->request->param();
        //接受body数据--业务参数(json格式)
        $data=array();

        //读取配置文件中的私钥信息
        $api_apiKey=\think\Config::get('data.api_interface');
        $this->privatekey=$api_apiKey[$systemParam['token']];

        $arr['token']    =$systemParam['token'];        //服务端分配的标识(不同客户端需使用不同的标识)
        $arr['timestamp']=$systemParam['timestamp'];    //时间戳，UTC时间，以北京时间东八区（+8）为准
        $arr['version']  =$systemParam['version'];      //版本号
        $arr['sign']     =$systemParam['sign'];         //签名
        $arr['source']   =$systemParam['source'];       //来源(0-安卓/1-IOS/2-H5/3-PC/4-php/5-java)
        $data=(Array)json_decode($systemParam['data']);
        $arr['data'] =$data; //业务参数json格式
        $arr['method'] =$data['method']; //访问接口,格式:模型名.方法名

        return $arr;
    }
    /**
     * @desc 获取所有以HTTP开头的header参数
     * @return array
     */
    private function getAllHeadersParam(){
        $headers = array();
        foreach($_SERVER as $key=>$value){
            if(substr($key, 0, 5)==='HTTP_'){
                $key = substr($key, 5);
                $key = str_replace('_', ' ', $key);
                $key = str_replace(' ', '-', $key);
                $key = strtolower($key);
                $headers[$key] = $value;
            }
        }
        return $headers;
    }
    /**
     * @desc 签名校验
     * @param $token string 服务端分配的标识(不同客户端需使用不同的标识)
     * @param $timestamp string 时间戳，UTC时间，以北京时间东八区（+8）为准
     * @param $version string 版本号
     * @param $sign string 签名
     * @param $source int 来源(0-安卓/1-IOS/2-H5/3-PC/4-php/5-java)
     * @param $privatekey string 私钥
     * @param $data 业务参数json格式
     * @return bool
     */
    public function checkAuth($token,$timestamp,$version,$sign,$source,$privatekey,$data){
        //参数判断
        if(empty($token)){
            return 'token不能为空！';
        }
        if(empty($timestamp)){
            return '时间戳不能为空！';
        }
        if(empty($version)){
            return '版本号不能为空！';
        }
        if(empty($data)){
            return '业务参数不能为空！';
        }
        if(empty($source) && $source<>'0'){
            return '来源不能为空！';
        }
        if(empty($sign)){
            return '签名不能为空！';
        }
        if(empty($privatekey)){
            return '私钥不能为空！';
        }
        $api_apiKey=\think\Config::get('data.api_interface');
        //时间校验
        $expire_second=$api_apiKey['expire_second'];
        $timestamp_t=$timestamp+$expire_second;
        if($timestamp_t<time()){
            return '请求已经过期！';
        }
        //$public= D('public');
        //$datas=$this->original;
        //系统参数
        $paramArr=array(
            'token'=>$token,
            'timestamp'=>$timestamp,
            'version'=>$version,
            'source'=>$source,
            'data'=>$data,
        );
        //按规则拼接为字符串
        $str = $this->createSign($paramArr,$privatekey);

        if($str != $sign){
            return '验签错误！';
        }
        return true;
    }

    /**
     * @desc 限制请求接口次数
     * @return bool
     */
    private function ask_count(){
        /*$client_ip = $this->sys_get_client_ip();
        $ask_url = $this->sys_GetCurUrl();
        $api_apiKey=\think\Config::get('data.api_interface');
        //限制次数
        $limit_num = $api_apiKey['api_ask_limit'];
        //有效时间内,单位:秒
        $limit_time = $api_apiKey['api_ask_time'];
        $now_time = time();
        $valid_time = $now_time - $limit_time;
        $ipwhere['creatime'] = array('EGT',date('Y-m-d H:i:s',$valid_time));
        $ipwhere['ip_name'] = $client_ip;
        $ipwhere['ask_url'] = $ask_url;
        $check_result = M('log_ip_ask')->where($ipwhere)->count();
        if($check_result !=='0'){
            if($check_result >= $limit_num){
                $this->returnE('已经超出了限制次数！');
            }
        }
        //执行插入
        $add_data = array(
            'ip_name'=>$client_ip,
            'ask_url'=>$ask_url,
            'creatime'=>date('Y-m-d H:i:s',time())
        );
        $result = M('log_ip_ask')->data($add_data)->add();
        if($result===false){
            $this->returnE('写入记录失败！');
        }*/
        return true;
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    private function sys_get_client_ip($type = 0,$adv=false) {
        $type = $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    /**
     * @desc php获取当前访问的完整url地址
     * @return string
     */
    private function sys_GetCurUrl() {
        $url = 'http://';
        if (isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') {
            $url = 'https://';
        }
        if ($_SERVER ['SERVER_PORT'] != '80') {
            $url .= $_SERVER ['HTTP_HOST'] . ':' . $_SERVER ['SERVER_PORT'] . $_SERVER ['REQUEST_URI'];
        } else {
            $url .= $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
        }
        return $url;
    }

    /**
     * @desc 非法IP限制访问
     * @param array $config
     * @return bool
     */
    private function illegalip(){
        if(!$this->ip_limit){
            return true;
        }
        $remote_ip = get_client_ip();
        if(in_array($remote_ip, $this->ip_allow)){
            return true;
        }
        return false;
    }

    /**
     * @desc 签名函数
     * @param $paramArr 系统参数
     * @param $apiKey 私钥
     * @return string 返回签名
     */
    public function createSign ($paramArr,$apiKey) {
        ksort($paramArr);
        $sign='';

        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $sign .= $key."=".$val."&";
            }
        }
        $sign=rtrim($sign,"&");
        $sign.=$apiKey;
        $sign=strtolower($sign);
        $sign = md5($sign);
        return $sign;
    }

    public function returnE($str){
        return $str;
    }

    /**
     * sign生成规则及步骤：
    ①　第一步：将所有需要发送至服务端的请求参数（空参数值的参数、文件、字节流、sign除外）按照参数名ASCII码从小到大排序（字典序）
    注意：
    l 参数名ASCII码从小到大排序（字典序）；
    l 如果参数的值为空不参与签名；
    l 文件、字节流不参与签名；
    l sign不参与签名；
    l 参数名、参数值区分大小写；
    ②　第二步：将排序后的参数按照URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串strA；
    ③　第三步：在strA后面拼接上apiKey得到striSignTemp字符串，将strSignTemp字符串转换为小写字符串后进行MD5运算，MD5运算后得到值作为sign的值传入服务端；

    示例（所有参数、参数值均为示例，开发人员参考格式即可）：
    token：cd171009328172Ad3sc
    apiKey：cd13H2ddd22212ds1da
    ①　第一步（获取到的请求参数并按照参数名ASCII码从小到大排序）：
    token=cd173309328172Ad322
    data={"userName":"18817201899",goods:["addrId":323,{"skuNo":"p12232-023","count":3},{"skuNo":"p12232-013","count":1}]}
    timestamp=1507537036
    version=v3.6.0

    ②　第二步（按规则拼接为字符串strA）：
    token=cd171009328172Ad3sc&data={"userName":"18817201899",goods:["addrId":323,{"skuNo":"p12232-023","count":3},{"skuNo":"p12232-013","count":1}]}timestamp=1507537036&version=v3.6.0
    ③　第三步（生成sign）：
    1)待签名字符串strSignTemp：
    token=cd171009328172Ad3sc&data={"userName":"18817201899",goods:["addrId":323,{"skuNo":"p12232-023","count":3},{"skuNo":"p12232-013","count":1}]}timestamp=1507537036&version=v3.6.0cd13H2ddd22212ds1da
    2)转换为小写字符串
    strtolower()
    3)MD5加密后的密文
    6D556D52822658FD47F7FE362544CEE1
     */
}