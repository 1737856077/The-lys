<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"D:\phpStudy\WWW\liuqingyan\zxpaiban\zxpaiban_project/admin/index\view\index.login.html";i:1532310987;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>后台管理登录</title>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/index.css"/>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/public.css"/>
    <script type="text/javascript" src="/static/admin/js/myString.js"></script>
    <script type="text/javascript" src="/static/admin/js/function.js"></script>
</head>
<script type="text/javascript">
function funsubmit(){
	if(document.getElementById("adminname").value.trim()==""){
		alert("用户名不能为空！");
		document.getElementById("adminname").focus();
		return false;
	}
	if(document.getElementById("adminpwd").value.trim()==""){
		alert("密码不能为空！");
		document.getElementById("adminpwd").focus();
		return false;
	}
	return true;
}

function focususername(){
	document.getElementById("adminname").focus();
}
</script>
<body >
	<div class="login_bg">
		<div class="login_con" style="text-align:center;">
        <form name="form1" method="post" action="/admin.php/index/index/checklogin" onsubmit="javascript:return funsubmit();">
			<h1><img src="/static/admin/images/logo.png" alt="" /></h1>
			<input type="text" value="用户名" onfocus="if(this.value == '用户名') this.value = ''" onblur="if(this.value =='') this.value = '用户名'"  name="adminname" id="adminname" class="names" />
			<input type="text" value="密码"  name="adminpwd"  id="adminpwd" class="names" onfocus="if(this.value == '密码'){ this.value = ''; this.type='password';}" onblur="if(this.value ==''){ this.value = '密码'; this.type='text';}"  />
			<!--<input type="text" value="" class="yzheng" />
			<img src="images/yz_bg.png" alt="" class="yz_bg"/>-->
			<button type="text" class="login">登 录</button>&nbsp;<br /><br />
        </form>   
		</div>
		<span class="pows">Powered by <?php echo config('custom_config.WebConfig_VersionName'); ?></span>
	</div>
</body>
</html>
