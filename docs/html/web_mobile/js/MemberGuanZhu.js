/**
 *  Create on:  2015-08-31 14:49:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author   ：liuqingyan[Leaya]
 *  Id		 :MemberGuanZhu.js
 */
 
//点击关注/取消
function OnClick_MemberGuanZhu(uid){
	S_xmlhttprequest();
	xmlHttp.open("get","/index.php?s=MemberGuanZhu/AjaxGuanZhu/uid/"+uid,true);
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
				 	if(obj["info"]["is_member_fans"]>0){
						var _class="follow ok"; var _title="已关注"; var _title_msg="关注成功"; 
					}else{
						var _class="follow"; var _title="关注"; var _title_msg="取消关注成功";
					}
				 	var str="";
						str +='<button type="button" class="'+_class+'" onclick="OnClick_MemberGuanZhu(\''+obj["info"]["uid"]+'\')">'+_title+'</button>';
					$(".attention_"+obj["info"]["uid"]).html(str);
					layer.open({
						style: 'width:100%;border:none; background-color:#78BA32; color:#fff; text-align:center;',
						content:_title_msg,
						time:2,
						shade:false
					})
				 }else{
					//$(".attention_"+obj["info"]["uid"]).html(obj["error_str"]);
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
 