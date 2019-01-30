/**
 * @[溯源系统] kedousuyuan Information Technology Co., Ltd.
 * @desc:网站前台-取得用户的地理信息
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:getlocation.js 2019-01-21 18:35:00 $
 */
var xmlHttp;
function S_xmlhttprequest(){
    if(window.ActiveXObject){
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
    }else if (window.XMLHttpRequest){
        xmlHttp = new XMLHttpRequest();
    }
}

var locPublic;
var isMapInitPublic = false;
window.addEventListener('message', function(event) {
    locPublic = event.data;
    console.log('location', locPublic);

    if(locPublic  && locPublic.module == 'geolocation') {
        var markUrl = 'https://apis.map.qq.com/tools/poimarker' +
            '?marker=coord:' + locPublic.lat + ',' + locPublic.lng +
            ';title:蝌蚪溯源;addr:' + (locPublic.addr || locPublic.city) +
            '&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&referer=myapp';
        // document.getElementById('markPage').src = markUrl;
        // alert(markUrl)
        var getLoaction_productCodeInfoId=document.getElementById('getLoaction_productCodeInfoId').value.trim();
        var getLoaction_sn=document.getElementById('getLoaction_sn').value.trim();
        if(getLoaction_productCodeInfoId == '' || getLoaction_sn == ''){
            return ;
        }
        S_xmlhttprequest();
        var _param='';
        _param += 'getLoaction_sn='+getLoaction_sn;
        _param += '&getLoaction_productCodeInfoId='+getLoaction_productCodeInfoId;
        _param += '&accuracy='+locPublic.accuracy;
        _param += '&adcode='+locPublic.adcode;
        _param += '&addr='+locPublic.addr;
        _param += '&nation='+locPublic.nation;
        _param += '&province='+locPublic.province;
        _param += '&city='+locPublic.city;
        _param += '&district='+locPublic.district;
        _param += '&lat='+locPublic.lat;
        _param += '&lng='+locPublic.lng;
        var url="/admin.php/sinterface/getlocation/insert";
        xmlHttp.open("post",url,true);
        xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlHttp.onreadystatechange=function()
        {
            if(xmlHttp.readyState==4)
            {
                if(xmlHttp.status==200)
                {
                    // var jsonstr = xmlHttp.responseText;
                    // var data = eval('('+jsonstr+')');
                    // alert(jsonstr)
                }
            }
        }
        xmlHttp.setRequestHeader("If-Modified-Since","0");
        xmlHttp.send(_param);
    } else {
        // console.log('');
    }
}, false);
window.onload=function (ev) {
    document.getElementById("geoPage").contentWindow.postMessage('getLocation', '*');
    // setTimeout(function() {
    //     if(!locPublic) {
    //         document.getElementById("geoPage")
    //             .contentWindow.postMessage('getLocation.robust', '*');
    //     }
    // }, 5000);
}