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
<body class="jui_bg_fff">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">我的团队</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main">
<div class="td_con">
    <div class="jui_public_list">
         <div class="jui_grid_w25">推荐层级</div>
         <div class="jui_grid_w35">团队（已激活）</div>
         <div class="jui_grid_w20">已收订单</div>
         <div class="jui_grid_w20 jui_text_right">漏单</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第一层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第二层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第三层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第四层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第五层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第六层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第七层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第八层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
    <div class="jui_public_list">
         <div class="jui_grid_w25">第九层</div>
         <div class="jui_grid_w35">0</div>
         <div class="jui_grid_w20">0</div>
         <div class="jui_grid_w20 jui_text_right">0</div>
    </div>
</div>


</div>
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
<!-- 主体end -->
</body>
</html>
