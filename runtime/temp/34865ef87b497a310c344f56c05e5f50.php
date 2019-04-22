<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"C:\Users\Administrator\Desktop\suyuan\sy/integral/index\view\index.logins.html";i:1555640982;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title></title>
    <link rel="stylesheet" href="/static/integral/css/login.css"/>
    <script type="text/javascript" src="/static/integral/js/jquery-1.7.2.min.js"></script>
    <style>
        .login_bg{
            background: #ffffff;
        }
        .login_btn{
            width: 80%;
            margin: 10%;
        }
        .other_login{
            top: 70%;
        }
        .other_choose{
            top: 80%;
        }
    </style>
</head>
<body>
<div class="login_bg">
    <div id="logo">
        <img src="/static/integral/img/logo.png" />
    </div>
    <a class="login_btn" href="/integral.php/index/index/login">登&nbsp;&nbsp;录</a>
    <a class="login_btn" href="/integral.php/index/index/register">注&nbsp;&nbsp;册</a>
    <div class="other_login">
        <div class="other"></div>
        <span>其他方式登录</span>
        <div class="other"></div>
    </div>
    <div class="other_choose">
        <div></div>
        <a href="">
            <img src="/static/integral/img/wx.png"  alt=""/>
        </a>
        <div></div>
    </div>
</div>
</body>
</html>