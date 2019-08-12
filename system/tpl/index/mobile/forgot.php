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
     <a class="jui_top_left" href="index.php/?m=index&c=login"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">忘记密码</div>
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
                 <input class="jui_flex1 reg_input" id="phone" name="phone"  type="tel" placeholder="请填写手机号">
           </div>
           <div class="jui_public_list jui_bor_rad_5 jui_flex_justify_between">
                 <div class="jui_flex_row_center">
                     <div class="reg_icon"><img src="/public/qyh/icons/yzm_icon.png"></div>
                     <input name="validate" id="ValiData" class="reg_input" style="width:3rem;" type="tel" placeholder="请输入验证码">
                 </div>
                 <input id="jui_form_yzm" class="reg_yzm" type="button"   value="发送验证码"">
           </div>
           <div class="jui_public_list jui_bor_rad_5">
                 <div class="reg_icon"><img src="/public/qyh/icons/mm_icon2.png"></div>
                 <input class="jui_flex1 reg_input" name="pwd" id="pwd" type="password" placeholder="请输入新密码">
           </div>
           <div class="jui_public_list jui_bor_rad_5">
                 <div class="reg_icon"><img src="/public/qyh/icons/mm_icon2.png"></div>
                 <input class="jui_flex1 reg_input" name="pwdd" id="pwdd" type="password" placeholder="请确认新密码">
           </div>
           <div class="jui_public_btn reg_btn"><input type="button" onclick="Forgot()"  value="重置密码"></div>
</div>
</form>
<!-- 主体end -->














</body>
<script>
    function Forgot() {
        var pwd1 = $("#pwd").val();
        var pwd2 = $("#pwdd").val();
        var m_phone = $('#phone').val();
        var code = $("#ValiData").val();
        $.post("index.php?m=index&c=forget_pwd",{m_phone:m_phone,forget_code:code,new_pass1:pwd1,new_pass2:pwd2},function (res) {
            layer.msg(res.msg())
            if (res.code == 200){
                setTimeout(function () {
                    window.location.href = '?m=index&c=login'
                },1000)
            }
        })
    }
</script>
<script>
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
        $.post("index.php?m=index&c=forget_smscode",{m_phone:m_phone},function (res) {
            layer.msg(res.msg())
            if (res.code == 200){
                setTimeout(function () {
                    window.location.href = '?m=index&c=index'
                },1000)
            }
        })
    })
</script>

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
</script>
</html>
