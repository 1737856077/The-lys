/**
 * @[练遇_后台管理系统] Shanghai Lianyu Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:function.css 2018-01-27 17:53:00 $
 */
 
function getById(id){
	return document.getElementById(id);
}
function getByName(name){
	return document.getElementsByName(name).item(0);	
}

//不能输入非法字符[@、&、‘、<、或>]
function noStrs(e){
	var keynum;
	var keychar;
	var numcheck;
	
	if(window.event) // IE
	  {
	  keynum = e.keyCode;
	  }
	else if(e.which) // Netscape/Firefox/Opera
	  {
	  keynum = e.which;
	  }
	keychar = String.fromCharCode(keynum);
	numcheck = /[^@&'<>]/;
	return numcheck.test(keychar);
}
//不能输入非法字符[@、&、‘、<、或>]
function noChars(e){
	var keynum;
	var keychar;
	var numcheck;
	
	if(window.event) // IE
	  {
	  keynum = e.keyCode;
	  }
	else if(e.which) // Netscape/Firefox/Opera
	  {
	  keynum = e.which;
	  }
	keychar = String.fromCharCode(keynum);
	numcheck = /[^@&'<>]/;
	return numcheck.test(keychar);
}
//不能输入非法字符[@、&、‘、<、或>]
function noChar(e){
	var keynum;
	var keychar;
	var numcheck;
	
	if(window.event) // IE
	  {
	  keynum = e.keyCode;
	  }
	else if(e.which) // Netscape/Firefox/Opera
	  {
	  keynum = e.which;
	  }
	keychar = String.fromCharCode(keynum);
	numcheck = /[^&'<>]/;
	return numcheck.test(keychar);
}
//复制内容时，自动追加到剪贴板
onBeforeCopy=function(){
	//alert(window.clipboardData.getData('text'));
	alert("");
}
//验证日期格式（0000-00-00 00:00:00）
function noCheckLongTime(name){
	var keychar=document.getElementsByName(name).item(0).value;
	var numcheck = /\d{4}-\d{2}-\d{2}\s{1}\d{2}:\d{2}:\d{2}/;
	if(!(numcheck.test(keychar))){
		//alert(keychar);
		document.getElementsByName(name).item(0).value=getLongTime();
	}
}
function getLongTime() 
{ 
	var myyear,mymonth,myweek,myday,mytime,mymin,myhour,mysec; 
	var mydate=new Date(); 
	myzhou=mydate.getDay();
	var myzhoustr="星期天";
	if(myzhou==1){ myzhoustr="星期一"; }
	if(myzhou==2){ myzhoustr="星期二"; }
	if(myzhou==3){ myzhoustr="星期三"; }
	if(myzhou==4){ myzhoustr="星期四"; }
	if(myzhou==5){ myzhoustr="星期五"; }
	if(myzhou==6){ myzhoustr="星期六"; }
	myyear=mydate.getFullYear(); 
	mymonth=mydate.getMonth()+1; 
	mymonth=mymonth<10 ? "0"+mymonth : mymonth;
	myday=mydate.getDate(); 
	myday=myday<10 ? "0"+myday : myday;
	myhour=mydate.getHours(); 
	mymin=mydate.getMinutes();
	mymin=mymin<10 ? "0"+mymin : mymin;
	mysec=mydate.getSeconds(); 
	mysec=mysec<10 ? "0"+mysec : mysec;
	mytime=myyear+"-"+mymonth+"-"+myday+" "+myhour+":"+mymin+":"+mysec; 
	return mytime;
}

//图片等比例缩小，参数，宽，高
function myimage(img,strwidth,strheight)
{
	//alert("img");
	var image=new Image();
	image.src=img.src;
	width=strwidth;
	height=strheight;
	if(image.width>width||image.height>height)
	{
	   w=image.width/width;
	   h=image.height/height;
	   if(w>h){
		   img.width=width;
		   img.height=image.height/w;
	   }
	   else
	   {
			img.height=height;
			img.width=image.width/h;
	   } 
	} 
}

//点击显示隐藏元素
//param string		id		--元素的ID
function OnClick_ShowElement(id){
	var new_id=document.getElementById(id);
	if(new_id.style.display=='none'){
		new_id.style.display='block'
	}else{
		new_id.style.display='none'
	}
	
}

//赋值给预览显示
//param	 string		val		--上传的图片文件域的图片本地路径
//param	 string		id		--上传的图片文件域的图片本地路径-》需要赋值给的IMG标签ID
function OnClick_ShowPreviewImg(val,id){
	document.getElementById(id).src=val;
}