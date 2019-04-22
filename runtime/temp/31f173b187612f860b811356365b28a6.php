<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"C:\Users\Administrator\Desktop\suyuan\sy/admin/index\view\index.main.html";i:1555559600;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>后台管理</title>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/index.css"/>
	<link type="text/css" rel="stylesheet" href="/static/admin/css/public.css"/>
</head>
<body  style="background-color:#f1f1f1">

        <div class="menus_r">
        		<div class="maps">
                    <i></i>
                    <p class="current">您当前的位置：后台管理</p>      
                </div>
                <div class="admin">
                    <p class="good"><span class="sw">上午好！</span><b><?php echo \think\Session::get('adminname'); ?></b><span class="please">欢迎登录<?php echo config('custom_config.WebConfig_Name'); ?>后台管理系统！</span></p>
                    <div class="details fl">
                    <div class="details_t">
                        <p class="f_time fl"><span>服务器时间：</span><?php echo date("Y-m-d H:i:s"); ?></p>
                        <p class="f_times fl"><span>Zend版本：</span><?php echo Zend_Version(); ?></p>
                    </div>
                    <div class="details_t">
                        <p class="f_time fl"><span>服务器IP地址：</span><?php echo $_SERVER["SERVER_ADDR"]; ?></p>
                        <p class="f_times fl"><span>显示错误信息：</span><?php $DisplayErrors=strtolower(get_cfg_var("display_errors")); if($DisplayErrors=="on"){echo "显示"; }else{ echo  '不显示'; } ?></p>
                    </div>
                    <div class="details_t">
                        <p class="f_time fl"><span>当前域名：</span><?php echo  $_SERVER['SERVER_NAME']; ?></p>
                        <p class="f_times fl"><span>服务器超时时间：</span><?php echo get_cfg_var("max_execution_time")." 秒"; ?></p>
                    </div>
                    <div class="details_t">
                        <p class="f_time fl"><span>PHP运行：</span><?php echo php_sapi_name(); ?></p>
                        <p class="f_times fl"><span>POST最大字节数：</span><?php echo get_cfg_var("post_max_size"); ?></p>
                    </div>
                    <div class="details_t">
                        <p class="f_time fl"><span>PHP版本：</span><?php echo PHP_VERSION;  ?></p>
                        <p class="f_times fl"><span>程序最多允许使用内存量：</span><?php echo get_cfg_var("memory_limit"); ?></p>
                    </div>
                    <div class="details_t">
                        <p class="f_time fl"><span>操作系统：</span><?php $PHPUname=explode(" ",php_uname()); echo $PHPUname[0]; ?></p>
                        <p class="f_times fl"><span>Session支持：</span><?php if(!isset($_session)){ echo '支持';}else{ echo '不支持';} ?></p>
                    </div>
                    <div class="details_t" style="border:none">
                        <p class="f_time fl"><span>上传限制大小：</span><?php echo get_cfg_var("upload_max_filesize"); ?></p>
                        <p class="f_times fl"><span>被屏蔽的函数：</span><?php $DisableFunctions=get_cfg_var("disable_functions"); if(empty($DisableFunctions)){echo "无"; }else{ echo  get_cfg_var("disable_functions"); } ?></p>
                    </div>
                </div>  
                <!-- details end -->
                        <div class="details_r fl">
                            <div class="details_rcon">
                            <a href="#"><dl>
                                <dt><img src="/static/admin/images/details_01.png" alt="" /></dt>
                                <dd>发文章</dd>
                            </dl>
                            </a>
                            <a href="#"><dl>
                                <dt><img src="/static/admin/images/details_02.png" alt="" /></dt>
                                <dd>图片管理</dd>
                            </dl>
                            </a>
                            <a href="#"><dl>
                                <dt><img src="/static/admin/images/details_03.png" alt="" /></dt>
                                <dd>推荐文章</dd>
                            </dl>
                            </a>
                            <a href="#"><dl>
                                <dt><img src="/static/admin/images/details_04.png" alt="" /></dt>
                                <dd>系统设置</dd>
                            </dl>
                            </a>
                            <a href="#"><dl>
                                <dt><img src="/static/admin/images/details_05.png" alt="" /></dt>
                                <dd>用户管理</dd>
                            </dl>
                            </a>
                            <a href="#"><dl>
                                <dt><img src="/static/admin/images/details_06.png" alt="" /></dt>
                                <dd>二维码</dd>
                            </dl>
                            </a>
                            </div>
                             <div class="details_ys">
                               <iframe width="200" scrolling="no" height="65" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=35&icon=1&num=3"></iframe>
                                
                            </div>
                        </div>
                </div>
                <!-- admin end -->    
			
        </div>
</body>
</html>