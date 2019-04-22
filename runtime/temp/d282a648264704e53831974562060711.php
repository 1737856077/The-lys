<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"C:\Users\Administrator\Desktop\suyuan\sy/integral/index\view\index.login.html";i:1555645233;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title></title>
    <link rel="stylesheet" href="/static/integral/css/login.css" />
    <script type="text/javascript" src="/static/integral/js/jquery-1.7.2.min.js"></script>
</head>

<body>
<script>
    function rep() {
        $.ajax({
            //几个参数需要注意一下
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "<?php echo url('register/checklogin'); ?>" ,//url
            data: $('#form1').serialize(),
            success: function (result){
                switch (result['code']) {
                    case 1:
                        $("#tishi").html(result['msg'])
                        break;
                    case 2:
                        $("#tishi").html(result['msg'])
                        break;
                    default:
                        window.location.href="/integral.php/index/index/index";
                }
            }
        });
    }
</script>
<div id="login"></div>
<div class="login_bg">
    <div id="logo">
        <img src="/static/integral/img/logo.png"  alt=""/>
    </div>
    <form class="form1" id="form1">
        <div class="userName">
            <lable>用户名：</lable>
            <input type="text" name="username" placeholder="请输入用户名"  />
        </div>
        <div class="passWord">
            <lable>密&nbsp;&nbsp;&nbsp;码：</lable>
            <input type="password" name="pwd" placeholder="请输入密码"/>
        </div>
        <div class="tishi" id="tishi"></div>
        <div class="choose_box">
            <div>
                <input type="checkbox" checked="checked" name="checkbox"/>
                <lable>记住密码</lable>
            </div>
            <a href="/integral.php/index/index/forgetpwd">忘记密码</a>
        </div>
        <button class="login_btn" onclick="rep()" type="button">登&nbsp;&nbsp;录</button>
    </form>
    <div class="other_login">
        <div class="other"></div>
        <span>其他方式登录</span>
        <div class="other"></div>
    </div>
    <div class="other_choose">
        <div></div>
        <a href="">
            <img src="/static/integral/img/wx.png" alt=""/>
        </a>
        <div></div>
    </div>
</div>
</body>
</html>