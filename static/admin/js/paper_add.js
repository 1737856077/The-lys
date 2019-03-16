/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc：纸张管理
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:paper_add.js.js.js 2019-03-16 18:01:00 $
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

//厚度
function onBlur_thickness(){
    var thickness=document.getElementById("thickness").value;
    if(thickness.trim()=="" || thickness.trim()<=0){
        document.getElementById("span_thickness").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_thickness").innerHTML="";
    }
    return true;
}

//单张价格
function onBlur_price(){
    var price=document.getElementById("price").value;
    if(price.trim()=="" || price.trim()<=0){
        document.getElementById("span_price").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_price").innerHTML="";
    }
    return true;
}

//add submit
function subfun(){
    //add title
    if(!onBlur_title()){return false;}
    //add 厚度
    if(!onBlur_thickness()){return false;}
    //add 单张价格
    if(!onBlur_price()){return false;}

	return true;
}

//edit submit
function subfunedit(){
    //title
    if(!onBlur_title()){return false;}
    //厚度
    if(!onBlur_thickness()){return false;}
    //单张价格
    if(!onBlur_price()){return false;}

	return true;
}