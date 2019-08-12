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
<body class="jui_bg_zhuse">
<!-- 头部 -->
<div class="jui_top_bar jui_bg_none">
     <a class="jui_top_left" href="?m=index&c=login"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">注册</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<form action="">
<div class="jui_main reg_con">
           <div class="jui_public_list jui_bor_rad_5">
                 <div class="reg_xz jui_flex_row_center jui_flex_justify_between" style="padding-right:2px;">
                     <p class="jui_fc_zhuse jui_fs12 jui_flex_no">+86</p>
                     <!--<img class="reg_arrow" src="icons/xia_arrow.png">-->
                 </div>                  
                 <input name="phone" id="phone" class="jui_flex1 reg_input" type="tel" placeholder="请填写手机号">
           </div>
           <div class="jui_public_list jui_bor_rad_5">
                 <div class="reg_icon"><img src="/public/qyh/icons/mm_icon2.png"></div>
                 <input name="pwd" id="pwd" class="jui_flex1 reg_input" type="password" placeholder="请填密码">
           </div>
           <div class="jui_public_list jui_bor_rad_5">
                 <div class="reg_icon"><img src="/public/qyh/icons/mm_icon2.png"></div>
                 <input name="pwd2" id="pwd2" class="jui_flex1 reg_input" type="password" placeholder="再次填写密码">
           </div>
           <div class="jui_public_list jui_bor_rad_5 jui_flex_justify_between">
                 <div class="jui_flex_row_center">
                     <div class="reg_icon"><img src="/public/qyh/icons/yzm_icon.png"></div>
                     <input name="Code" id="Code" class="reg_input" style="width:3rem;" type="tel" placeholder="请输入验证码">
                 </div>
                 <input name="Validate" id="jui_form_yzm" class="reg_yzm" type="button" value="发送验证码" ">
           </div>
    <div class="jui_public_list jui_bor_rad_5">
        <div class="reg_icon"><img src="/public/qyh/icons/mm_icon2.png"></div>
        <input name="invite" id="invite" class="jui_flex1 reg_input" type="password" placeholder="请输入邀请码">
    </div>
           <div class="jui_flex_row_center">
                <input class="jui_form_check" checked="checked" type="checkbox">
                <div class="jui_fc_fff jui_pad_l8 jui_fs12 jui_text_underline">同意<a href="xiyi.html" class="jui_fc_fff">轻松还相关服务协议</a></div>
           </div>
           <div class="jui_h16"></div>
           <div class="jui_public_btn reg_btn"><input id="Register" type="button" value="注册"></div>
</div>
</form>
<!-- 主体end -->
</body>
<scrript>
</scrript>

<script>
//倒计时  不需要jquery库  
	function settime(num){
		var yzm_input=document.getElementById("jui_form_yzm"); //如果用getElementsByClassName获取类，获取的为数组，下面的yzm_input要改为yzm_input[0]
		var num;
		if( num==0 ){
			yzm_input.value="重新发送";
			yzm_input.removeAttribute("disabled");
			yzm_input.setAttribute("class","reg_yzm")
			return false; //直到倒计时0时停止执行函数
			}else{
				yzm_input.setAttribute("disabled","disabled");
				yzm_input.setAttribute("class","reg_yzm jui_fc_ddd")
				yzm_input.value=num+"s后重发";
				num--;
				}
		 //setTimeout(function(){settime(num)},1000);
		 setTimeout("settime("+num+")", 1000); //num为变量，所以要用“+”链接
	}
$("#jui_form_yzm").click(function () {
    var m_phone = $('#phone').val();
    if(m_phone.length==0){
        layer.msg('请输入手机号');
        return;
    }
    if(!(/^1[3456789]\d{9}$/.test(m_phone))){
        layer.msg('请输入正确的手机号')
        return;
    }
    settime(60);
    $.post("?m=index&c=reg_smscode",{m_phone:m_phone},function (res) {
        layer.msg(res.msg)
    })
})
</script>
<script>
    $("#Register").click(function () {
        var phone = $("#phone").val();
        var code = $("#Code").val();
        var pwd = $("#pwd").val();
        var pwd2 = $("#pwd2").val();
        var invite = $("#invite").val();
        if (phone.length==0){
            layer.msg('手机号为空')
            return;
        }
        if(!(/^1(3|4|5|6|7|8|9)\d{9}$/.test(phone))) {
            layer.msg('请输入正确的手机号')
            return false;
        }
        if (pwd == pwd2){}else {
            layer.msg('两次密码不一致');
            return false;
        }
        if (code.length==0){
            layer.msg('验证码为空')
            return;
        }
        if (invite.length==0){
            layer.msg('邀请码为空')
            return;
        }
        $.post("?m=index&c=register",{invite_code:invite,m_phone:phone,reg_code:code,m_password:pwd},
            function (data) {
                layer.msg(data.msg())
                if (data.code == 200){
                    setTimeout(function () {
                        window.location.href = 'index.php?m=index&c=index'
                    },1000)
                }
            })
    })

</script>
</html>
