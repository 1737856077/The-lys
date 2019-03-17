/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:公用AJAX
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:PublicAjax.js 2019-03-17 18:01:00 $
 */
var xmlHttp;
function S_xmlhttprequest(){
    if(window.ActiveXObject){
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
    }else if (window.XMLHttpRequest){
        xmlHttp = new XMLHttpRequest();
    }
}

function AjaxGet(objname,url){
    S_xmlhttprequest();
    xmlHttp.open("get",url,true);
    xmlHttp.onreadystatechange=function()
    {
        if(xmlHttp.readyState==4)
        {
            if(xmlHttp.status==200)
            {
                var s = xmlHttp.responseText;
            }

        }
    }
    xmlHttp.setRequestHeader("If-Modified-Since","0");
    xmlHttp.send(null);
}