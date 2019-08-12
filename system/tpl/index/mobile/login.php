<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>轻松还</title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="stylesheet" type="text/css" href="/public/qyh/css/style.css">
<link rel="stylesheet" type="text/css" href="/public/qyh/css/css.css">
<script src="/public/qyh/js/flexible.js"></script>
<script src="/public/qyh/js/jquery-3.3.1.min.js"></script>
<script src="/public/qyh/js/public.js"></script>
    <script src="/public/qyh/js/layer.js"></script>
</head>
<body class="jui_bg_grey">
<!-- 主体 -->
<img class="login_topimg" src="/public/qyh/icons/login_topimg.jpg">
<form class="form1" id="form1" action="">
<div class="login_bar">
    <div class="jui_pad_14 jui_bor_rad_5 login_con">
          <img class="jui_box_shadow jui_bor_rad_50 logo_img" src="/public/qyh/icons/logo.jpg">
          <h1 class="login_tit jui_pad_l12">登录</h1>
          <div class="jui_h12"></div>
           <div class="jui_public_list">
                 <div class="login_icon"><img src="/public/qyh/icons/mobile_png.png"></div>
                 <input name="m_phone" class="phone" id="phone" type="tel" placeholder="请输入手机号">
           </div>
           <div class="jui_public_list">
                 <div class="login_icon"><img src="/public/qyh/icons/mima_icon.png"></div>
                 <input name="m_password" class="pwd" id="pwd" type="password" placeholder="请输入密码">
           </div>
           <a href="index.php/?m=index&c=forgot" class="jui_block jui_fc_zhuse jui_text_right">忘记密码？</a>
           <div class="jui_h30"></div>
           <div class="jui_public_btn login_btn"><input type="button" value="登录" id="ClickLogin"></div>
    </div>
    <div class="jui_h16"></div>
    <a href="index.php/?m=index&c=register" class="jui_block jui_text_center jui_fc_000 jui_fs15 jui_font_weight">注册</a>
    <div class="jui_h30"></div>
    <div class="login_dl_titbar">
         <div class="login_dl_titline"></div>
         <div class="login_dl_tittext jui_fc_999">第三方登录</div>
    </div>
    <div class="jui_h30"></div>
    <div class="jui_flex_row_center jui_flex_justify_center">
         <div class="login_dl_icon"><img src="/public/qyh/icons/qq_icon.png"></div>
         <div class="login_dl_icon"><img src="/public/qyh/icons/wx_icon.png"></div>
         <div class="login_dl_icon"><img src="/public/qyh/icons/wb_icon.png"></div>
    </div>
</div>
</form>
<!-- 主体end -->
</body>
<script type="text/javascript">
    $('#ClickLogin').click(function () {
        var m_phone = $('#phone').val();
        var m_pass = $('#pwd').val();
        $.post("?m=index&c=login",{m_phone:m_phone,m_password:m_pass},function (res) {
           layer.msg(res.msg)
           if (res.code == 200){
              setTimeout(function () {
                  window.location.href = '?m=index&c=index'
              },1000)
            }
        })
    });

</script>
<script>
$(document).ready(function(){
	var con_h = document.body.offsetHeight - $('.login_topimg').outerHeight();
	//console.log(con_h);
	$(".login_bar").css("height",con_h);
	
});

</script>
</html>
