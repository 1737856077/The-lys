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
    <script type="text/javascript" src="/public/qyh/js/layer.js"></script>
    <script src="/public/qyh/js/common.js"></script>
    <script src="/public/qyh/js/layer.js"></script>

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
<!--    <div class="jui_pad_l16 jui_pad_r16">-->
<!--        <div class="jui_public_list jui_bor_rad_5 jui_bg_ztqian smrz_inpubar">-->
<!--            <div class="jui_fc_lightzs jui_pad_r12">姓&nbsp;&nbsp;&nbsp;名</div>-->
<!--            <input class="jui_flex1" type="text" value="" placeholder="请输入真实姓名" id="m_zsxm">-->
<!--        </div>-->
<!--        <div class="jui_public_list jui_bor_rad_5 jui_bg_ztqian smrz_inpubar">-->
<!--            <div class="jui_fc_lightzs jui_pad_r12">身份证</div>-->
<!--            <input class="jui_flex1" type="text" value="" placeholder="请输入身份证" id="m_carid">-->
<!--        </div>-->
<!--    </div>-->

    <div class="jui_pad_l16 jui_pad_r16">
        <div class="jui_h16"></div>
        <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
            <div class="jui_pad_r12">姓&nbsp;&nbsp;&nbsp;名</div>
            <input class="jui_flex1" type="text" value="" placeholder="请输入真实姓名" id="m_zsxm">
        </div>
        <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
            <div class="jui_pad_r12">身份证</div>
            <input class="jui_flex1" type="text" value="" placeholder="请输入身份证" id="m_carid">
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
                        <img id="imghead" border="0" src="/public/qyh/icons/smrz_img01.png" onClick="return false;" onerror = "this.src = 'icons/smrz_img01.png'">
                    </div>
                    <div class="smrz_img_input">
                        <p class="jui_fc_fff">上传身份证正面</p>
                    </div>
                </div>
                <div class="smrz_img_bar jui_flex_col">
                    <div id="jui_preview2">
                        <img id="imghead2" border="0" src="/public/qyh/icons/smrz_img02.png"  onClick="return false;" onerror = "this.src = 'icons/smrz_img02.png'">
                    </div>
                    <div class="smrz_img_input">
                        <p class="jui_fc_fff">上传身份证反面</p>
                    </div>
                </div>
            </div>



        </div>
        <!-- 证件上传end -->
    <div class="jui_public_btn"><input type="button" value="提交审核" id="send"></div>
</div>
</div>
<!-- 主体end -->
<input type="hidden" id="uid" value="<?php echo $_SESSION['uid']?>">
<input type="hidden" id="token" value="<?php echo $_SESSION['token']?>">

<script type="text/javascript">
    $(function() {
        var input = document.createElement('input');
        var   uid = $("#uid").val();
        var   token= $("#token").val();
        input.type = 'file';
        input.accept = 'image/*';
        var m_carimg1 = null;
        var m_carimg2 = null;
        function send() {
            if(!$("#m_zsxm").val()) {
                layer.msg('姓名不能为空')
                return;
            }
            if(!m_carimg1 || !m_carimg2) {
                layer.msg('图片不能为空')
                return;
            }
            if(!/\d{15,20}/.test($("#m_carid").val())) {
                layer.msg('请属于合法的身份证信息');
                return;
            }
            var req = {
                uid: localStorage.getItem('h_uid'),
                token: localStorage.getItem('h_token'),
                m_zsxm: $("#m_zsxm").val(),
                m_carid: $("#m_carid").val(),
                m_carimg1: m_carimg1,
                m_carimg2: m_carimg2,
                uid:uid,
                token:token

            }
            var formdata = new FormData();
            console.log(req.m_carimg1);
            for(let attr in req) {
                formdata.append(attr, req[attr])
            }
            $.ajax({type: 'post', url:'/index.php?m=user&c=real_name', data: formdata, contentType: false, processData: false, success: function(data) {
                    data = JSON.parse(data);
                    if(data.code == 200) {
                        setTimeout(function () {
                            window.location.href = '?m=index&c=index'
                        },1000)
                        layer.msg('提交成功')

                        // setTimeout(()=> {
                        //   window.location.href = 'center.html';
                        // },1000)
                    } else {
                        layer.msg(data.msg)
                    }
                }})
        }
        var reg = /^(http|https)[\w\.\:\/]*(?=\/static\/)/;
        var reqx = {uid: uid, token : token}
        $.ajax({type: "post", url: 'index.php?m=user&c=real_info', data:reqx , success: function(data) {
                data = JSON.parse(data);
                if(data.data.m_rz == 1) {
                    $("#send").css({display: 'none'});
                }
                $("#m_zsxm").val(data.data.m_zsxm);
                $("#m_carid").val(data.data.m_carid);
                $("#imghead2").attr('src', data.data.m_carimg1);
                $("#imghead").attr('src', data.data.m_carimg2)
                m_carimg1 = data.data.m_carimg1.replace(reg, ".");
                m_carimg2 = data.data.m_carimg2.replace(reg, ".");
            }})
        $("#send").on('click',send);
        $("#jui_preview").on('click', function() {
            var reader = new FileReader();
            input.onchange = function() {
                var file = this.files[0];
                console.log(file.name);
                if(!/(jpg|png|jpeg)$/.test(file.name)) {
                    layer.msg('仅支持png,jpg格式图片')
                    return;
                }
                reader.readAsDataURL(file);
                reader.onload = function() {
                    $("#imghead").attr('src', this.result);
                    m_carimg1 = file;
                }
                input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
            }
            input.click();
        })
        $("#jui_preview2").on('click', function() {
            var reader = new FileReader();
            input.onchange = function() {
                var file = this.files[0];
                console.log(file.name);
                if(!/(jpg|png|jpeg)$/.test(file.name)) {
                    layer.msg('仅支持png,jpg格式图片')
                    return;
                }
                reader.readAsDataURL(file);
                reader.onload = function() {
                    $("#imghead2").attr('src', this.result);
                    m_carimg2 = file;
                }
                input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
            }
            input.click();
        })
    })
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
</body>


</html>
