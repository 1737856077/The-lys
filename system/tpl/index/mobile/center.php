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
    <script src="/public/qyh/js/layer.js"></script>
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">

     <div class="jui_top_left"></div>
     <div class="jui_top_middle">我的</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main">
    <!-- 头像 -->
    <div class="my_top_con jui_flex_col_center">
          <div class="my_tx jui_bor_rad_50"><img id="tx" class="tx" src="/public/qyh/icons/tx.jpg"></div>
          <p id="name" class="jui_fc_fff jui_fs18 jui_pad_5"></p>
          <a href="?m=user&c=daili" class="jui_flex_row_center jui_flex_justify_center my_dl_btn">
              <img  src="/public/qyh/icons/dl_icon.png">
              <p>申请代理</p>
          </a>
          <div class="jui_h16"></div>
          <div class="jui_flex_row_center jui_w100">
               <div class="jui_grid_w50 jui_flex_col_center jui_bor_right tishi">
                    <img class="my_icon" src="/public/qyh/icons/my_kicon1.png">
                    <p class="jui_fs15 jui_fc_fff">我的信用卡</p>
               </div>
               <div class="jui_grid_w50 jui_flex_col_center tishi">
                    <img class="my_icon" src="/public/qyh/icons/my_kicon1.png">
                    <p class="jui_fs15 jui_fc_fff">我的储蓄卡</p>
               </div>
          </div>
    </div>
    <!-- 头像end -->
    <div class="jui_bg_fff">     
         <a href="?m=user&c=shiming" class="jui_public_list">
               <img class="my_icon" src="/public/qyh/icons/my_icon01.png">
               <p class="jui_fc_000 jui_fs15 jui_flex1">实名认证</p>
               <div class="jui_fc_999 jui_fs12 jui_pad_r8 jui_flex_no">

                   未认证</div>
               <img class="jui_arrow_rimg" src="/public/qyh/icons/jt_right.png">
         </a>
         <a href="?m=user&c=skfs" class="jui_public_list">
               <img class="my_icon" src="/public/qyh/icons/my_icon02.png">
               <p class="jui_fc_000 jui_fs15 jui_flex1">收款方式</p>
               <img class="jui_arrow_rimg" src="/public/qyh/icons/jt_right.png">
         </a>
     </div>
     <div class="jui_h12"></div>
    <div class="jui_bg_fff">
         <a href="?m=user&c=yqm" class="jui_public_list">
               <img class="my_icon" src="/public/qyh/icons/my_icon03.png">
               <p class="jui_fc_000 jui_fs15 jui_flex1">邀请好友</p>
               <img class="jui_arrow_rimg" src="/public/qyh/icons/jt_right.png">
         </a>
         <a href="#" onclick="cache()" class="jui_public_list">
               <img class="my_icon" src="/public/qyh/icons/my_icon04.png">
               <p class="jui_fc_000 jui_fs15 jui_flex1">清除缓存</p>
               <img class="jui_arrow_rimg" src="/public/qyh/icons/jt_right.png">
         </a>
         <a href="?m=user&c=contact" class="jui_public_list">
               <img class="my_icon" src="/public/qyh/icons/my_icon05.png">
               <p class="jui_fc_000 jui_fs15 jui_flex1">联系我们</p>
               <img class="jui_arrow_rimg" src="/public/qyh/icons/jt_right.png">
         </a>
     </div>
     <div class="jui_h12"></div>
     <div id="tuichu" class="jui_bg_fff jui_public_list jui_flex_justify_center jui_fc_zhuse jui_fs15">退出登录</div>
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
               <div class="jui_box_pub_middle jui_fc_000" id="tip_des">确定要退出吗？</div>
                 <div class="jui_h20"></div>
                 <div class="jui_box_btnbar jui_flex_row_center jui_flex_justify_center">
                       <div class="jui_box_btn jui_bor_rad_5" id="close">取消</div>
                       <div class="jui_box_btn jui_bor_rad_5 jui_bg_zhuse jui_fc_fff" onclick="close2()" id="close2">确定</div>
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
   function close2() {
       $.post("?m=user&c=ulogin",function (res) {
           onclose.log(res)
       })
        window.location.href = "?m=index&c=login";
   }
    function cache() {
        layer.msg('清除成功');
    }
</script>
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
<script type="text/javascript">
$(function() {
	 /*弹框显示与隐藏*/	
	 $("#tuichu").on('click', function() {
		 $(".jui_box_bar").removeClass("jui_none");
     })
	 $("#close").on('click', function() {
		 $(".jui_box_bar").addClass("jui_none");
	  })
	 $("#close2").on('click', function() {
		 $(".jui_box_bar").addClass("jui_none");
	  })
	  
	
	/*开发中提示*/ 
	$(document).on("click",".tishi",function(){
		box_timer("轻松还正在努力开发中...");
	});
	 
});
</script>
</html>
