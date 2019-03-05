/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @desc:业务员管理-关连商家处理JS
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:salesman_business.js 2018-05-07 18:27:00 $
 */
 
var xmlHttp;
function S_xmlhttprequest(){
	 if(window.ActiveXObject){
	  	xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	 }else if (window.XMLHttpRequest){
	  	xmlHttp = new XMLHttpRequest();
	 }
} 
 
// 关连
function onclick_auth(business_id){
	S_xmlhttprequest();
	
	var _timestamp=new Date().getTime();
	var salesman_id=document.getElementById('salesman_id').value;
	var data='&salesman_id='+salesman_id;
		data+='&business_id='+business_id;
	var url='/admin.php/salesman/salesmanbusiness/ajax_auth.html?sjtime='+_timestamp+Math.ceil(Math.random()*1000);;
	
	xmlHttp.open("post",url,true);
	xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.status==200)
			{
				 var jsonstr = xmlHttp.responseText;
				 var data = eval('('+jsonstr+')');
				if(data['code']!=0){
					alert(data['msg']);	
				}
				
			}
			
		}
	}
	xmlHttp.setRequestHeader("If-Modified-Since","0");
	xmlHttp.send(data);
}
 
 