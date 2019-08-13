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
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">好友列表</div>
     <a href="?m=user&c=tuandui" class="jui_top_right">我的团队</a>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main">
    <div id="haoyou" class="jui_bg_fff">
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
<script>
    var uid = $("#uid").val()
    var token = $("#token").val();
    $.post("?m=user&c=teams",{uid:uid,token:token},function (res) {
        data = JSON.parse(res);
        console.log(data);
        for(var i = 0; i < data.t_num; i++){
            var html='';
            html+="<div class='jui_public_list2'>";
            html+="<div class='jui_bor_rad_50 team_tx'>";
            html+="<img src='/public/qyh/icons/tx.jpg'>";
            html+="</div>";
            html+=" <div class='jui_flex1 jui_flex_col'>";
            html+=" <p>"+data.teams_info[i]['m_name']+"</p>";
            html+=" <p>"+data.teams_info[i]['m_phone']+"</p>";
            html+=" </div>";
            html+="<div class='jui_fc_lightzs'>";
            html+=data.teams_info[i]['m_regtime'];
            html+="</div>";
            html+="</div>";
            console.log(html);
            $("#haoyou").append(html)
        }

    })
</script>
<!-- 主体end -->
</body>
</html>
