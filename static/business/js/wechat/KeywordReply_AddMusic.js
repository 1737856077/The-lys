/**
 *  Create on  :  2015-07-28 16:44:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:KeywordReply_AddMusic.js
 */

//显示弹框
function Oclick_ShowBox(name){
	document.getElementById("div_material_image").style.display='none';
	document.getElementById("div_material_music").style.display='none';
	
	document.getElementById("div_material_"+name).style.display='block';
	
	$('#dialogBg').fadeIn(300);
}
//关闭弹窗
function Oclick_claseDialogBtn(){
	$('#dialogBg').fadeOut(300,function(){
	});
}  

//从图片素材库中选择图片使用 
function GetWechatMaterialImage(imgurl){
	document.getElementById("music_thumb_media_id").value=imgurl;//图文消息-图片
	Oclick_claseDialogBtn();//关闭弹窗
}
//音乐素材库中选择素材使用 
function GetWechatMaterialMusic(url,hdurl,mid){
	document.getElementById("music_link_url").value=url;//多媒体素材URL
	document.getElementById("music_hq_link_url").value=hdurl;//高清多媒体素材URL
	document.getElementById("music_thumb_media_id").value=mid;//缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
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
//音乐消息-标题
function onblur_music_title(){
	var flag=true;
	var music_title=document.getElementById("music_title");
	var span_music_title=document.getElementById("span_music_title");
	if(music_title.value.trim()==""){
		span_music_title.innerHTML="标题不能为空！";
		flag=false;
	}else{
		span_music_title.innerHTML="";
	}
	return flag;
}
//音乐消息-描述
function onblur_music_description(){
	var flag=true;
	var music_description=document.getElementById("music_description");
	var span_music_description=document.getElementById("span_music_description");
	if(music_description.value.trim()==""){
		span_music_description.innerHTML="描述不能为空！";
		flag=false;
	}else{
		span_music_description.innerHTML="";
	}
	return flag;
}
//音乐消息-音乐链接
function onblur_music_link_url(){
	var flag=true;
	var music_link_url=document.getElementById("music_link_url");
	var span_music_link_url=document.getElementById("span_music_link_url");
	if(music_link_url.value.trim()==""){
		span_music_link_url.innerHTML="音乐链接不能为空！";
		flag=false;
	}else{
		span_music_link_url.innerHTML="";
	}
	return flag;
}
//音乐消息-高质量音乐链接
function onblur_music_hq_link_url(){
	var flag=true;
	var music_hq_link_url=document.getElementById("music_hq_link_url");
	var span_music_hq_link_url=document.getElementById("span_music_hq_link_url");
	if(music_hq_link_url.value.trim()==""){
		span_music_hq_link_url.innerHTML="高质量音乐链接不能为空！";
		flag=false;
	}else{
		span_music_hq_link_url.innerHTML="";
	}
	return flag;
}
//音乐消息-缩略图的MediaId
function onblur_music_thumb_media_id(){
	var flag=true;
	var music_thumb_media_id=document.getElementById("music_thumb_media_id");
	var span_music_thumb_media_id=document.getElementById("span_music_thumb_media_id");
	if(music_thumb_media_id.value.trim()==""){
		span_music_thumb_media_id.innerHTML="缩略图的MediaId不能为空！";
		flag=false;
	}else{
		span_music_thumb_media_id.innerHTML="";
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
		//音乐消息-标题
		if(!onblur_music_title()){
			return 	flag=false;
		}
		//音乐消息-描述
		if(!onblur_music_description()){
			return 	flag=false;
		}
		//音乐消息-音乐链接
		if(!onblur_music_link_url()){
			return 	flag=false;
		}
		//音乐消息-高质量音乐链接
		//if(!onblur_music_hq_link_url()){
//			return 	flag=false;
//		}
		//音乐消息-缩略图的MediaId
		if(!onblur_music_thumb_media_id()){
			return 	flag=false;
		}	
	
	return true;
}
 