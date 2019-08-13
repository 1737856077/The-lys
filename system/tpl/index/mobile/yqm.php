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
     <a class="jui_top_left" href="?m=user&c=user"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">我的邀请码</div>
     <a href="?m=user&c=team" class="jui_top_right">好友列表</a>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main jui_pad_16">
     <div class="jui_bg_fff jui_bor_rad_5 jui_flex_col_center yqm_bar">
          <div class="yqm_img jui_mar_b8"><img id="tx" src="/public/qyh/images/yqm.png"></div>
          <div class="jui_fs15 jui_fc_lightzs">邀请码：<span id="yqm" class="jui_fc_lan">0XCBCD</span></div>
          <div class="jui_h30"></div>
          <div class="jui_flex_row_center">

                <div id="Copy" onclick="copytxt()" class="yqm_btn jui_bg_jblan jui_bor_rad_5" >复制邀请链接</div>
                <div class="yqm_btn jui_bor_rad_5 jui_bg_zhuse">保存为图片</div>
          </div>
     </div>
     <div class="jui_h16"></div>
     <div class="jui_line_h14">
           <P>1、每推荐一个注册用户激活，直推人赠送QSHC50枚</p>
           <p>2、第二代送QSHC30枚</p>
           <p>3、第三代送QSHC20枚</p>
           <p>4、第4-9代送QSHC10枚</p>
           <p>5、QSHC未来可参与游戏，消费和各大数字货币交易所流通交易</P>
     </div>
    <input type="hidden" name="lianjie" id="lianjei" value="" >
    <input type="hidden" id="uid" name="uid" value="<?php echo $_SESSION['uid']?>">
    <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']?>">
    <script language="javascript">
        function copytxt(){

            var con=document.getElementById(lianjei);

            con.select();
            document.execCommand("Copy");

        }
    </script>
        <script>

            var   uid = $("#uid").val();
            var   token= $("#token").val();
            $.post('?m=user&c=invite_user',{uid:uid,token:token,get_type:1},function (res) {
                data = JSON.parse(res);
                if (data.code==200){
                    $("#tx").attr('src', data.qr_code)
                    $("#yqm").html(data.user.m_yqm)
                    $("#lianjei").val(data.url)

                }else {
                    // layer.msg(data.msg)
                    setTimeout(function () {
                        window.location.href = '?m=user&c=user'
                    },1000)
                }
            })
        </script>

</div>
<!-- 主体end -->
</body>
</html>
