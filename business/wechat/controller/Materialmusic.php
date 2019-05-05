<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:MaterialMusicAction.class.php 2015-08-03 09:08:00 $
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
class Materialmusic extends UserCommon{
	
	//显示列表页面
	public function index(){
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');	

		$p=isset($_GET['p']) ? intval($_GET['p']) : 1;
		$num=20;
		
		$_where="";
		
		$count = $ModelWechatMaterialMusic->where(" 1 $_where ")->count();
		import("ORG.Util.Page");
		$Page=new Page($count, $num);
		$Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
		$show=$Page->show();
		
		$List=$ModelWechatMaterialMusic->where(" 1 $_where ")->order("id DESC")->page($p.','.$num)->select();				
		
		$this->assign("count",$count);
		$this->assign("List",$List);
		$this->assign("page",$show);		
		return $this->fetch();
	}
	
	//显示添加页面
	public function add(){
		$ModelWechatMaterial=Db::name('WechatMaterial');
		
		$ListWechatMaterialImages=$ModelWechatMaterial->where("data_type='image' ")->select();
		
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		return $this->fetch();
	}
	
	//显示编辑页面
	public function edit(){
		$id = isset($_POST['id']) ? intval(trim($_POST['id'])) : intval($_GET['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		
		$getone=$ModelWechatMaterialMusic->where("id='$id'")->find();
		if(empty($getone)){ echo "paramer error!"; exit;  }
	
		$ListWechatMaterialImages=$ModelWechatMaterial->where("data_type='image'")->select();
	
		$this->assign("getone",$getone);
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		return $this->fetch();
	}
	
	//删除
	public function delete(){
		$id = isset($_POST['id']) ? intval(trim($_POST['id'])) : intval($_GET['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		$getone=$ModelWechatMaterialMusic->where("id='$id'")->find();
		if(empty($getone)){ echo "paramer error!"; exit;  }
		if(!empty($getone["url"])){//删除
			$_arr=explode("/", $getone["url"]);
			@unlink("./Public/Uploads/AutomaticReply/".$_arr[count($_arr)-2]."/".$_arr[count($_arr)-1]);
		}
		if(!empty($getone["hd_url"])){//删除
			$_arr=explode("/", $getone["hd_url"]);
			@unlink("./Public/Uploads/AutomaticReply/".$_arr[count($_arr)-2]."/".$_arr[count($_arr)-1]);
		}
		
		$ModelWechatMaterialMusic->where("id='$id'")->delete();
		
		$this->success("操作成功！",__URL__."/index",3);
		exit;
	}
	
	//提交添加页面表单
	public function insert(){
		$music_title=htmlspecialchars(trim($_POST['music_title']));
		$music_description=htmlspecialchars(trim($_POST['music_description']));
		$music_link_url="";
		$music_hq_link_url="";
		$thumb_url=htmlspecialchars(trim($_POST['thumb_url']));
		$music_thumb_media_id=htmlspecialchars(trim($_POST['music_thumb_media_id']));
		$gettime=time();
		
		require_once './Public/Lib/UploadFile.php';
		import('ORG.Util.Image');
		$_dir_time=date('Ymd');
		$_dir='./Public/Uploads/AutomaticReply/'. $_dir_time;
		if (!file_exists($_dir)) {mkdir($_dir, 0777, true);}
		if($_FILES['music_link_url']['size']>0){
			$music_link_url=upmusic($_dir."/","music_link_url");
			$music_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$music_link_url;
		}
		if($_FILES['music_hq_link_url']['size']>0){
			$music_hq_link_url=upmusic($_dir."/","music_hq_link_url");
			$music_hq_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$music_hq_link_url;
		}
		
		if(empty($music_title) or empty($music_description) 
		or empty($music_link_url) 
		or empty($music_thumb_media_id)
		){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		
		$data["title"]=$music_title;
		$data["introduction"]=$music_description;
		$data["url"]=$music_link_url;
		$data["hd_url"]=$music_hq_link_url;
		$data["thumb_url"]=$thumb_url;
		$data["thumb_media_id"]=$music_thumb_media_id;
		$data["data_type"]="music";
		$data["data_status"]="1";
		$data["create_time"]=$gettime;
		$data["update_time"]=$gettime;
		$ModelWechatMaterialMusic->add($data);
		
		$this->success("添加成功！",__URL__."/index",3);
		exit;
	}
	
	//提交编辑页面表单
	public function update(){
		$id=intval(trim($_POST['id']));
		$music_title=htmlspecialchars(trim($_POST['music_title']));
		$music_description=htmlspecialchars(trim($_POST['music_description']));
		$music_link_url=htmlspecialchars(trim($_POST['old_url']));
		$music_hq_link_url=htmlspecialchars(trim($_POST['old_hd_url']));
		$thumb_url=htmlspecialchars(trim($_POST['thumb_url']));
		$music_thumb_media_id=htmlspecialchars(trim($_POST['music_thumb_media_id']));
		$gettime=time();
		
		require_once './Public/Lib/UploadFile.php';
		import('ORG.Util.Image');
		$_dir_time=date('Ymd');
		$_dir='./Public/Uploads/AutomaticReply/'. $_dir_time;
		if (!file_exists($_dir)) {mkdir($_dir, 0777, true);}
		if($_FILES['music_link_url']['size']>0){
			if(!empty($music_link_url)){//删除
				$_arr=explode("/", $music_link_url);
				@unlink("./Public/Uploads/AutomaticReply/".$_arr[count($_arr)-2]."/".$_arr[count($_arr)-1]);
			}
			$music_link_url=upmusic($_dir."/","music_link_url");
			$music_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$music_link_url;
		}
		if($_FILES['music_hq_link_url']['size']>0){
			if(!empty($music_hq_link_url)){//删除
				$_arr=explode("/", $music_hq_link_url);
				@unlink("./Public/Uploads/AutomaticReply/".$_arr[count($_arr)-2]."/".$_arr[count($_arr)-1]);
			}
			$music_hq_link_url=upmusic($_dir."/","music_hq_link_url");
			$music_hq_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$music_hq_link_url;
		}
		
		if(empty($music_title) or empty($music_description)
		or empty($music_link_url) 
		or empty($music_thumb_media_id)
		){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		
		$data["title"]=$music_title;
		$data["introduction"]=$music_description;
		$data["url"]=$music_link_url;
		$data["hd_url"]=$music_hq_link_url;
		$data["thumb_url"]=$thumb_url;
		$data["thumb_media_id"]=$music_thumb_media_id;		
		$data["update_time"]=$gettime;
		$ModelWechatMaterialMusic->where("id='$id'")->save($data);
		
		$this->success("编辑成功！",__URL__."/index",3);
		exit;
	}
	
}