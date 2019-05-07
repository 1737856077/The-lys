/**
 *  Create on  :  2015-07-28 16:30:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:KeywordReply_AddNews.js
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
function GetWechatMaterialImage(imgurl){
	document.getElementById("news_link_url").value=imgurl;//图文消息-图片
	Oclick_claseDialogBtn();//关闭弹窗
}
//从素材库选择，图文
function GetWechatMaterial(mid){
	document.getElementById("news_media_id").value=mid;//
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
//图文消息-素材的MediaId
function onblur_news_media_id(){
	var flag=true;
	var news_media_id=document.getElementById("news_media_id");
	var span_news_media_id=document.getElementById("span_news_media_id");
	if(news_media_id.value.trim()==""){
		span_news_media_id.innerHTML="素材的MediaId不能为空！";
		flag=false;
	}else{
		span_news_media_id.innerHTML="";
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
	
	return true;
}

//提交验证
function funsubmit_news_material(){
	var flag=true;
		//关键字
		if(!onblur_key_word()){
			return 	flag=false;
		}
		
		//图文消息-素材的MediaId
		if(!onblur_news_media_id()){
			return 	flag=false;
		}
	
	return true;
}
 