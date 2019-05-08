/**
 *  Create on  :  2015-07-28 16:44:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:KeywordReply_AddVideo.js
 */

//显示弹框
function Oclick_ShowBox(name){
	document.getElementById("div_material_"+name).style.display='block';
	
	$('#dialogBg').fadeIn(300);
}
//关闭弹窗
function Oclick_claseDialogBtn(){
	$('#dialogBg').fadeOut(300,function(){
	});
}  

//视频素材库中选择用
function GetWechatMaterialVideo(mid){
	document.getElementById("video_media_id").value=mid;//视频消息-视频的MediaId
	Oclick_claseDialogBtn();//关闭弹窗
}
//关键字
function onblur_key_word(){
	var flag=true;
	var key_word=document.getElementById("key_word");
	var span_key_word=document.getElementById("span_key_word");
	if(key_word.value.trim()==""){
		span_key_word.innerHTML="关键字不能为空！";
		flag=false;
	}else{
		span_key_word.innerHTML="";
	}
	return flag;
}
//视频消息-视频的MediaId
function onblur_video_media_id(){
	var flag=true;
	var video_media_id=document.getElementById("video_media_id");
	var span_video_media_id=document.getElementById("span_video_media_id");
	if(video_media_id.value.trim()==""){
		span_video_media_id.innerHTML="视频的MediaId不能为空！";
		flag=false;
	}else{
		span_video_media_id.innerHTML="";
	}
	return flag;
}
//视频消息-标题
function onblur_video_title(){
	var flag=true;
	var video_title=document.getElementById("video_title");
	var span_video_title=document.getElementById("span_video_title");
	if(video_title.value.trim()==""){
		span_video_title.innerHTML="标题不能为空！";
		flag=false;
	}else{
		span_video_title.innerHTML="";
	}
	return flag;
}
//视频消息-描述
function onblur_video_description(){
	var flag=true;
	var video_description=document.getElementById("video_description");
	var span_video_description=document.getElementById("span_video_description");
	if(video_description.value.trim()==""){
		span_video_description.innerHTML="描述不能为空！";
		flag=false;
	}else{
		span_video_description.innerHTML="";
	}
	return flag;
}

//提交验证
function funsubmit_update(){
	var flag=true;
		//关键字
		if(!onblur_key_word()){
			return 	flag=false;
		}
		//视频消息-视频的MediaId
		if(!onblur_video_media_id()){
			return 	flag=false;
		}
		//视频消息-标题
		if(!onblur_video_title()){
			return 	flag=false;
		}
		//视频消息-描述
		if(!onblur_video_description()){
			return 	flag=false;
		}
	
	return true;
}
