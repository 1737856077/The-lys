/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @desc:业务员管理JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:salesman_add.js 2018-05-07 18:01:00 $
 */

//name
function onBlur_name(){
	if(document.getElementById("name").value.trim()==""){
		document.getElementById("span_name").innerHTML="不能为空！";	
		return false;
	}else{
		document.getElementById("span_name").innerHTML="";	
	}
}

//联系电话
function onBlur_tel(){
	var tel=document.getElementById("tel").value;
	if(tel.trim()==""){
		document.getElementById("span_tel").innerHTML="不能为空！";	
		return false;
	}else{
		document.getElementById("span_tel").innerHTML="";	
	}
}


//add submit
function subfun(){
	//name
	return onBlur_name();
	
	//联系电话
	return onBlur_tel();


	return true;
}

//edit submit
function subfunedit(){
	//联系电话
	return onBlur_tel();
	
	return true;
}