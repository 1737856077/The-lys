/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品模版内容JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:templatecontent_.js 2018-07-06 11:27:00 $
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

//属性内容
function onBlur_content(){
	if(document.getElementById("content").value.trim()==""){
		document.getElementById("span_content").innerHTML="不能为空！";	
		return false;
	}else{
		document.getElementById("span_content").innerHTML="";	
		return true;
	}
}

//add submit
function subfun(){
	//title
	if(!onBlur_title()){
		return false;	
	}
	
	//属性内容
	if(!onBlur_content()){
		return false;	
	}
	return true;
}