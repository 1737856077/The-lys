/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:用户登录
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:login.js 2019-03-17 18:01:00 $
 */

//username
function onBlur_username(){
    var username = document.getElementById("username").value.trim();
	if(username==""){
		document.getElementById("span_username").innerHTML="不能为空！";
		return false;
	}else{
        document.getElementById("span_username").innerHTML='';
	}
	return true;
}

//pwd
function onBlur_pwd(){
    var pwd = document.getElementById("pwd").value.trim();
    if(pwd==""){
        document.getElementById("span_pwd").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_pwd").innerHTML="";
    }
    return true;
}

// submit
function subfun(){
	//username
	if(!onBlur_username()){return false;}
	//pwd
    if(!onBlur_pwd()){return false;}

	return true;
}