/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:二维码管理-二维码统计-查看详细处理JS
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:qrreport_productlist.js 2018-09-24 20:09:00 $
 */

//二维码生产日期
function onBlur_search_create(){
    var search_create_begin=document.getElementById('search_create_begin').value.trim();
    var search_create_end=document.getElementById('search_create_end').value.trim();
    if(search_create_begin=='' && search_create_end!='') {
        document.getElementById("span_search").innerHTML = "启用“二维码生产日期”，起始日期都不能为空！";
        return false;
    }else if(search_create_begin!='' && search_create_end==''){
        document.getElementById("span_search").innerHTML = "启用“二维码生产日期”，起始日期都不能为空！";
        return false;
    }else{
        document.getElementById("span_search").innerHTML="";
        return true;
    }
}

//二维码激活日期
function onBlur_search_qr_open(){
    var search_qr_open_begin=document.getElementById('search_qr_open_begin').value.trim();
    var search_qr_open_end=document.getElementById('search_qr_open_end').value.trim();
    if(search_qr_open_begin=='' && search_qr_open_end!='') {
        document.getElementById("span_search").innerHTML = "启用“二维码激活日期”，起始日期都不能为空！";
        return false;
    }else if(search_qr_open_begin!='' && search_qr_open_end==''){
        document.getElementById("span_search").innerHTML = "启用“二维码激活日期”，起始日期都不能为空！";
        return false;
    }else{
        document.getElementById("span_search").innerHTML="";
        return true;
    }
}

//add submit
function subfun(){
    //二维码生产日期
    if(onBlur_search_create()==false){
        return false;
    }

    //二维码激活日期
    if(onBlur_search_qr_open()==false){
        return false;
    }

    return true;
}