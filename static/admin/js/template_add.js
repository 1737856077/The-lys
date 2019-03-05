/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品模版JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:template_add.js 2018-07-06 10:34:00 $
 */


//title
function onBlur_title(){
	if(document.getElementById("title").value.trim()==""){
		document.getElementById("span_title").innerHTML="不能为空！";	
		return false;
	}else{
		document.getElementById("span_title").innerHTML="";	
		return true;
	}
}

//图片
function OnBlur_images(){
	if(document.getElementById("IMAGES").value!=""){
		var IMAGES=document.getElementById("IMAGES").value;
		var tmptype=IMAGES.substr(IMAGES.lastIndexOf(".")+1);
		tmptype=tmptype.toLowerCase();
		if(tmptype=="jpg" || tmptype=="jpeg" || tmptype=="png" || tmptype=="gif" || tmptype=="bmp"){
			document.getElementById("spanIMAGES").innerHTML="";
		}else{
			document.getElementById("spanIMAGES").innerHTML="图片格式错误！";
			return false;	
		}
	}	
	return true;
}

//add submit
function subfun(){
	//title
	if(!onBlur_title()){
		return false;	
	}	
	
	//图片
	if(!OnBlur_images()){
		return false;	
	}
	return true;
}