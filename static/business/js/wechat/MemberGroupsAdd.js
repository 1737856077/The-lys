/**
 *  Create on  :  2015-07-28 16:59:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:KeywordReply_AddImage.js
 */
 
//分组名称
function onblur_title(){
	var flag=true;
	var title=document.getElementById("title");
	var span_title=document.getElementById("span_title");
	if(title.value.trim()==""){
		span_title.innerHTML="分组名称不能为空！";
		flag=false;
	}else{
		span_title.innerHTML="";
	}
	return flag;
}

//提交验证
function funsubmit_add(){
	var flag=true;
		//分组名称
		if(!onblur_title()){
			return 	flag=false;
		}
	
	return true;
}