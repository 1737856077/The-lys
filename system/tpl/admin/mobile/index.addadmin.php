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
</head>
<body>
<?php
	if(intval($userid)==0){
?>
<div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">

  <div class="layui-form-item">
    <label class="layui-form-label">登录手机</label>
    <div class="layui-input-inline">
      <input type="text" name="mobile" lay-verify="phone" placeholder="请输入号码" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">登录密码</label>
    <div class="layui-input-inline">
      <input type="text" name="passwd" lay-verify="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">真实姓名</label>
    <div class="layui-input-inline">
      <input type="text" name="nickname" lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item cols">
        <label class="layui-form-label">角色组</label>
        <div class="layui-input-block">
            <?php foreach ($role as $k => $v){ ?>
                <input type="radio" name="w_role" value="<?php echo $v['id']; ?>" title="<?php echo $v['r_name']; ?>">
            <?php } ?>
        </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="确认" class="layui-btn layui-btn-normal">
    </div>
  </div>
</div>
<script src="/static/layui.js"></script> 
<script>
  layui.use('form', function(){
    var $ = layui.$,form = layui.form;
		form.render();
		form.on('submit(LAY-user-front-submit)', function(obj){
			var field = obj.field;			
			layui.$.post('?m=index&c=addadmin',field,function(data){
                if(data.role == 'error'){
                    alert('您当前没有操作权限');
                    top.location.href='?m=index&c=index';
                }
				if(data.status==1){
					layer.msg('添加成功', {offset: '15px',icon: 1,time: 1000}, function(){parent.location.reload();});		
				}else{
					layer.msg('操作失败:'+data.msg);
				}
			},'json');
		});
  })
  </script>
 <?php
 }else{
 ?>
<div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
  <div class="layui-form-item">
    <label class="layui-form-label">登录手机</label>
    <div class="layui-input-inline">
      <input type="text" name="mobile" lay-verify="phone" placeholder="请输入号码" value="<?php echo $admin['w_name'];?>" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">登录密码</label>
    <div class="layui-input-inline">
      <input type="text" name="passwd" lay-verify="password" placeholder="不修改请留空" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">真实姓名</label>
    <div class="layui-input-inline">
      <input type="text" name="nickname" lay-verify="required" placeholder="请输入用户名" value="<?php echo $admin['w_nick'];?>"autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item cols">
        <label class="layui-form-label">角色组</label>
        <div class="layui-input-block">
            <?php foreach ($role as $k => $v){ ?>
                <input type="radio" name="w_role" value="<?php echo $v['id']; ?>" title="<?php echo $v['r_name']; ?>" <?php if($v['id'] == $admin['w_role']){ echo 'checked'; }?>>
            <?php } ?>
        </div>
   </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="确认" class="layui-btn layui-btn-normal">
    </div>
  </div>
</div>
<script src="/static/layui.js"></script> 
<script>
  layui.use('form', function(){
    var $ = layui.$,form = layui.form;
		form.render();
		form.on('submit(LAY-user-front-submit)', function(obj){
			var field = obj.field;			
			layui.$.post('?m=index&c=editadmin&id=<?php echo $userid; ?>',field,function(data){
                if(data.role == 'error'){
                    alert('您当前没有操作权限');
                    top.location.href='?m=index&c=index';
                }
				if(data.status==1){
					layer.msg('操作成功', {offset: '15px',icon: 1,time: 1000}, function(){parent.location.reload();});		
				}else{
					layer.msg('操作失败:'+data.msg);
				}
			},'json');
		});
  })
  </script>
<?php
}
?>
</body>
</html>