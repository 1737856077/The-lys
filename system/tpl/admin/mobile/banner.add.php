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
	if(intval($b_id)==0){
?>
<div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
  <div class="layui-form-item">
    <label class="layui-form-label">图片位置</label>
    <div class="layui-input-inline">
       <select name="b_pos">
        <?php
            foreach($cates as $k=>$v){
                echo '<option value="'.$k.'">'.$v.'</option>';
            }
        ?>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">图片名称</label>
    <div class="layui-input-inline">
      <input type="text" name="b_name" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">链接地址</label>
    <div class="layui-input-inline">
      <input type="text" name="b_link" placeholder="http://" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">轮播图片</label>
    <div class="layui-input-inline">
      <input type="text" name="b_img" autocomplete="off" class="layui-input" id="b_img">
      <div class="layui-upload">
      <button type="button" class="layui-btn" id="test1">上传图片</button>
      </div>
   </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">排序</label>
    <div class="layui-input-inline">
      <input type="text" name="b_index" value="0" autocomplete="off" class="layui-input">
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
  layui.use(['form','upload'],function(){
      var $ = layui.$, form = layui.form, upload = layui.upload;
	  var uploadInst = upload.render({
		elem: '#test1'
		,url: '?m=config&c=upload'
		,done: function(res){
		  if(res.code > 0){
			return layer.msg('上传失败');
		  }else{
		  	$('#b_img').val(res.msg);
		  }
		}
	  });
		form.render();
		form.on('submit(LAY-user-front-submit)', function(obj){
			var field = obj.field;
			if(field['b_pos']<1){
				alert('请选择图片位置');
				return;
			}
			layui.$.post('?m=config&c=banner_add',field,function(data){
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
    <label class="layui-form-label">图片位置</label>
    <div class="layui-input-inline">
       <select name="b_pos">
        <?php
            foreach($cates as $k=>$v){
				if($banner['b_pos']==$k){
                	echo '<option value="'.$k.'" selected>'.$v.'</option>';
				}else{
                	echo '<option value="'.$k.'">'.$v.'</option>';
				}
            }
        ?>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">图片名称</label>
    <div class="layui-input-inline">
      <input type="text" name="b_name" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $banner['b_name'];?>">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">链接地址</label>
    <div class="layui-input-inline">
      <input type="text" name="b_link" placeholder="http://" autocomplete="off" class="layui-input" value="<?php echo $banner['b_link'];?>">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">轮播图片</label>
    <div class="layui-input-inline">
      <input type="text" name="b_img" autocomplete="off" class="layui-input" id="b_img" value="<?php echo $banner['b_img'];?>">
      <div class="layui-upload">
      <button type="button" class="layui-btn" id="test1">上传图片</button>
      </div>
   </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">排序</label>
    <div class="layui-input-inline">
      <input type="text" name="b_index" value="0" autocomplete="off" class="layui-input" value="<?php echo $banner['b_index'];?>">
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
  layui.use(['form','upload'],function(){
      var $ = layui.$, form = layui.form, upload = layui.upload;
	  var uploadInst = upload.render({
		elem: '#test1'
		,url: '?m=config&c=upload'
		,done: function(res){
		  if(res.code > 0){
			return layer.msg('上传失败');
		  }else{
		  	$('#b_img').val(res.msg);
		  }
		}
	  });
  
	form.render();
	form.on('submit(LAY-user-front-submit)', function(obj){
		var field = obj.field;			
		layui.$.post('?m=config&c=banner_edit&id=<?php echo $b_id; ?>',field,function(data){
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