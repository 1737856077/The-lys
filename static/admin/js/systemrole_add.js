/**
 * @[无忧超星物业缴费系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:权限管理-系统角色JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:systemrole_add.js.js 2018-07-14 10:57:00 $
 */

//title
function onBlur_title(){
    if(document.getElementById("title").value.trim()==""){
        //alert('必填项不能为空！');
        document.getElementById("span_title").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_title").innerHTML="";
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
