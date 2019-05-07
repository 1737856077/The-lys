/**
 *  Create on  :  2015-08-12 11:11:50 liuqingyan[Leaya] , liuqingyan0308@gmail.com
 *  Author     ：liuqingyan[Leaya]
 *  Id			:WechatWatchGroupsLocalAdd
 */
 
//操作
function select_groups_id(){
	var flag=true;
	var div_groups_id=document.getElementById("div_groups_id");
	var span_groups_id=document.getElementById("span_groups_id");
	var n=0;
	var inputitem=div_groups_id.getElementsByTagName("input");
	
	for (var i=0;i<inputitem.length;i++){ 
		var e = inputitem[i];
		
		if (e.type == "checkbox" && e.name!='chkAll' && e.checked==true) {
			n++;
		}
	}
	if(n<1){
		span_groups_id.innerHTML="未选择所属分组！";
		//location.href="#div_OriginId";
		flag=false;
	}else{
		span_groups_id.innerHTML="";
	}
	//alert(n);
	return flag;
} 
 
//提交验证
function funsubmit_add(){
	var flag=true;
		//操作
		if(!select_groups_id()){
			return 	flag=false;
		}
	
	return true;
}  