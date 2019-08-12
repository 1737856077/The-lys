<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME; ?> - <?php echo WEBDESC; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/css/layui.css">
    <link rel="stylesheet" href="/static/css/main.css">
</head>
<body>
<div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding:20px 20px 0px 0px;">
    <div class="layui-form-item">
        <label class="layui-form-label">选择菜单</label>
        <div class="layui-input-inline">
            <select name="s_id">
                <?php
                foreach ($styles as $v) {
                        echo '<option value="' . $v['s_id'] . '">' . $v['s_name'] . '</option>';
                }
                ?>
            </select>
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
    layui.use(['form','upload'], function () {
      var $ = layui.$, form = layui.form, upload = layui.upload;
        form.render();
        form.on('submit(LAY-user-front-submit)', function (obj) {
            var field = obj.field;
            layui.$.post('?m=config&c=add_menu', field, function (data) {
                if(data.role == 'error'){
                    alert('您当前没有操作权限');
                    top.location.href='?m=index&c=index';
                }
                if (data.status == 1) {
                    layer.msg('操作成功', {offset: '15px', icon: 1, time: 1000}, function () {
                        parent.location.reload();
                    });
                } else {
                    layer.msg('操作失败:' + data.msg);
                }
            }, 'json');
        });
    })
</script>
</body>
</html>