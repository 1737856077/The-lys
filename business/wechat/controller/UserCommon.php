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
use \app\common\controller\CommonAdmin;
class UserCommon extends CommonAdmin{
	/**
	 * @描述：初始方法
	 */
	public function _initialize(){
		parent::_initialize();
		
		/*调试时注册微信配置参数SESSION begin*/
        Session::set('WeiXinConfig_Token','weixin');
        Session::set('WeiXinConfig_APP_ID','wxb8d7d0f77e16a9fe');
        Session::set('WeiXinConfig_APP_SECRET','e3aedffe336958d1e2ce8e6e4c28eaf3');
		/*调试时注册微信配置参数SESSION end*/
		if(!Session::has('WeiXinConfig_APP_ID')){
		    echo '非法操作！';exit;
        }
	}
	
}