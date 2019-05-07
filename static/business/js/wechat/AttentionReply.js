/**
 *  Create on  :  2015-07-27 14:48:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:AttentionReply.js
 */
 
//显示弹框
function Oclick_ShowBox(name){
	document.getElementById("div_material_image").style.display='none';
	document.getElementById("div_material_video").style.display='none';
	document.getElementById("div_material_voice").style.display='none';
	document.getElementById("div_material_music").style.display='none';
	
	document.getElementById("div_material_"+name).style.display='block';
	
	$('#dialogBg').fadeIn(300);
}
//关闭弹窗
function Oclick_claseDialogBtn(){
	$('#dialogBg').fadeOut(300,function(){
	});
} 
 
 
//选择消息类型
function SelectMsgType(id){
	document.getElementById("div_replay_news").style.display='none';
	document.getElementById("div_replay_music").style.display='none';
	document.getElementById("div_replay_video").style.display='none';
	document.getElementById("div_replay_voice").style.display='none';
	document.getElementById("div_replay_image").style.display='none';
	document.getElementById("div_replay_text").style.display='none';
	
	document.getElementById("div_replay_"+id).style.display='block';
	document.getElementById("msgtype").value=id;
}
 
//从图片素材库中选择图片使用 
function GetWechatMaterialImage(imgurl,mid){
	document.getElementById("news_link_url").value=imgurl;//图文消息-图片
	document.getElementById("image_link_url").value=imgurl;//图片消息-图片
	document.getElementById("image_media_id").value=mid;//图片消息-MediaId
	document.getElementById("music_thumb_media_id").value=imgurl;//音乐消息-缩略图的MediaId
	
	Oclick_claseDialogBtn();//关闭弹窗
}

//从语音素材库中选择使用 
function GetWechatMaterialVoice(mid){
	document.getElementById("voice_media_id").value=mid;//语音消息-语音的MediaId
	Oclick_claseDialogBtn();//关闭弹窗
}

//视频素材库中选择用
function GetWechatMaterialVideo(mid){
	document.getElementById("video_media_id").value=mid;//视频消息-视频的MediaId
	Oclick_claseDialogBtn();//关闭弹窗
}

//音乐素材库中选择素材使用 
function GetWechatMaterialMusic(url,hdurl,mid){
	document.getElementById("music_link_url").value=url;//多媒体素材URL
	document.getElementById("music_hq_link_url").value=hdurl;//高清多媒体素材URL
	document.getElementById("music_thumb_media_id").value=mid;//缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
	Oclick_claseDialogBtn();//关闭弹窗
}