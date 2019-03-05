/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:生成二维码JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:createqrcode_add.js 2018-07-06 10:34:00 $
 */


//product_id
function onBlur_product_id(){
	if(document.getElementById("product_id").value.trim()==""){
		document.getElementById("span_product_id").innerHTML="不能为空！";	
		return false;
	}else{
		document.getElementById("span_product_id").innerHTML="";	
		return true;
	}
}

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
	//product_id
	if(onBlur_product_id==false){
		return false;	
	}	
	
	//title
	if(onBlur_title()==false){
		return false;	
	}	
	
	return true;
}