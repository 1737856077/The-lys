<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:HomeReplyWechatWatchAction.php 2015-08-05 09:12:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\wechat\controller\HomeConsumptionPushAction;
class HomeReplyWechatWatchAction extends Controller{
	
	/**
	 * @描述：关注回复
	 * @param 	string 	$ToUserName		--接收者-普通用户openid
	 * @param 	string 	$FromUserName	--发送方的公众号ID
	 */
	public function AttentionReply($ToUserName,$FromUserName){
		$ModelAutomaticReply=Db::name("AutomaticReply");
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatAtricles=Db::name('WechatAtricles');
		$gettime=time();
		
			$getoneAutomaticReply=$ModelAutomaticReply->where("data_type=0")
													->order("create_time DESC")->find();
			if(empty($getoneAutomaticReply)){
				return "";
			}
			//wirtefile(json_encode($info));
			
			//news:图文消息；music：音乐消息；video：视频消息；voice：语音消息；image：图片消息；text：文本消息；
			if($getoneAutomaticReply["msgtype"]=="news"){//news:图文消息；
				$articles=array();
// 				if(!empty($getoneAutomaticReply["media_id"])){//素材库
// 					$getoneWechatMaterial=$ModelWechatMaterial->where("media_id='$getoneAutomaticReply[media_id]'")->find();
// 					$_atricles_id_arr=explode(",", $getoneWechatMaterial["atricles_id"]);
// 					foreach($_atricles_id_arr as $k=>$val){
// 						$getoneWechatAtricles=$ModelWechatAtricles->where("atr_id='$val'")->find();
// 						//取得缩略图URL
// 						$getoneWechatMaterialThumb=$ModelWechatMaterial->where("media_id='$getoneWechatAtricles[thumb_media_id]'")->find();
						
// 						$articles[$k]=array("title"=>$getoneWechatAtricles["title"],
// 								"description"=>$getoneWechatAtricles["digest"],
// 								"url"=>$getoneWechatAtricles["content_source_url"],
// 								"picurl"=>$getoneWechatMaterialThumb["url"],
// 						);
// 					}
					
// 				}else{
					$articles[0]=array("title"=>$getoneAutomaticReply["title"],
							"description"=>htmlspecialchars_decode($getoneAutomaticReply["description"]),
							"url"=>$getoneAutomaticReply["url"],
							"picurl"=>$getoneAutomaticReply["link_url"],
					);
				//}
					
			}else if($getoneAutomaticReply["msgtype"]=="music"){//音乐消息
				$articles=array("media_id"=>$getoneAutomaticReply["thumb_media_id"],
						"title"=>$getoneAutomaticReply["title"],
						"description"=>htmlspecialchars_decode($getoneAutomaticReply["description"]),
						"music_url"=>$getoneAutomaticReply["link_url"],
						"hd_music_url"=>$getoneAutomaticReply["hq_link_url"],
				);
			}else if($getoneAutomaticReply["msgtype"]=="video"){//视频消息
				$articles=array("media_id"=>$getoneAutomaticReply["media_id"],
						"title"=>$getoneAutomaticReply["title"],
						"description"=>htmlspecialchars_decode($getoneAutomaticReply["description"]),
				);
			}else if($getoneAutomaticReply["msgtype"]=="voice"){//语音消息
				$articles=array("media_id"=>$getoneAutomaticReply["media_id"]);
			}else if($getoneAutomaticReply["msgtype"]=="image"){//图片消息
				$articles=array("media_id"=>$getoneAutomaticReply["media_id"]);
			}else if($getoneAutomaticReply["msgtype"]=="text"){//文本消息
				$articles=htmlspecialchars_decode($getoneAutomaticReply["description"]);
			}
	
			//回复关键字 begin
			$ConsumptionPushAction=new HomeConsumptionPushAction();
			$xml=$ConsumptionPushAction->AutomaticReply($articles,$ToUserName,$FromUserName,$getoneAutomaticReply["msgtype"]);
				
			//wirtefile($xml);
			return $xml;
			//回复关键字 end
		
	
		return '';
	}
	
	/**
	 * @描述：关键词回复
	 * @param 	mixed 	$info		--传入的参数
	 * @param 	string 	$ToUserName		--接收者-普通用户openid
	 * @param 	string 	$FromUserName	--发送方的公众号ID
	 */
	public function KeywordReply($info,$ToUserName,$FromUserName){
		$ModelAutomaticReply=Db::name("AutomaticReply");
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelWechatAtricles=Db::name('WechatAtricles');
		$gettime=time();
		if(!empty($info['Content'])){		
			$getoneAutomaticReply=$ModelAutomaticReply->where("data_type=1 AND key_word='$info[Content]'")
													->order("create_time DESC")->find();
			if(empty($getoneAutomaticReply)){
				return "";
			}
			//wirtefile(json_encode($info));
			//添加日志
			$ModelWechatWatchSendInfo=Db::name("WechatWatchSendInfo");
			$countWechatWatchSendInfo=$ModelWechatWatchSendInfo->where("msg_id='$info[MsgID]'")->count();
			if(!$countWechatWatchSendInfo){
				$dataWechatWatchSendInfo=array("send_info_id"=>returnUUID(),
						"msg_type"=>"text",
						"msg_id"=>$info['MsgID'],
						"from_username"=>$ToUserName,
						"to_username"=>$FromUserName,
						"description"=>$info['Content'],
						"msg_time"=>$info['CreateTime'],
						"create_time"=>$gettime,
						"update_time"=>$gettime,
				);
				$ModelWechatWatchSendInfo->add($dataWechatWatchSendInfo);
			}
			//news:图文消息；music：音乐消息；video：视频消息；voice：语音消息；image：图片消息；text：文本消息；
			if($getoneAutomaticReply["msgtype"]=="news"){//news:图文消息；
				$articles=array();
				if(!empty($getoneAutomaticReply["media_id"])){//素材库
					$getoneWechatMaterial=$ModelWechatMaterial->where("media_id='$getoneAutomaticReply[media_id]'")->find();
					$_atricles_id_arr=explode(",", $getoneWechatMaterial["atricles_id"]);
					foreach($_atricles_id_arr as $k=>$val){
						$getoneWechatAtricles=$ModelWechatAtricles->where("atr_id='$val'")->find();
						//取得缩略图URL
						$getoneWechatMaterialThumb=$ModelWechatMaterial->where("media_id='$getoneWechatAtricles[thumb_media_id]'")->find();
				
						$articles[$k]=array("title"=>$getoneWechatAtricles["title"],
								"description"=>htmlspecialchars_decode($getoneWechatAtricles["digest"]),
								"url"=>$getoneWechatAtricles["content_source_url"],
								"picurl"=>$getoneWechatMaterialThumb["url"],
						);
					}
					
				}else{
					$articles[0]=array("title"=>$getoneAutomaticReply["title"],
							"description"=>htmlspecialchars_decode($getoneAutomaticReply["description"]),
							"url"=>$getoneAutomaticReply["url"],
							"picurl"=>$getoneAutomaticReply["link_url"],
					);
				}
			}else if($getoneAutomaticReply["msgtype"]=="music"){//音乐消息
				$articles=array("media_id"=>$getoneAutomaticReply["thumb_media_id"],
						"title"=>$getoneAutomaticReply["title"],
						"description"=>htmlspecialchars_decode($getoneAutomaticReply["description"]),
						"music_url"=>$getoneAutomaticReply["link_url"],
						"hd_music_url"=>$getoneAutomaticReply["hq_link_url"],
				);
			}else if($getoneAutomaticReply["msgtype"]=="video"){//视频消息
				$articles=array("media_id"=>$getoneAutomaticReply["media_id"],
						"title"=>$getoneAutomaticReply["title"],
						"description"=>htmlspecialchars_decode($getoneAutomaticReply["description"]),
				);
			}else if($getoneAutomaticReply["msgtype"]=="voice"){//语音消息
				$articles=array("media_id"=>$getoneAutomaticReply["media_id"]);
			}else if($getoneAutomaticReply["msgtype"]=="image"){//图片消息
				$articles=array("media_id"=>$getoneAutomaticReply["media_id"]);
			}else if($getoneAutomaticReply["msgtype"]=="text"){//文本消息
				$articles=htmlspecialchars_decode($getoneAutomaticReply["description"]);
			}
		
			//回复关键字 begin
			$ConsumptionPushAction=new HomeConsumptionPushAction();
			$xml=$ConsumptionPushAction->AutomaticReply($articles,$ToUserName,$FromUserName,$getoneAutomaticReply["msgtype"]);
			
			//wirtefile($xml);
			return $xml;			
			//回复关键字 end
		}
		
		return '';
	}
	
}

