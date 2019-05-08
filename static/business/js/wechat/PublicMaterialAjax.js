/**
 * Encoding     :   UTF-8
 * Created on   :   2015-08-07 11:12:00 by liuqingyan[Leaya] , liuqingyan0308@gmail.com
 * Id			:	PublicMaterialAjax.js
 * 描述			：	查询素材信息
 */
 
var xmlHttp;
function S_xmlhttprequest(){
	 if(window.ActiveXObject){
		 xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	 }else if (window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	 }
}

//检索没数据的样式
function GetNullNumberStr(){
	var s="";
	//s +='<div class="road_01">';
		s +=' 亲，暂时没有数据！';
	//s +='</div>';
	return s;
}

//AJAX请求处理-素材
function AjaxMaterialSearchInfo(type){
	S_xmlhttprequest();
	var InputMaterialUrl=document.getElementById("InputMaterialUrl").value;
	var InputMaterialMusicUrl=document.getElementById("InputMaterialMusicUrl").value;
	var page=document.getElementById("PageMaterial_"+type).value;
	
	var Table=document.getElementById("Table_"+type);
	var _timestamp=new Date().getTime();
	
	var param="";
		param += "&page="+page;
		param += "&MsgType="+type;
		//param += "&sjtime="+_timestamp+Math.ceil(Math.random()*1000);
	var link01=document.getElementById("link_"+type);
	
	var url=InputMaterialUrl;
	if(type=="music"){url=InputMaterialMusicUrl;}
	url += "&sjtime="+_timestamp+Math.ceil(Math.random()*1000);
	//alert(param);
	xmlHttp.open("post",url,true);
	xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.status==200)
			{
				 var s = xmlHttp.responseText;
				 var obj = eval('('+s+')');
				 
				 //清空老数据
				 if(page==1){
				 	var rownum=Table.rows.length;
					if(rownum>1){
						for(i=1;i<rownum;i++){
							Table.deleteRow(i);
							rownum=rownum-1;
							i=i-1;
						}
					} 
				 }
				 
				 if(obj["count"]<1){//没有数据
					 link01.innerHTML=GetNullNumberStr();
					 document.getElementById("PageMaterial_"+type).value="1";
				 }else{
					 WriteMaterialSearchHtml(obj["list"],page,type);
					 
					 if(obj["page"]==obj["total_page"]){
						 link01.innerHTML='亲，没有更多了哈...';
					 }else{
						 document.getElementById("PageMaterial_"+type).value=obj["last_page"];
						 link01.innerHTML='<a href="javascript:AjaxMaterialSearchInfo(\''+type+'\');">点击加载更多...</a>';
					 }
				 }
			
			}
			
		}else{
			link01.innerHTML='加载中...';
		}
	}
	xmlHttp.setRequestHeader("If-Modified-Since","0");
	xmlHttp.send(param);
}

//格试化数据
function WriteMaterialSearchHtml(objstr,page,type){
	var obj = objstr;
	
	if(type=="image"){//图片
		for (var i=0;i<obj.length;i++){ 
			var tr=document.createElement("tr");
				tr.style="border-left:3px solid #cfbba9";
				tr.className="mid_02";
		　　
			var td=document.createElement("td");	
				td.innerHTML='<img src="'+obj[i]["Url"]+'" height="100" width="150" alt="" />';
		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML=''+obj[i]["Time"]+'';
		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML='<a href="javascript:GetWechatMaterialImage(\''+obj[i]["Url"]+'\',\''+obj[i]["MediaId"]+'\')">选中使用</a>';
		　　　　	tr.appendChild(td);
			document.getElementById("TableTbody_"+type).appendChild (tr);
		}
	}else if(type=="video"){//视频
		for (var i=0;i<obj.length;i++){ 
			var tr=document.createElement("tr");
				tr.style="border-left:3px solid #cfbba9";
				tr.className="mid_02";
		　　
			//var td=document.createElement("td");	
//				td.innerHTML=''+obj[i]["MediaId"]+'';
//		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML=''+obj[i]["Title"]+'';
		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML='<a href="javascript:GetWechatMaterialVideo(\''+obj[i]["MediaId"]+'\')">选中使用</a>';
		　　　　	tr.appendChild(td);
			document.getElementById("TableTbody_"+type).appendChild (tr);
		}
	}else if(type=="voice"){//语音
		for (var i=0;i<obj.length;i++){ 
			var tr=document.createElement("tr");
				tr.style="border-left:3px solid #cfbba9";
				tr.className="mid_02";
		　　
			//var td=document.createElement("td");	
//				td.innerHTML=''+obj[i]["MediaId"]+'';
//		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML=''+obj[i]["Title"]+'';
		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML='<a href="javascript:GetWechatMaterialVoice(\''+obj[i]["MediaId"]+'\')">选中使用</a>';
		　　　　	tr.appendChild(td);
			document.getElementById("TableTbody_"+type).appendChild (tr);
		}
	}else if(type=="music"){//音乐
		for (var i=0;i<obj.length;i++){ 
			var tr=document.createElement("tr");
				tr.style="border-left:3px solid #cfbba9";
				tr.className="mid_02";
		　　
			var td=document.createElement("td");	
				td.innerHTML='<img src="'+obj[i]["ThumbUrl"]+'" height="100" width="150" alt="" />';
		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML=''+obj[i]["Title"]+'';
		　　　　	tr.appendChild(td);
			var td=document.createElement("td");	
		　　　　	td.innerHTML='<a href="javascript:GetWechatMaterialMusic(\''+obj[i]["Url"]+'\',\''+obj[i]["HdUrl"]+'\',\''+obj[i]["ThumbMediaId"]+'\')">选中使用</a>';
		　　　　	tr.appendChild(td);
			document.getElementById("TableTbody_"+type).appendChild (tr);
		}
	}

}
 
 