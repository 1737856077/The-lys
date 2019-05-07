/**
 *  Create on  :  2015-08-12 13:19:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:MessagePush.js
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

//选择所有粉丝
function onclick_groups_id_all(id){
	var div_groups_id=document.getElementById("div_groups_id");
	var inputitem=div_groups_id.getElementsByTagName("input");
	if(id.checked==true){
		for (var i=0;i<inputitem.length;i++){ 
			var e = inputitem[i];
			
			if (e.type == "checkbox" && e.name!='groups_id_all') {
				e.checked=true;
			}
		}
	}else{
		for (var i=0;i<inputitem.length;i++){ 
			var e = inputitem[i];
			
			if (e.type == "checkbox" && e.name!='groups_id_all') {
				e.checked=false;
			}
		}
	}

}
//点击单个分组时事件
function onclick_groups_id(id){
	if(id.checked==false){
		document.getElementById("groups_id_all").checked=false;
	}
}

//地区-添加到推送列表
function OnClick_PushAddressAdd(){
	var city_id=document.getElementById("city_id");
	var push_address=document.getElementById("push_address");
	var span_push_address=document.getElementById("span_push_address");
	if(city_id.options.length==0){
		span_push_address.innerHTML="请选择推送地区！";
	}else{
		for(var i=0;i<city_id.options.length;i++){
			var e=city_id.options[i];
			if(e.selected==true){
				if(VerificationCityIdEqValue(e.value)<1){
					push_address.options.add(new Option(e.text,e.value));
				}
				//city_id.remove(i);
				//i=i-1;
			}
		}
	}
	
}
//地区-从推送列表移除
function OnClick_PushAddressRemove(){
	var push_address=document.getElementById("push_address");
	var span_push_address=document.getElementById("span_push_address");
	if(push_address.options.length==0){
		span_push_address.innerHTML="请选择需移除的推送地区！";
	}else{
		for(var i=0;i<push_address.options.length;i++){
			var e=push_address.options[i];
			if(e.selected==true){
				push_address.remove(i);
				i=i-1;
			}
		}
	}
	
}

//验证又推送地区是否已存在相同的地区
function VerificationCityIdEqValue(val){
	var n=0;
	var push_address=document.getElementById("push_address");
	for(var i=0;i<push_address.options.length;i++){
		var e=push_address.options[i];
		if(e.value==val){
			n++;
		}
	}
	return n;
}
//提交时将所有的已选为推送的地区设为选中状态
function SelectPushAddressAll(){
	var push_address=document.getElementById("push_address");
	for(var i=0;i<push_address.options.length;i++){
		var e=push_address.options[i];
		e.selected=true;
	}
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
	
	//提交时将所有的已选为推送的地区设为选中状态
	SelectPushAddressAll();
	return true;
}
