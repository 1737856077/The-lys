<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:Wechatwatchgroups.php 2015-07-29 15:19:00 $
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
class Wechatwatchgroups extends UserCommon{
	
	//显示用户分组主界面
	public function index(){
		$ModelWechatWatch=Db::name('WechatWatch');
		$ModelWechatGroups=Db::name('WechatGroups');
		
		$SearchName=isset($_POST["SearchName"]) ? htmlspecialchars(trim($_POST['SearchName'])) : htmlspecialchars($_GET['SearchName']);
		$paramter="/SearchName/$SearchName/";
		
		$p=isset($_GET['p']) ? intval($_GET['p']) : 1;
		$num=20;
		
		$_where=" AND data_status=1";
		if(!empty($SearchName)){$_where.=" AND nickname LIKE '%".$SearchName."%'";}
		
		$count = $ModelWechatWatch->where(" 1 $_where ")->count();
		import("ORG.Util.Page");
		$Page=new Page($count, $num,$paramter);
		$Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
		$show=$Page->show();
		
		$List=$ModelWechatWatch->where(" 1 $_where ")->order("wechat_watch_id DESC")->page($p.','.$num)->select();
		
		//取得分组
		$ListWechatGroups=$ModelWechatGroups->order("id ASC")->select();
		$ArrayWechatGroups=array();
		foreach ($ListWechatGroups as $key=>$value){
			$ArrayWechatGroups[$value["id"]]=$value["name"];
		}
		
		$this->assign("count",$count);
		$this->assign("List",$List);
		$this->assign("page",$show);
		$this->assign("ArrayWechatGroups",$ArrayWechatGroups);
		$this->assign("SearchName",$SearchName);
		return $this->fetch();
	}

	//显示编辑分组界面
	public function edit(){
		$openid=isset($_POST["openid"]) ? htmlspecialchars(trim($_POST['openid'])) : htmlspecialchars($_GET['openid']);
		
		$ModelWechatWatch=Db::name('WechatWatch');
		$ModelWechatGroups=Db::name('WechatGroups');
		
		$getone = $ModelWechatWatch->where("wechat_openid='$openid' ")->find();
		if(empty($getone)){echo "paramer error!"; exit;}
		$ListWechatGroups=$ModelWechatGroups->order("id ASC")->select();
		
		$this->assign("getone",$getone);
		$this->assign("ListWechatGroups",$ListWechatGroups);
		return $this->fetch();
	}
	
	//提交编辑分组表单
	public function update(){
		$openid=htmlspecialchars(trim($_POST['openid']));
		$groups_id=intval(trim($_POST['groups_id']));
		$gettime=time();
		
		if(empty($openid)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		$ModelWechatWatch=Db::name('WechatWatch');
		
		$info=$this->WechatGroupsMove($openid,$groups_id);
		if($info["errcode"]=="0"){
			$data=array("wechat_groups_id"=>$groups_id,
						"update_time"=>$gettime,
			);
			
			$ModelWechatWatch->where("wechat_openid='$openid'")->save($data);
		
			$this->success("操作成功！",__URL__."/index",3);
			exit;
		}else{
			$this->error("操作失败！原因：".json_encode($info),__URL__."/index",3);
			exit;
		}
	}
	
	//全选操作
	public function editinfo(){
		$openid_list=$_POST['sqt'];
		$groups_id=intval(trim($_POST['groups_id']));
		$gettime=time();
		
		if(!count($openid_list)){
			echo "<script language=\"javascript\">alert(\"未选择粉丝！\");history.go(-1);</script>";
			exit;
		}
		$ModelWechatWatch=Db::name('WechatWatch');
		
		$info=$this->WechatGroupsMoveBatch($openid_list,$groups_id);
		if($info["errcode"]=="0"){
			$data=array("wechat_groups_id"=>$groups_id,
					"update_time"=>$gettime,
			);
			foreach ($openid_list as $key=>$val){	
				$ModelWechatWatch->where("wechat_openid='$val'")->save($data);
			}
			$this->success("操作成功！",__URL__."/index",3);
			exit;
		}else{
			$this->error("操作失败！原因：".json_encode($info),__URL__."/index",3);
			exit;
		}
	
	}

	//微信分组接口-移动用户分组
	public function WechatGroupsMove($openid,$to_groupid){
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=".$Token;
		$json='{"openid":"'.$openid.'","to_groupid":'.$to_groupid.'}';
		$file_content=$PublicAction->curlPost($url,$json);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
	}
	
	//微信分组接口-移动用户分组-批量
	public function WechatGroupsMoveBatch($openid_list,$to_groupid){
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate?access_token=".$Token;
		$json='{"openid_list":["'.implode('","', $openid_list).'"],"to_groupid":'.$to_groupid.'}';
		$file_content=$PublicAction->curlPost($url,$json);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
	}
	
}
