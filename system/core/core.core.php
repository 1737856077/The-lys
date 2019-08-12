<?php
error_reporting(E_ALL);
header('Content-Type: text/html;charset=utf-8');
mb_internal_encoding('UTF-8');
date_default_timezone_set('PRC');
session_start();
class core {
	public static function init() {
		$Paras 	 = $_GET;
		$mod_name=array_key_exists('m', $Paras)?$Paras['m']:'index';
		$act_name=array_key_exists('c', $Paras)?$Paras['c']:'index';
		if (!preg_match('/^[a-z0-9_\-]+$/', $mod_name) || !preg_match('/^[a-z0-9_\-]+$/', $act_name)) self::__403();
		$mod_file = SYSTEM.'/mod/'.MODULE.'/'.$mod_name.'.mod.php';	
		if (!is_file($mod_file)) self::__403();
		require(SYSTEM.'/core/mod.core.php');
		require($mod_file);
		$mod_classname  = 'mod_'.$mod_name;
		$model 			= new $mod_classname;
		$methods 		= get_class_methods($model);
//		foreach($methods as $k=>$v){
//			//echo "insert into w_style values (0,'','/public/icons/".$mod_name.".".$v.".png','?m=".$mod_name."&c=".$v."',1,0);<br/>";
//			echo "$v <br/>";
//		}
		if (!in_array($act_name, $methods)) self::__403();
		call_user_func_array(array($model, $act_name), array());
	}
	public static function __403() {
		self::error('非法请求');
	}
	public static function error($message) {
		header('X-Error-Message: '.rawurlencode($message));
		$msg = $message;
		require(SYSTEM.'/tpl/error.tpl.php');
		exit;
	}
	//core::lib( 'db' );
	public static function lib($name) {
		static $libs = array();
		if (!array_key_exists($name, $libs)) {
			require(SYSTEM.'/lib/'.$name.'.lib.php');
			$classname = 'lib_'.$name;
			$libs[$name] = new $classname;
		}
		return $libs[$name];
	}
	public static function logger($data) {
		$text = '';
		$data['TIME'] = date('Y-m-d H:i:s');
		$data['URI'] = $_SERVER['REQUEST_URI'];
		foreach ($data as $k => $v) $text .= '['.$k.']: '.$v."\r\n";
		$text .= "\r\n";
		file_put_contents(SYSTEM.'/data/log/'.date('Y.m.d').'.txt', $text, FILE_APPEND);
	}
}