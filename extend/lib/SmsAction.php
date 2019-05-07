<?php
namespace lib;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:SmsAction.class.php 2015-06-16 09:42:00 $
 */

use think\Controller;
use think\Db;
use think\Session;
class SmsAction extends Controller{
	
	private $SMS_SIGNATURE="";
	private $SEND_SMS_URL="http://api.cnsms.cn/?ac=send&encode=utf8";//发送短信接口地址
	private $SEND_MONITOR_NUM=3;//每小时发送最多条数
	
	/*
	 * 获取错误信息
	 */
	private function getErrorMsg($error){
		$errors = array(
				'100'=>'发送成功',
				'101'=>'验证失败',
				'102'=>'短信不足',
				'103'=>'操作失败',
				'104'=>'非法字符',
				'105'=>'内容过多',
				'106'=>'号码过多',
				'107'=>'频率过快',
				'108'=>'号码内容空',
				'109'=>'账号冻结',
				'110'=>'禁止频繁单条发送',
				'111'=>'系统暂定发送',
				'112'=>'号码错误',
				'113'=>'定时时间格式不对',
				'114'=>'账号被锁，10分钟后登录',
				'115'=>'连接失败',
				'116'=>'禁步接口发送',
				'117'=>'绑定IP不正确',
				'120'=>'系统升级',
		);
		$return = isset($errors[$error]) ? $errors[$error] : "系统忙";
		return $return;
	}

	/**
	 * @描述：发送短信
	 * @param 	string	$phone					--手机号
	 * @param	int		$sms_template_id		--模版ID，sms_template表的id
	 * @param	array	$Info					--需替换字符； 示例：array("username"=>"刘庆艳","time"=>"2015-05-18")	
	 * @return	array 	$ret					--返回值
	 * 					$ret['code']			--0：为无错误；其它为有错误！
	 * 					$ret['msg']				--错误描述
	 */
	public function postContent($phone,$sms_template_id,$Info)
	{
		$getoneSmsTemplate=Db::name("SmsTemplate")->where("id='$sms_template_id'")->find();

		if(is_null($getoneSmsTemplate)) {
			$ret['code'] = 1;
			$ret['msg'] = '短信模板读取失败';
		}
		if($getoneSmsTemplate['data_status']!=1) {
			$ret['code'] = 1;
			$ret['msg'] = '短信模板不可用';
			return $ret;
		}
		if(!chkstr($phone,'mobile')){
			$ret['code'] = 1;
			$ret['msg'] = '手机号格式错误';
			return $ret;
		}
	
		$_Text=$this->SMS_SIGNATURE.$getoneSmsTemplate["content"];
	
		foreach($Info as $key=>$val){
			$_Text=str_replace("{\$".$key."}", $val, $_Text);
		}
	
		$gettime=time();
		$_date_ymd=date("Y-m-d");
		$_date_h=date("H");
		//判断手机号每小时是否发送超过3次
		$ModelSmsSendMonitor=Db::name("SmsSendMonitor");
		$getoneSmsSendMonitor=$ModelSmsSendMonitor->where("mobile='$phone'")->find();
		if(empty($getoneSmsSendMonitor)){//不存在,新增记录
			$dataSmsSendMonitor=array("mobile"=>$phone,
									"date_ymd"=>date("Y-m-d"),
									"date_h"=>date("H"),
									"data_status"=>0,
									"create_time"=>$gettime,
									"update_time"=>$gettime,
			);
			$ModelSmsSendMonitor->add($dataSmsSendMonitor);
			$getoneSmsSendMonitor=$dataSmsSendMonitor;
		}else{//存在，更新日期
			//不是现在这一时间的，更新数据
			if($getoneSmsSendMonitor["date_ymd"]!=$_date_ymd or $getoneSmsSendMonitor["date_h"]!=$_date_h){
				$_dataSmsSendMonitor=array("date_ymd"=>date("Y-m-d"),
											"date_h"=>date("H"),
											"data_status"=>0,
											"update_time"=>$gettime,
				);
				$ModelSmsSendMonitor->where("mobile='$phone'")->save($_dataSmsSendMonitor);
			}
			$getoneSmsSendMonitor=$ModelSmsSendMonitor->where("mobile='$phone'")->find();
		}
		if($getoneSmsSendMonitor["data_status"]>=$this->SEND_MONITOR_NUM){//每小时发送已超出
			$ret['code'] = "107";
			$ret['msg'] = '操作频繁， 每小时短信请求不得超过'.$this->SEND_MONITOR_NUM.'次，请稍后再试！';
			return $ret;
		}
		$ModelSmsSendMonitor->where("mobile='$phone'")->setInc("data_status",1);
		
		//添加发送日志		
		$ModelSmsSendLog=Db::name("SmsSendLog");
		$dataSmsSendLog=array("mobile"=>$phone,
							"content"=>$_Text,
							"create_time"=>$gettime,
							"update_time"=>$gettime,
		);
		$returnIDSmsSendLog=$ModelSmsSendLog->add($dataSmsSendLog);
		
		$res = $this->postText($phone, $_Text);
		if ($res == "100" ) {
			$ret['code'] = 0;
			$ret['msg'] = '短信发送成功, 请注意查收!';
			$ModelSmsSendLog->where("id='$returnIDSmsSendLog'")->setField("data_status","1");
		} else {			
			$ret = array('code' => 1, 'msg' =>  $this->getErrorMsg($res));
		}
		return $ret;
	}
	
	/**
	 * 发送短信
	 */
	public function postText($mobile, $content)
	{
		$file_content=file_get_contents($this->SEND_SMS_URL."&uid=".config('SMS_UID')."&pwd=".md5(config('SMS_PWD'))."&mobile=".$mobile."&content=".urlencode($content));
		return $file_content;
	}
	
}


