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
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">升级</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main jui_pad_16">
     <div class="jui_bor_rad_5 jui_bg_fff jui_pad_16">
             <p>原会员等级：普通会员</p>
             <p class="jui_pad_t5">升级为：城市代理</p>
     </div>
     <div class="jui_h16"></div>
     <div class="jui_bor_rad_5 jui_bg_fff jui_pad_16 jui_flex_col_center">
           <ul class="jui_flex_row_center dlsq_tit">
                <li class="jui_flex1 dlsq_tit_hover">微信支付</li>
                <li class="jui_flex1">支付宝</li>
                <li class="jui_flex1">账户余额</li>
           </ul>
           <div class="jui_h30"></div>
           <div class="dlsq_upimg">
                <img id="imghead" border="0" src="/public/qyh/icons/add_img2.png" onClick="$('#previewImg').click();">
           </div> 
           <div class="jui_h12"></div>
           <div>付款金额：<span class="jui_fc_zhuse">0.00</span>元</div>
           <div class="jui_h12"></div>
     </div>
     <div class="jui_h16"></div>
     <div class="jui_text_center">
          <p>请使用另一个手机的--扫码支付</p>
          <p>付款后会自动激活信用卡，请勿重复支付</p>
     </div>
     <div class="jui_public_btn jui_pad_lnone jui_pad_rnone"><input type="button" value="保存二维码"></div>
</div>
<!-- 主体end -->
</body>

<script>
    $(document).ready(function(){
		/*可用多个tab */
        $(".dlsq_tit li").click(function(){
            $(this).siblings().removeClass("dlsq_tit_hover");
            $(this).addClass("dlsq_tit_hover");
        });
		
		
		box_timer("轻松还：暂未开放申请");
		$(document).on("click",".dlsq_tit li",function(){
			box_timer("轻松还：暂未开放申请");
		});	
    });
</script>
</html>
