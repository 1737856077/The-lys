<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:UserCommonAction.class.php 2015-06-01 15:38:00 $
 */
 
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Paginator;
use think\File;
use think\Image;
use \app\common\controller\CommonBase;
class UserCommon extends CommonBase{
	/**
	 * @描述：初始方法
	 */
	public function _initialize(){
		parent::_initialize();
		
		/*调试时注册微信配置参数SESSION begin*/
        Session::set('WeiXinConfig_Token','lianyuwechat');
        Session::set('WeiXinConfig_APP_ID','wxc18fa831272ac730');
        Session::set('WeiXinConfig_APP_SECRET','8eaa03d4dd154ddc50736d77085956c2');
		/*调试时注册微信配置参数SESSION end*/
		if(!Session::has('WeiXinConfig_APP_ID')){
		    echo '非法操作！';exit;
        }
	}
	
}