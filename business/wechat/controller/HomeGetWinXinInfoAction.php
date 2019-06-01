<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @描述：取得微信用户信息
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:HomeGetWinXinInfoAction.php 2015-06-16 09:41:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\wechat\controller\HomeCommonAction;
use think\Config;
class HomeGetWinXinInfoAction extends HomeCommonAction
{
	public function GetOpenid()
	{
        $param = $this->request->param();
		if(config('WebConfig_Debug')){
			return config('WebConfig_Debug_Openid');
			exit;
		}
		$WeiXin_Openid=Session::get("WeiXin_Openid");
		//wirtefile("excel0:".json_encode($WeiXin_Openid));
		if(is_array($WeiXin_Openid) or is_object($WeiXin_Openid)){
			$WeiXin_Openid=(Array)$WeiXin_Openid;
			$WeiXin_Openid=$WeiXin_Openid["openid"];
		}
		if(empty($WeiXin_Openid)){
			//通过code获得openid
			if (!isset($param['code'])){
				//触发微信返回code码
				$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].__SELF__);
				$url = $this->__CreateOauthUrlForCode($baseUrl);
				Header("Location: $url");
				exit();
			} else {
				//获取code码，以获取openid
                $param = $this->request->param();
				$code = $param['code'];
				$openid = $this->getOpenidFromMp($code);
				//wirtefile("excel1:".json_encode($openid));
				if(is_array($openid) or is_object($openid)){
					$openid=(Array)$openid;
					$openid=$openid["openid"];
				}
				Session::set("WeiXin_Openid", $openid);	
				return $openid;
			}
		}else{			
			return $WeiXin_Openid;
		}
	}
	
	//未授权用户，取得用户基本信息
	public function GetOpenidUserInfo()
	{ $param = $this->request->param();
			if (!isset($param['code'])){
				//触发微信返回code码
				$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].__SELF__);
				$url = $this->__CreateOauthUrlForCodeUserInfo($baseUrl);
				Header("Location: $url");
				exit();
			} else {
				//获取code码，以获取openid
				$code = $param['code'];
				$openid = $this->GetOpenidFromMpUserInfo($code);
				
				$data = json_decode(file_get_contents("access_token_snsapi_userinfo.json"));
				$data->expire_time = time() + 7000;
				$data->access_token = $openid["access_token"];
				$fp = fopen("access_token_snsapi_userinfo.json", "w");
				fwrite($fp, json_encode($data));
				fclose($fp); 
				
				return $openid;
			}
	}

	public function GetJsApiParameters($UnifiedOrderResult)
	{
		if(!array_key_exists("appid", $UnifiedOrderResult)
		|| !array_key_exists("prepay_id", $UnifiedOrderResult)
		|| $UnifiedOrderResult['prepay_id'] == "")
		{
			throw new WxPayException("参数错误");
		}
		$jsapi = new WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp("$timeStamp");
		$jsapi->SetNonceStr(WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
		$jsapi->SetSignType("MD5");
		$jsapi->SetPaySign($jsapi->MakeSign());
		$parameters = json_encode($jsapi->GetValues());
		return $parameters;
	}

	public function GetOpenidFromMp($code)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		//curl_setopt($ch, CURLOP_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$openid = $data['openid'];
		return $openid;
	}
	public function GetOpenidFromMpUserInfo($code)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		//curl_setopt($ch, CURLOP_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		//$openid = $data['openid'];
		return $data;
	}

	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}

		$buff = trim($buff, "&");
		return $buff;
	}

	private function __CreateOauthUrlForCode($redirectUrl)
	{
		$urlObj["appid"] = APP_ID;
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}
	
	private function __CreateOauthUrlForCodeUserInfo($redirectUrl)
	{
		$urlObj["appid"] = APP_ID;
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_userinfo";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}

	private function __CreateOauthUrlForOpenid($code)
	{
		$urlObj["appid"] = APP_ID;
		$urlObj["secret"] = APP_SECRET;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}
}