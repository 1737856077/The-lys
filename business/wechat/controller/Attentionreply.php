<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:AttentionReplyAction.class.php 2015-07-24 16:27:00 $
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
use think\Config;
class Attentionreply extends UserCommon{
	
	public function index(){
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$getoneAutomaticReply=$ModelAutomaticReply->where("data_status=1 AND data_type=0")->find();
		
		$this->assign("getoneAutomaticReply",$getoneAutomaticReply);
		return $this->fetch();
	}
	
	//显示添加页面
	public function add(){
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		
		$getone['msgtype']="news";
		$ListWechatMaterialImages=$ModelWechatMaterial->where("data_type='image' ")
								->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialVideo=$ModelWechatMaterial->where("data_type='video' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialVoice=$ModelWechatMaterial->where("data_type='voice' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialMusic=$ModelWechatMaterialMusic->where("data_type='music' ")->order("create_time DESC")
								->limit("0,10")->select();
		
		$this->assign("getone",$getone);
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		$this->assign("ListWechatMaterialVideo",$ListWechatMaterialVideo);
		$this->assign("ListWechatMaterialVoice",$ListWechatMaterialVoice);
		$this->assign("ListWechatMaterialMusic",$ListWechatMaterialMusic);
		return $this->fetch();
	}
	
	//显示编辑页面
	public function edit(){
        $param = $this->request->param();
		$id=isset($param["id"]) ? intval(trim($param['id'])) : 0;
		if(!$id){ echo "paramter error!"; exit;}
		
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		
		$getone=$ModelAutomaticReply->where("id='$id'")->find();
		$ListWechatMaterialImages=$ModelWechatMaterial->where("data_type='image' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialVideo=$ModelWechatMaterial->where("data_type='video' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialVoice=$ModelWechatMaterial->where("data_type='voice' ")->order("create_time DESC")
								->limit("0,10")->select();		
		$ListWechatMaterialMusic=$ModelWechatMaterialMusic->where("data_type='music' ")->order("create_time DESC")
								->limit("0,10")->select();
		
		$this->assign("getone",$getone);
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		$this->assign("ListWechatMaterialVideo",$ListWechatMaterialVideo);
		$this->assign("ListWechatMaterialVoice",$ListWechatMaterialVoice);		
		$this->assign("ListWechatMaterialMusic",$ListWechatMaterialMusic);
		return $this->fetch();
	}
	
	//提交添加表单
	public function insert(){
		$msgtype=htmlspecialchars(trim($_POST['msgtype']));
		$gettime=time();
		
		$news_link_url=htmlspecialchars(trim($_POST['news_link_url']));
		//$news_images=htmlspecialchars(trim($_POST['news_images']));
		$news_title=htmlspecialchars(trim($_POST['news_title']));
		$news_description=htmlspecialchars(trim($_POST['news_description']));
		$news_url=htmlspecialchars(trim($_POST['news_url']));
		
		$music_title=htmlspecialchars(trim($_POST['music_title']));
		$music_description=htmlspecialchars(trim($_POST['music_description']));
		$music_link_url=htmlspecialchars(trim($_POST['music_link_url']));
		$music_hq_link_url=htmlspecialchars(trim($_POST['music_hq_link_url']));
		$music_thumb_media_id=htmlspecialchars(trim($_POST['music_thumb_media_id']));
		
		$video_media_id=htmlspecialchars(trim($_POST['video_media_id']));
		$video_title=htmlspecialchars(trim($_POST['video_title']));
		$video_description=htmlspecialchars(trim($_POST['video_description']));
		
		$voice_media_id=htmlspecialchars(trim($_POST['voice_media_id']));
		
		$image_link_url=htmlspecialchars(trim($_POST['image_link_url']));
		$image_media_id=htmlspecialchars(trim($_POST['image_media_id']));
		
		$text_description=htmlspecialchars(trim($_POST['text_description']));
		
		require_once './Public/Lib/UploadFile.php';
		//import('ORG.Util.Image');
		//$Image = new Image();
		
		$_dir_time=date('Ymd');
		$_dir='./Public/Uploads/AutomaticReply/'. $_dir_time;
		if($msgtype=="news"){//图文消息
			if (!file_exists($_dir)) {mkdir($_dir, 0777, true);}
			if(empty($news_link_url) and $_FILES['news_images']['size']>0){
				$news_link_url=upface($_dir."/","news_images");
                $Image = Image::open($_dir."/".$news_link_url);
				//$news_link_url=$Image->thumb($_dir."/".$news_link_url, $_dir."/"."thumb_".$news_link_url,"",C('AutomaticReply_Width'),C('AutomaticReply_Height'));
                $news_link_url=$_dir."/"."thumb_".$news_link_url;
                $Image->thumb(config('AutomaticReply_Width'), config('AutomaticReply_Height'))
                    ->save($news_link_url);
                $news_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$news_link_url;
			}
		
			if(empty($news_link_url) or empty($news_title) or empty($news_description) or empty($news_url)
			){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="music"){//音乐消息
			if(empty($music_title) or empty($music_description) or empty($music_link_url) or empty($music_thumb_media_id)
			){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="video"){//视频消息
			if(empty($video_media_id) or empty($video_title) or empty($video_description)
			){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="voice"){//语音消息
			if(empty($voice_media_id) ){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="image"){//图片消息
			if (!file_exists($_dir)) {mkdir($_dir, 0777, true);}
			if(empty($image_link_url) and $_FILES['image_images']['size']>0){
				$image_link_url=upface($_dir."/","image_images");
                $Image = Image::open($_dir."/".$image_link_url);
				//$image_link_url=$Image->thumb($_dir."/".$image_link_url, $_dir."/"."thumb_".$image_link_url,"",C('AutomaticReply_Width'),C('AutomaticReply_Height'));
                $image_link_url=$_dir."/"."thumb_".$image_link_url;
                $Image->thumb(config('AutomaticReply_Width'), config('AutomaticReply_Height'))
                    ->save($image_link_url);
				$image_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$image_link_url;
			}
				
			if(empty($image_link_url) ){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="text"){//文本消息
			if(empty($text_description) ){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		
		$data=array();
		$data["msgtype"]=$msgtype;
		$data["data_type"]="0";
		$data["data_status"]="1";
		$data["create_time"]=$gettime;
		$data["update_time"]=$gettime;
		if($msgtype=="news"){//图文消息
			$data["title"]=$news_title;
			$data["description"]=$news_description;
			$data["link_url"]=$news_link_url;
			$data["url"]=$news_url;
		}else if($msgtype=="music"){//音乐消息
			$data["title"]=$music_title;
			$data["description"]=$music_description;
			$data["link_url"]=$music_link_url;
			$data["hq_link_url"]=$music_hq_link_url;
			$data["thumb_media_id"]=$music_thumb_media_id;
		}else if($msgtype=="video"){//视频消息
			$data["title"]=$video_title;
			$data["description"]=$video_description;
			$data["media_id"]=$video_media_id;
		}else if($msgtype=="voice"){//语音消息
			$data["media_id"]=$voice_media_id;
		}else if($msgtype=="image"){//图片消息
			$data["link_url"]=$image_link_url;
			$data["media_id"]=$image_media_id;
		}else if($msgtype=="text"){//文本消息
			$data["description"]=$text_description;
		}
		
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$ModelAutomaticReply->insertGetId($data);
		
		$this->success("添加成功！",url("attentionreply/index"),3);
		exit;
	}
	
	//提交编辑表单
	public function update(){
		$msgtype=htmlspecialchars(trim($_POST['msgtype']));
		$id=intval(trim($_POST['id']));
		$gettime=time();
		
		$news_link_url=htmlspecialchars(trim($_POST['news_link_url']));
		//$news_images=htmlspecialchars(trim($_POST['news_images']));
		$news_title=htmlspecialchars(trim($_POST['news_title']));
		$news_description=htmlspecialchars(trim($_POST['news_description']));
		$news_url=htmlspecialchars(trim($_POST['news_url']));
		
		$music_title=htmlspecialchars(trim($_POST['music_title']));
		$music_description=htmlspecialchars(trim($_POST['music_description']));
		$music_link_url=htmlspecialchars(trim($_POST['music_link_url']));
		$music_hq_link_url=htmlspecialchars(trim($_POST['music_hq_link_url']));
		$music_thumb_media_id=htmlspecialchars(trim($_POST['music_thumb_media_id']));
		
		$video_media_id=htmlspecialchars(trim($_POST['video_media_id']));
		$video_title=htmlspecialchars(trim($_POST['video_title']));
		$video_description=htmlspecialchars(trim($_POST['video_description']));
		
		$voice_media_id=htmlspecialchars(trim($_POST['voice_media_id']));
		
		$image_link_url=htmlspecialchars(trim($_POST['image_link_url']));
		$image_media_id=htmlspecialchars(trim($_POST['image_media_id']));
		
		$text_description=htmlspecialchars(trim($_POST['text_description']));
		
		require_once './Public/Lib/UploadFile.php';
		//import('ORG.Util.Image');
		//$Image = new Image();
		
		$_dir_time=date('Ymd');
		$_dir='./Public/Uploads/AutomaticReply/'. $_dir_time;
		if($msgtype=="news"){//图文消息			
			if (!file_exists($_dir)) {mkdir($_dir, 0777, true);}
			if(empty($news_link_url) and $_FILES['news_images']['size']>0){
				$news_link_url=upface($_dir."/","news_images");
                $Image = Image::open($_dir."/".$news_link_url);
				//$news_link_url=$Image->thumb($_dir."/".$news_link_url, $_dir."/"."thumb_".$news_link_url,"",C('AutomaticReply_Width'),C('AutomaticReply_Height'));
                $news_link_url=$_dir."/"."thumb_".$news_link_url;
                $Image->thumb(config('AutomaticReply_Width'), config('AutomaticReply_Height'))
                    ->save($news_link_url);
                $news_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$news_link_url;
			}
				
			if(empty($news_link_url) or empty($news_title) or empty($news_description) or empty($news_url)
			){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="music"){//音乐消息
			if(empty($music_title) or empty($music_description) or empty($music_link_url) or empty($music_thumb_media_id)
			){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="video"){//视频消息
			if(empty($video_media_id) or empty($video_title) or empty($video_description) 
			){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="voice"){//语音消息
			if(empty($voice_media_id) ){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="image"){//图片消息
			if (!file_exists($_dir)) {mkdir($_dir, 0777, true);}
			if(empty($image_link_url) and $_FILES['image_images']['size']>0){
				$image_link_url=upface($_dir."/","image_images");
                $Image = Image::open($_dir."/".$image_link_url);
				//$image_link_url=$Image->thumb($_dir."/".$image_link_url, $_dir."/"."thumb_".$image_link_url,"",C('AutomaticReply_Width'),C('AutomaticReply_Height'));
                $image_link_url=$_dir."/"."thumb_".$image_link_url;
                $Image->thumb(config('AutomaticReply_Width'), config('AutomaticReply_Height'))
                    ->save($image_link_url);
                $image_link_url=parent::GetServerHostUrl().str_replace(".", '', $_dir)."/".$image_link_url;
			}
			
			if(empty($image_link_url) ){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="text"){//文本消息
			if(empty($text_description) ){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		
		$data=array();
		$data["msgtype"]=$msgtype;
		$data["update_time"]=$gettime;
		if($msgtype=="news"){//图文消息
			$data["title"]=$news_title;
			$data["description"]=$news_description;
			$data["link_url"]=$news_link_url;
			$data["url"]=$news_url;			
		}else if($msgtype=="music"){//音乐消息
			$data["title"]=$music_title;
			$data["description"]=$music_description;
			$data["link_url"]=$music_link_url;
			$data["hq_link_url"]=$music_hq_link_url;
			$data["thumb_media_id"]=$music_thumb_media_id;
		}else if($msgtype=="video"){//视频消息
			$data["title"]=$video_title;
			$data["description"]=$video_description;
			$data["media_id"]=$video_media_id;
		}else if($msgtype=="voice"){//语音消息
			$data["media_id"]=$voice_media_id;
		}else if($msgtype=="image"){//图片消息
			$data["link_url"]=$image_link_url;
			$data["media_id"]=$image_media_id;
		}else if($msgtype=="text"){//文本消息			
			$data["description"]=$text_description;
		}
		
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$ModelAutomaticReply->where("id='$id'")->update($data);
		
		$this->success("更新成功！",url("attentionreply/index"),3);
		exit;
	}
	
	
}