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
<script src="/public/qyh/js/shiming_upimg.js"></script>
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">实名认证</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main">
      <div class="jui_pad_l16 jui_pad_r16">
          <div class="jui_h16"></div>
          <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
               <div class="jui_pad_r12">姓&nbsp;&nbsp;&nbsp;名</div>
               <input class="jui_flex1" type="text" value="" placeholder="请输入您的真实姓名">
          </div>
          <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
               <div class="jui_pad_r12">身份证</div>
               <input class="jui_flex1" type="text" value="" placeholder="请输入您的身份证号">
          </div>
      </div>
        <!-- 证件上传 -->
        <div class="jui_flex_col_center jui_pad_b20 jui_bg_fff">
           <div class="jui_public_tit jui_flex_justify_center">
                   <img src="/public/qyh/icons/tit_left.png" style="height:8px;">
                   <p class="jui_fs14 jui_fc_lightzs jui_pad_l12 jui_pad_r12">拍摄并上传您的证件照片</p>
                   <img src="/public/qyh/icons/tit_right.png" style="height:8px;">
           </div>
           <div class="jui_h12"></div>
           <div class="smrz_bar jui_flex jui_flex_justify_between">
                 <div class="smrz_img_bar jui_flex_col">
                         <div id="jui_preview">
                            <img id="imghead" border="0" src="/public/qyh/icons/smrz_img01.png" onClick="$('#previewImg').click();">
                         </div>
                         <div class="smrz_img_input">
                              <p class="jui_fc_fff">上传身份证正面</p>
                              <input type="file" onChange="previewImage(this)" id="previewImg" />
                         </div>
                  </div>
                   <div class="smrz_img_bar jui_flex_col">
                         <div id="jui_preview2">
                            <img id="imghead2" border="0" src="/public/qyh/icons/smrz_img02.png" onClick="$('#previewImg2').click();">
                         </div>
                         <div class="smrz_img_input">
                              <p class="jui_fc_fff">上传身份证反面</p>
                              <input type="file" onChange="previewImage2(this)" style="display:none;" id="previewImg2" />
                         </div>
                   </div>
           </div>
        </div>
        <!-- 证件上传end -->  
        <div class="jui_h12"></div>    
      <div class="jui_public_btn"><input type="button" value="提交审核"></div>
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

</script>
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
