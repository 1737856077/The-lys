/**
 *  Create on:  2015-09-01 10:01:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author   ：liuqingyan[Leaya]
 *  Id		 :MemberFavorites.js
 */
 
//点击收藏/取消
function OnClick_Favorites(id){
	S_xmlhttprequest();
	xmlHttp.open("get","/index.php?s=Favorites/AjaxFavorites/demandid/"+id,true);
	xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.status==200)
			{
				 var s = xmlHttp.responseText;
				 var obj = eval('('+s+')');

				 if(obj["error_val"]=="0"){//没有错
				 	if(obj["info"]["is_favorites"]>0){
						var _class="collect ok"; var _title="已收藏"; var _title_msg="收藏成功";
					}else{
						var _class="collect"; var _title="收藏"; var _title_msg="取消收藏成功";
					}
				 	var str="";
						str +='<a href="javascript:OnClick_Favorites(\''+obj["info"]["demandid"]+'\')" >';
										str +='<i  class="'+_class+'"></i>';
										str +='<span>'+_title+'</span>';
						str +='</a>';
						
					document.getElementById("favorites_"+obj["info"]["demandid"]).innerHTML=str;
					layer.open({
						style: 'width:100%;border:none; background-color:#78BA32; color:#fff; text-align:center;',
						content:_title_msg,
						time:2,
						shade:false
					})
				 }else{
					//document.getElementById("favorites_"+obj["info"]["demandid"]).innerHTML=obj["error_str"];
					layer.open({
						style: 'width:100%;border:none; background-color:#78BA32; color:#fff; text-align:center;',
						content:"-_-# "+obj["error_str"],
						time:2,
						shade:false
					})
				 }
			
			}
			
		}
	}
	xmlHttp.setRequestHeader("If-Modified-Since","0");
	xmlHttp.send(null);
} 