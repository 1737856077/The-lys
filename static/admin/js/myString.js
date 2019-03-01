/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:myString.css 2018-01-27 17:53:00 $
 */
 
//去掉空格
String.prototype.trim=function(){
	return this.replace(/(^\s*)|(\s*$)/g,"");	
}
String.prototype.ltrim=function(){
	return this.replace(/(^\s*)/g,"");
}
String.prototype.rtrim=function(){
	return this.replace(/(\s*$)/g,"");
}


