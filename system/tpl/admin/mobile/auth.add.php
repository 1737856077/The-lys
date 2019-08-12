<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME; ?> - <?php echo WEBDESC; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/css/layui.css">
    <link rel="stylesheet" href="/static/css/main.css">
</head>
<body>
<?php
if (intval($auth_id) == 0) {
    ?>
    <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
         style="padding:20px 20px 0px 0px;">
        <div class="layui-form-item">
            <label class="layui-form-label">父节点</label>
            <div class="layui-input-inline">
                <select name="a_pid">
                    <option value="0">顶级节点</option>
                    <?php
                    foreach($auth as $k=>$v){
                        echo '<option value="'.$v['id'].'">'.$v['a_name'].'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限名称</label>
            <div class="layui-input-inline">
                <input type="text" name="a_name" placeholder="请输入权限名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">控制器</label>
            <div class="layui-input-inline">
                <input type="text" name="a_ctl" placeholder="请输入控制器" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">方法</label>
            <div class="layui-input-inline">
                <input type="text" name="a_fun" placeholder="请输入方法" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="确认"
                       class="layui-btn layui-btn-normal">
            </div>
        </div>
    </div>
    <script src="/static/layui.js"></script>
    <script>
        layui.use('form', function () {
            var $ = layui.$, form = layui.form;
            form.render();
            form.on('submit(LAY-user-front-submit)', function (obj) {
                var field = obj.field;
                layui.$.post('?m=index&c=auth_add', field, function (data) {
                    if(data.role == 'error'){
                        alert('您当前没有操作权限');
                        top.location.href='?m=index&c=index';
                    }
                    if (data.status == 1) {
                        layer.msg('添加成功', {offset: '15px', icon: 1, time: 1000}, function () {
                            parent.location.reload();
                        });
                    } else {
                        layer.msg('操作失败:' + data.msg);
                    }
                }, 'json');
            });
        })
    </script>
<?php
}else{
?>
    <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
         style="padding:20px 20px 0px 0px;">
        <div class="layui-form-item">
            <label class="layui-form-label">权限名称</label>
            <div class="layui-input-inline">
                <input type="text" name="a_name" placeholder="请输入权限名称" autocomplete="off"
                       value="<?php echo $auth['a_name']; ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">控制器</label>
            <div class="layui-input-inline">
                <input type="text" name="a_ctl" placeholder="请输入控制器" autocomplete="off"
                       value="<?php echo $auth['a_ctl']; ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">方法</label>
            <div class="layui-input-inline">
                <input type="text" name="a_fun" placeholder="请输入方法" autocomplete="off"
                       value="<?php echo $auth['a_fun']; ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="确认"
                       class="layui-btn layui-btn-normal">
            </div>
        </div>
    </div>
    <script src="/static/layui.js"></script>
    <script>
        layui.use('form', function () {
            var $ = layui.$, form = layui.form;
            form.render();
            form.on('submit(LAY-user-front-submit)', function (obj) {
                var field = obj.field;
                layui.$.post('?m=index&c=auth_edit&id=<?php echo $auth_id; ?>', field, function (data) {
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
    <?php
}
?>
</body>
</html>