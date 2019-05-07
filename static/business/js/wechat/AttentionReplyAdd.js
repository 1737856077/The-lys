/**
 *  Create on  :  2015-07-28 11:49:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:AttentionReplyAdd.js
 */

//图文消息-图片	
function onblur_news_link_url(){
	var flag=true;
	var news_link_url=document.getElementById("news_link_url");
	var news_images=document.getElementById("news_images");
	var span_news_link_url=document.getElementById("span_news_link_url");
	if(news_link_url.value.trim()=="" && news_images.value.trim()==""){
		span_news_link_url.innerHTML="图片不能为空！";
		flag=false;
	}else if(news_link_url.value.trim()=="" && news_images.value.trim()!=""){
		var tmptype=news_images.value.substr(news_images.value.lastIndexOf(".")+1);
		tmptype=tmptype.toLowerCase();
		if(tmptype=="jpg" || tmptype=="png" || tmptype=="gif" ){
			span_news_link_url.innerHTML="";
		}else{
			span_news_link_url.innerHTML="图片格式错误！";
			return false;	
		}	
	}else{
		span_news_link_url.innerHTML="";
	}
	return flag;
}
//图文消息-标题
function onblur_news_title(){
	var flag=true;
	var news_title=document.getElementById("news_title");
	var span_news_title=document.getElementById("span_news_title");
	if(news_title.value.trim()==""){
		span_news_title.innerHTML="标题不能为空！";
		flag=false;
	}else{
		span_news_title.innerHTML="";
	}
	return flag;
}
//图文消息-描述
function onblur_news_description(){
	var flag=true;
	var news_description=document.getElementById("news_description");
	var span_news_description=document.getElementById("span_news_description");
	if(news_description.value.trim()==""){
		span_news_description.innerHTML="描述不能为空！";
		flag=false;
	}else{
		span_news_description.innerHTML="";
	}
	return flag;
}
//图文消息-URL
function onblur_news_url(){
	var flag=true;
	var news_url=document.getElementById("news_url");
	var span_news_url=document.getElementById("span_news_url");
	if(news_url.value.trim()==""){
		span_news_url.innerHTML="URL不能为空！";
		flag=false;
	}else{
		span_news_url.innerHTML="";
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

//语音消息-语音的MediaId
function onblur_voice_media_id(){
	var flag=true;
	var voice_media_id=document.getElementById("voice_media_id");
	var span_voice_media_id=document.getElementById("span_voice_media_id");
	if(voice_media_id.value.trim()==""){
		span_voice_media_id.innerHTML="语音的MediaId不能为空！";
		flag=false;
	}else{
		span_voice_media_id.innerHTML="";
	}
	return flag;
}

//图片消息-图片
function onblur_image_link_url(){
	var flag=true;
	var image_link_url=document.getElementById("image_link_url");
	var image_images=document.getElementById("image_images");
	var span_image_link_url=document.getElementById("span_image_link_url");
	if(image_link_url.value.trim()=="" && image_images.value.trim()==""){
		span_image_link_url.innerHTML="图片不能为空！";
		flag=false;
	}else if(image_link_url.value.trim()=="" && image_images.value.trim()!=""){
		var tmptype=image_images.value.substr(image_images.value.lastIndexOf(".")+1);
		tmptype=tmptype.toLowerCase();
		if(tmptype=="jpg" || tmptype=="png" || tmptype=="gif" ){
			span_image_link_url.innerHTML="";
		}else{
			span_image_link_url.innerHTML="图片格式错误！";
			return false;	
		}	
	}else{
		span_image_link_url.innerHTML="";
	}
	return flag;
}

//文本消息-文本
function onblur_text_description(){
	var flag=true;
	var text_description=document.getElementById("text_description");
	var span_text_description=document.getElementById("span_text_description");
	if(text_description.value.trim()==""){
		span_text_description.innerHTML="文本不能为空！";
		flag=false;
	}else{
		span_text_description.innerHTML="";
	}
	return flag;
}

//提交验证
function funsubmit_update(){
	var flag=true;
	var msgtype=document.getElementById("msgtype").value.trim();
	if(msgtype=="news"){//图文消息
		//图文消息-图片	
		if(!onblur_news_link_url()){
			return 	flag=false;
		}
		//图文消息-标题
		if(!onblur_news_title()){
			return 	flag=false;
		}
		//图文消息-描述
		if(!onblur_news_description()){
			return 	flag=false;
		}
		//图文消息-URL
		if(!onblur_news_url()){
			return 	flag=false;
		}
	}else if(msgtype=="music"){//音乐消息
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
		
	}else if(msgtype=="video"){//视频消息
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
	}else if(msgtype=="voice"){//语音消息
		//语音消息-语音的MediaId
		if(!onblur_voice_media_id()){
			return 	flag=false;
		}
	}else if(msgtype=="image"){//图片消息
		//图片消息-图片
		if(!onblur_image_link_url()){
			return 	flag=false;
		}
	}else if(msgtype=="text"){//文本消息		
		//文本消息-文本
		if(!onblur_text_description()){
			return 	flag=false;
		}
	}
	

	
	
	
	return true;
}
