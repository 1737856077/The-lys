/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:编辑二维码JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:productcode_add.js 2019-03-19 18:34:00 $
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

//add submit
function subfun(){
	//title
	if(onBlur_title()==false){
		return false;	
	}	
	
	return true;
}