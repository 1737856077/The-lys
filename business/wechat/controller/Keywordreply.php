<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:KeywordReplyAction.class.php 2015-07-28 14:57:00 $
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
class Keywordreply extends UserCommon{
	
	public function index(){
	    $param = $this->request->param();
	    $SearchMsgType = isset($param['SearchMsgType']) ? $param['SearchMsgType'] : '' ;
		$SearchMsgType=urldecode($SearchMsgType);
		if(empty($SearchMsgType)){ $SearchMsgType="news";  }
		if($SearchMsgType=="news_material"){ $SearchMsgType="news";  }
		$parameter="/SearchMsgType/$SearchMsgType/";
		
		$ModelAutomaticReply=Db::name('AutomaticReply');
		
		$p=isset($param['p']) ? intval($param['p']) : 1;
		$num=20;
		$map = [];
        if(!empty($SearchName)){ $map['msgtype'] = ['like', '%' . $SearchMsgType . '%'];}
		$count = $ModelAutomaticReply->where($map)->where('data_status',1)->count();
		//import("ORG.Util.Page");
		//$Page=new Page($count, $num,$parameter);
		//$Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
		//$show=$Page->show();
		
		//$List=$ModelAutomaticReply->where(" 1 $_where ")->order("id DESC")->page($p.','.$num)->select();
        $List=$ModelAutomaticReply->where($map)->where('data_status',1)
            ->order('id DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();
				
		$this->assign("count",$count);
		$this->assign("List",$List);
		$this->assign("page",$show);
		$this->assign("SearchMsgType",$SearchMsgType);
		return $this->fetch();
	}
	
	//显示添加页面
	public function add(){
	    $param = $this->request->param();
		$MsgType = isset($param['MsgType']) ? $param['MsgType'] :'';
		$MsgType=htmlspecialchars(trim($MsgType));
		if(empty($MsgType)){ $MsgType="news";  }

		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');

		$ListWechatMaterialImages=$ModelWechatMaterial->where("data_type='image' ")->select();
		$ListWechatMaterialVideo=$ModelWechatMaterial->where("data_type='video' ")->select();
		$ListWechatMaterialVoice=$ModelWechatMaterial->where("data_type='voice' ")->select();
		$ListWechatMaterialMusic=$ModelWechatMaterialMusic->where("data_type='music' ")->select();

		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		$this->assign("ListWechatMaterialVideo",$ListWechatMaterialVideo);
		$this->assign("ListWechatMaterialVoice",$ListWechatMaterialVoice);
		$this->assign("ListWechatMaterialMusic",$ListWechatMaterialMusic);
		$this->assign("MsgType",$MsgType);
		return $this->fetch("add_".$MsgType);
	}
	
	//显示编辑页面
	public function edit(){
	    $param = $this->request->param();
		$id = isset($param['id']) ? intval(trim($param['id'])) : intval($param['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		
		$getone=$ModelAutomaticReply->where("id='$id'")->find();
		if(empty($getone)){ echo "paramer error!"; exit;  }
		$MsgType=$getone["msgtype"];
		if($getone["msgtype"]=="news" and !empty($getone["media_id"])){
			$MsgType="news_material";
		}
		
		$ListWechatMaterialImages=$ModelWechatMaterial->where("data_type='image' ")->select();
		$ListWechatMaterialVideo=$ModelWechatMaterial->where("data_type='video' ")->select();
		$ListWechatMaterialVoice=$ModelWechatMaterial->where("data_type='voice' ")->select();
		$ListWechatMaterialMusic=$ModelWechatMaterialMusic->where("data_type='music' ")->select();
		
		$this->assign("getone",$getone);
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		$this->assign("ListWechatMaterialVideo",$ListWechatMaterialVideo);
		$this->assign("ListWechatMaterialVoice",$ListWechatMaterialVoice);
		$this->assign("ListWechatMaterialMusic",$ListWechatMaterialMusic);
		$this->assign("MsgType",$MsgType);
		$this->display("edit_".$MsgType);
	}
	
	//提交添加表单
	public function insert(){
	    $param = $this->request->param();
	    $msgtype = isset($param['msgtype'])?htmlspecialchars(trim($param['msgtype'])):'';
        $key_word = isset($param['key_word'])?htmlspecialchars(trim($param['key_word'])):'';
		$gettime=time();
        $news_media_id = isset($param['news_media_id'])?htmlspecialchars(trim($param['news_media_id'])):'';
        $news_link_url = isset($param['news_link_url'])?htmlspecialchars(trim($param['news_link_url'])):'';
        $news_title = isset($param['news_title'])?htmlspecialchars(trim($param['news_title'])):'';
        $news_description = isset($param['news_description'])?htmlspecialchars(trim($param['news_description'])):'';
        $news_url = isset($param['news_url'])?htmlspecialchars(trim($param['news_url'])):'';
        $music_title = isset($param['music_title'])?htmlspecialchars(trim($param['music_title'])):'';
        $music_description = isset($param['music_description'])?htmlspecialchars(trim($param['music_description'])):'';
        $music_link_url = isset($param['music_link_url'])?htmlspecialchars(trim($param['music_link_url'])):'';
        $music_hq_link_url = isset($param['music_hq_link_url'])?htmlspecialchars(trim($param['music_hq_link_url'])):'';
        $music_thumb_media_id = isset($param['music_thumb_media_id'])?htmlspecialchars(trim($param['music_thumb_media_id'])):'';
        $video_media_id = isset($param['video_media_id'])?htmlspecialchars(trim($param['video_media_id'])):'';
        $video_title = isset($param['video_title'])?htmlspecialchars(trim($param['video_title'])):'';
        $video_description = isset($param['video_description'])?htmlspecialchars(trim($param['video_description'])):'';
        $voice_media_id = isset($param['voice_media_id'])?htmlspecialchars(trim($param['voice_media_id'])):'';
        $image_link_url = isset($param['image_link_url'])?htmlspecialchars(trim($param['image_link_url'])):'';
        $image_media_id = isset($param['image_media_id'])?htmlspecialchars(trim($param['image_media_id'])):'';
        $text_description = isset($param['text_description'])?htmlspecialchars(trim($param['text_description'])):'';

		$ModelAutomaticReply=Db::name('AutomaticReply');
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatAtricles=Db::name('WechatAtricles');
		
		require_once './Public/Lib/UploadFile.php';
		//import('ORG.Util.Image');
		//$Image = new Image();
		
		$_dir_time=date('Ymd');
		$_dir='./Public/Uploads/AutomaticReply/'. $_dir_time;
		
		if(empty($key_word)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		//查看关键词是否存在相同
		$getoneAutomaticReply=$ModelAutomaticReply->where("data_type=1 AND key_word='$key_word'")->find();
		if(!empty($getoneAutomaticReply)){
			$_msgtype=$getoneAutomaticReply["msgtype"];
			$_msgtype_str="";
			//news:图文消息；music：音乐消息；video：视频消息；voice：语音消息；image：图片消息；text：文本消息；
			if($_msgtype=="news" or $_msgtype=="news_material"){$_msgtype_str="图文回复";}
			else if($_msgtype=="music"){$_msgtype_str="音乐回复";}
			else if($_msgtype=="video"){$_msgtype_str="视频回复";}
			else if($_msgtype=="voice"){$_msgtype_str="语音回复";}
			else if($_msgtype=="image"){$_msgtype_str="图片回复";}
			else if($_msgtype=="text"){$_msgtype_str="文本回复";}
			echo "<script language=\"javascript\">alert(\"关键词在[ $_msgtype_str ]中已存在相同；！\");history.go(-1);</script>";
			exit;
		}
		
		if($msgtype=="news"){//图文消息
			if(empty($news_link_url) or empty($news_title) or empty($news_description) or empty($news_url)
			){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}else if($msgtype=="news_material"){//图文消息-素材库
			if(empty($news_media_id) ){
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
		$data["key_word"]=$key_word;
		$data["data_type"]="1";
		$data["data_status"]="1";
		$data["create_time"]=$gettime;
		$data["update_time"]=$gettime;
		if($msgtype=="news"){//图文消息
			$data["title"]=$news_title;
			$data["description"]=$news_description;
			$data["link_url"]=$news_link_url;
			$data["url"]=$news_url;
		}else if($msgtype=="news_material"){//图文消息-素材库
			$getoneWechatMaterial=$ModelWechatMaterial->where("media_id='$news_media_id'")->find();
			$_atricles_id_arr=explode(",", $getoneWechatMaterial["atricles_id"]);
			if(stripos($getoneWechatMaterial["atricles_id"],",")!==false){
				$getoneWechatAtricles=$ModelWechatAtricles->where("atr_id='$_atricles_id_arr[0]'")->find();
			}else{
				$getoneWechatAtricles=$ModelWechatAtricles->where("atr_id='$getoneWechatMaterial[atricles_id]'")->find();
			}
			//取得缩略图
			$getoneWechatMaterialThumb=$ModelWechatMaterial->where("media_id='$getoneWechatAtricles[thumb_media_id]'")->find();
			$data["msgtype"]="news";
			$data["title"]=$getoneWechatAtricles["title"];
			$data["description"]=$getoneWechatAtricles["digest"];
			$data["link_url"]=$getoneWechatMaterialThumb["url"];
			$data["url"]=$getoneWechatAtricles["content_source_url"];
			$data["media_id"]=$getoneWechatMaterial["media_id"];
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
		
		
		$ModelAutomaticReply->insertGetId($data);
		
		$this->success("添加成功！",url("keywordreply/index")."?SearchMsgType=$msgtype",3);
		exit;
	}
	
	//提交编辑表单
	public function update(){
	    $param = $this->request->param();
		$id=intval(trim($param['id']));
		$msgtype=htmlspecialchars(trim($param['msgtype']));
		$key_word=htmlspecialchars(trim($param['key_word']));
		$gettime=time();
	
		$news_media_id=htmlspecialchars(trim($param['news_media_id']));
		$news_link_url=htmlspecialchars(trim($param['news_link_url']));
		//$news_images=htmlspecialchars(trim($param['news_images']));
		$news_title=htmlspecialchars(trim($param['news_title']));
		$news_description=htmlspecialchars(trim($param['news_description']));
		$news_url=htmlspecialchars(trim($param['news_url']));
	
		$music_title=htmlspecialchars(trim($param['music_title']));
		$music_description=htmlspecialchars(trim($param['music_description']));
		$music_link_url=htmlspecialchars(trim($param['music_link_url']));
		$music_hq_link_url=htmlspecialchars(trim($param['music_hq_link_url']));
		$music_thumb_media_id=htmlspecialchars(trim($param['music_thumb_media_id']));
	
		$video_media_id=htmlspecialchars(trim($param['video_media_id']));
		$video_title=htmlspecialchars(trim($param['video_title']));
		$video_description=htmlspecialchars(trim($param['video_description']));
	
		$voice_media_id=htmlspecialchars(trim($param['voice_media_id']));
	
		$image_link_url=htmlspecialchars(trim($param['image_link_url']));
		$image_media_id=htmlspecialchars(trim($param['image_media_id']));
	
		$text_description=htmlspecialchars(trim($param['text_description']));
	
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatAtricles=Db::name('WechatAtricles');
		
		require_once './Public/Lib/UploadFile.php';
		//import('ORG.Util.Image');
		//$Image = new Image();
	
		$_dir_time=date('Ymd');
		$_dir='./Public/Uploads/AutomaticReply/'. $_dir_time;
	
		if(empty($key_word)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		//查看关键词是否存在相同
		$getoneAutomaticReply=$ModelAutomaticReply->where("data_type=1 AND id!='$id' AND key_word='$key_word'")->find();
		if(!empty($getoneAutomaticReply)){
			$_msgtype=$getoneAutomaticReply["msgtype"];
			$_msgtype_str="";
			//news:图文消息；music：音乐消息；video：视频消息；voice：语音消息；image：图片消息；text：文本消息；
			if($_msgtype=="news" or $_msgtype=="news_material"){$_msgtype_str="图文回复";}
			else if($_msgtype=="music"){$_msgtype_str="音乐回复";}
			else if($_msgtype=="video"){$_msgtype_str="视频回复";}
			else if($_msgtype=="voice"){$_msgtype_str="语音回复";}
			else if($_msgtype=="image"){$_msgtype_str="图片回复";}
			else if($_msgtype=="text"){$_msgtype_str="文本回复";}
			echo "<script language=\"javascript\">alert(\"关键词在[ $_msgtype_str ]中已存在相同；！\");history.go(-1);</script>";
			exit;
		}
	
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
		}else if($msgtype=="news_material"){//图文消息-素材库
				if(empty($news_media_id) ){
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
		$data["key_word"]=$key_word;
		$data["update_time"]=$gettime;
		if($msgtype=="news"){//图文消息
			$data["title"]=$news_title;
			$data["description"]=$news_description;
			$data["link_url"]=$news_link_url;
			$data["url"]=$news_url;
		}else if($msgtype=="news_material"){//图文消息-素材库
				$getoneWechatMaterial=$ModelWechatMaterial->where("media_id='$news_media_id'")->find();
				$_atricles_id_arr=explode(",", $getoneWechatMaterial["atricles_id"]);
				if(stripos($getoneWechatMaterial["atricles_id"],",")!==false){
					$getoneWechatAtricles=$ModelWechatAtricles->where("atr_id='$_atricles_id_arr[0]'")->find();
				}else{
					$getoneWechatAtricles=$ModelWechatAtricles->where("atr_id='$getoneWechatMaterial[atricles_id]'")->find();
				}
				//取得缩略图
				$getoneWechatMaterialThumb=$ModelWechatMaterial->where("media_id='$getoneWechatAtricles[thumb_media_id]'")->find();
				$data["msgtype"]="news";
				$data["title"]=$getoneWechatAtricles["title"];
				$data["description"]=$getoneWechatAtricles["digest"];
				$data["link_url"]=$getoneWechatMaterialThumb["url"];
				$data["url"]=$getoneWechatAtricles["content_source_url"];
				$data["media_id"]=$getoneWechatMaterial["media_id"];
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
	
		
		$ModelAutomaticReply->where("id='$id'")->update($data);
	
		$this->success("编辑成功！",url("keywordreply/index")."SearchMsgType=$msgtype",3);
		exit;
	}
	
	//删除
	public function delete(){
	    $param = $this->request->param();
		$id = isset($param['id']) ? intval(trim($param['id'])) : intval($param['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		
		$ModelAutomaticReply=Db::name('AutomaticReply');
		$getone=$ModelAutomaticReply->where("id='$id'")->find();
		if(empty($getone)){ echo "paramer error!"; exit;  }
		$MsgType=$getone["msgtype"];
		$ModelAutomaticReply->where("id='$id'")->delete();
		$this->success("操作成功！",url("keywordreply/index")."SearchMsgType=$MsgType",3);
		exit;
	}
}