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
<link rel="stylesheet" href="/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="/kindeditor/lang/zh-CN.js"></script>
<script charset="utf-8" src="/kindeditor/plugins/code/prettify.js"></script>
<script>
    KindEditor.ready(function(K) {
        var editor1 = K.create('textarea[name="n_content"]', {
            cssPath : '/kindeditor/plugins/code/prettify.css',
            uploadJson : '/kindeditor/php/upload_json.php',
            fileManagerJson : '/kindeditor/php/file_manager_json.php',
            allowFileManager : true,
						afterBlur: function () { this.sync(); },
            afterCreate : function() {
                var self = this;
                K.ctrl(document, 13, function() {
                    self.sync();
                });
                K.ctrl(self.edit.doc, 13, function() {
                    self.sync();
                });
            }
        });
        prettyPrint();
    });
</script>
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">
         	  信息编辑
          </div>
            <div class="layui-card-body">
                <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
                  <div class="layui-form-item">
                    <div class="layui-input-inline">
                      <textarea name="n_content" style='width:720px;height:600px;visibility:hidden;'><?php echo $about['n_content'];?></textarea>
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
                        form.render();
                        form.on('submit(LAY-user-front-submit)', function(obj){
                            var field = obj.field;			
                            layui.$.post('?m=config&c=about&id=<?php echo $about['id'];?>',field,function(data){
                                if(data.role == 'error'){
                                    alert('您当前没有操作权限');
                                    top.location.href='?m=index&c=index';
                                }
                                if(data.status==1){
                                    layer.msg('修改成功', {offset: '15px',icon: 1,time: 1000}, function(){
																			window.location.href='?m=config&c=about&id=<?php echo $about['id'];?>';
																		});		
                                }else{
                                    layer.msg('操作失败:'+data.msg);
                                }
                            },'json');
                        });
                  })
                  </script>
                 
                </div>
    </div>
  </div>
  </div>
</div>
</body>
</html>