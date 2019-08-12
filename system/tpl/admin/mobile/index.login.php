<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo WEBNAME;?> - <?php echo WEBDESC;?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/static/css/layui.css">
	<link rel="stylesheet" href="/static/css/main.css">
	<link rel="stylesheet" href="/static/css/login.css">
</head>
<body style="background: #f5f5f5;">

  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">

    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2><?php echo WEBNAME;?></h2>
        <p><?php echo WEBDESC;?></p>
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
          <input type="text" name="username" id="LAY-user-login-username" lay-verify="phone" placeholder="手机号" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
          <input type="password" name="password" id="LAY-user-login-password" lay-verify="pass" placeholder="密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <div class="layui-row">
            <div class="layui-col-xs7">
              <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
              <input type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
            </div>
            <div class="layui-col-xs5">
              <div style="margin-left: 10px;">
                <img src="admin.php?m=index&c=captcha" class="layadmin-user-login-codeimg" onClick="this.src='admin.php?m=index&c=captcha&_='+Math.random();">
              </div>
            </div>
          </div>
        </div>
        <div class="layui-form-item" style="margin-bottom: 20px;">
          <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">        
        </div>
        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid layui-btn-normal" lay-submit lay-filter="LAY-user-login-submit">登 录</button>
        </div>
      </div>
    </div>
    
    <div class="layui-trans layadmin-user-login-footer">
      <p><?php echo WEBNAME;?></p>
    </div>
  </div>

<script src="/static/layui.js"></script>
<script>
layui.use(['element','form'], function(){
  	var element = layui.element,form = layui.form;
	form.verify({pass: [/^[\S]{6,12}$/, "密码必须6到12位，且不能出现空格"]});
    form.render();
    form.on('submit(LAY-user-login-submit)', function(obj){
		var field = obj.field;
		if(field.username  == ''){
			return layer.msg('手机号不能为空');
		}
		if(field.password == ''){
			return layer.msg('密码不能为空');
		}
		if(field.vercode == ''){
			return layer.msg('验证码不能为空');
		}
		layui.$.post('admin.php?m=index&c=login',field,function(data){
			if(data.status==1){
				layer.msg('登录成功,正在跳转...', {offset: '15px',icon: 1,time: 1000}, function(){top.location.href = 'admin.php';});
			}else{
				layer.msg('登录失败:'+data.msg);
			}
		});
	});
});
</script>
</body>
</html>