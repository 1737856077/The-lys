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
     <div class="jui_top_middle">计划</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main">
     <div class="jui_bg_zsjb plan_top_bar"></div>
     <div class="jui_pad_l12 jui_pad_r12 plan_bar">
           <ul class="jui_box_shadow jui_bor_rad_5 jui_flex_row_center jui_flex plan_tit">
                 <li class="jui_grid_w50 plan_tit_hover">众筹计划<span></span></li>
                 <li class="jui_grid_w50">还款计划<span></span></li>
           </ul>
           <div class="plan_con">
                <div class="jui_h12"></div>
                <div class="jui_bg_fff jui_box_shadow jui_bor_rad_5"> 
                      <div class="jui_flex_row_center jui_pad_8">
                          <a href="?m=plan&c=debt" class="plan_zcjh_list jui_grid_w25">
                                <div class="jui_bg_ztqian jui_grid_list plan_jbbg1">
                                     <p id="qz"></p>
                                     <p class="jui_fs12 jui_pad_t5">信用卡</p>
                                </div>
                          </a>
                          <a href="?m=plan&c=debt" class="plan_zcjh_list jui_grid_w25">
                                <div class="jui_bg_ztqian jui_grid_list plan_jbbg2">
                                     <p id="qz1"></p>
                                     <p class="jui_fs12 jui_pad_t5">房贷（审核中）</p>
                                </div>
                          </a>
                           <a href="?m=plan&c=debt" class="plan_zcjh_list jui_grid_w25">
                                <div class="jui_bg_ztqian jui_grid_list plan_jbbg3">
                                    <p id="qz2"></p>
                                     <img class="plan_zcjh_icon" src="/public/qyh/icons/jia.png">
                                     <p class="jui_fs12 jui_pad_t5">车贷</p>
                                </div>
                           </a>
                           <a href="?m=plan&c=debt" class="plan_zcjh_list jui_grid_w25">
                                <div class="jui_bg_ztqian jui_grid_list plan_jbbg4">
                                    <p id="qz3"></p>
                                     <img class="plan_zcjh_icon" src="/public/qyh/icons/jia.png">
                                     <p class="jui_fs12 jui_pad_t5">其他</p>
                                </div>
                           </a>
                       </div>
                       <div class="jui_public_list jui_flex_justify_between jui_bor_top">
                            <p class="jui_fs15">可还款总额：<span id="hk">**</span></p>
                            <div class="plan_jh_btn jui_bor_rad_5" id="jihuo">激活</div>
                       </div>
                </div>  
                <div class="jui_h12"></div>  
                <div class="jui_bg_fff jui_box_shadow jui_bor_rad_5"> 
                     <div class="jui_public_tit jui_bor_bottom">
                          <span class="sy_tit_icon"></span>
                          <div class="jui_flex1 jui_fs16 jui_pad_l8 jui_fc_000">还款计划</div>
                     </div>
                     <div class="plan_jd_con">                     
                             <div class="jui_flex_row_center jui_public_list">
                                  <div class="jui_fc_666 jui_pad_r12">第一阶段</div>
                                  <div class="jui_flex1 jui_progress_bar"><span id="jd0" style="width:100%"></span></div>
                                  <div class="plan_hkjh_mony jui_fc_zhuse jui_mar_l16">600.0/600.0</div>
                            </div>
                             <div class="jui_flex_row_center jui_public_list">
                                  <div class="jui_fc_666 jui_pad_r12">第二阶段</div>
                                  <div class="jui_flex1 jui_progress_bar"><span id="1" style="width:20%"></span></div>
                                  <div class="plan_hkjh_mony jui_fc_zhuse jui_mar_l16">
                                       <a href="sk_list.html" class="plan_btn">去确认</a>
                                  </div>
                            </div>
                             <div class="jui_flex_row_center jui_public_list">
                                  <div class="jui_fc_666 jui_pad_r12">第三阶段</div>
                                  <div class="jui_flex1 jui_progress_bar"><span id="jd2" style="width:0%"></span></div>
                                  <div class="plan_hkjh_mony jui_fc_000 jui_mar_l16">0.0/5400.0</div>
                            </div>
                             <div class="jui_flex_row_center jui_public_list">
                                  <div class="jui_fc_666 jui_pad_r12">第四阶段</div>
                                  <div class="jui_flex1 jui_progress_bar"><span id="jd3" style="width:0%"></span></div>
                                  <div class="plan_hkjh_mony jui_fc_000 jui_mar_l16">0.0/16200.0</div>
                            </div>
                             <div class="jui_flex_row_center jui_public_list">
                                  <div class="jui_fc_666 jui_pad_r12">第五阶段</div>
                                  <div class="jui_flex1 jui_progress_bar"><span id="jd4" style="width:0%"></span></div>
                                  <div class="plan_hkjh_mony jui_fc_000 jui_mar_l16">0.0/17400.0</div>
                            </div>

                     </div>
                </div>            
           </div>
           <div class="plan_con jui_none">
                <!-- 没有数据 -->
                <div class="jui_none_bar" style="padding-top:3.5rem;">
                      <img src="/public/qyh/icons/none_icon.png" alt="">
                      <p>暂无数据</p>
                </div>
                <!-- 没有数据end -->
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
<!-- 提示 -->
<div class="jui_box_bar jui_none">
     <div class="jui_box_conbar">
           <div class="jui_box_con jui_bg_ztqian">
               <div class="jui_h20"></div>
               <div class="jui_box_pub_middle jui_fc_000" id="tip_des">是否要确认激活债务？</div>
                 <div class="jui_h20"></div>
                 <div class="jui_box_btnbar jui_flex_row_center jui_flex_justify_center">
                       <div class="jui_box_btn jui_bor_rad_5" id="close">取消</div>
                       <a href="jihuo_list.html" class="jui_box_btn jui_bor_rad_5 jui_bg_zhuse jui_fc_fff">激活</a>
                 </div>
                 <div class="jui_h20"></div>
           </div>
     </div>
</div>
<input type="hidden" id="uid" name="uid" value="<?php echo $_SESSION['uid']?>">
<input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']?>">
<!-- 提示end -->
</body>
<script>
    var   uid = $("#uid").val();
    var   token= $("#token").val();
    $.post("?m=plan&c=plan_index1",{uid:uid,token:token},function (res) {
        data = JSON.parse(res);
        // console.log(data.plan_3)
       if (data.plan_1!=0){
           $("#qz").html(data.plan_1)
       }
        if (data.plan_2!=0){
            $("#qz1").html(data.plan_2)
        }
        if (data.plan_3!=0){
            $("#qz2").html(data.plan_3)
        }
        if (data.plan_4!=0){
            $("#qz3").html(data.plan_4)
        }
        $("#hk").html(data.cash_price)
    })
    $.post("?m=plan&c=crowd_funding",{uid:uid,token:token},function (res) {
        data = JSON.parse(res);
        // jindu = data.alr_arr[i]/data.stage_arr[i];
        var alr_arr_length = data.stage_arr.length;
        for (var i = 0; i < alr_arr_length;i++){

            var html+=`
             <div class="jui_flex_row_center jui_public_list">
                <div class="jui_fc_666 jui_pad_r12">第`{i+1}`阶段</div>
                <div class="jui_flex1 jui_progress_bar"><span id="jd2" style="width:0%"></span></div>
            <div class="plan_hkjh_mony jui_fc_000 jui_mar_l16"><p></p>/<p>`data.stage_arr[i]`</p></div>
                </div>
            `;



        }
    })
    //验证登录信息
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
<script type="text/javascript">
$(function() {
     /*可用多个tab */
        $(".plan_tit li").click(function(){
            $(this).siblings().removeClass("plan_tit_hover");
            $(this).addClass("plan_tit_hover");
            hIndex=$(this).index();
			hparent=$(this).parents(".plan_bar");
			hparent.children(".plan_con").addClass("jui_none");
            hparent.children(".plan_con").eq(hIndex).removeClass("jui_none");
        });	
		
		
	 /*弹框显示与隐藏*/	
	 $("#jihuo").on('click', function() {
		 $(".jui_box_bar").removeClass("jui_none");
     })
	 $("#close").on('click', function() {
		 $(".jui_box_bar").addClass("jui_none");
	  })
	 
	 
});
</script>
</html>
