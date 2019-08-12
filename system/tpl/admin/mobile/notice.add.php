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
    <link rel="stylesheet" href="/kindeditor/themes/default/default.css"/>
    <link rel="stylesheet" href="/kindeditor/plugins/code/prettify.css"/>
    <script charset="utf-8" src="/kindeditor/kindeditor-all-min.js"></script>
    <script charset="utf-8" src="/kindeditor/lang/zh-CN.js"></script>
    <script charset="utf-8" src="/kindeditor/plugins/code/prettify.js"></script>
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    特色产品管理
                </div>
                <div class="layui-card-body">
                    <?php
                    if (intval($n_id) == 0) {
                        ?>
                        <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
                             style="padding:20px 20px 0px 0px;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">标题</label>
                                <div class="layui-input-inline" style="width:600px;">
                                    <input type="text" name="n_title" placeholder="" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item cols">
                                <label class="layui-form-label">缩略图</label>
                                <div class="layui-inline">
                                    <input type="hidden" name="n_img"  id="n_img" value="">
                                    <div class="layui-upload-list">
                                        <img class="w_n_img" id="w_n_img" src="" width="80">
                                    </div>
                                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">描述</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_desc" value="" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">排序</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="n_index" value="0" autocomplete="off"
                                               class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-input-block">
                                    <input type="button" lay-submit lay-filter="LAY-user-front-submit"
                                           id="LAY-user-front-submit" value="确认" class="layui-btn layui-btn-normal">
                                </div>
                            </div>
                        </div>
                        <script src="/static/layui.js"></script>
                        <script>
                            layui.use(['form', 'upload', 'laydate'], function () {
                                var $ = layui.$, form = layui.form, upload = layui.upload;
                                var uploadInst = upload.render({
                                    elem: '#test1'
                                    , url: '?m=config&c=upload'
                                    , done: function (res) {
                                        if (res.code > 0) {
                                            return layer.msg('上传失败');
                                        } else {
                                            $('#w_n_img').attr('src', res.msg);
                                            $('#n_img').val(res.msg);
                                        }
                                    }
                                });
                                form.render();
                                form.on('submit(LAY-user-front-submit)', function (obj) {
                                    var field = obj.field;
                                    layui.$.post('?m=config&c=notice_add', field, function (data) {
                                        if (data.role == 'error') {
                                            alert('您当前没有操作权限');
                                            top.location.href = '?m=index&c=index';
                                        }
                                        if (data.status == 1) {
                                            layer.msg('添加成功', {offset: '15px', icon: 1, time: 1000}, function () {
                                                window.location.href = '?m=config&c=notice';
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
                                <label class="layui-form-label">标题</label>
                                <div class="layui-input-inline" style="width:600px;">
                                    <input type="text" name="n_title" placeholder="" autocomplete="off"
                                           class="layui-input" value="<?php echo $n['n_title']; ?>">
                                </div>
                            </div>
                            <div class="layui-form-item cols">
                                <label class="layui-form-label">缩略图</label>
                                <div class="layui-inline">
                                    <input type="hidden" name="n_img"  id="n_img" value="<?php echo $n['n_img']; ?>">
                                    <div class="layui-upload-list">
                                        <img class="w_n_img" id="w_n_img" src="<?php echo $n['n_img']; ?>" width="80">
                                    </div>
                                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">描述</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_desc" value="<?php echo $n['n_desc']; ?>"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">排序</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_index" value="<?php echo $n['n_index']; ?>"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <input type="button" lay-submit lay-filter="LAY-user-front-submit"
                                           id="LAY-user-front-submit" value="确认" class="layui-btn layui-btn-normal">
                                </div>
                            </div>
                        </div>
                        <script src="/static/layui.js"></script>
                        <script>
                            layui.use(['form', 'upload', 'laydate'], function () {
                                var $ = layui.$, form = layui.form, upload = layui.upload;
                                var uploadInst = upload.render({
                                    elem: '#test1'
                                    , url: '?m=config&c=upload'
                                    , done: function (res) {
                                        if (res.code > 0) {
                                            return layer.msg('上传失败');
                                        } else {
                                            $('#w_n_img').attr('src', res.msg);
                                            $('#n_img').val(res.msg);
                                        }
                                    }
                                });
                                form.render();
                                form.on('submit(LAY-user-front-submit)', function (obj) {
                                    var field = obj.field;
                                    layui.$.post('?m=config&c=notice_edit&id=<?php echo $n_id; ?>', field, function (data) {
                                        if (data.role == 'error') {
                                            alert('您当前没有操作权限');
                                            top.location.href = '?m=index&c=index';
                                        }
                                        if (data.status == 1) {
                                            layer.msg('操作成功', {offset: '15px', icon: 1, time: 1000}, function () {
                                                window.location.href = '?m=config&c=notice';
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
                </div>
            </div>
        </div>
    </div>
</body>
</html>