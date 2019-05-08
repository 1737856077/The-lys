/**
 *  Create on  :  2015-07-28 17:03:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:KeywordReply_AddText.js
 */
//关键字
function onblur_key_word(){
	var flag=true;
	var key_word=document.getElementById("key_word");
	var span_key_word=document.getElementById("span_key_word");
	if(key_word.value.trim()==""){
		span_key_word.innerHTML="关键字不能为空！";
		flag=false;
	}else{
		span_key_word.innerHTML="";
	}
	return flag;
}
//文本消息-文本
function onblur_text_description(){
	var flag=true;
	var text_description=document.getElementById("text_description");
	var span_text_description=document.getElementById("span_text_description");
	if(text_description.value.trim()==""){
		span_text_description.innerHTML="文本不能为空！";
		flag=false;
	}else{
		span_text_description.innerHTML="";
	}
	return flag;
}
//提交验证
function funsubmit_update(){
	var flag=true;
		//关键字
		if(!onblur_key_word()){
			return 	flag=false;
		}
		//文本消息-文本
		if(!onblur_text_description()){
			return 	flag=false;
		}
	
	return true;
}
 
 