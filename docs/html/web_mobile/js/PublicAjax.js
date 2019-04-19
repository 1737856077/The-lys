/**
 *  Create on  : 2015-05-18 16:45:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:PublicAjax.js
 */
 
var xmlHttp;
function S_xmlhttprequest(){
	 if(window.ActiveXObject){
		 xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	 }else if (window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	 }
}

