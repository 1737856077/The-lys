<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:MemberAction.class.php 2015-08-10 13:44:00 $
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
use \app\wechat\controller\UserCommon; 
class Member extends UserCommon{
	
	//显示用户列表
	public function index(){
		$ModelMember=Db::name('Member');
		$ModelWechatWatch=Db::name('WechatWatch');
		
		$SearchTel=isset($_POST["SearchTel"]) ? htmlspecialchars(trim($_POST['SearchTel'])) : htmlspecialchars($_GET['SearchTel']);
		$paramter="/SearchTel/$SearchTel/";
		
		$p=isset($_GET['p']) ? intval($_GET['p']) : 1;
		$num=20;
		
		$_where="";
		if(!empty($SearchTel)){$_where.=" AND moblie LIKE '%".$SearchTel."%'";}
		
		$count = $ModelMember->where(" 1 $_where ")->count();
		import("ORG.Util.Page");
		$Page=new Page($count, $num,$paramter);
		$Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
		$show=$Page->show();
		
		$List=$ModelMember->where(" 1 $_where ")->order("create_time DESC")->page($p.','.$num)->select();
		$_List=array();
		foreach ($List as $key=>$value){
			$getoneWechatWatch=$ModelWechatWatch->where("wechat_openid='$value[wechat_openid]'")->find();
			$value["headimgurl"]=$getoneWechatWatch["headimgurl"];
			$value["nickname"]=$getoneWechatWatch["nickname"];
			$_List[]=$value;
		}
		
		$this->assign("count",$count);
		$this->assign("List",$_List);
		$this->assign("page",$show);
		$this->assign("SearchTel",$SearchTel);
		return $this->fetch();
	}
	
}
