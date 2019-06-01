/**
 * Encoding     :   UTF-8
 * Created on   :   2015-08-12 13:48:00 by liuqingyan[Leaya] , liuqingyan0308@gmail.com
 * Id			:	MessagePushCity.js
 * 描述			：	地区信息
 */
 
var xmlHttp;
function S_xmlhttprequest(){
	 if(window.ActiveXObject){
		 xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	 }else if (window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	 }
}


//根据一级城市ID取得二级城市列表
function GetAreaCityOneID(id){
	document.getElementById("city_id").options.length = 0;
	//document.getElementById("city_id").add(new Option("请选择市","0"));
	if(id>0){	
		var url="/admin.php?s=UserCity/AjaxGetCity/id/"+id;
		AjaxPostCity("city_id",url);
	}else{
	}
}



function AjaxPostCity(objname,url){
	
	S_xmlhttprequest();
	xmlHttp.open("get",url,true);
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.status==200)
			{
				 var s = xmlHttp.responseText;
				//alert(s);
				SelectJoinCity(s,objname);
			}
			
		}
	}
	xmlHttp.setRequestHeader("If-Modified-Since","0");
	xmlHttp.send(null);
}


function SelectJoinCity(jsonstr,objname){
	
	var data = eval('('+jsonstr+')');
	if(!data.length){
		return;
	}
	
	if(data.length>0){
		for(var i=0; i<data.length;i++){
			document.getElementById(objname).add(new Option(data[i]['TITLE'],data[i]['ID']));
		}
		document.getElementById(objname).style.display="";
	}
}



