/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:地区AJAX请求信息处理JS
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:city.js 2018-04-12 11:31:00 $
 */
 
var xmlHttp;
function S_xmlhttprequest(){
	 if(window.ActiveXObject){
	  	xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	 }else if (window.XMLHttpRequest){
	  	xmlHttp = new XMLHttpRequest();
	 }
}

//根据省份ID取得城市列表
function GetProvinceID(id){
	document.getElementById("CityID").options.length = 0;
	document.getElementById("CityID").add(new Option("地级市",""));
	document.getElementById("DistrictID").options.length = 0;
	document.getElementById("DistrictID").add(new Option("区县",""));
	var url="/admin.php/region/region/ajax_region.html?id="+id;
	AjaxPost("CityID",url);
}

//根据城市ID取得县/区列表
function GetCityID(id){
	document.getElementById("DistrictID").options.length = 0;
	document.getElementById("DistrictID").add(new Option("区县",""));
	var url="/admin.php/region/region/ajax_region.html?id="+id;
	AjaxPost("DistrictID",url);
}

function AjaxPost(objname,url){
	S_xmlhttprequest();
	xmlHttp.open("get",url,true);
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.status==200)
			{
				 var s = xmlHttp.responseText;

				SelectJoin(s,objname);
			}
			
		}
	}
	xmlHttp.setRequestHeader("If-Modified-Since","0");
	xmlHttp.send(null);
}

function SelectJoin(jsonstr,objname){
	var data = eval('('+jsonstr+')');
	if(!data.length){
		return;
	}
	for(var i=0; i<data.length;i++){
		document.getElementById(objname).add(new Option(data[i]['TITLE'],data[i]['ID']));
	}
	
}