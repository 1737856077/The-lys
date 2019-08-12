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
    <script>
        KindEditor.ready(function (K) {
            var editor1 = K.create('textarea[name="n_content"]', {
                cssPath: '/kindeditor/plugins/code/prettify.css',
                uploadJson: '/kindeditor/php/upload_json.php',
                fileManagerJson: '/kindeditor/php/file_manager_json.php',
                allowFileManager: true,
                afterBlur: function () {
                    this.sync();
                },
                afterCreate: function () {
                    var self = this;
                    K.ctrl(document, 13, function () {
                        self.sync();
                    });
                    K.ctrl(self.edit.doc, 13, function () {
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
                    文章管理
                </div>
                <div class="layui-card-body">
                    <?php
                    if (intval($n_id) == 0) {
                        ?>
                        <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
                             style="padding:20px 20px 0px 0px;">
                            <!--   <div class="layui-form-item">
                    <label class="layui-form-label">文章分类</label>
                    <div class="layui-input-inline">
                       <select name="n_cate">
                        <?php
                            /*                            foreach($cates as $c){
                                                            echo '<option value="'.$c['id'].'">'.$c['c_name'].'</option>';
                                                        }
                                                    */
                            ?>
                      </select>
                    </div>
                  </div>-->
                            <div class="layui-form-item">
                                <label class="layui-form-label">标题</label>
                                <div class="layui-input-inline" style="width:600px;">
                                    <input type="text" name="n_title" placeholder="" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">发布时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_time" id="n_time"
                                           value="<?php echo date('Y-m-d H:i:s', time()); ?>" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item cols">
                                <label class="layui-form-label">缩略图</label>
                                <div class="layui-inline">
                                    <input type="hidden" name="n_img" id="n_img" value="">
                                    <div class="layui-upload-list">
                                        <img class="w_n_img" id="w_n_img" src="" width="80">
                                    </div>
                                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">详情</label>
                                <div class="layui-input-inline">
                                    <textarea name="n_content"
                                              style='width:700px;height:400px;visibility:hidden;'></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">排序</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_index" value="0" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">阅读</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_read" value="0" autocomplete="off" class="layui-input">
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
                                var $ = layui.$, form = layui.form, upload = layui.upload, laydate = layui.laydate;
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
                                laydate.render({
                                    elem: '#n_time'
                                    , type: 'datetime'
                                });
                                form.render();
                                form.on('submit(LAY-user-front-submit)', function (obj) {
                                    var field = obj.field;
                                    layui.$.post('?m=class&c=class_add', field, function (data) {
                                        if (data.role == 'error') {
                                            alert('您当前没有操作权限');
                                            top.location.href = '?m=index&c=index';
                                        }
                                        if (data.status == 1) {
                                            layer.msg('添加成功', {offset: '15px', icon: 1, time: 1000}, function () {
                                                window.location.href = '?m=class&c=index';
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
                            <!--<div class="layui-form-item">
                    <label class="layui-form-label">文章分类</label>
                    <div class="layui-input-inline">
                       <select name="n_cate">
                        <?php
                            /*                            foreach($cates as $c){
                                                            if($c['id']==$n['n_cate']){
                                                                echo '<option value="'.$c['id'].'" selected>'.$c['c_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$c['id'].'">'.$c['c_name'].'</option>';
                                                            }
                                                        }
                                                    */
                            ?>
                      </select>
                    </div>
                  </div>-->
                            <div class="layui-form-item">
                                <label class="layui-form-label">标题</label>
                                <div class="layui-input-inline" style="width:600px;">
                                    <input type="text" name="n_title" placeholder="" autocomplete="off"
                                           class="layui-input" value="<?php echo $n['n_title']; ?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">发布时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_time" id="n_time"
                                           value="<?php echo date('Y-m-d H:i:s', $n['n_time']); ?>" autocomplete="off"
                                           class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item cols">
                                <label class="layui-form-label">缩略图</label>
                                <div class="layui-inline">
                                    <input type="hidden" name="n_img" id="n_img" value="<?php echo $n['n_img']; ?>">
                                    <div class="layui-upload-list">
                                        <img class="w_n_img" id="w_n_img" src="<?php echo $n['n_img']; ?>" width="80">
                                    </div>
                                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">详情</label>
                                <div class="layui-input-inline">
                                    <textarea name="n_content"
                                              style='width:700px;height:400px;visibility:hidden;'><?php echo $n['n_content']; ?></textarea>
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
                                <label class="layui-form-label">阅读</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="n_read" value="<?php echo $n['n_read']; ?>"
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
                                var $ = layui.$, form = layui.form, upload = layui.upload, laydate = layui.laydate;
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
                                laydate.render({
                                    elem: '#n_time'
                                    , type: 'datetime'
                                });
                                form.render();
                                form.on('submit(LAY-user-front-submit)', function (obj) {
                                    var field = obj.field;
                                    layui.$.post('?m=class&c=class_edit&id=<?php echo $n_id; ?>', field, function (data) {
                                        if (data.role == 'error') {
                                            alert('您当前没有操作权限');
                                            top.location.href = '?m=index&c=index';
                                        }
                                        if (data.status == 1) {
                                            layer.msg('操作成功', {offset: '15px', icon: 1, time: 1000}, function () {
                                                window.location.href = '?m=class&c=index';
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