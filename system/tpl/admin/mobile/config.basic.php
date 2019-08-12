<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo WEBNAME; ?>-<?php echo WEBDESC; ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/css/layui.css">
    <link rel="stylesheet" href="/static/css/main.css">
    <style type="text/css">
        .layui-icon {
            margin-right: 0px
        }
    </style>
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body">
                    <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                        <div class="layui-tab">
                            <ul class="layui-tab-title">
                                <li class="layui-this">站点设置</li>
                                <li>会员设置</li>
<!--                                <li>评分系统</li>-->
                                <li>客服设置</li>
                                <li>APP设置</li>
                            </ul>
                            <div class="layui-tab-content">
                                <div class="layui-tab-item layui-show">
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">系统名称</label>
                                        <div class="layui-inline" style="width:600px;">
                                            <input type="text" name="w_name" class="layui-input"
                                                   value="<?php echo $config['w_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">系统LOGO</label>
                                        <div class="layui-inline">
                                            <input type="hidden" name="w_logo" id="w_logo"
                                                   value="<?php echo $config['w_logo']; ?>">
                                            <div class="layui-upload-list"><img class="w_logo_img" id="w_logo_img"
                                                                                src="<?php echo $config['w_logo']; ?>"
                                                                                width="80"></div>
                                            <button type="button" class="layui-btn" id="w_logo_btn">上传图片</button>
                                        </div>
                                    </div>
                                    <!-- <div class="layui-form-item cols">
                    <div class="layui-inline">
                      <label class="layui-form-label">系统主色</label>
                      <div class="layui-input-inline">
                        <input type="hidden" name="w_color1" value="<?php /*echo $config['w_color1'];*/ ?>" id="w_color1">
                        <div id="w_color_btn1"></div>
                      </div>
                    </div>
                    <div class="layui-inline">
                      <label class="layui-form-label">系统辅色</label>
                      <div class="layui-input-inline">
                        <input type="hidden" name="w_color2" value="<?php /*echo $config['w_color2'];*/ ?>" id="w_color2">
                        <div id="w_color_btn2"></div>
                      </div>
                    </div>
                  </div>
                  <div class="layui-form-item cols">
                    <label class="layui-form-label">首页板式</label>
                    <div class="layui-inline">
                      <input type="radio" name="w_temp" value="2" title="双列" <?php echo $config['w_temp'] == 2 ? 'checked' : '' ?>>
                      <input type="radio" name="w_temp" value="3" title="三列" <?php echo $config['w_temp'] == 3 ? 'checked' : '' ?>>
                      <input type="radio" name="w_temp" value="4" title="四列" <?php echo $config['w_temp'] == 4 ? 'checked' : '' ?>>
                    </div>
                  </div>-->
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">匹配模式</label>
                                        <div class="layui-inline">
                                            <input type="radio" name="w_pattern" value="1"
                                                   title="基础模式" <?php echo $config['w_pattern'] == 1 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_pattern" value="2"
                                                   title="加强模式" <?php echo $config['w_pattern'] == 2 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_pattern" value="3"
                                                   title="无敌模式" <?php echo $config['w_pattern'] == 3 ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">价格设置</label>
                                        <div class="layui-inline" style="width:250px;">
                                            <input type="text" name="w_price_num" class="layui-input"
                                                   value="<?php echo $config['w_price_num']; ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <div class="layui-inline">
                                            <label class="layui-form-label">系统账户1</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="w_user" class="layui-input"
                                                       value="<?php echo $config['w_user']; ?>">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">系统账户2</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="w_user2" class="layui-input"
                                                       value="<?php echo $config['w_user2']; ?>">
                                            </div>
                                            <label class="layui-form-label-col">找不到匹配人时默认匹配该账户ID</label>
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">自动清理</label>
                                        <div class="layui-inline">
                                            <div class="layui-input-inline">
                                                <input type="text" name="w_hour" class="layui-input"
                                                       value="<?php echo $config['w_hour']; ?>">
                                            </div>
                                            <label class="layui-form-label-col">小时内不升级将被清理</label>
                                        </div>
                                    </div>

                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">描述</label>
                                        <div class="layui-inline">
                                            <div class="layui-input-inline" style="width:600px;">
                                                <textarea name="w_notice" placeholder=""
                                                          class="layui-textarea"><?php echo $config['w_notice']; ?></textarea>
                                            </div>
                                            <label class="layui-form-label-col">邀请好友处描述方案,多条请以'|'号分割</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="layui-tab-item">
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">阶段设置</label>
                                        <div class="layui-inline">
                                            <input type="radio" name="w_level" value="7"
                                                   title="7阶" <?php echo $config['w_level'] == 7 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_level" value="9"
                                                   title="9阶" <?php echo $config['w_level'] == 9 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_level" value="11"
                                                   title="11阶" <?php echo $config['w_level'] == 11 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_level" value="13"
                                                   title="13阶" <?php echo $config['w_level'] == 13 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_level" value="15"
                                                   title="15阶" <?php echo $config['w_level'] == 15 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_level" value="20"
                                                   title="20阶" <?php echo $config['w_level'] == 20 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_level" value="30"
                                                   title="30阶" <?php echo $config['w_level'] == 30 ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">排列架构</label>
                                        <div class="layui-inline">
                                            <input type="radio" name="w_frame" value="1"
                                                   title="无限直推" <?php echo $config['w_frame'] == 1 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_frame" value="3"
                                                   title="三三复制" <?php echo $config['w_frame'] == 3 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_frame" value="4"
                                                   title="四四复制" <?php echo $config['w_frame'] == 4 ? 'checked' : '' ?>>
                                            <input type="radio" name="w_frame" value="5"
                                                   title="五五复制" <?php echo $config['w_frame'] == 5 ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">自动滑落</label>
                                        <div class="layui-inline">
                                            <input type="radio" name="w_hualuo" value="0"
                                                   title="跟随系统" <?php echo $config['w_hualuo'] == 0 ? 'checked' : '' ?>
                                                   lay-filter="w_hualuo">
                                            <input type="radio" name="w_hualuo" value="1"
                                                   title="首层滑落" <?php echo $config['w_hualuo'] == 1 ? 'checked' : '' ?>
                                                   lay-filter="w_hualuo">
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols" id="w_hualuo_line"
                                         style=" <?php echo $config['w_hualuo'] == 0 ? 'display:none' : ''; ?>">
                                        <div class="layui-inline">
                                            <label class="layui-form-label">滑落数量</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="w_huanum" class="layui-input"
                                                       value="<?php echo $config['w_huanum']; ?>">
                                            </div>
                                            <label class="layui-form-label-col">每个会员最多接受滑落数量</label>
                                        </div>
                                    </div>

                                    <div class="layui-form-item">
                                        <label class="layui-form-label">最低级别</label>
                                        <div class="layui-input-inline" style="width:180px;">
                                            <select name="w_hlevel" lay-verify="required">
                                                <option value="0">普通会员</option>
                                                <?php
                                                foreach ($levels as $lv) {
                                                    if ($lv['id'] == $config['w_hlevel']) {
                                                        echo '<option value="' . $lv['id'] . '" selected>' . $lv['l_name'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $lv['id'] . '">' . $lv['l_name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="layui-form-label-col">大于等于该级别才可接受滑落</label>
                                    </div>
                                </div>

                                <div class="layui-tab-item">
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">客服名称</label>
                                        <div class="layui-inline" style="width:200px;">
                                            <input type="text" name="w_kefu" class="layui-input"
                                                   value="<?php echo $config['w_kefu']; ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">联系方式</label>
                                        <div class="layui-inline" style="width:200px;">
                                            <input type="text" name="w_tel" class="layui-input"
                                                   value="<?php echo $config['w_tel']; ?>">
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">客服二维码</label>
                                        <div class="layui-inline">
                                            <input type="hidden" name="w_linecode" id="w_linecode"
                                                   value="<?php echo $config['w_linecode']; ?>">
                                            <div class="layui-upload-list"><img class="w_linecode_img"
                                                                                id="w_linecode_img"
                                                                                src="<?php echo $config['w_linecode']; ?>"
                                                                                width="80"></div>
                                            <button type="button" class="layui-btn" id="w_linecode_btn">上传图片</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-tab-item">
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">IOS图标</label>
                                        <div class="layui-inline">
                                            <input type="hidden" name="w_icon" id="w_icon"
                                                   value="<?php echo $config['w_icon']; ?>">
                                            <div class="layui-upload-list"><img class="w_icon_img" id="w_icon_img"
                                                                                src="<?php echo $config['w_icon']; ?>"
                                                                                width="80"></div>
                                            <button type="button" class="layui-btn" id="w_icon_btn">上传图片</button>
                                        </div>
                                    </div>

                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">升级海报</label>
                                        <div class="layui-inline">
                                            <input type="hidden" name="w_uphb" id="w_uphb"
                                                   value="<?php echo $config['w_uphb']; ?>">
                                            <div class="layui-upload-list"><img class="w_uphb_img" id="w_uphb_img"
                                                                                src="<?php echo $config['w_uphb']; ?>"
                                                                                width="80"></div>
                                            <button type="button" class="layui-btn" id="w_uphb_btn">上传图片</button>
                                        </div>
                                    </div>

                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">推广海报</label>
                                        <div class="layui-inline">
                                            <input type="hidden" name="w_yqhb" id="w_yqhb"
                                                   value="<?php echo $config['w_yqhb']; ?>">
                                            <div class="layui-upload-list"><img class="w_yqhb_img" id="w_yqhb_img"
                                                                                src="<?php echo $config['w_yqhb']; ?>"
                                                                                width="80"></div>
                                            <button type="button" class="layui-btn" id="w_yqhb_btn">上传图片</button>
                                        </div>
                                    </div>
                                    <div class="layui-form-item cols">
                                        <label class="layui-form-label">App下载</label>
                                        <div class="layui-inline" style="width:600px;">
                                            <input type="text" name="w_down1" class="layui-input"
                                                   value="<?php echo $config['w_down1']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="button" lay-submit lay-filter="LAY-user-front-submit"
                                       id="LAY-user-front-submit" value="保存设置" class="layui-btn layui-btn-normal">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/layui.js"></script>
<script>
    layui.use(['form', 'upload', 'element', 'colorpicker'], function () {
        var $ = layui.$, form = layui.form, upload = layui.upload, element = layui.element,
            colorpicker = layui.colorpicker;
        //开启全功能
        colorpicker.render({
            elem: '#w_color_btn1',
            color: '<?php echo $config['w_color1'];?>',
            format: 'rgb',
            predefine: true,
            alpha: true,
            done: function (color) {
                $('#w_color1').val(color);
            }
        });
        colorpicker.render({
            elem: '#w_color_btn2',
            color: '<?php echo $config['w_color2'];?>',
            format: 'rgb',
            predefine: true,
            alpha: true,
            done: function (color) {
                $('#w_color2').val(color);
            }
        });
        form.render();
        form.on('submit(LAY-user-front-submit)', function (obj) {
            var field = obj.field;
            layui.$.post('?m=config&c=basic', field, function (data) {
                if (data.role == 'error') {
                    alert('您当前没有操作权限');
                    top.location.href = '?m=index&c=index';
                }
                if (data.status == 1) {
                    layer.msg('设置成功', {offset: '15px', icon: 1, time: 1000}, function () {
                        location.reload();
                    });
                } else {
                    layer.msg('操作失败:' + data.msg);
                }
            }, 'json');
        });
        form.on('submit(ck_save_user)', function (obj) {
            layui.$.post('?m=config&c=save_credit', {type: 1}, function (data) {
                if (data.role == 'error') {
                    alert('您当前没有操作权限');
                    top.location.href = '?m=index&c=index';
                }
                if (data.status == 1) {
                    layer.msg('设置成功', {offset: '15px', icon: 1, time: 1000}, function () {
                        location.reload();
                    });
                } else {
                    layer.msg('操作失败:' + data.msg);
                }
            }, 'json');
        });
        form.on('radio(w_hualuo)', function (data) {
            console.log(data);
            if (data.value == 1) {
                $('#w_hualuo_line').show();
            } else {
                $('#w_hualuo_line').hide();
            }
            form.render();
        });
        upload.render({
            elem: '#w_logo_btn'
            , url: '?m=config&c=upload'
            , before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#w_logo_img').attr('src', result);
                });
            }
            , done: function (res) {
                if (res.code > 0) {
                    return layer.msg('上传失败');
                } else {
                    $('#w_logo').val(res.msg);
                }
            }
        });
        upload.render({
            elem: '#w_linecode_btn'
            , url: '?m=config&c=upload'
            , before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#w_linecode_img').attr('src', result);
                });
            }
            , done: function (res) {
                if (res.code > 0) {
                    return layer.msg('上传失败');
                } else {
                    $('#w_linecode').val(res.msg);
                }
            }
        });
        upload.render({
            elem: '#w_icon_btn'
            , url: '?m=config&c=upload'
            , before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#w_icon_img').attr('src', result);
                });
            }
            , done: function (res) {
                if (res.code > 0) {
                    return layer.msg('上传失败');
                } else {
                    $('#w_icon').val(res.msg);
                }
            }
        });

        upload.render({
            elem: '#w_uphb_btn'
            , url: '?m=config&c=upload'
            , before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#w_uphb_img').attr('src', result);
                });
            }
            , done: function (res) {
                if (res.code > 0) {
                    return layer.msg('上传失败');
                } else {
                    $('#w_uphb').val(res.msg);
                }
            }
        });

        upload.render({
            elem: '#w_yqhb_btn'
            , url: '?m=config&c=upload'
            , before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#w_yqhb_img').attr('src', result);
                });
            }
            , done: function (res) {
                if (res.code > 0) {
                    return layer.msg('上传失败');
                } else {
                    $('#w_yqhb').val(res.msg);
                }
            }
        });
    });


</script>
</body>
</html>
