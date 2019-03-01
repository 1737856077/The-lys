/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:业务员管理JS验证
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:salesman_add.js 2019-03-01 18:01:00 $
 */

//name
function onBlur_name(){
	if(document.getElementById("name").value.trim()==""){
		document.getElementById("span_name").innerHTML="不能为空！";	
		return false;
	}else{
		document.getElementById("span_name").innerHTML="";	
	}
	return true;
}

//入职日期
function onBlur_job_in_time(){
	var job_in_time=document.getElementById("job_in_time").value;
	if(job_in_time.trim()==""){
		document.getElementById("span_job_in_time").innerHTML="不能为空！";
		return false;
	}else{
		document.getElementById("span_job_in_time").innerHTML="";
	}
    return true;
}

//分成比例
function onBlur_divide_into(){
    var divide_into=document.getElementById("divide_into").value;
    if(divide_into.trim()==""){
        document.getElementById("span_divide_into").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_divide_into").innerHTML="";
    }
    return true;
}

//联系电话
function onBlur_tel(){
    var tel=document.getElementById("tel").value;
    if(tel.trim()==""){
        document.getElementById("span_tel").innerHTML="不能为空！";
        return false;
    }else{
        document.getElementById("span_tel").innerHTML="";
    }
    return true;
}

//add submit
function subfun(){
	//name
	if(!onBlur_name()){return false;}
	//入职日期
    if(!onBlur_job_in_time()){return false;}
	//分成比例
    if(!onBlur_divide_into()){return false;}
	//联系电话
    if(!onBlur_tel()){return false;}

	return true;
}

//edit submit
function subfunedit(){
    //入职日期
    if(!onBlur_job_in_time()){return false;}
    //分成比例
    if(!onBlur_divide_into()){return false;}
    //联系电话
    if(!onBlur_tel()){return false;}
	
	return true;
}