/**
 *  Create on:  2015-08-31 17:12:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author   ：liuqingyan[Leaya]
 *  Id		 :MemberDemandPraise.js
 */
 
//点击赞/取消
function OnClick_MemberDemandPraise(id){
	S_xmlhttprequest();
	xmlHttp.open("get","/index.php?s=DemandPraise/AjaxPraise/demandid/"+id,true);
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
				 	if(obj["info"]["is_member_check"]>0){var _class="zan ok";  var _title_msg="点赞成功"; }else{var _class="zan"; var _title_msg="取消点赞成功"; }
				 	var str="";
						str +='<a href="javascript:OnClick_MemberDemandPraise(\''+obj["info"]["demandid"]+'\')"><i class="'+_class+'"></i><span>赞 '+obj["info"]["total"]+'</span></a>';
					document.getElementById("DemandPraise_"+obj["info"]["demandid"]).innerHTML=str;
					layer.open({
						style: 'width:100%;border:none; background-color:#78BA32; color:#fff; text-align:center;',
						content:_title_msg,
						time:2,
						shade:false
					})
				 }else{
					//document.getElementById("DemandPraise_"+obj["info"]["demandid"]).innerHTML=obj["error_str"];
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
 