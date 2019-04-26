<?php
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @desc:配置文件
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:config.php 2018-04-06 14:58:00 $
 */

$newArray=require_once('config.php');
$newArray['app_debug']=true;// 应用调试模式
$newArray['app_trace']=true; // 应用Trace
$newArray['app_status']=''; // 应用模式状态


$newArray['yubiaoqian']=array(
    'app_id'=>'2019031863612029',//应用AppID
    'rsaPublicKeyPem'=>'xxxxxxx',//应用公钥
    'rsaPrivateKey'=>'xxxxxxxxx',//请填写商户私钥，一行字符串
    'alipayrsaPublicKey' => 'xxxxxx',//请填写支付宝公钥，一行字符串
    'url'=>'https://openapi.alipay.com/gateway.do',
);


return $newArray;
