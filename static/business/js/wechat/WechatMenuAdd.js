/**
 *  Create on  :  2015-07-31 11:23:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:WechatMenuAdd.js
 */

//显示弹框
function Oclick_ShowBox(name){
	document.getElementById("div_material_image").style.display='none';
	document.getElementById("div_material_video").style.display='none';
	document.getElementById("div_material_voice").style.display='none';
	document.getElementById("div_material_mpnews").style.display='none';
	if(name=="music" || name=="voice" ){
		document.getElementById("div_material_voice").style.display='block';
	}else if(name=="text" ){
	}else{
		document.getElementById("div_material_"+name).style.display='block';
	}
	$('#dialogBg').fadeIn(300);
}
//关闭弹窗
function Oclick_claseDialogBtn(){
	$('#dialogBg').fadeOut(300,function(){
	});
}
//从素材库中选择使用 
function GetWechatMaterial(mid){
	document.getElementById("media_id").value=mid;
	Oclick_claseDialogBtn();//关闭弹窗
}


//名称
function onblur_title(){
	var flag=true;
	var title=document.getElementById("title");
	var span_title=document.getElementById("span_title");
	if(title.value.trim()==""){
		span_title.innerHTML="名称不能为空！";
		flag=false;
	}else{
		span_title.innerHTML="";
	}
	return flag;
}
//跳转的URL
function onblur_url(){
	var flag=true;
	var data_type=document.getElementById("data_type");
	var url=document.getElementById("url");
	var span_url=document.getElementById("span_url");
	if(data_type.value=="view"){//跳转URL
		if(url.value.trim()==""){
			span_url.innerHTML="跳转的URL不能为空！";
			flag=false;
		}else{
			span_url.innerHTML="";
		}
	}else{
		span_url.innerHTML="";
	}
	
	return flag;
}
//按钮的KEY
function onblur_btn_key(){
	var flag=true;
	var data_type=document.getElementById("data_type");
	var btn_key=document.getElementById("btn_key");
	var span_btn_key=document.getElementById("span_btn_key");
	if(data_type.value=="click"){//点击推事件
		if(btn_key.value.trim()==""){
			span_btn_key.innerHTML="按钮的KEY不能为空！";
			flag=false;
		}else{
			span_btn_key.innerHTML="";
		}
	}else{
		span_btn_key.innerHTML="";
	}
	
	return flag;
}
//素材的MediaId
function onblur_media_id(){
	var flag=true;
	var data_type=document.getElementById("data_type");
	var media_id=document.getElementById("media_id");
	var span_media_id=document.getElementById("span_media_id");
	if(data_type.value=="media_id" || data_type.value=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
		if(media_id.value.trim()==""){
			span_media_id.innerHTML="素材的MediaId不能为空！";
			flag=false;
		}else{
			span_media_id.innerHTML="";
		}
	}else{
		span_media_id.innerHTML="";
	}
	
	return flag;
}


//提交验证
function funsubmit_add(){
	var flag=true;
	
	//名称
	if(!onblur_title()){
		return 	flag=false;
	}
	//跳转的URL
	if(!onblur_url()){
		return 	flag=false;
	}
	//按钮的KEY
	if(!onblur_btn_key()){
		return 	flag=false;
	}
	//素材的MediaId
	if(!onblur_media_id()){
		return 	flag=false;
	}
	
	return true;
}