/**
 *  Create on  :  2015-07-28 16:56:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:KeywordReply_AddVoice.js
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
//从语音素材库中选择使用 
function GetWechatMaterialVoice(mid){
	document.getElementById("voice_media_id").value=mid;//语音消息-语音的MediaId
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

//提交验证
function funsubmit_update(){
	var flag=true;
		//关键字
		if(!onblur_key_word()){
			return 	flag=false;
		}
		//语音消息-语音的MediaId
		if(!onblur_voice_media_id()){
			return 	flag=false;
		}
	
	return true;
}