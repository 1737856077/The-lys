<?php
namespace app\wechat\controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-7-27
 * Time: 下午4:54
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Paginator;
class PublicAction extends Controller{

    /*获取accessToken*/
    public function accessToken() {
    	// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    	$data = json_decode(file_get_contents("access_token.json"));
    	if ($data->expire_time < time()) {
    		// 如果是企业号用以下URL获取access_token
    		// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
    		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.Session::get('WeiXinConfig_APP_ID').'&secret='.Session::get('WeiXinConfig_APP_SECRET');
            wirtefile($url);
            $file_content=file_get_contents($url);
            wirtefile($file_content);
    		$res = json_decode($file_content);
    		$access_token = $res->access_token;
    		if ($access_token) {
    			$data->expire_time = time() + 7000;
    			$data->access_token = $access_token;
    			$fp = fopen("access_token.json", "w");
    			fwrite($fp, json_encode($data));
    			fclose($fp);
    		}
    	} else {
    		$access_token = $data->access_token;
    	}
    	return $access_token;

    }

    /*curl 模拟POST提交*/
    public function curlPost($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $output = curl_exec($curl);
        curl_close($curl); // 关闭CURL会话
        return $output;
    }
    
    //获取用户基本信息
    public function GetUserInfoWechat($openid){
    	//wirtefile("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->GetAccessToken()."&openid=".$openid."&lang=zh_CN");
    	$file_content=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->accessToken()."&openid=".$openid."&lang=zh_CN");
    	//wirtefile($file_content);
    	if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
    	$file_content=(Array)json_decode($file_content);
    
    	return $file_content;
    }
}