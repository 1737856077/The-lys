<?php
date_default_timezone_set('PRC');
$newData=require_once('../../../admin/extra/data.php');
$config = array (	
		//应用ID,您的APPID。
		'app_id' => $newData['alipay']['app_id'],

		//商户私钥
		'merchant_private_key' => $newData['alipay']['rsaPrivateKey'],
		
		//异步通知地址
		'notify_url' => $newData['alipay']['notify_url'],
		
		//同步跳转
		'return_url' => $newData['alipay']['return_url'],

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => $newData['alipay']['url'],

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => $newData['alipay']['alipayrsaPublicKey'],
);
?>