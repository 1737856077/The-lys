<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:WechatGroupsAction.class.php 2015-07-29 11:15:00 $
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
class Wechatgroups extends UserCommon{
	
	public function index(){
		$ModelWechatGroups=Db::name('WechatGroups');
		
		$p=isset($_GET['p']) ? intval($_GET['p']) : 1;
		$num=20;
		
		$_where="";
		$count = $ModelWechatGroups->where(" 1 $_where ")->count();
		import("ORG.Util.Page");
		$Page=new Page($count, $num);
		$Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
		$show=$Page->show();
		
		$List=$ModelWechatGroups->where(" 1 $_where ")->order("id DESC")->page($p.','.$num)->select();
		
		//$this->SyncGroup(1);//同步微信分组
		
		$this->assign("count",$count);
		$this->assign("List",$List);
		$this->assign("page",$show);
		return $this->fetch();
	}
	
	//显示添加页面
	public function add(){
		return $this->fetch();
	}
	
	//显示编辑页面
	public function edit(){
		$id = isset($_POST['id']) ? intval(trim($_POST['id'])) : intval($_GET['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		
		$ModelWechatGroups=Db::name('WechatGroups');
		$getone=$ModelWechatGroups->where("id='$id'")->find();
		
		$this->assign("getone",$getone);
		return $this->fetch();
	}
	
	//提交添加表单
	public function insert(){
		$title=htmlspecialchars(trim($_POST['title']));
		$gettime=time();
		
		if(empty($title)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		
		$data=array();
		$data["name"]=$title;
		$data["create_time"]=$gettime;
		$data["update_time"]=$gettime;
		
		$ModelWechatGroups=Db::name('WechatGroups');
		$count=$ModelWechatGroups->where("name='$title'")->count();
		if($count){
			echo "<script language=\"javascript\">alert(\"分组名称已存在相同！\");history.go(-1);</script>";
			exit;
		}
		if($count>=100){
			echo "<script language=\"javascript\">alert(\"分组名称个数已达到上限！\");history.go(-1);</script>";
			exit;
		}
		
		$info=$this->WechatGroupsAdd($title);
		$info=$info['group'];
		$data["id"]=$info->id;
		if($data["id"]){
			
			$ModelWechatGroups->add($data);
			
			$this->success("添加成功！",__URL__."/index",3);
			exit;
		}else{
			$this->error("添加失败！原因：".json_encode($info),__URL__."/index",3);
			exit;
		}
	}
	
	//提交编辑表单
	public function update(){
		$id=htmlspecialchars(trim($_POST['id']));
		$title=htmlspecialchars(trim($_POST['title']));
		$gettime=time();
		
		if(empty($title)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		
		$ModelWechatGroups=Db::name('WechatGroups');
		
		$count=$ModelWechatGroups->where("id='$id'")->count();
		if(!$count){ echo "paramer error!"; exit; }
		
		$data=array();
		$data["name"]=$title;
		$data["update_time"]=$gettime;
		
		$info=$this->WechatGroupsEdit($id,$title);
		if($info["errcode"]=="0"){
				
			$ModelWechatGroups->where("id='$id'")->save($data);
				
			$this->success("编辑成功！",__URL__."/index",3);
			exit;
		}else{
			$this->error("编辑失败！原因：".json_encode($info),__URL__."/index",3);
			exit;
		}
	}
	
	//删除分组：还需调试，post删除未返回值
	public function delete(){
		$id = isset($_POST['id']) ? intval(trim($_POST['id'])) : intval($_GET['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		
		$ModelWechatGroups=Db::name('WechatGroups');
		$getone=$ModelWechatGroups->where("id='$id'")->find();
		if(empty($getone)){ echo "Data does not exist!"; exit;  }
		
		$info=$this->WechatGroupsDelete($id);
		//print_r($info);exit;
		//if($info["errcode"]=="0"){
		
			$ModelWechatGroups->where("id='$id'")->delete();
		
			$this->success("操作成功！",__URL__."/index",3);
			exit;
		//}else{
			//$this->error("操作失败！原因：".json_encode($info),__URL__."/index",3);
			//exit;
		//}		
	}
	
	//同步微信分组
	public function SyncGroup($type=0){
		$ModelWechatGroups=Db::name('WechatGroups');
		$gettime=time();
		
		$info=$this->WechatGroupsSync();
		$info=$info['groups'];	
		$info=(Array)$info;
		$ids=array();
		foreach ($info as $key=>$value){
			$value=(Array)$value;
			$ids[$key]=$value["id"];
			$count=$ModelWechatGroups->where("id='$value[id]'")->count();
			if($count){
				//更新
				$data=array("name"=>$value["name"],
							"count_member"=>$value["count"],
							"update_time"=>$gettime,
				);
				$ModelWechatGroups->where("id='$value[id]'")->save($data);
			}else{
				//insert
				$data=array("id"=>$value["id"],
						"name"=>$value["name"],
						"count_member"=>$value["count"],
						"create_time"=>$gettime,
						"update_time"=>$gettime,
				);
				$ModelWechatGroups->add($data);
			}
		}
		
		if(count($ids)){
			$ModelWechatGroups->where("id NOT IN(".implode(",", $ids).")")->delete();
		}else{
			$ModelWechatGroups->where("id>=0")->delete();
		}
		if($type==0){
			$this->success("同步成功！",__URL__."/index",3);
			exit;
		}
		
	}
	
	//微信添加分组接口
	public function WechatGroupsAdd($title){
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/groups/create?access_token=".$Token;
		$json='{"group":{"name":"'.$title.'"}}';
		$file_content=$PublicAction->curlPost($url,$json);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
		
		return $file_content;
	}
	
	//微信修改分组接口
	public function WechatGroupsEdit($id,$title){
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/groups/update?access_token=".$Token;
		$json='{"group":{"id":'.$id.',"name":"'.$title.'"}}';
		$file_content=$PublicAction->curlPost($url,$json);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
	}
	
	//微信删除分组接口
	public function WechatGroupsDelete($id){
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/groups/delete?access_token=".$Token;
		$json='{"group":{"id":'.$id.'}}';
		$file_content=$PublicAction->curlPost($url,$json);
		wirtefile($file_content);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
	}
	
	//微信同步分组接口
	public function WechatGroupsSync(){
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/groups/get?access_token=".$Token;
		$file_content=$PublicAction->curlPost($url);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
	}
	
	
}
