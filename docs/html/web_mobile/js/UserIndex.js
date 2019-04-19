/**
 *  Create on:  2015-06-30 09:47:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author   ：liuqingyan[Leaya]
 *  Id		 :UserIndex.js
 */
 
//检索没数据的样式
function GetNullNumberStr(){
	var s="";
	//s +='<div class="road_01">';
		s +=' 亲，暂时没有数据！';
	//s +='</div>';
	return s;
}


//AJAX请求处理
function AjaxPostSearchInfo(){
	S_xmlhttprequest();
	var url=document.getElementById("ajax_url").value;
	var page=document.getElementById("page").value;
	
	var GetUserOpenid=document.getElementById("GetUserOpenid").value;
	document.getElementById("select_status").value="0";
	
	var param="page="+page;
		param+="&openid="+encodeURIComponent(GetUserOpenid);
	var link01=document.getElementById("link01");
	//alert(param);
	xmlHttp.open("get",url+"&"+param,true);
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
				 	$(".ajax_lists").remove();
				 }
				 
				 var _div=document.createElement("div");
					  _div.className="ajax_lists";
					  _div.setAttribute("id","page"+page);
				 link01.parentNode.insertBefore(_div,link01);
				 
				 if(obj["count"]<1){//没有数据
					 link01.innerHTML=GetNullNumberStr();
					 document.getElementById("page").value="1";
					 document.getElementById("total_page").value="1";
					 document.getElementById("select_status").value="0";
				 }else{
					 document.getElementById("page"+page).innerHTML=WriteRightSearchHtml(obj["list"]);
					 
					 if(obj["page"]==obj["total_page"]){
						 //document.getElementById("page").value="1";
						 //document.getElementById("total_page").value="1";
						 document.getElementById("select_status").value="0";
						 link01.innerHTML='亲，没有更多了哈...';
					 }else{
						 document.getElementById("page").value=obj["last_page"];
						 document.getElementById("total_page").value=obj["total_page"];
						 document.getElementById("select_status").value="1";
						 //link01.innerHTML='<img src="images/xiala.png" alt=""><a href="javascript:AjaxPostSearchInfo('+obj["last_page"]+');">点击即可刷新</a>';
						 link01.innerHTML='<img src="/images/xiala.png" alt=""  style="vertical-align:middle;"><a href="javascript:AjaxPostSearchInfo();">下拉即可刷新</a>';
					 }
				 }
			
			}
			
		}else{
			link01.innerHTML='<img src="/Public/home/images/landing_01.gif" alt="" >';
		}
	}
	xmlHttp.setRequestHeader("If-Modified-Since","0");
	xmlHttp.send(null);
}

//格试化数据
function WriteRightSearchHtml(objstr){
	var obj = objstr;
	var s="";
	var public_url=document.getElementById("public_url").value; 
	var ProductInfo_Url=document.getElementById("ProductInfo_Url").value; 
	var BuyAdd_Url=document.getElementById("BuyAdd_Url").value; 
	
	
	
	
	
	
	for (var i=0;i<obj.length;i++){
            var img_arr =new Array();
            img_arr = obj[i]['DemandImages'].split('/');
            var imgPath = img_arr[0];
            var imgName = 'thumb_'+img_arr[1];
			
			
				s +='<div class="index_con">';
					s +='<div class="product_con">';
						s +='<div class="yonghu">';
							//s +='<a href="/index.php?s=PersonalHome/index"><img src="'+obj[i]["member_img"]+'" alt=""></a>';
							s +='<img src="'+obj[i]["member_img"]+'" alt="">';
							s +='<h3>&nbsp;'+obj[i]["member_nickname"]+'</h3>';
						s +='</div>';
						s +='<div class="yonghu_r attention_'+obj[i]["member_uid"]+'">';	
								if(obj[i]["is_member"]=="1"){
									if(obj[i]["member_attention"]=="1"){//取消关注
											s +='<button type="button" class="follow ok" onclick="OnClick_MemberGuanZhu(\''+obj[i]["member_uid"]+'\')">已关注</button>';
									}else{//关注
											s +='<button type="button" class="follow" onclick="OnClick_MemberGuanZhu(\''+obj[i]["member_uid"]+'\')">关注</button>';
									}
								}else{
											s +='<button type="button" class="follow">关注</button>';
								}
						s +='</div>';
						s +='<div class="banner_con">';
							s +='<a href="/index.php?s=DemandDetail/index/demandid/'+obj[i]["DemandID"]+'">';
							if(obj[i]["DemandImages"]==null || obj[i]["DemandImages"]=='undefined' || obj[i]["DemandImages"]=='' ){
								s +='<img src="'+public_url+'/Uploads/Demand/default.jpg" height="130" />';
							}else{
								s +='<img src="'+public_url+'/Uploads/Demand/'+imgPath+'/'+imgName+'" height="130" />';
							}
							s +='</a>';
						s +='</div>';
						s +='<div class="product_title">';
							s +='<div class="zjia">';
								s +='<div class="zjia_title">';
									s +='<h3><a href="/index.php?s=DemandDetail/index/demandid/'+obj[i]["DemandID"]+'">'+obj[i]["Title"]+'</a></h3>';
									s +='<div><i>¥</i>&nbsp;<span>'+obj[i]["Price"]+'</span></div>';
								s +='</div>';
								s +='<p>'+obj[i]["Description"]+'</p>';
							s +='</div>';
							s +='<div class="zjia_r"  id="favorites_'+obj[i]["DemandID"]+'">';
								if(obj[i]["is_member"]=="1"){
									if(obj[i]["is_favorites"]=="1"){//取消收藏
										s +='<a href="javascript:OnClick_Favorites(\''+obj[i]["DemandID"]+'\');" >';
											s +='<i  class="collect ok"></i>';
											s +='<span>已收藏</span>';
										s +='</a>';
									}else{//收藏
										s +='<a href="javascript:OnClick_Favorites(\''+obj[i]["DemandID"]+'\');" >';
											s +='<i  class="collect"></i>';
											s +='<span>收藏</span>';
										s +='</a>';
									}
								}else{
											s +='<i  class="collect"></i>';
											s +='<span>收藏</span>';
								}
							s +='</div>';
						s +='</div>';
						s +='<div class="pinglun_bottom">';
							s +='<ul>';
								s +='<li><a href="/index.php?s=DemandDetail/index/demandid/'+obj[i]["DemandID"]+'#div_demand_comment"><i class="comment"></i><p>评论</p>&nbsp;<span>'+obj[i]["DemandComment"]+'</span></a></li>';
								s +='<li id="DemandPraise_'+obj[i]["DemandID"]+'">';
									
									if(obj[i]["is_member"]=="1"){
										if(obj[i]["member_DemandPraise"]=="1"){//取消赞
											s +='<a href="javascript:OnClick_MemberDemandPraise(\''+obj[i]["DemandID"]+'\');"><i class="zan ok"></i><span>赞 '+obj[i]["DemandPraise"]+'</span></a>';
										}else{//赞
											s +='<a href="javascript:OnClick_MemberDemandPraise(\''+obj[i]["DemandID"]+'\');"><i class="zan"></i><span>赞 '+obj[i]["DemandPraise"]+'</span></a>';
										}
									}else{
											s +='<a href="javascript:void(0)"><i class="zan"></i><span>赞 '+obj[i]["DemandPraise"]+'</span></a>';
									}
								s +='</li>';
								s +='<li style="border-right:none;  text-align: right;"><a href="/index.php?s=DemandDetail/index/demandid/'+obj[i]["DemandID"]+'" class="yao">我也要</a></li>';
							s +='</ul>';
						s +='</div>';
					s +='</div>';
					
				s +='</div>';

			
	}
	 return s;
}
 

 