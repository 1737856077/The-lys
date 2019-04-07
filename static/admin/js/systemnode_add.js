/**
 * @[无忧超星物业缴费系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:权限管理-系统节点JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:systemnode_add.js.js 2018-07-14 13:32:00 $
 */

//title
function onBlur_title(){
    if(document.getElementById("title").value.trim()==""){
        document.getElementById("span_title").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_title").innerHTML="";
    }
}

//路径
function onBlur_content(){
    if(document.getElementById("content").value.trim()==""){
        document.getElementById("span_content").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_content").innerHTML="";
    }
}

//add submit
function subfun(){
	//title
	if(onBlur_title()==false){
		return false;
	}

    //路径
    if(onBlur_content()==false){
        return false;
    }

	return true;
}
