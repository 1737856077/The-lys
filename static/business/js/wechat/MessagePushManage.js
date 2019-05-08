/**
 *  Create on  :  2015-07-30 11:02:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:MessagePushManage.js
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

//选择消息类型
function SelectMsgType(id){
	var id=id;
	var alink_media_id=document.getElementById("alink_media_id");
	if(id=="text"){
		document.getElementById("div_description").style.display='block';
		document.getElementById("div_media_id").style.display='none';
	}else{
		
		document.getElementById("div_description").style.display='none';
		document.getElementById("div_media_id").style.display='block';
		alink_media_id.onclick=function(){Oclick_ShowBox(id);}
	}
	//改变事件
	
	
	
}

//从素材库中选择使用 
function GetWechatMaterial(mid){
	document.getElementById("media_id").value=mid;
	Oclick_claseDialogBtn();//关闭弹窗
}


//素材的MediaId
function onblur_media_id(){
	var flag=true;
	var media_id=document.getElementById("media_id");
	var span_media_id=document.getElementById("span_media_id");
	if(media_id.value.trim()==""){
		span_media_id.innerHTML="素材的MediaId不能为空！";
		flag=false;
	}else{
		span_media_id.innerHTML="";
	}
	return flag;
}

//文本
function onblur_description(){
	var flag=true;
	var description=document.getElementById("description");
	var span_description=document.getElementById("span_description");
	if(description.value.trim()==""){
		span_description.innerHTML="文本不能为空！";
		flag=false;
	}else{
		span_description.innerHTML="";
	}
	return flag;
}


//提交验证
function funsubmit_add(){
	var flag=true;
	var msgtype=document.getElementById("msgtype");
	//alert("["+msgtype.value+"]");			
	//素材的MediaId
	if(msgtype.value!="text"){	
		if(!onblur_media_id()){
			return 	flag=false;
		}
	}
	if(msgtype.value=="text"){	
		//文本
		if(!onblur_description()){
			return 	flag=false;
		}
	}
	return true;
}
