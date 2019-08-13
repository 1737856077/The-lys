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
<!-- 主体 -->
<div class="jui_main">
<!-- 轮播图 -->
<div class="banner_con">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            foreach ($banner as $key=>$val)
            {
                echo "<div class='swiper-slide'>"."<img src='".$val['b_img']."'"."></div>";
            }
            ?>
<!--            <div class="swiper-slide"><img src="/public/qyh/images/banner1.jpg"></div>-->
<!--            <div class="swiper-slide"><img src="/public/qyh/images/banner2.jpg"></div>-->
<!--            <div class="swiper-slide"><img src="/public/qyh/images/banner3.jpg"></div>-->
        </div>
        <div class="swiper-pagination"></div>			
    </div>
</div>
<script src="/public/qyh/js/swiper.min.js"></script>
<script type="text/javascript">
        var mySwiper = new Swiper('.swiper-container', {
            autoplay: 2500,
            pagination: '.swiper-pagination',
            autoplayDisableOnInteraction: false,
            loop: true,
            paginationType: 'bullets',
            paginationClickable: true,
            observer: true,
        })
</script>
<!-- 轮播图end -->
<div class="jui_h12"></div>
<!-- 近期还款 -->
<div class="jui_pad_l12 jui_pad_r12">
     <div class="jui_bg_fff jui_pad_l12 jui_pad_r12 jui_bor_rad_10">
            <div class="jui_public_tit jui_pad_lnone jui_pad_rnone">
                  <span class="sy_tit_icon"></span>
                  <div class="jui_flex1 jui_fs16 jui_pad_l8 jui_fc_000">近期还款</div>
                  <a href="?m=plan&c=wallet" class="jui_flex_no jui_fc_999">更多</a>
            </div>
            <div class="jui_flex_row_center jui_flex_justify_between jui_pad_b12">
                 <div>180****5485</div>
                 <div class="jui_text_center">成功还款<span class="jui_fc_zhuse">10000</span>元</div>
            </div>
     </div>
</div>
<!-- 近期还款end -->
<div class="jui_h12"></div>
<!-- 特色产品 -->
<div class="jui_pad_l12 jui_pad_r12">
     <div class="jui_bg_fff jui_pad_l12 jui_pad_r12 jui_bor_rad_10 jui_clearfix">
            <div class="jui_public_tit jui_pad_lnone jui_pad_rnone">
                  <span class="sy_tit_icon"></span>
                  <div class="jui_flex1 jui_fs16 jui_pad_l8 jui_fc_000"></div>
            </div>
         <?php
         foreach($notice as $key=>$val)
         {
             echo "<div class='jui_flex_row_center sy_tscp_list'>".
                 "<div class='sy_tscp_img'>"."<img src='".$val['n_img']."'>"."</div>".
                 "<div class='jui_flex1'>".
                 "<p class='jui_fs15 jui_fc_000 jui_font_weight'>".$val['n_title']."</p>".
                 "<p class='jui_fs12 jui_pad_t5 jui_fc_999 jui_font_weight'>".$val['n_desc']."</p>".
                 "</div>"."</div>";
         }
         ?>
<!--            <div class="jui_flex_row_center sy_tscp_list">-->
<!--                 <div class="sy_tscp_img"><img src="/public/qyh/images/ts_img01.png"></div>-->
<!--                 <div class="jui_flex1">-->
<!--                      <p class="jui_fs15 jui_fc_000 jui_font_weight">智能还贷</p>-->
<!--                      <p class="jui_fs12 jui_pad_t5 jui_fc_999 jui_font_weight">还房贷 还车贷，3-5个月还清百万债务</p>-->
<!--                 </div>-->
<!--            </div>-->
<!--            <div class="jui_flex_row_center sy_tscp_list">-->
<!--                 <div class="sy_tscp_img"><img src="/public/qyh/images/ts_img02.png"></div>-->
<!--                 <div class="jui_flex1">-->
<!--                      <p class="jui_fs15 jui_fc_000 jui_font_weight">0费率还卡</p>-->
<!--                      <p class="jui_fs12 jui_pad_t5 jui_fc_999 jui_font_weight">随借随还 低门槛，担保金抵扣利息</p>-->
<!--                 </div>-->
<!--            </div>-->
<!--            <div class="jui_flex_row_center sy_tscp_list">-->
<!--                 <div class="sy_tscp_img"><img src="/public/qyh/images/ts_img03.png"></div>-->
<!--                 <div class="jui_flex1">-->
<!--                      <p class="jui_fs15 jui_fc_000 jui_font_weight">帮还赚利息</p>-->
<!--                      <p class="jui_fs12 jui_pad_t5 jui_fc_999 jui_font_weight">担保抵押 平台担保，帮助他人还卡赚利息，轻松摆脱债务</p>-->
<!--                 </div>-->
<!--            </div>-->
<!--            <div class="jui_flex_row_center sy_tscp_list">-->
<!--                 <div class="sy_tscp_img"><img src="/public/qyh/images/ts_img04.png"></div>-->
<!--                 <div class="jui_flex1">-->
<!--                      <p class="jui_fs15 jui_fc_000 jui_font_weight">申请代理</p>-->
<!--                      <p class="jui_fs12 jui_pad_t5 jui_fc_999 jui_font_weight">无忧裂变计划，长期稳定高收入</p>-->
<!--                 </div>-->
<!--            </div>-->
<!--            <div class="jui_flex_row_center sy_tscp_list">-->
<!--                 <div class="sy_tscp_img"><img src="/public/qyh/images/ts_img05.png"></div>-->
<!--                 <div class="jui_flex1">-->
<!--                      <p class="jui_fs15 jui_fc_000 jui_font_weight">TOKEN激励</p>-->
<!--                      <p class="jui_fs12 jui_pad_t5 jui_fc_999 jui_font_weight">数字资产升值，参与众筹多少，平台送多少数字资产 </p>-->
<!--                 </div>-->
<!--            </div>-->
     </div>
</div>
<!-- 特色产品end -->
<div class="jui_h12"></div>
<!-- 学院 -->
<div class="jui_pad_l12 jui_pad_r12 jui_bor_rad_5">
     <div class="jui_bg_fff jui_pad_l12 jui_pad_r12 jui_bor_rad_10">
            <div class="jui_public_tit jui_pad_lnone jui_pad_rnone jui_flex_justify_between">
                  <div class="jui_flex_row_center">
                      <span class="sy_tit_icon"></span>
                      <div class="jui_fs16 jui_pad_l8 jui_fc_000">轻松还学院</div>
                  </div>
                  <div class="jui_fs12 sy_xy_tit">
                       <span class="jui_pad_l20 jui_fc_zhuse">推荐</span>
                       <span class="jui_pad_l20">最新</span>
                       <span class="jui_pad_l20">最热</span>
                  </div>
            </div>
            <div class="jui_flex jui_flex_wrap sy_qhxy_bar">
                <?php
               foreach ($news as $key=>$val){
                   echo "<a href='#' class='sy_qhxy_list jui_grid_w50'>".
                       "<div class='jui_bor_rad_5 sy_qhxy_listcon'>".
                       "<div class='sy_qhxy_img'>"."<img src='".$val['n_img']."'"."></div>".
                       "<div class='sy_qhxy_text jui_ellipsis_1'>".$val['n_title']."</div>".
                       "</div>"."</a>";
               }
                ?>
<!--                 <a href="news_con.html" class="sy_qhxy_list jui_grid_w50">-->
<!--                       <div class="jui_bor_rad_5 sy_qhxy_listcon">-->
<!--                             <div class="sy_qhxy_img"><img src="/public/qyh/images/img01.jpg" alt=""></div>-->
<!--                             <div class="sy_qhxy_text jui_ellipsis_1">0费率还款技巧</div>-->
<!--                       </div>-->
<!--                 </a>-->
<!--                 <a href="news_con.html" class="sy_qhxy_list jui_grid_w50">-->
<!--                       <div class="jui_bor_rad_5 sy_qhxy_listcon">-->
<!--                             <div class="sy_qhxy_img"><img src="/public/qyh/images/img02.jpg" alt=""></div>-->
<!--                             <div class="sy_qhxy_text jui_ellipsis_1">担保金如何获取？</div>-->
<!--                       </div>-->
<!--                 </a>-->
<!--                 <a href="news_con.html" class="sy_qhxy_list jui_grid_w50">-->
<!--                       <div class="jui_bor_rad_5 sy_qhxy_listcon">-->
<!--                             <div class="sy_qhxy_img"><img src="/public/qyh/images/img03.jpg" alt=""></div>-->
<!--                             <div class="sy_qhxy_text jui_ellipsis_1">如何帮他人还款赚利息</div>-->
<!--                       </div>-->
<!--                 </a>-->
<!--                 <a href="news_con.html" class="sy_qhxy_list jui_grid_w50">-->
<!--                       <div class="jui_bor_rad_5 sy_qhxy_listcon">-->
<!--                             <div class="sy_qhxy_img"><img src="/public/qyh/images/img04.jpg" alt=""></div>-->
<!--                             <div class="sy_qhxy_text jui_ellipsis_1">借款人不还钱怎么办？</div>-->
<!--                       </div>-->
<!--                 </a>-->
            </div>
     </div>
</div>
<!-- 学院end -->
<div class="jui_h12"></div>
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
</body>
<script type="text/javascript">
$(function() {
      //控制图片尺寸
	  $('.sy_qhxy_img').height($('.sy_qhxy_img').width()*223/314);
	  
	  
	/*可用多个tab */
	$(".sy_xy_tit span").click(function(){
		$(this).siblings().removeClass("jui_fc_zhuse");
		$(this).addClass("jui_fc_zhuse");
	});	

	  
})
</script>
</html>
