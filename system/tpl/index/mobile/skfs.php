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
<script src="/public/qyh/js/upload_img.js"></script>
    <script src="/public/qyh/js/flexible.js"></script>
    <script type="text/javascript" src="/public/qyh/js/layer.js"></script>
    <script src="/public/qyh/js/common.js"></script>
</head>
<body class="jui_bg_grey">
<!-- 头部 -->
<div class="jui_top_bar">
     <a class="jui_top_left" href="javascript:history.back(-1)"><img src="/public/qyh/icons/back_icon.png"></a>
     <div class="jui_top_middle">收款方式</div>
</div>
<!-- 头部end -->
<!-- 主体 -->
<div class="jui_main jui_pad_l16 jui_pad_r16">
      <div class="jui_h16"></div>
      <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
           <div class="jui_pad_r12">收款渠道</div>
           <div>微信或支付宝</div>
      </div>
      <div class="jui_public_list jui_bor_rad_5 skfs_inpubar">
           <div class="jui_pad_r12">收款账号</div>
          <input class="jui_flex1" type="text" value="" placeholder="请输入微信或支付宝收款账号" id="p_num">
      </div>
      <div class="jui_bg_fff jui_flex_col_center jui_pad_20 jui_bor_rad_5">
           <div class="skfs_img" id="shoukuan">
               <img id="imghead" border="0" src="/public/qyh/icons/add_img2.png" onerror = "this.src = '/public/qyh/icons/add_img2.png'"  onclick="return false;">
<!--                <img id="imghead" border="0" src="/public/qyh/icons/add_img2.png" onClick="$('#previewImg').click();">-->
           </div>
          <input type="file" onChange="previewImage(this)" style="display:none;" id="previewImg" />
           <div class="jui_h12"></div>
           <p>点击上传收款二维码</p>
      </div>
      <div class="jui_h16"></div>
      <div class="jui_public_list jui_flex_justify_between jui_bor_rad_5 skfs_inpubar jui_mar_bnone">
           <div class="jui_flex_row_center">
               <p class="jui_pad_r8 jui_flex_no">验证码</p>
<!--               <input style="width:3rem;" type="tel" placeholder="请输入验证码">-->
               <input style="width:3rem;" type="tel" placeholder="请输入验证码" id="pay_code">
           </div>
<!--           <input id="jui_form_yzm" class="jui_fc_zhuse" type="button" value="获取验证码" onclick="settime(60);">
-->
          <input id="jui_form_yzm" class="jui_fc_lan" type="button" value="获取验证码">
      </div>
<!--      <div class="jui_public_btn jui_pad_lnone jui_pad_rnone"><input type="button" value="提交审核"></div> -->
    <div class="jui_public_btn"><input type="button" value="提交审核" id="btn"></div>
</div>
<!-- 主体end -->
<input type="hidden" id="uid" value="<?php echo $_SESSION['uid']?>">
<input type="hidden" id="token" value="<?php echo $_SESSION['token']?>">
<input type="hidden" id="m_phone" value="<?php echo $_SESSION['m_phone']?>">
<script>
    //倒计时  不需要jquery库
    var regcode = true;

    var p_phone = uid = $("#m_phone").val();
    var p_id;
    var input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    var   uid = $("#uid").val();
    var   token= $("#token").val()
    var reqxq = {
        uid: uid,
        token: token,
    }
    ;
    function settime(num){
        var yzm_input=document.getElementById("jui_form_yzm"); //如果用getElementsByClassName获取类，获取的为数组，下面的yzm_input要改为yzm_input[0]
        var num;
        if( num==0 ){
            regcode = true;
            yzm_input.value="重新发送";
            yzm_input.removeAttribute("disabled");
            yzm_input.setAttribute("class","jui_fc_lan")
            return false; //直到倒计时0时停止执行函数
        }else{
            regcode = false;
            yzm_input.setAttribute("disabled","disabled");
            yzm_input.setAttribute("class","jui_fc_lan")
            yzm_input.value=num+"s后重发";
            num--;
        }
        //setTimeout(function(){settime(num)},1000);
        setTimeout("settime("+num+")", 1000); //num为变量，所以要用“+”链接
    }
    $(function() {
        var p_img = null;
        //给
        $.ajax({type:'post', url: '/index.php?m=user&c=pay_info', data: reqxq, success: function(data) {
                data = JSON.parse(data);
                if(data.code != 200) {
                    layer.msg(data.msg)
                    setTimeout(()=>{
                        window.history.back(-1);
                    }, 1000)
                    return;
                }
                p_id = data.data.p_id || 0;
                $("#imghead").attr('src', data.data.p_img);
                data.data.p_img = data.data.p_img || "";
                p_img = data.data.p_img.replace(/^(http|https)[\w\.\:\/]*(?=\/static\/)/, '.');
                $("#p_num").val(data.data.p_num);
            }})
        //
        $("#jui_form_yzm").on('click', function() {
            if(!regcode){
                return;
            }
            console.log(p_phone)
            $.ajax({type: 'post', url:'/index.php?m=index&c=setpay_smscode', data:{m_phone: p_phone}, success: function(data) {
                    data = JSON.parse(data);
                    console.log(data)
                    if(data.code == 200) {
                        settime(60);
                        layer.msg(data.msg)
                    }
                }})
        })
        $("#btn").on('click', function() {
            if(!$("#p_num").val()) {
                layer.msg('收款账号不能为空')
                return ;
            }
            if(!p_img) {
                layer.msg('收款码不能为空')
                return ;
            }
            $.ajax({type: 'post', url: '/index.php?m=user&c=is_setup', data: reqxq, success: function(data) {
                    data = JSON.parse(data);
                    if(data.code != 200) {
                        layer.open({content: data.msg, time: 1, skin: 'msg'})
                        setTimeout(()=>{
                            window.history.back(-1)
                        }, 1000)
                        return;
                    }
                    if(data.is_rz == 1) {
                        var req = {
                            uid: uid,
                            token: token,
                            p_type: 1,
                            p_id,
                            p_status: 1,
                            p_num: $("#p_num").val(),
                            p_img,
                            p_phone,
                            pay_code: $("#pay_code").val(),
                        }
                        var formdata = new FormData();
                        for(let attr in req) {
                            formdata.append(attr, req[attr])
                        }
                        $.ajax({type: 'post', url: '/index.php?m=user&c=pay_save', contentType: false, data: formdata, processData: false, success: function(data) {
                                data = JSON.parse(data);
                                if(data.code == 200) {
                                    setTimeout(()=> {
                                        window.location.href = 'center.html';
                                    }, 1000)
                                    layer.msg('添加成功')
                                }else {
                                    layer.msg(data.msg)
                                }
                            }})
                    } else {
                        layer.open({content: '请先完成实名认证', time: 1, skin: 'msg'});
                        setTimeout(()=>{
                            window.history.back(-1);
                        }, 1000)
                    }
                }})
        })
        $("#shoukuan").on('click', function() {
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
                    p_img = file;
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
<!---->
<!--<script>-->
<!--//倒计时  不需要jquery库  -->
<!--	function settime(num){-->
<!--		var yzm_input=document.getElementById("jui_form_yzm"); -->
<!--		var num;-->
<!--		if( num==0 ){-->
<!--			yzm_input.value="重新发送";-->
<!--			yzm_input.removeAttribute("disabled");-->
<!--			yzm_input.setAttribute("class","jui_fc_zhuse")-->
<!--			return false; //直到倒计时0时停止执行函数-->
<!--			}else{-->
<!--				yzm_input.setAttribute("disabled","disabled");-->
<!--				yzm_input.setAttribute("class","jui_fc_ddd")-->
<!--				yzm_input.value=num+"s后重发";-->
<!--				num--;-->
<!--				}-->
<!--		 //setTimeout(function(){settime(num)},1000);-->
<!--		 setTimeout("settime("+num+")", 1000); //num为变量，所以要用“+”链接-->
<!--	}-->
<!--	-->
<!--</script>-->
</html>
