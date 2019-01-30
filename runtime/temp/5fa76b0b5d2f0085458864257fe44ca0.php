<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\phpStudy\WWW\liuqingyan\zxpaiban\zxpaiban_project/admin/index\view\index.header.html";i:1539047218;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>后台管理</title>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/index.css"/>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/public.css"/>
</head>
<body>
	<div class="backstage">
		<a href="/admin.php/index/index/main" target="mainframe"><div class="webs fl">网站内容管理系统</div></a>
        <div class="webs_r fr">
        	<ul class="webs_con">
                <li class="adminid"></li>
                <li class="adminids">登陆者&nbsp;:&nbsp;<?php echo \think\Session::get('adminname'); ?></li>
				<?php if(auth('admin/admin/modifypwd')): ?>
                <li><a href="/admin.php/admin/admin/modifypwd" target="mainframe"><span>修改密码</span></a></li>
				<?php endif; ?>
                <li><a href="/admin.php/index/index/unlogin" title="退出"><span>退出</span></a></li>
                <!--<li><a href="/index.php" target="_blank" title="前台"><span>前台</span></a></li>-->
        	</ul>
        </div>
	</div>
</body>
</html>