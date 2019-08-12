<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $this->config['w_name']; ?></title>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <script type="text/javascript" src="/public/js/flexible.js"></script>
    <script src="/public/js/jquery-3.3.1.min.js"></script>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            outline: none;
            -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
        }

        /*-webkit-tap-highlight-color:rgba(255,255,255,0);控制手机端点击时出现的颜色背景*/
        html, body {
            width: 100%;
            height: 100%;
        }

        body {
            color: #333;
            font-family: "Microsoft YaHei", "微软雅黑";
            background: #fff;
            max-width: 750px;
            margin: 0px auto;
        }

        /*div,h1,h2,h3,h4,h5,h6,ul,ol,li,dd,dt,p,img{ margin:0px; padding:0px;}*/
        input {
            background: transparent;
            outline: none;
            border: none;
        }

        p, div {
            font-size: 0.37333rem;
        }

        /*默认字体大小14px*/
        .login_bar {
            width: 100%;
            height: 100%;
        }

        .login_logo {
            height: 2.6rem;
            margin: 1.3rem auto;
        }

        .login_con {
            padding: 0px 1.3rem;
            width: 100%;
        }

        .login_con .jui_public_list {
            width: 100%;
            background: #344883;
            margin-bottom: .4266rem;
            border: none;
            height: 1.17333rem;
        }

        .login_con .jui_public_list input {
            line-height: 1.1rem;
            font-size: .37333rem;
            color: #fff;
            padding-left: 0.26rem;
        }

        .login_con .jui_public_btn {
            padding: 0rem;
        }

        .login_con .jui_public_btn input {
            background: #3c5dc1;
        }

        .login_link {
            padding-bottom: 1.1733rem;
        }

        .login_con h1 {
            font-size: .5333rem;
            font-weight: normal;
            padding: 1.3rem 0px;
            color: #fff;
            text-align: center;
        }

        .reg_yzm {
            border-left: 1px solid #afbde8;
            height: .6rem;
            line-height: .6rem !important;
            font-size: .32rem !important;
            text-align: center;
            -webkit-flex: 0 0 2.4rem;
            -moz-flex: 0 0 2.4rem;
            -ms-flex: 0 0 2.4rem;
            flex: 0 0 2.4rem;
        }

        .jui_bg_zhuse {
            background: #2d3d6d !important;
        }

        .jui_public_list, .jui_public_list2 {
            display: box;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            -moz-align-items: center;
            -ms-align-items: center;
            align-items: center;
        }

        /*固定高度100*/
        .jui_public_list {
            border-bottom: 1px solid #eee;
            padding: 0px .42666rem;
            height: 1.33333rem;
            overflow: hidden;
        }

        .jui_public_list:nth-last-child(1) {
            border: none;
        }

        .jui_public_list input {
            line-height: 1.3rem;
        }

        .jui_public_list input[type='checkbox'], .jui_public_list input[type='radio'] {
            line-height: 0px;
        }

        /*与.form_radio高度一样即可*/
        .jui_public_btn {
            padding: .42666rem;
        }

        .jui_public_btn input {
            display: block;
            width: 100%;
            height: 1.17333rem;
            line-height: 1.17333rem;
            text-align: center;
            background: #2d3d6d;
            color: #fff;
            font-size: .4rem;
            -webkit-border-radius: 5px;
            border-radius: 5px;
            border: none;
        }

        /*提示信息*/
        .box_bar {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 999999;
            background: rgba(255, 255, 255, 0.5);
            display: none;
        }

        .box_con {
            position: absolute;
            z-index: 11;
            left: 50%;
            bottom: 2rem;
            width: 4rem;
            margin-left: -2rem;
            background: #000;
            -webkit-border-radius: .2666rem;
            border-radius: .2666rem;
            color: #fff;
            text-align: center;
            padding: .42666rem 0px;
        }
    </style>
</head>
<body class="jui_bg_zhuse">
<!-- 主体 -->
<form class="jui_flex_col_center jui_flex_justify_between login_bar">
    <div class="login_con">
        <h1 class="jui_text_center jui_fc_fff">快速注册</h1>
        <div class="jui_public_list jui_bor_rad_5">
            <input class="jui_flex1" type="tel" placeholder="请输入您的手机号" id="m_phone">
        </div>
        <div class="jui_public_list jui_bor_rad_5 jui_flex_justify_between jui_pad_rnone">
            <input style="width:4.8rem;" type="tel" placeholder="请输入验证码" id="reg_code">
            <input id="jui_form_yzm" class="reg_yzm jui_fc_lightzs" type="button" value="获取验证码">
        </div>
        <div class="jui_public_list jui_bor_rad_5">
            <input class="jui_flex1" type="password" placeholder="请输入密码" id="m_password">
        </div>
        <div class="jui_public_list jui_bor_rad_5">
            <input class="jui_flex1" type="text" placeholder="请输入邀请码" id="invite_code"
                   value="<?php if (isset($_GET['t'])) {
                       echo $_GET['t'];
                   } ?>" <?php if (isset($_GET['t'])) {
                echo 'readonly ';
            } ?>>
        </div>
        <div class="jui_public_btn"><input type="button" value="立即注册" id="register"></div>
    </div>

</form>
<div class="box_bar">
    <div class="box_con f26">
        <p>提交失败</p>
    </div>
</div>
<!-- 主体end -->
</body>
<script>
    //倒计时  不需要jquery库
    var regcode = true;

    function settime(num) {
        var yzm_input = document.getElementById("jui_form_yzm"); //如果用getElementsByClassName获取类，获取的为数组，下面的yzm_input要改为yzm_input[0]
        var num;
        if (num == 0) {
            regcode = true;
            yzm_input.value = "重新发送";
            yzm_input.removeAttribute("disabled");
            yzm_input.setAttribute("class", "reg_yzm jui_fc_lightzs");

            return false; //直到倒计时0时停止执行函数
        } else {
            yzm_input.setAttribute("disabled", "disabled");
            yzm_input.setAttribute("class", "reg_yzm jui_fc_lightzs")
            yzm_input.value = num + "s后重发";
            num--;
        }
        setTimeout("settime(" + num + ")", 1000);           //num为变量，所以要用“+”链接
    }

    $(function () {
        $("#jui_form_yzm").on('click', function () {
            if (!regcode) {
                return;
            } else {
                $.ajax({
                    type: 'post',
                    url: "/index.php?m=index&c=reg_smscode",
                    data: {m_phone: $("#m_phone").val()},
                    success: function (data) {
                        data = JSON.parse(data);
                        $('.box_bar .box_con p').html(data.msg);
                        $(".box_bar").show();
                        if (data.code != 200) {
                            setTimeout(function () {
                                $(".box_bar").css('display', 'none');
                            }, 1000);

                        } else {
                            setTimeout(function () {
                                $(".box_bar").css('display', 'none');
                            }, 1000);
                            regcode = false;
                            settime(60);
                        }
                    }
                })

            }
        });
        $("#register").on('click', function () {
            var data = {
                invite_code: $("#invite_code").val(),
                m_phone: $("#m_phone").val(),
                reg_code: $("#reg_code").val(),
                m_password: $("#m_password").val()
            };
            if (!/\w{6}/.test($("#m_password").val())) {
                $('.box_bar .box_con p').html('密码至少输入6位');
                $(".box_bar").show();
                setTimeout(function () {
                    $(".box_bar").css('display', 'none');
                }, 1000);
                return;
            }
            if (!$("#reg_code").val()) {
                $('.box_bar .box_con p').html('验证码不能为空');
                $(".box_bar").show();
                setTimeout(function () {
                    $(".box_bar").css('display', 'none');
                }, 1000);

                return;
            }
            if (!$("#invite_code").val()) {
                $('.box_bar .box_con p').html('邀请码不能为空');
                $(".box_bar").show();
                setTimeout(function () {
                    $(".box_bar").css('display', 'none');
                }, 1000);
                return;
            }
            $.ajax({
                type: 'post', url: '/index.php?m=index&c=register', data: data, success: function (data) {
                    data = JSON.parse(data);
                    if (data.code == 200) {
                        $('.box_bar .box_con p').html(data.msg);
                        $(".box_bar").show();
                        setTimeout(function () {
                            $(".box_bar").css('display', 'none');
                            window.location.href = '<?php echo $this->config['w_down1']; ?>';
                        }, 1000);
                    } else {
                        $('.box_bar .box_con p').html(data.msg);
                        $(".box_bar").show();
                        setTimeout(function () {
                            $(".box_bar").css('display', 'none');
                        }, 1000);
                    }
                }
            })
        })
    })
</script>
</html>
