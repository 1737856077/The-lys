<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @描述：用户信息合法性验证
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:HomeUserCommonAction.php 2015-06-16 09:43:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\Cookie;
use think\model;
use \app\wechat\controller\HomeCommonAction;
use \app\wechat\controller\HomeGetWinXinInfoAction;
class HomeUserCommonAction extends HomeCommonAction{
	public $_wechat_openid="";
	public $memInfo ;
	public function _initialize() {
		//header("Content-Type:text/html; charset=utf-8");
		//import('ORG.Util.Session');
		//import('ORG.Util.Cookie');
		//load("extend");
		
		$GetWinXinInfoAction=new HomeGetWinXinInfoAction();
		$GetUserOpenid=$GetWinXinInfoAction->GetOpenid();
		$this->_wechat_openid=$GetUserOpenid;
		$this->SynchronizationWechatWatch($GetUserOpenid);//同步Openid
		
		$countMember=Db::table('Member')->where("wechat_openid='$GetUserOpenid'")->count();
		$this->memInfo = Db::table('Member')->where("wechat_openid='123456'")->select();
		if(!$countMember){
			//echo "亲！需要您绑定手机号后才可以操作，谢谢！"; exit;
			echo "<script type=\"text/javascript\">location.href='".url('Register/index')."';</script>";exit;
			$JumpParameters=array("LeftTitle"=>"随便逛逛",
					"LeftUrl"=>url("Take/index"),
					"RightTitle"=>"注册",
					"RightUrl"=>url('Register/index'),
			);
			$this->assign("JumpParameters",$JumpParameters);
			$this->error("亲！需要您注册后才可以操作，点击下方“注册”立刻去注册，谢谢！",url('Register/index'),3);
			exit;
		}
	}
	
	//同步Openid
	public function SynchronizationWechatWatch($Openid){
		$ModelWechatWatch=Db::name("WechatWatch");
		$countWechatWatch=$ModelWechatWatch->where("wechat_openid='$Openid'")->count();
		$GetUserOpenid=$Openid;
		$GetWinXinInfoAction=new HomeGetWinXinInfoAction();
		//取各URL地址
		
		$ServerHostUrl=parent::GetServerHostUrl();
		
		if(!$countWechatWatch){
			$gettime=time();
			$GetUserInfoWechatArray=parent::GetUserInfoWechat($Openid);			
			
			if(in_array("errcode", $GetUserInfoWechatArray)){
				$GetUserOpenidArray=$GetWinXinInfoAction->GetOpenidUserInfo();
				$GetUserOpenidArray=(Array)$GetUserOpenidArray;
				$GetUserInfoWechatArray=parent::GetUserInfoWechatUserInfo($GetUserOpenidArray['openid']);
			
			}
			$GetUserInfoWechatArray["nickname"]=empty($GetUserInfoWechatArray["nickname"]) ? "游客" : $GetUserInfoWechatArray["nickname"];
			$GetUserInfoWechatArray["headimgurl"]=empty($GetUserInfoWechatArray["headimgurl"]) ? $ServerHostUrl."/Public/Uploads/defaultuser.png" : $GetUserInfoWechatArray["headimgurl"];
			$dataWechatWatch=array(
						"wechat_openid"=>$GetUserOpenid,
						"developer_account"=>"none_user",
						"nickname"=>"$GetUserInfoWechatArray[nickname]",
						"sex"=>"$GetUserInfoWechatArray[sex]",
						"province"=>"$GetUserInfoWechatArray[province]",
						"city"=>"$GetUserInfoWechatArray[city]",
						"country"=>"$GetUserInfoWechatArray[country]",
						"headimgurl"=>"$GetUserInfoWechatArray[headimgurl]",
						"privilege"=>json_encode($GetUserInfoWechatArray[privilege]),
						"wechat_groups_id"=>"$GetUserInfoWechatArray[groupid]",
						"create_time"=>$gettime,
						"update_time"=>$gettime,
			);
			$returnid=$ModelWechatWatch->insertGetId($dataWechatWatch);
		}
	}
	
}

