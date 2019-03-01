/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:PublicUser.css 2018-01-27 17:53:00 $
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


//全选
function CheckAll(form) 
{ 
	for (var i=0;i<form.elements.length;i++) 
	{ 
		var e = form.elements[i]; 
		if (e.Name != "chkAll"&&e.disabled!=true) 
		e.checked = form.chkAll.checked; 
	} 
} 
//是否选中了新闻
function CheckSelect(form) 
{ 
	var n=0;
	
	for (var i=0;i<form.elements.length;i++) 
	{ 
		var e = form.elements[i]; 
		if (e.Name != "spt[]"&&e.checked==true) 
		n++;
	}
	if(n==0){
		alert("未选数据！");
		return false;
	}
}

//格式化浮点数
// param src	原参数
// param pos	格式需保留的小数位数
function FormatFloat(src, pos){
	return Math.round(src*Math.pow(10, pos))/Math.pow(10, pos);
}

//只能输入数字
function noNumbers(e){
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
	numcheck = /\d/;
	return numcheck.test(keychar);
	
	
	/*var code = (e.keyCode ? e.keyCode : e.which);  //兼容火狐 IE      
                if(!$.browser.msie&&(e.keyCode==0x8))  //火狐下不能使用退格键     
                {     
                     return ;     
                    }     
                    return code >= 48 && code<= 57; */

	
}
//只能输入数字
function noNumbersLine(e){
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
	numcheck = /[\-\d]/;
	return numcheck.test(keychar);
}
//只能输入数字和一个小数点
function noFloat(e,name){
	//alert(name);
	var keynum;
	var keychar;
	var numcheck;
	var Flage=false;
	
	if(window.event) // IE
	  {
	  keynum = e.keyCode;
	  }
	else if(e.which) // Netscape/Firefox/Opera
	  {
	  keynum = e.which;
	  }
	keychar = String.fromCharCode(keynum);
	
	if(countStr(document.getElementById(name).value,".")>0){
		numcheck = /[0-9]/;
	}else{
		numcheck = /[0-9.]/;
	}
	if(numcheck.test(keychar)){
		Flage=true;
	}
	
	return Flage;
}
function publicBlurEnterFloat(id){
	if(document.getElementById(id).value.trim()==""){
		alert("不能为空！");
	}else{
		document.getElementById(id).value=substringFloatLeft0(document.getElementById(id).value)=='undefined' ? '0' : substringFloatLeft0(document.getElementById(id).value); 
	}
}
function publicBlurEnterFloatSpan(id){
	if(document.getElementById(id).value.trim()==""){
		//alert("不能为空！");
		document.getElementById("span"+id).innerHTML="不能为空！";
	}else{
		document.getElementById(id).value=substringFloatLeft0(document.getElementById(id).value)=='undefined' ? '0' : substringFloatLeft0(document.getElementById(id).value); 
		document.getElementById("span"+id).innerHTML="";
	}
}
//统计字符出现的个数
function countStr(str,searchStr){
	var _TmpArr=Array();
	_TmpArr=str.split(searchStr);
	return _TmpArr.length-1;
}
//不能输入非法字符
function noStrs(e){
	//debugger;
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
	numcheck = /[^\'<>,~\-`!#%*\\]/;
	return numcheck.test(keychar);
}

//去掉数字左边的0  只能是整数
function substringLeft0(str){
	if(str.substring(0,1)=='0'){
		str=str.substring(1);
		//alert(str);
		substringLeft0(str);
	}
	
	return str;
}
//去掉数字左边的0  浮点数
function substringFloatLeft0(str){
	if(str.substring(0,1)=='.'){
		str="0"+str;
		return str;
	}
	if(str.substring(0,2)!='0.'){
		if(str.substring(0,1)=='0'){
			str=str.substring(1);
			//alert(str);
			substringFloatLeft0(str);
		}
	}
	
	return str;
}

function checkclassfun(n){
	document.getElementById("checkclass").value=n;
}

//显示隐藏层 -- 操作checkbox
function chkShowHideDiv(chkName,divName){
	if(document.getElementById(chkName).checked==true){
		document.getElementById(divName).style.display="block";
	}else{
		document.getElementById(divName).style.display="none";
	}
}

//等比例缩放图片函数
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

function fun_money(s, n)  
{  
   n = n > 0 && n <= 20 ? n : 2;  
   s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";  
   var l = s.split(".")[0].split("").reverse(),  
   r = s.split(".")[1];  
   t = "";  
   for(i = 0; i < l.length; i ++ )  
   {  
      t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");  
   }  
   return t.split("").reverse().join("") + "." + r;  
}   

//浮点数加法运算  
 function FloatAdd(arg1,arg2){  
   var r1,r2,m;  
   try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}  
   try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}  
   m=Math.pow(10,Math.max(r1,r2))  
   return (arg1*m+arg2*m)/m  
}  
  
 //浮点数减法运算  
 function FloatSub(arg1,arg2){  
	 var r1,r2,m,n;  
	 try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}  
	 try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}  
	 m=Math.pow(10,Math.max(r1,r2));  
	 //动态控制精度长度  
	 n=(r1>=r2)?r1:r2;  
	 return ((arg1*m-arg2*m)/m).toFixed(n);  
 }  
   
 //浮点数乘法运算  
 function FloatMul(arg1,arg2)   
 {   
	  var m=0,s1=arg1.toString(),s2=arg2.toString();   
	  try{m+=s1.split(".")[1].length}catch(e){}   
	  try{m+=s2.split(".")[1].length}catch(e){}   
	  return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)   
  }   
  
  
//浮点数除法运算  
function FloatDiv(arg1,arg2){   
	var t1=0,t2=0,r1,r2;   
	try{t1=arg1.toString().split(".")[1].length}catch(e){}   
	try{t2=arg2.toString().split(".")[1].length}catch(e){}   
	with(Math){   
		r1=Number(arg1.toString().replace(".",""))   
		r2=Number(arg2.toString().replace(".",""))   
		return (r1/r2)*pow(10,t2-t1);   
	}   
} 

//时间格式
function TimeFormat(e){
	
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
	numcheck = /\b\d{4}-\d{1,2}-\d{1,2}\b/; 
	return numcheck.test(keychar);

} 

/*
 *@描述：计算日期之差
 *@param  date		_start		--开始日期，格式：YYYY-MM-DD
 *@param  date		_final		--结束日期，格式：YYYY-MM-DD
 *@return int					--返回的起始时间相隔的天数(示例：如果起始时间为同一天，返回结果为0)
 */
function dateDiff(_start,_final){
			var s = _start.split('-');
			var f = _final.split('-');
			var _s = new Date(s[0],s[1]-1,s[2]);
			var _f = new Date(f[0],f[1]-1,f[2]);
			var diff = _f.getTime() - _s.getTime();
			return Math.ceil(diff/(1000*3600*24));
}

/*
 *@描述：追加日期
 *@param  date		_start		--原日期时间，格式：YYYY-MM-DD
 *@param  int		_day		--需追加的天数，
 *@return date					--返回的追加天数后的新日期
 */
function dateAdd(_start,_day){
			var s = _start.split('-');
			var _s = new Date(s[0],s[1]-1,s[2]);
			var _r = _s.getTime() + (_day-1)*1000*3600*24;
			var _d = new Date(_r);
			var y = _d.getFullYear();
			var m = _d.getMonth()+1;
			var d = _d.getDate();
			return y +'-'+ m +'-'+ d;
}

/*
 *@描述：根据起始日期得出此时间段内的工作日的总天数
 *@param  date		_start		--开始日期，格式：YYYY-MM-DD
 *@param  date		_final		--结束日期，格式：YYYY-MM-DD
 *@return int					--返回的此时间段内的工作日的总天数
 */
function GetBaseDayNumByStimeAndEtime(){
	var s = _start.split('-');
	var f = _final.split('-');
	var _s = new Date(s[0],s[1]-1,s[2]);
	var _f = new Date(f[0],f[1]-1,f[2]);
	//var diff = _f.getTime() - _s.getTime();
	//return Math.ceil(diff/(1000*3600*24));
	//1000*3600*24=
	for(i=_s.getTime(); i<=_f.getTime(); i+=86400000){
		
	}
	
}

/*
 *@描述：根据起始日期得出此时间段内的周未（周六、周日）的总天数
 *@param  date		_start		--开始日期，格式：YYYY-MM-DD
 *@param  date		_final		--结束日期，格式：YYYY-MM-DD
 *@return int					--返回的此时间段内的周未（周六、周日）的总天数
 */
function GetWeekDayNumByStimeAndEtime(){
	
	
}

/*
 *@描述：根据起始日期得出此时间段内的节假日的总天数
 *@param  date		_start		--开始日期，格式：YYYY-MM-DD
 *@param  date		_final		--结束日期，格式：YYYY-MM-DD
 *@return int					--返回的此时间段内的节假日的总天数
 */
function GetHolidayDayNumByStimeAndEtime(){
	
	
}
