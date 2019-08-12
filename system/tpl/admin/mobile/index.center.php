<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo WEBNAME;?> - <?php echo WEBDESC;?></title>
  <link rel="stylesheet" href="/static/css/layui.css">
	<link rel="stylesheet" href="/static/css/main.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin" style="min-width:100%;">
<div class="layui-header layui-bg-blue">
    <div class="layui-logo" style="width:auto;">
	<?php 
	if(!empty($this->config['w_logo'])){
		echo '<img src="'.$this->config['w_logo'].'" height="55" />';
	}
	?>
	<?php echo WEBNAME;?></div>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item change-pwd"><a href="javascript:void(0)"><i class="layui-icon layui-icon-password"></i>密码修改</a></li>   
      <li class="layui-nav-item"><a href="?m=index&c=logout"><i class="layui-icon layui-icon-spread-left"></i>退出</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-cyan">
    <div class="layui-side-scroll">
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
      	<li class="layui-nav-item" style="height:10px;"></li>
          <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;" target="layadmin-iframe"><i class="layui-icon layui-icon-util"></i>系统设置</a>
          <dl class="layui-nav-child">
              <dd><a href="?m=config&c=basic" target="layadmin-iframe"><i class="layui-icon layui-icon-set"></i>基础设置</a></dd>
              <dd><a href="?m=config&c=sms" target="layadmin-iframe"><i class="layui-icon layui-icon-cellphone"></i>短信设置</a></dd>
              <dd><a href="?m=config&c=level" target="layadmin-iframe"><i class="layui-icon layui-icon-upload-circle"></i>还款配置</a></dd>
              <dd><a href="?m=config&c=banner" target="layadmin-iframe"><i class="layui-icon layui-icon-senior"></i>广告管理</a></dd>
              <dd><a href="?m=config&c=notice" target="layadmin-iframe"><i class="layui-icon layui-icon-notice"></i>特色产品</a></dd>
              <dd><a href="?m=class&c=index" target="layadmin-iframe"><i class="layui-icon layui-icon-table"></i>文章管理</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;"><i class="layui-icon layui-icon-user"></i>会员管理</a>
          <dl class="layui-nav-child">
              <dd><a href="?m=user&c=index" target="layadmin-iframe"><i class="layui-icon layui-icon-username"></i>会员管理</a></dd>
              <dd><a href="?m=user&c=jh_list" target="layadmin-iframe"><i class="layui-icon layui-icon-app"></i>众筹计划</a></dd>
              <dd><a href="?m=user&c=uplevel" target="layadmin-iframe"><i class="layui-icon layui-icon-app"></i>众筹订单</a></dd>

          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:void(0)"><i class="layui-icon layui-icon-list"></i>其他管理</a>
          <dl class="layui-nav-child">
            <dd><a href="?m=config&c=about&id=2" target="layadmin-iframe"><i class="layui-icon layui-icon-read"></i>用户协议</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:void(0)"><i class="layui-icon layui-icon-set-fill"></i>账户管理</a>
          <dl class="layui-nav-child">
            <dd><a href="?m=index&c=admin" target="layadmin-iframe"><i class="layui-icon layui-icon-group"></i>后台账户</a></dd>
            <dd><a href="javascript:void(0)" class="change-pwd"><i class="layui-icon layui-icon-password"></i>修改密码</a></dd>
            <dd><a href="?m=index&c=role_index" target="layadmin-iframe"><i class="layui-icon layui-icon-tree"></i>角色管理</a></dd>
            <dd><a href="?m=index&c=auth_index" target="layadmin-iframe"><i class="layui-icon layui-icon-unlink"></i>权限管理</a></dd>
          </dl>
        </li>
     </ul>
    </div>
  </div>
  
  <div class="layui-body">
		<iframe src="?m=index&c=main" frameborder="0" class="layadmin-iframe" name="layadmin-iframe"></iframe>
  </div>
    <div class="layui-row" id="lay-pass">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">修改密码</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form" lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" lay-verify="required" lay-verType="tips" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="repassword" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn layui-btn-normal" lay-submit lay-filter="setmypass">确认修改</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  
  <div class="layui-footer"> 
    <?php echo WEBNAME.'@'.date('Y',time());?>
  </div>
</div>
<script src="/static/layui.js"></script>
<script>
//JavaScript代码区域
layui.use(['element','layer','form'], function(){
  var element 	= layui.element;	
  var layer 	= layui.layer;
  var form 		= layui.form;
	form.verify({pass: [/^[\S]{6,12}$/, "密码必须6到12位，且不能出现空格"]});
	form.render();
	form.on('submit(setmypass)', function(obj){
		var field = obj.field;
		if(field.oldPassword  == ''){
			return layer.msg('原密码不能为空');
		}
		if(field.password == ''){
			return layer.msg('新密码不能为空');
		}
		if(field.password !== field.repassword){
			return layer.msg('两次密码输入不一致');
		}

		layui.$.post('?m=index&c=changepwd',field,function(data){
			if(data.code==1){
				layer.msg('修改成功', {offset: '15px',icon: 1,time: 1000}, function(){location.href = 'admin.php';});		
			}else{
				layer.msg('修改失败:'+data.msg);
			}
		});
	});
	layui.$('.change-pwd').click(function(){
		  layer.open({
		  type: 1,
		  title: false,
		  scrollbar: false,
		  area: '520px',
		  skin: 'layui-layer-nobg', //没有背景色
		  shadeClose: true,
		  content: layui.$('#lay-pass')
		});
		
	});
});

</script>
</body>
</html>