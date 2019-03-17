/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:用户注册
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:regin.js 2019-03-17 18:01:00 $
 */

var xmlHttp;
function S_xmlhttprequest(){
    if(window.ActiveXObject){
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
    }else if (window.XMLHttpRequest){
        xmlHttp = new XMLHttpRequest();
    }
}

//username
function onBlur_username(){
    var username = document.getElementById("username").value.trim();
	if(username==""){
		document.getElementById("span_username").innerHTML="不能为空！";
		return false;
	}else{
        S_xmlhttprequest();
        var url='/index.php/member/register/checkname';
        var data='username='+username;
        xmlHttp.open("POST",url,true);
        xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttp.onreadystatechange=function()
        {
            if(xmlHttp.readyState==4)
            {
                if(xmlHttp.status==200)
                {
                    var s = xmlHttp.responseText;
                    s = eval('('+s+')');
                    if(s.code == 0){
                        document.getElementById("span_username").innerHTML="验证通过！";
                    }else{
                        document.getElementById("span_username").innerHTML=s.msg;
                    }
                }
            }
        }
        // xmlHttp.setRequestHeader("If-Modified-Since","0");
        xmlHttp.send(data);
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

//pwd2
function onBlur_pwd2(){
    var pwd = document.getElementById("pwd").value.trim();
    var pwd2 = document.getElementById("pwd2").value.trim();
    if(pwd2=="") {
        document.getElementById("span_pwd2").innerHTML = "不能为空！";
        return false;
    }else if(pwd!=pwd2){
        document.getElementById("span_pwd2").innerHTML = "二次密码不相同！";
        return false;
    }else{
        document.getElementById("span_pwd2").innerHTML="";
    }
    return true;
}

//email
function onBlur_email(){
    var reg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"); //正则表达式
    var email = document.getElementById("email").value.trim();
    if(email!=""){
        if(!reg.test(email)) { //正则验证不通过，格式不对
            document.getElementById("span_email").innerHTML = "邮箱格式错误！";
            return false;
        }else{
            document.getElementById("span_email").innerHTML="";
        }
    }else{
        document.getElementById("span_email").innerHTML="";
    }
    return true;
}

// submit
function subfun(){
	//username
	if(!onBlur_username()){return false;}
	//pwd
    if(!onBlur_pwd()){return false;}
    //pwd2
    if(!onBlur_pwd2()){return false;}
	return true;
}