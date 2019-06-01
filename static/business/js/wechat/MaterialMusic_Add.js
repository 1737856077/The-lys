/**
 *  Create on  :  2015-08-03 10:07:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:MaterialMusic_Add.js
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

//从图片素材库中选择图片使用 
function GetWechatMaterialImage(imgurl,mid){
	document.getElementById("thumb_url").value=imgurl;//图文消息-图片
	document.getElementById("music_thumb_media_id").value=mid;//图文消息-图片
	Oclick_claseDialogBtn();//关闭弹窗
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
	var tmptype=music_link_url.value.substr(music_link_url.value.lastIndexOf(".")+1);
	tmptype=tmptype.toLowerCase();
	if(music_link_url.value.trim()==""){
		span_music_link_url.innerHTML="音乐链接不能为空！";
		flag=false;
	}else if(tmptype!="mp3" ){
		span_music_link_url.innerHTML="音乐链接格式不对！";
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
	var tmptype=music_hq_link_url.value.substr(music_hq_link_url.value.lastIndexOf(".")+1);
	tmptype=tmptype.toLowerCase();
	if(music_hq_link_url.value.trim()==""){
		span_music_hq_link_url.innerHTML="高质量音乐链接不能为空！";
		flag=false;
	}else if(tmptype!="mp3" ){
		span_music_hq_link_url.innerHTML="高质量音乐链接格式不对！";
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


//音乐消息-音乐链接
function onblur_music_link_url_edit(){
	var flag=true;
	var music_link_url=document.getElementById("music_link_url");
	var span_music_link_url=document.getElementById("span_music_link_url");
	var tmptype=music_link_url.value.substr(music_link_url.value.lastIndexOf(".")+1);
	tmptype=tmptype.toLowerCase();
	if(music_link_url.value.trim()!=""){
		if(tmptype!="mp3" ){
			span_music_link_url.innerHTML="音乐链接格式不对！";
			flag=false;	
		}else{
			span_music_link_url.innerHTML="";
		}
	}else{
		span_music_link_url.innerHTML="";
	}
	return flag;
}
//音乐消息-高质量音乐链接
function onblur_music_hq_link_url_edit(){
	var flag=true;
	var music_hq_link_url=document.getElementById("music_hq_link_url");
	var span_music_hq_link_url=document.getElementById("span_music_hq_link_url");
	var tmptype=music_hq_link_url.value.substr(music_hq_link_url.value.lastIndexOf(".")+1);
	tmptype=tmptype.toLowerCase();
	if(music_hq_link_url.value.trim()!=""){
		if(tmptype!="mp3" ){
			span_music_hq_link_url.innerHTML="高质量音乐链接格式不对！";
			flag=false;
		}else{
			span_music_hq_link_url.innerHTML="";
		}
	}else{
		span_music_hq_link_url.innerHTML="";
	}
	return flag;
}

//提交验证
function funsubmit_update(){
	var flag=true;

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

//提交验证
function funsubmit_up(){
	var flag=true;

		//音乐消息-标题
		if(!onblur_music_title()){
			return 	flag=false;
		}
		//音乐消息-描述
		if(!onblur_music_description()){
			return 	flag=false;
		}
		//音乐消息-音乐链接
		if(!onblur_music_link_url_edit()){
			return 	flag=false;
		}
		//音乐消息-高质量音乐链接
		//if(!onblur_music_hq_link_url_edit()){
//			return 	flag=false;
//		}
		//音乐消息-缩略图的MediaId
		if(!onblur_music_thumb_media_id()){
			return 	flag=false;
		}	
	
	return true;
}
 