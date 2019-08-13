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
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">
     <div class="jui_top_left"></div>
     <div class="jui_top_middle">钱包</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main">
     <div class="jui_bg_zsjb wallet_top_bar"></div>
     <div class="wallet_bar">
              <div class="wallet_list jui_bor_rad_5">
                   <div class="jui_public_tit jui_pad_l8 jui_pad_r8 jui_bor_bottom jui_flex_justify_between">
                        <div class="jui_flex_row_center">
                             <img class="wallet_icon" src="/public/qyh/icons/wallet_icon.png">
                             <p class="wallet_tit">佣金账户</p>
                        </div>
                        <a href="wallet_mx2.html" class="jui_fs15 jui_fc_zhuse">明细&gt;&gt;</a>
                   </div>
                   <div class="jui_pad_12">
                           <div class="jui_fs30 jui_fc_000"><span class="jui_fs12">￥</span>0.0000</div>
                           <div class="jui_pad_t8">冻结：<span class="jui_fc_777">￥0.0000</span></div>
                           <div class="jui_flex_row_center jui_pad_t8 jui_flex_justify_between">
                                 <div>可用：<span class="jui_fc_777">￥0.0000</span></div>
                                 <div class="jui_bor_rad_5 wallet_tx_btn tishi">提现</div>
                           </div>           
                   </div>
              </div>
              <div class="wallet_list jui_bor_rad_5">
                   <div class="jui_public_tit jui_pad_l8 jui_pad_r8 jui_bor_bottom jui_flex_justify_between">
                        <div class="jui_flex_row_center">
                             <img class="wallet_icon" src="/public/qyh/icons/wallet_icon.png">
                             <p class="wallet_tit">保证金账户</p>
                        </div>
                        <a href="wallet_mx2.html" class="jui_fs15 jui_fc_zhuse">明细&gt;&gt;</a>
                   </div>
                   <div class="jui_pad_12">
                           <div class="jui_fs30 jui_fc_000"><span class="jui_fs12">￥</span>0.0000</div>
                           <div class="jui_flex_row_center jui_pad_t8 jui_flex_justify_between">
                                 <div>可用：<span class="jui_fc_777">￥0.0000</span></div>
                                 <div class="jui_bor_rad_5 wallet_tx_btn tishi">提现</div>
                           </div>           
                   </div>
              </div>
              <div class="wallet_list jui_bor_rad_5">
                   <div class="jui_public_tit jui_pad_l8 jui_pad_r8 jui_bor_bottom jui_flex_justify_between">
                        <div class="jui_flex_row_center">
                             <img class="wallet_icon" src="/public/qyh/icons/wallet_icon.png">
                             <p class="wallet_tit">日返账户</p>
                        </div>
                   </div>
                   <div class="jui_pad_12">
                           <div class="jui_fs30 jui_fc_000"><span class="jui_fs12">￥</span>0.0000</div>
                           <div class="jui_flex_row_center jui_pad_t8 jui_flex_justify_between">
                                 <div>预计今日返还：<span class="jui_fc_777">￥0.0000</span></div>
                           </div>           
                   </div>
              </div>
              <div class="wallet_list jui_bor_rad_5">
                   <div class="jui_public_tit jui_pad_l8 jui_pad_r8 jui_bor_bottom jui_flex_justify_between">
                        <div class="jui_flex_row_center">
                             <img class="wallet_icon" src="/public/qyh/icons/wallet_icon.png">
                             <p class="wallet_tit">数字资产QSHC</p>
                        </div>
                        <a href="wallet_mx.html" class="jui_fs15 jui_fc_zhuse">明细&gt;&gt;</a>
                   </div>
                   <div class="jui_pad_12">
                           <div class="jui_fs30 jui_fc_000">45899</div>
                           <div class="jui_flex_row_center jui_pad_t8 jui_flex_justify_between">
                                 <div class="jui_fc_999">≈44555CNY</div>
                                 <a href="wallet_tx.html" class="jui_bor_rad_5 wallet_tx_btn">提现</a>
                           </div>           
                   </div>
              </div>
     </div>
</div>
<!-- 主体end -->
<!-- 固定底部 -->
<div class="jui_footer">
    <a href="?m=index&c=index" class="jui_foot_list jui_hover">
        <b class="foot_index"></b>
        <p>首页</p>
    </a>
    <a href="?m=plan&c=plan_index" class="jui_foot_list">
        <b class="foot_plan"></b>
        <p>计划</p>
    </a>
    <a href="?m=plan&c=wallet" class="jui_foot_list">
        <b class="foot_team"></b>
        <p>钱包</p>
    </a>
    <a href="?m=user&c=user" class="jui_foot_list">
        <b class="foot_my"></b>
        <p>我的</p>
    </a>
</div>
<!-- 固定底部end -->
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
$(function() {
	$(document).on("click",".tishi",function(){
		box_timer("轻松还正在努力开发中...");
	});
});
</script>
</html>
