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
    <style type="text/css">
        .layui-form-switch {
            margin-top: -4px;
        }

        .layui-form-item .layui-input-inline {
            width: auto;
        }

        .layui-form-label {
            width: auto;
        }

        td {
            text-align: center;
        }

    </style>
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    还款配置
                    <div class="layui-form" style="width:250px;float: right;">
                        <div class="layui-form-item">
                            <div class="layui-input-inline">
                                <label class="layui-form-label">阶段</label>
                                <input type="checkbox" name="w_nick" lay-skin="switch" lay-filter="w_nick"
                                       lay-text="开|关" <?php echo $this->config['w_nick']==1?'checked':'' ?>>
                            </div>
                            <!--<div class="layui-input-inline">
                                <label class="layui-form-label">价格</label>
                                <input type="checkbox" name="w_price" lay-skin="switch" lay-filter="w_price"
                                       lay-text="开|关" <?php /*/*echo $this->config['w_price']==1?'checked':''*/?>>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="layui-card-body">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th style="text-align: center">收益回报</th>
                            <th style="text-align: center">级别名称</th>
                            <th style="text-align: center">一单匹配</th>
                            <th style="text-align: center">二单匹配</th>
                            <th style="text-align: center">直推人数(激活要求)</th>
                            <th style="text-align: center">团队人数(激活要求)</th>
                            <th style="text-align: center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $x = 1;
                        foreach ($levels as $l) {
                            ?>
                            <tr>
                                <form name="form_<?php echo $x; ?>" id="form_<?php echo $x; ?>">
                                    <td><?php echo $this->config['w_price_num'] * pow(3, $x); ?>元</td>
                                    <td>
                                        <div class="layui-inline" style="width:120px;">
                                            <input type="text" name="l_name" class="layui-input"
                                                   value="<?php echo $l['l_name']; ?>">
                                        </div>
                                        <div class="layui-inline on-nick"
                                             style="width:120px;<?php echo $this->config['w_nick'] == 1 ? '' : 'display:none' ?>">
                                            <input type="text" name="l_nick" class="layui-input"
                                                   value="<?php echo $l['l_nick']; ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_user1" class="layui-input"
                                                   value="<?php echo $l['l_user1']; ?>">
                                        </div>
                                        阶
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_level1" class="layui-input"
                                                   value="<?php echo $l['l_level1']; ?>">
                                        </div>
                                        级
                                    </td>
                                    <td>
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_user2" class="layui-input"
                                                   value="<?php echo $l['l_user2']; ?>">
                                        </div>
                                        阶
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_level2" class="layui-input"
                                                   value="<?php echo $l['l_level2']; ?>">
                                        </div>
                                        级
                                    </td>
                                    <td>
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_tnum" class="layui-input"
                                                   value="<?php echo $l['l_tnum']; ?>">
                                        </div>
                                        人
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_tlevel" class="layui-input"
                                                   value="<?php echo $l['l_tlevel']; ?>">
                                        </div>
                                        级
                                    </td>
                                    <td>
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_znum" class="layui-input"
                                                   value="<?php echo $l['l_znum']; ?>">
                                        </div>
                                        人
                                        <div class="layui-inline" style="width:50px;">
                                            <input type="text" name="l_zlevel" class="layui-input"
                                                   value="<?php echo $l['l_zlevel']; ?>">
                                        </div>
                                        级
                                    </td>
                                    <td>
                                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="charge"
                                           href="javascript:save_level(<?php echo $x; ?>);">保存</a>
                                    </td>
                                </form>
                            </tr>
                            <?php
                            $x++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/layui.js"></script>
<script>
    var $;
    layui.use(['form', 'upload', 'element'], function () {
        $ = layui.$, form = layui.form, element = layui.element;
        form.render();
        form.on('switch(w_nick)', function (data) {
            var switch_val = this.checked ? 1 : 0;
            if (switch_val) {
                $('.on-nick').show();
            } else {
                $('.on-nick').hide();
            }
            layui.$.post('?m=config&c=switchlevel', {'w_nick': switch_val}, function (data) {
                if (data.role == 'error') {
                    alert('您当前没有操作权限');
                    top.location.href = '?m=index&c=index';
                }
                if (data.status == 1) {
                    layer.msg('设置成功', {offset: '15px', icon: 1, time: 1000});
                } else {
                    layer.msg('操作失败:' + data.msg);
                }
            }, 'json');
        });
        form.on('switch(w_price)', function (data) {
            var switch_val = this.checked ? 1 : 0;
            if (switch_val) {
                $('.on-price').show();
            } else {
                $('.on-price').hide();
            }
            layui.$.post('?m=config&c=switchlevel', {'w_price': switch_val}, function (data) {
                if (data.role == 'error') {
                    alert('您当前没有操作权限');
                    top.location.href = '?m=index&c=index';
                }
                if (data.status == 1) {
                    layer.msg('设置成功', {offset: '15px', icon: 1, time: 1000});
                } else {
                    layer.msg('操作失败:' + data.msg);
                }
            }, 'json');
        });
    });

    function save_level(id) {
        var form = document.querySelector('#form_' + id);
        var formdata = new FormData(form);
        formdata.append("id", id);
        var xhr = new XMLHttpRequest();
        xhr.open("post", "?m=config&c=save_level");
        xhr.send(formdata);
        xhr.onload = function (res) {
            console.log(res)
            if (xhr.role == 'error') {
                alert('您当前没有操作权限');
                top.location.href = '?m=index&c=index';
            }
            if (xhr.status == 200) {
                alert('设置成功');
            }
        }
    }
</script>
</body>
</html>