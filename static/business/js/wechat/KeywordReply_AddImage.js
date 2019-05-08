/**
 *  Create on  :  2015-07-28 16:59:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:KeywordReply_AddImage.js
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
	document.getElementById("image_link_url").value=imgurl;//图片消息-图片
	document.getElementById("image_media_id").value=mid;
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

//提交验证
function funsubmit_update(){
	var flag=true;
		
		//关键字
		if(!onblur_key_word()){
			return 	flag=false;
		}
		//图片消息-图片
		if(!onblur_image_link_url()){
			return 	flag=false;
		}
	
	return true;
}