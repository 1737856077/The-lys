<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"C:\Users\Administrator\Desktop\suyuan\sy/integral/index\view\index.register.html";i:1555643949;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="viewport" content="height=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <title></title>
    <link rel="stylesheet" href="/static/integral/css/register.css"/>
    <script type="text/javascript" src="/static/integral/js/jquery.js"></script>
    <script type="text/javascript" src="/static/integral/js/jquery-1.7.2.min.js"></script>
</head>
<body>
<div class="register">
    <div class="regTop" style="background: #4a4d54">
        <span>用户注册</span>
        <a class="back" style='text-decoration:none;' href="javascript:history.go(-1)">&lt;&nbsp;返回</a>
    </div>
    <div class="content">
        <div class="point">
            <span>注册成功后，手机号也可为登录账号。</span>
        </div>
        <form class="form1" id="form1" >
            <div class="message">
                <input type="text" name="username" placeholder="请输入用户名" required/>
                <input type="tel" class="moblie" id="moblie" name="moblie" placeholder="输入手机号" onmouseleave="rep()" pattern="[0-9]{11}" required/>
                <input type="password" name="pwd" placeholder="请输入6-25位密码" pattern="[0-9A-Za-z]{6,25}" required/>
                <input type="password" placeholder="请再次输入密码" pattern="[0-9A-Za-z]{6,25}" required/>
                <input type="text" placeholder="输入验证码" required/>
                <a class="code" style="margin-top: 4.2rem;color: #4a4d54;text-decoration:none;" href="" required>获取验证码</a>
            </div>

            <div class="agree">
               <!--<input type="checkbox"/><span>&nbsp;同意&nbsp;</span><a href="">《注册协议》</a>&ndash;&gt;-->
                <p class="tishi" id="tishi"></p>
            </div>
            <input class="submit" style="background: #4a4d54" onclick="tishi()" value="提交" type="button">
        </form>
        <script>
            function tishi() {
                $.ajax({
                    //几个参数需要注意一下
                    type: "POST",//方法类型
                    dataType: "json",//预期服务器返回的数据类型
                    url: "<?php echo url('register/register'); ?>" ,//url
                    data: $('#form1').serialize(),
                    success: function (result){
                        switch (result['code']) {
                            case 1:
                                $("#tishi").html(result['msg'])
                                break;
                            case 2:
                                $("#tishi").html(result['msg'])
                                break;
                            case 3:
                                $("#tishi").html(result['msg'])
                                break;
                            case 4:
                                $("#tishi").html(result['msg'])
                                break;
                            default:
                                window.location.href="/integral.php/index/index/index";
                        }
                    }
                });
            }
            function rep() {
                $.ajax({
                    //几个参数需要注意一下
                    type: "POST",//方法类型
                    dataType: "json",//预期服务器返回的数据类型
                    url: "<?php echo url('register/rep'); ?>" ,//url
                    data: $('#moblie').serialize(),
                    success: function (result){
                        $("#tishi").html(result)
                    }
                });
            }
        </script>
    </div>
</div>
</body>
</html>