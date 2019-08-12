<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->config['w_name']; ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="stylesheet" type="text/css" href="/new_web/css/style.css">
<link rel="stylesheet" type="text/css" href="/new_web/css/css.css">
<script src="/new_web/js/flexible.js"></script>
<script src="/new_web/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/new_web/js/layer.js"></script>
<script src="/new_web/js/common.js"></script>
</head>
<body class="jui_bg_zhuse">
<!-- 主体 -->
<form class="jui_flex_col_center jui_flex_justify_between login_bar">
     <div class="login_con">
         <img class="login_logo" src="<?php echo $this->config['w_logo']; ?>">
         <div class="jui_bg_fff jui_bor_rad_5 jui_pad_16">
             <div class="jui_fs20 jui_fc_zhuse jui_pad_b12">注册</div>
           <div class="jui_public_list jui_bor_rad_5">
                 <input class="jui_flex1" type="tel" placeholder="请输入您的手机号" id="m_phone">
           </div>
           <div class="jui_public_list jui_bor_rad_5 jui_flex_justify_between jui_pad_rnone">
                 <input style="width:3rem;" type="tel" placeholder="请输入验证码" id="reg_code">
                 <input id="jui_form_yzm" class="reg_yzm jui_fc_lightzs" type="button" value="获取验证码">
           </div>
           <div class="jui_public_list jui_bor_rad_5">
                 <input class="jui_flex1" type="password" placeholder="请输入密码" id="m_password">
           </div>
             <div class="jui_public_list jui_bor_rad_5">
                 <input class="jui_flex1" type="text" placeholder="请输入邀请码" id="invite_code" value="<?php if(isset($_GET['t'])){ echo $_GET['t']; } ?>"  <?php if(isset($_GET['t'])){ echo 'readonly '; } ?>>
             </div>
             <div class="jui_fc_000 jui_pad_t5 jui_pad_b16 jui_fs12"></div>
           <div class="jui_public_btn">
               <input type="button" value="立即注册" id="register">
           </div>
         </div>
     </div>
</form>
<!-- 主体end -->
</body>
<script src="/new_web/js/register.js"></script>
<script>
//倒计时  不需要jquery库
  var regcode = true;
	function settime(num){
		var yzm_input=document.getElementById("jui_form_yzm"); //如果用getElementsByClassName获取类，获取的为数组，下面的yzm_input要改为yzm_input[0]
		var num;
		if( num==0 ){
      regcode = true;
			yzm_input.value="重新发送";
			yzm_input.removeAttribute("disabled");
			yzm_input.setAttribute("class","reg_yzm jui_fc_lightzs");

			return false; //直到倒计时0时停止执行函数
			}else{
				yzm_input.setAttribute("disabled","disabled");
				yzm_input.setAttribute("class","reg_yzm jui_fc_lightzs")
				yzm_input.value=num+"s后重发";
				num--;
				}
		 //setTimeout(function(){settime(num)},1000);
		 setTimeout("settime("+num+")", 1000); //num为变量，所以要用“+”链接
	}
  $(function() {
    $("#jui_form_yzm").on('click', function() {
      if(!regcode) {
        return;
      } else {
      if(/^1([38]\d|5[0-35-9]|7[3678])\d{8}$/.test($("#m_phone").val())){
          $.ajax({type:'post', url: baseURL +"/index.php?m=index&c=reg_smscode", data:{ m_phone: $("#m_phone").val()}, success: function(data) {
            data = JSON.parse(data);
            if(data.code != 200) {
              layer.open({
                content: data.msg
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
              });
            } else {
              regcode = false;
              settime(60);
            }
          }})
        } else {
          layer.open({
            content: '请输入正确手机号'
            ,btn: '我知道了'
          });
        }
      }
    })
    $("#register").on('click', function() {
      var data = {
        invite_code : $("#invite_code").val(),
        m_phone: $("#m_phone").val(),
        reg_code: $("#reg_code").val(),
        m_password: $("#m_password").val()
      };
      if(!/\w{6}/.test($("#m_password").val())){
        layer.open({
          content: '密码至少输入6位'
          ,skin: 'msg'
          ,time: 1 //2秒后自动关闭
        });
        return;
      }
      if(!$("#reg_code").val()) {
        layer.open({
          content: '验证码不能为空'
          ,skin: 'msg'
          ,time: 1 //2秒后自动关闭
        });
        return;
      }
      if(!$("#invite_code").val()) {
        layer.open({
          content: '邀请码不能为空'
          ,skin: 'msg'
          ,time: 1 //2秒后自动关闭
        });
        return;
      }
      $.ajax({type:'post', url: baseURL +'/index.php?m=index&c=register', data: data, success: function(data) {
        data = JSON.parse(data);
        if(data.code == 200 ) {
          setTimeout(function () {
              window.location.href = '<?php echo $this->config['w_down1']; ?>';
          },1000);
          layer.open({
            content: '注册成功'
            ,skin: 'msg'
            ,time: 1 //2秒后自动关闭
          });
        } else {
          layer.open({
            content: data.msg
            ,skin: 'msg'
            ,time: 1 //2秒后自动关闭
          });
        }
      }})
    })

  })
</script>
</html>
