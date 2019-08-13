<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>轻松还</title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="stylesheet" type="text/css" href="/public/qyh/css/style.css">
<link rel="stylesheet" type="text/css" href="/public/qyh/css/swiper.min.css">
<link rel="stylesheet" type="text/css" href="/public/qyh/css/css.css">
<script src="/public/qyh/js/flexible.js"></script>
<script src="/public/qyh/js/jquery-3.3.1.min.js"></script>
<script src="/public/qyh/js/public.js"></script>
<script src="/public/qyh/js/upload_img.js"></script>
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">收款方式</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main jui_pad_l16 jui_pad_r16">
      <div class="jui_h16"></div>
      <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
           <div class="jui_pad_r12">收款渠道</div>
           <div>微信或支付宝</div>
      </div>
      <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
           <div class="jui_pad_r12">收款账号</div>
           <input class="jui_flex1" type="text" value="" placeholder="请输入微信或支付宝收款账号">
      </div>
      <div class="jui_bg_fff jui_flex_col_center jui_pad_20 jui_bor_rad_5">
           <div class="skfs_img" id="up_img">
                <img id="imghead" border="0" src="/public/qyh/icons/add_img2.png" onClick="$('#previewImg').click();">
           </div> 
           <input type="file" onChange="previewImage(this)" style="display:none;" id="previewImg" />
           <div class="jui_h12"></div>
           <p>点击上传收款二维码</p>
      </div>
      <div class="jui_h16"></div>
      <div class="jui_public_list jui_flex_justify_between jui_bor_rad_5 skfs_inpubar jui_mar_bnone">
           <div class="jui_flex_row_center">
               <p class="jui_pad_r8 jui_flex_no">验证码</p>
               <input style="width:3rem;" type="tel" placeholder="请输入验证码">
           </div>
           <input id="jui_form_yzm" class="jui_fc_zhuse" type="button" value="获取验证码" onclick="settime(60);">
      </div>     
      <div class="jui_public_btn jui_pad_lnone jui_pad_rnone"><input type="button" value="提交审核"></div> 
</div>
<!-- 主体end -->
<input type="hidden" id="uid" value="<?php echo $_SESSION['uid']?>">
<input type="hidden" id="token" value="<?php echo $_SESSION['token']?>">
<script>
    var   uid = $("#uid").val();
    var   token= $("#token").val();
    $.post('index.php?m=index&c=get_info',{uid:uid,token:token},function (res) {
        data = JSON.parse(res);
        if (data.code==200){
            $("#tx").attr('src', data.user.m_avatar)
            $("#name").html('src', data.user.m_name)
        }else {
            // layer.msg(data.msg)
            window.location.href="?m=index&c=login";
        }
    })
</script>
</body>

<script>
//倒计时  不需要jquery库  
	function settime(num){
		var yzm_input=document.getElementById("jui_form_yzm"); 
		var num;
		if( num==0 ){
			yzm_input.value="重新发送";
			yzm_input.removeAttribute("disabled");
			yzm_input.setAttribute("class","jui_fc_zhuse")
			return false; //直到倒计时0时停止执行函数
			}else{
				yzm_input.setAttribute("disabled","disabled");
				yzm_input.setAttribute("class","jui_fc_ddd")
				yzm_input.value=num+"s后重发";
				num--;
				}
		 //setTimeout(function(){settime(num)},1000);
		 setTimeout("settime("+num+")", 1000); //num为变量，所以要用“+”链接
	}
	
</script>
</html>
