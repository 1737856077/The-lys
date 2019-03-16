/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:模版分类管理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:dtemplatetype_add.js.js 2019-03-16 18:01:00 $
 */

//title
function onBlur_title(){
    var title=document.getElementById("title").value;
    if(title.trim()==""){
        document.getElementById("span_title").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_title").innerHTML="";
    }
    return true;
}

//add submit
function subfun(){
    //add title
    if(!onBlur_title()){return false;}

	return true;
}

//edit submit
function subfunedit(){
    //title
    if(!onBlur_title()){return false;}
	
	return true;
}