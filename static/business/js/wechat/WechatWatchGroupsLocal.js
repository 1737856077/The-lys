/**
 *  Create on  :  2015-08-12 16:24:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:WechatWatchGroups_Index.js
 */
 
//输入粉丝昵称
function onblur_SearchName(){
	var flag=true;
	var SearchName=document.getElementById("SearchName");
	var span_SearchName=document.getElementById("span_SearchName");
	if(SearchName.value.trim()=="" || SearchName.value.trim()=="输入粉丝昵称"){
		span_SearchName.innerHTML="搜索内容不能为空！";
		flag=false;
	}else{
		span_SearchName.innerHTML="";
	}
	return flag;
}
 
//提交验证
function funsubmit_search(){
	var flag=true;
		//输入粉丝昵称
		if(!onblur_SearchName()){
			return 	flag=false;
		}
	
	return true;
} 

//全选操作
function Onsubmit_openid(){
	var flag=true;
	var div_wechat_list=document.getElementById("div_wechat_list");
	var span_from_submit=document.getElementById("span_from_submit");
	var n=0;
	var inputitem=div_wechat_list.getElementsByTagName("input");
	
	for (var i=0;i<inputitem.length;i++){ 
		var e = inputitem[i];
		
		if (e.type == "checkbox" && e.name!='chkAll' && e.checked==true) {
			n++;
		}
	}
	if(n<1){
		span_from_submit.innerHTML="未选择粉丝！";
		//location.href="#div_OriginId";
		flag=false;
	}else{
		span_from_submit.innerHTML="";
	}
	//alert(n);
	return flag;
}


//提交验证
function funsubmit_editinfo(){
	var flag=true;
	var checkclass=document.getElementById("checkclass");
	var groups_id=document.getElementById("groups_id");
	var span_from_submit=document.getElementById("span_from_submit");
	
		//全选操作
		if(!Onsubmit_openid()){
			return 	flag=false;
		}
	if(checkclass.value=="1" && groups_id.value=="1"){
		span_from_submit.innerHTML="无法将粉丝从默认分组中移除！";
		return 	flag=false;
	}
	
	return true;
} 