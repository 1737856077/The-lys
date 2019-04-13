/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:在线设计 - 设置标签基础信息
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:onlineSetLable.js 2019-03-31 18:01:00 $
 */

//标签名称
function onBlur_title(){
    var title = document.getElementById("title").value.trim();
    if(title == ''){
        document.getElementById("span_title").innerHTML = "不能为空！";
        return false
    }else {
        document.getElementById("span_title").innerHTML = "";
    }
    return true;
}

//标签尺寸-宽度
function onBlur_lable_size_wide(){
    var lable_size_wide = document.getElementById("lable_size_wide").value.trim();
    if(lable_size_wide  <=0){
        document.getElementById("span_lable_size_wide").innerHTML = "不能为空！";
        return false
    }else {
        document.getElementById("span_lable_size_wide").innerHTML = "";
    }
    return true;
}

//标签尺寸-高度
function onBlur_lable_size_height(){
    var lable_size_height = document.getElementById("lable_size_height").value.trim();
    if(lable_size_height  <=0){
        document.getElementById("span_lable_size_height").innerHTML = "不能为空！";
        return false
    }else {
        document.getElementById("span_lable_size_height").innerHTML = "";
    }
    return true;
}

//标签间距-水平间距
function onBlur_label_spacing_level(){
    var label_spacing_level = document.getElementById("label_spacing_level").value.trim();
    if(label_spacing_level  <=0){
        document.getElementById("span_label_spacing_level").innerHTML = "不能为空！";
        return false
    }else {
        document.getElementById("span_label_spacing_level").innerHTML = "";
    }
    return true;
}

//标签间距-垂直间距
function onBlur_label_spacing_vertical(){
    var label_spacing_vertical = document.getElementById("label_spacing_vertical").value.trim();
    if(label_spacing_vertical <=0){
        document.getElementById("span_label_spacing_vertical").innerHTML = "不能为空！";
        return false
    }else {
        document.getElementById("span_label_spacing_vertical").innerHTML = "";
    }
    return true;
}


// submit
function subfun(){
    //标签名称
    if(!onBlur_title()){return false;}
    //标签尺寸-宽度
    if(!onBlur_lable_size_wide()){return false;}
    //标签尺寸-高度
    if(!onBlur_lable_size_height()){return false;}
    //标签间距-水平间距
    if(!onBlur_label_spacing_level()){return false;}
    //标签间距-垂直间距
    if(!onBlur_label_spacing_vertical()){return false;}
    return true;
}