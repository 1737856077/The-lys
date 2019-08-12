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
if (intval($userid) == 0) {
    ?>
    <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
         style="padding:20px 20px 0px 0px;">
        <div class="layui-form-item">
            <label class="layui-form-label">推荐人ID</label>
            <div class="layui-input-inline">
                <input type="text" name="m_tid" placeholder="请输入推荐人ID" autocomplete="off" class="layui-input">
            </div>
        </div>
        <?php
        if (($this->config['w_frame'] == 1 && $this->config['w_hualuo'] == 1) || $this->config['w_frame'] > 1) {
            ?>
            <div class="layui-form-item">
                <label class="layui-form-label">节点人ID</label>
                <div class="layui-input-inline">
                    <input type="text" name="m_pid" placeholder="请输入节点人ID" autocomplete="off" class="layui-input">
                </div>
            </div>
            <?php
        }
        ?>
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="m_name" placeholder="请输入真实姓名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-inline">
                <input type="radio" name="m_gender" value="0" title="未知" checked>
                <input type="radio" name="m_gender" value="1" title="男">
                <input type="radio" name="m_gender" value="2" title="女">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登录手机</label>
            <div class="layui-input-inline">
                <input type="text" name="m_phone" lay-verify="phone" placeholder="请输入登录手机" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登录密码</label>
            <div class="layui-input-inline">
                <input type="text" name="m_pass" lay-verify="password" placeholder="请输入登录密码" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">会员级别</label>
            <div class="layui-input-inline">
                <select name="m_level">
                    <?php
                    foreach ($u_levels as $k => $v) {
                        echo '<option value="' . $k . '">' . $v . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-inline">
                <input type="text" name="m_avatar" autocomplete="off" class="layui-input" id="m_avatar">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="test2">上传图片</button>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">个人简介</label>
            <div class="layui-inline" style="width:200px;">
                <textarea name="m_infos" placeholder="60字以内" class="layui-textarea"></textarea>
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
        layui.use(['form', 'upload'], function () {
            var $ = layui.$, form = layui.form, upload = layui.upload;
            form.render();
            form.on('submit(LAY-user-front-submit)', function (obj) {
                var field = obj.field;
                layui.$.post('?m=user&c=add_user', field, function (data) {
                    if (data.status == 1) {
                        layer.msg('添加成功', {offset: '15px', icon: 1, time: 1000}, function () {
                            parent.location.reload();
                        });
                    } else {
                        layer.msg('操作失败:' + data.msg);
                    }
                }, 'json');
            });
            upload.render({
                elem: '#test1'
                , url: '?m=config&c=upload'
                , done: function (res) {
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    } else {
                        $('#m_qrcode').val(res.msg);
                    }
                }
            });
            upload.render({
                elem: '#test2'
                , url: '?m=config&c=upload'
                , done: function (res) {
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    } else {
                        $('#m_avatar').val(res.msg);
                    }
                }
            });
        })
    </script>
<?php
}else{
?>
    <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
         style="padding:20px 20px 0px 0px;">
        <div class="layui-form-item">
            <label class="layui-form-label">推荐人ID</label>
            <div class="layui-input-inline">
                <input type="text" name="m_tid" placeholder="请输入推荐人ID" autocomplete="off" class="layui-input"
                       value="<?php echo $member['m_tid']; ?>">
            </div>
        </div>
        <?php
        if (($this->config['w_frame'] == 1 && $this->config['w_hualuo'] == 1) || $this->config['w_frame'] > 1) {
            ?>
            <div class="layui-form-item">
                <label class="layui-form-label">节点人ID</label>
                <div class="layui-input-inline">
                    <input type="text" name="m_pid" placeholder="请输入节点人ID" autocomplete="off" class="layui-input"
                           value="<?php echo $member['m_pid']; ?>">
                </div>
            </div>
            <?php
        }
        ?>
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="m_name" placeholder="请输入真实姓名" autocomplete="off" class="layui-input"
                       value="<?php echo $member['m_name']; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-inline">
                <input type="radio" name="m_gender" value="0"
                       title="未知" <?php echo $member['m_gender'] == 0 ? 'checked' : '' ?>>
                <input type="radio" name="m_gender" value="1"
                       title="男" <?php echo $member['m_gender'] == 1 ? 'checked' : '' ?>>
                <input type="radio" name="m_gender" value="2"
                       title="女" <?php echo $member['m_gender'] == 2 ? 'checked' : '' ?>>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登录手机</label>
            <div class="layui-input-inline">
                <input type="text" name="m_phone" lay-verify="phone" placeholder="请输入登录手机" autocomplete="off"
                       class="layui-input" value="<?php echo $member['m_phone']; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登录密码</label>
            <div class="layui-input-inline">
                <input type="text" name="m_pass" lay-verify="password" placeholder="不修改请留空" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">会员级别</label>
            <div class="layui-input-inline">
                <select name="m_level">
                    <?php
                    foreach ($u_levels as $k => $v) {
                        if ($member['m_level'] == $k) {
                            echo '<option value="' . $k . '" selected>' . $v . '</option>';
                        } else {
                            echo '<option value="' . $k . '">' . $v . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-inline">
                <input type="text" name="m_avatar" autocomplete="off" class="layui-input" id="m_avatar"
                       value="<?php echo $member['m_avatar']; ?>">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="test2">上传图片</button>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">个人简介</label>
            <div class="layui-inline" style="width:200px;">
                <textarea name="m_infos" placeholder="60字以内"
                          class="layui-textarea"><?php echo $member['m_infos']; ?></textarea>
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
        layui.use(['form', 'upload'], function () {
            var $ = layui.$, form = layui.form, upload = layui.upload;
            upload.render({
                elem: '#test1'
                , url: '?m=config&c=upload'
                , done: function (res) {
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    } else {
                        $('#m_qrcode').val(res.msg);
                    }
                }
            });
            upload.render({
                elem: '#test2'
                , url: '?m=config&c=upload'
                , done: function (res) {
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    } else {
                        $('#m_avatar').val(res.msg);
                    }
                }
            });
            form.render();
            form.on('submit(LAY-user-front-submit)', function (obj) {
                var field = obj.field;
                layui.$.post('?m=user&c=edit_user&id=<?php echo $userid; ?>', field, function (data) {
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