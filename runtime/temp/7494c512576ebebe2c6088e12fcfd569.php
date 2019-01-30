<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"D:\phpStudy\WWW\liuqingyan\zxpaiban\zxpaiban_project/admin/index\view\index.menu.html";i:1548837995;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/index.css"/>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/public.css"/>
    <script type="text/javascript" src="/static/admin/js/jquery.js"></script>
	<!--[if lte IE 6]>
<script src="/Public/js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div,p,img,li,span,i');
    </script>
	<![endif]-->
    
<script type="text/javascript">
    $(function(){
       $(".menus").height($(window).height()-54).find(".menus_r").width($(window).width()-160-20);  
   
    /****************左侧菜单触发二级菜单******************/
    $(".menus_l > ul > li.tab > .list_back").each(function(m,n){
        $(n).click(function(){
          $(this).next("ul").slideToggle().parent("li").addClass("change").siblings("li.tab").removeClass("change").find("ul").hide();
        });
    });  
});  
</script>
</head>
<body style="background:#191f26 none repeat scroll;">
    <div class="menus">
     	<div class="menus_l">
        	 <ul>
              <li class="cur">
                  <div class="list_ca list_back"><i></i><a href="javascript:vivo(0)">内容管理</a><em></em></div>
              </li>

                 <?php if(auth('admin/admin/index') or  auth('admin/manager/index') or  auth('admin/admin/add') or  auth('admin/adminoperatelog/index')  or  auth('admin/admin/modifypwd')): ?>
                 <li class="tab change">
                     <div class="list_cb list_back"><i></i><a href="javascript:vivo(0)">系统管理员 </a><em></em></div>
                     <ul class="ct" style="display:none;">
                         <?php if(auth('admin/admin/index')): ?>
                         <li><a href="/admin.php/admin/admin/index" target="mainframe">管理员列表</a></li>
                         <?php endif; if(auth('admin/admin/add')): ?>
                         <li><a href="/admin.php/admin/admin/add" target="mainframe">添加管理员</a></li>
                         <?php endif; if(auth('admin/adminoperatelog/index')): ?>
                         <li><a href="/admin.php/admin/adminoperatelog/index" target="mainframe">操作记录　</a></li>
                         <?php endif; if(auth('admin/admin/modifypwd')): ?>
                         <li><a href="/admin.php/admin/admin/modifypwd" target="mainframe">修改密码　</a></li>
                         <?php endif; ?>
                         <li><a href="#" target="mainframe">分享注册　</a></li>
                     </ul>
                     <hr>
                 </li>
                 <?php endif; ?>
                 
                 <li class="tab">
                    <div class="list_cd list_back"><i></i><a href="javascript:vivo(0)">安全管理</a><em></em></div>
                    <ul class="ct" style="display:none;">
                        <li><a href="#" target="mainframe">修改密码　</a></li>
                        <li><a href="#" target="mainframe">fdsdfdsfsfdsf　</a></li>
                    </ul>
                    <hr>
                  </li>
                 
                 <li class="tab">
                    <div class="list_cd list_back"><i></i><a href="javascript:vivo(0)">基础资料</a><em></em></div>
                    <ul class="ct" style="display:none;">
                        <li><a href="#" target="mainframe">标准模版管理　</a></li>
                        <li><a href="#" target="mainframe">|--模版列有　</a></li>
                        <li><a href="#" target="mainframe">|--添加模版　</a></li>
                        <li><a href="#" target="mainframe">|--设置状态　</a></li>
                        <li><a href="#" target="mainframe">模版分类管理　</a></li>
                        <li><a href="#" target="mainframe">|--分类列有　</a></li>
                        <li><a href="#" target="mainframe">|--添加分类　</a></li>
                        <li><a href="#" target="mainframe">|--编辑分类　</a></li>
                        <li><a href="#" target="mainframe">纸张管理　</a></li>
                        <li><a href="#" target="mainframe">|--材质列表　</a></li>
                        <li><a href="#" target="mainframe">|--添加材质　</a></li>
                        <li><a href="#" target="mainframe">|--编辑材质　</a></li>
                    </ul>
                    <hr>
                  </li>

                 <?php if(auth('auth/systemrole/index') or  auth('auth/systemnode/index')): ?>
                 <li class="tab">
                     <div class="list_cc list_back"><i></i><a href="javascript:vivo(0)">权限管理</a><em></em></div>
                     <ul class="ct" style="display:none;">
                         <?php if(auth('auth/systemrole/index')): ?>
                         <li><a href="/admin.php/auth/systemrole/index" target="mainframe">系统角色</a></li>
                         <?php endif; if(auth('auth/systemnode/index')): ?>
                         <li><a href="/admin.php/auth/systemnode/index" target="mainframe">系统结点</a></li>
                         <?php endif; ?>
                     </ul>
                     <hr>
                 </li>
                 <?php endif; ?>
                 
                 <li class="tab">
                    <div class="list_cd list_back"><i></i><a href="javascript:vivo(0)">工单管理</a><em></em></div>
                    <ul class="ct" style="display:none;">
                        <li><a href="#" target="mainframe">工单列表　</a></li>
                        <li><a href="#" target="mainframe">待回复工单　</a></li>
                    </ul>
                    <hr>
                  </li>

                 <?php if(auth('salesman/salesman/index') or  auth('salesman/divideinto/index')): ?>
                 <li class="tab">
                     <div class="list_cc list_back"><i></i><a href="javascript:vivo(0)">业务人员</a><em></em></div>
                     <ul class="ct" style="display:none;">
                         <?php if(auth('salesman/salesman/index')): ?>
                         <li><a href="/admin.php/salesman/salesman/index" target="mainframe">资料管理</a></li>
                         <?php endif; ?>
                         <li><a href="#" target="mainframe">扩广分成　</a></li>
                        <li><a href="#" target="mainframe">业务统计　</a></li>
                     </ul>
                     <hr>
                 </li>
                 <?php endif; ?>
                 
                 <li class="tab">
                    <div class="list_cd list_back"><i></i><a href="javascript:vivo(0)">客户管理</a><em></em></div>
                    <ul class="ct" style="display:none;">
                        <li><a href="#" target="mainframe">客户列表（0）　</a></li>
                        <li><a href="#" target="mainframe">资料管理　</a></li>
                        <li><a href="#" target="mainframe">财务往来　</a></li>
                        <li><a href="#" target="mainframe">统计报表　</a></li>
                    </ul>
                    <hr>
                  </li>
                  
                  <li class="tab">
                    <div class="list_cd list_back"><i></i><a href="javascript:vivo(0)">订单管理</a><em></em></div>
                    <ul class="ct" style="display:none;">
                    	<li><a href="#" target="mainframe">订单列表（0）　</a></li>
                        <li><a href="#" target="mainframe">订单审核　</a></li>
                        <li><a href="#" target="mainframe">订单下发　</a></li>
                        <li><a href="#" target="mainframe">状态管理　</a></li>
                        <li><a href="#" target="mainframe">下载模版文件(1)　</a></li>
                    </ul>
                    <hr>
                  </li>
<!--
                  <?php if(auth('product/product/index')): ?>
                  <li class="tab">
                    <div class="list_cd list_back"><i></i><a href="javascript:vivo(0)">产品管理</a><em></em></div>
                    <ul class="ct" style="display:none;">
                        <?php if(auth('product/product/index')): ?>
                        <li><a href="/admin.php/product/product/index" target="mainframe">产品列表　</a></li>
                        <?php endif; ?>
                    </ul>
                    <hr>
                  </li>
                  <?php endif; if(auth('qrcode/productcode/index') or  auth('qrcode/createqrcode/add') or auth('qrcode/qrreport/index')): ?>
                 <li class="tab">
                     <div class="list_cd list_back"><i></i><a href="javascript:vivo(0)">二维码管理</a><em></em></div>
                     <ul class="ct" style="display:none;">
                         <?php if(auth('qrcode/productcode/index')): ?>
                         <li><a href="/admin.php/qrcode/productcode/index" target="mainframe">二维码列表</a></li>
                         <?php endif; if(auth('qrcode/createqrcode/add')): ?>
                         <li><a href="/admin.php/qrcode/createqrcode/add" target="mainframe">生成二维码</a></li>
                         <?php endif; if(auth('qrcode/qrreport/index')): ?>
                         <li><a href="/admin.php/qrcode/qrreport/index" target="mainframe">二维码统计</a></li>
                         <?php endif; ?>
                     </ul>
                     <hr>
                 </li>
                 <?php endif; ?>
-->
            </ul>
        
        </div>
        
    </div>
</body>
</html>