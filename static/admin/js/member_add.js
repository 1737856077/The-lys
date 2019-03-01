/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:用户管理JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:member_add.js 2019-03-01 18:01:00 $
 */

//邮箱
function onBlur_email(){
    var email=document.getElementById("email").value;
    if(email.trim()==""){
        document.getElementById("span_email").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_email").innerHTML="";
    }
    return true;
}

//add submit
function subfun(){
	//邮箱
	if(!onBlur_email()){return false;}

	return true;
}

//edit submit
function subfunedit(){
    //邮箱
    if(!onBlur_email()){return false;}
	
	return true;
}