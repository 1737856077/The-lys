<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:HomeConsumptionPushAction.php 2015-07-03 11:33:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\wechat\controller\HomeCommonAction;
class HomeConsumptionPushAction extends Controller{
	
	/*
	 * @描述：发送图文信息
	 * @param	string	$openid		--接收者-普通用户openid 
	 * @param	array	$articles	--需发送的信息，最多10条信息
	 */
	public function PushNews($openid,$articles){

		$jsonstr='{
					"touser":"'.$openid.'",
					"msgtype":"news",
					"news":{
						"articles": [';
						foreach($articles as $key=>$value){
							$jsonstr.='{
								"title":"'.$value['title'].'",
								"description":"'.$value['description'].'",
								"url":"'.$value['url'].'",
								"picurl":"'.$value['picurl'].'"
							},';
						}
						$jsonstr.=']
					}
				}';
	
		$CommonAction=new HomeCommonAction();
		
		$posturl="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$CommonAction->GetAccessToken();
		$CommonAction->PostSend($posturl,$jsonstr);
		
	}
	
	/**
	 * @描述：自动回复，回复图文信息
	 * @param 	mixed 	$articles		--发送信息
	 * @param 	string 	$ToUserName		--接收者-普通用户openid 
	 * @param 	string 	$FromUserName	--发送方的公众号ID
	 * @param 	string 	$MsgType		--消息类型（news:图文消息；music：音乐消息；
	 * 											video：视频消息；voice：语音消息；
	 * 											image：图片消息；text：文本消息；）
	 */
	public function AutomaticReply($articles,$ToUserName,$FromUserName,$MsgType="news"){
		$CreateTime=time();
		$xml='<xml>
						<ToUserName><![CDATA['.$ToUserName.']]></ToUserName>
						<FromUserName><![CDATA['.$FromUserName.']]></FromUserName>
						<CreateTime>'.$CreateTime.'</CreateTime>
						<MsgType><![CDATA['.$MsgType.']]></MsgType>';
		if($MsgType=="news"){//图文消息
			$xml.='<ArticleCount>'.count($articles).'</ArticleCount>
				   <Articles>';
						foreach($articles as $key=>$value){
							$xml.='<item>
									<Title><![CDATA['.$value['title'].']]></Title>
									<Description><![CDATA['.$value['description'].']]></Description>
									<PicUrl><![CDATA['.$value['picurl'].']]></PicUrl>
									<Url><![CDATA['.$value['url'].']]></Url>
									</item>';
						}
			$xml.='</Articles>';
		}else if($MsgType=="music"){//音乐消息
			$xml.='<Music>
						<Title><![CDATA['.$articles['title'].']]></Title>
						<Description><![CDATA['.$articles['description'].']]></Description>
						<MusicUrl><![CDATA['.$articles['music_url'].']]></MusicUrl>
						<HQMusicUrl><![CDATA['.$articles['hd_music_url'].']]></HQMusicUrl>
						<ThumbMediaId><![CDATA['.$articles['media_id'].']]></ThumbMediaId>
					</Music>';
		}else if($MsgType=="video"){//视频消息
			$xml.='<Video>
						<MediaId><![CDATA['.$articles['media_id'].']]></MediaId>
						<Title><![CDATA['.$articles['title'].']]></Title>
						<Description><![CDATA['.$articles['description'].']]></Description>
				</Video>';
		}else if($MsgType=="voice"){//语音消息
			$xml.='<Voice>
						<MediaId><![CDATA['.$articles['media_id'].']]></MediaId>
					</Voice>';
		}else if($MsgType=="image"){//图片消息
			$xml.='<Image>
						<MediaId><![CDATA['.$articles['media_id'].']]></MediaId>
				</Image>';
		}else if($MsgType=="text"){//文本消息
			$xml.='<Content><![CDATA['.$articles.']]></Content>';
		}
		$xml.='</xml>';
		return $xml;
	}
	
}
