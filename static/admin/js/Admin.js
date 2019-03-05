/**
 * @[练遇_官网-后台管理系统] Shanghai Lianyu Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Admin.js 2018-01-26 17:18:50 $
 */
 
//用户名
function Onblur_name(){
	var flag=true;
	
	var name=document.getElementById("name");
	var span_name=document.getElementById("span_name");
	
	if(name.value.trim()==""){
		span_name.innerHTML="用户名不能为空！";
		flag=false;
	}else{
		span_name.innerHTML="";
	}
	
	return flag;
}

//密码
function Onblur_pwd(){
	var flag=true;
	
	var pwd=document.getElementById("pwd");
	var span_pwd=document.getElementById("span_pwd");
	
	if(pwd.value.trim()==""){
		span_pwd.innerHTML="密码不能为空！";
		flag=false;
	}else{
		span_pwd.innerHTML="";
	}
	
	return flag;
}

//添加提交
function funsubmit(){
	
	var flag = true;

	//用户名
	if(!Onblur_name()){
		return 	flag=false;
	}
	//密码
	if(!Onblur_pwd()){
		return 	flag=false;
	}
	document.getElementById("onSubmit").disabled=true;
	return flag;
}

//编辑提交
function funsubmit_modify(){
	
	var flag = true;

	//密码
	if(!Onblur_pwd()){
		return 	flag=false;
	}
	document.getElementById("onSubmit").disabled=true;
	return flag;
}

//修改密码 begin
//老密码
function Onblur_adminpwd1(){
	var flag=true;
	
	var adminpwd1=document.getElementById("adminpwd1");
	var span_adminpwd1=document.getElementById("span_adminpwd1");
	
	if(adminpwd1.value.trim()==""){
		span_adminpwd1.innerHTML="老密码不能为空！";
		flag=false;
	}else{
		span_adminpwd1.innerHTML="";
	}
	
	return flag;
}
//新密码
function Onblur_adminpwd2(){
	var flag=true;
	
	var adminpwd2=document.getElementById("adminpwd2");
	var span_adminpwd2=document.getElementById("span_adminpwd2");
	
	if(adminpwd2.value.trim()==""){
		span_adminpwd2.innerHTML="新密码不能为空！";
		flag=false;
	}else{
		span_adminpwd2.innerHTML="";
	}
	
	return flag;
}
//确认新密码
function Onblur_adminpwd3(){
	var flag=true;
	var adminpwd2=document.getElementById("adminpwd2");
	var adminpwd3=document.getElementById("adminpwd3");
	var span_adminpwd3=document.getElementById("span_adminpwd3");
	
	if(adminpwd3.value.trim()==""){
		span_adminpwd3.innerHTML="确认新密码不能为空！";
		flag=false;
	}else if(adminpwd2.value.trim()!=adminpwd3.value.trim()){
		span_adminpwd3.innerHTML="新密码与确认新密码不相同！";
		flag=false;
	}else{
		span_adminpwd3.innerHTML="";
	}
	
	return flag;
}

//提交-编辑密码
function funsubmit_modifypwd(){
	
	var flag = true;

	//老密码
	if(!Onblur_adminpwd1()){
		return 	flag=false;
	}
	//新密码
	if(!Onblur_adminpwd2()){
		return 	flag=false;
	}
	//确认新密码
	if(!Onblur_adminpwd3()){
		return 	flag=false;
	}
	document.getElementById("onSubmit").disabled=true;
	return flag;
}
//修改密码 end

//编辑重置密码提交
function funsubmit_modify_setpwd(){
	
	var flag = true;

	//密码
	if(!Onblur_pwd()){
		return 	flag=false;
	}
	document.getElementById("onSubmit").disabled=true;
	return flag;
}
