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
<script src="/public/qyh/js/upload_img.js"></script>
    <script src="/public/qyh/js/layer.js"></script>
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">录入债务</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<form action="">
<div class="jui_main jui_pad_16">
      <div class="jui_public_list jui_bor_rad_5 zw_list">
           <div class="jui_fc_lightzs jui_pad_r12">债务类型：</div>
           <div class="jui_fc_lightzs">信用卡账单</div>
      </div>
      <div class="jui_public_list jui_bor_rad_5 zw_list">
           <div class="jui_fc_lightzs jui_pad_r12">债务金额：</div>
           <input class="jui_flex1" type="number" value="" placeholder="请输入债务金额">
      </div>
      <div class="jui_bg_fff jui_flex_col_center jui_pad_20 jui_bor_rad_5">
           <div class="skfs_img" id="up_img">
                <img id="imghead" border="0" src="/public/qyh/icons/add_img2.png" onClick="$('#previewImg').click();">
           </div> 
           <input type="file" onChange="previewImage(this)" style="display:none;" id="previewImg" />
           <div class="jui_h12"></div>
           <p class="jui_fc_lightzs">上传债务凭证</p>
      </div>    
      <div class="jui_public_btn jui_pad_lnone jui_pad_rnone"><input type="button" value="提交审核"></div>
</div>
</form>
<!-- 主体end -->
</body>
<script>
//倒计时  不需要jquery库  
	function settime(num){
		var yzm_input=document.getElementById("jui_form_yzm"); //如果用getElementsByClassName获取类，获取的为数组，下面的yzm_input要改为yzm_input[0]
		var num;
		if( num==0 ){
			yzm_input.value="重新发送";
			yzm_input.removeAttribute("disabled");
			yzm_input.setAttribute("class","jui_fc_zhuse")
			return false; //直到倒计时0时停止执行函数
			}else{
				yzm_input.setAttribute("disabled","disabled");
				yzm_input.setAttribute("class","jui_fc_999")
				yzm_input.value=num+"s后重发";
				num--;
				}
		 //setTimeout(function(){settime(num)},1000);
		 setTimeout("settime("+num+")", 1000); //num为变量，所以要用“+”链接
	}
</script>
</html>
