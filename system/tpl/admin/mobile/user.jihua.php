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
    <link rel="stylesheet" href="/static/css/login.css">
</head>

<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    借款计划
                </div>
                <div class="layui-card-body">
                    <div class="layui-form" lay-filter="lay-search" id="lay-search">
                        <div class="layui-inline">
                            <label class="layui-form-label-col" style="float:left">
                                搜索：</label>
                            <div class="layui-input-inline" style="width:200px;">
                                <input type="text" name="n_id" placeholder="用户ID" autocomplete="off"
                                       class="layui-input">
                            </div>
                            <div class="layui-input-inline" style="width: 200px;">
                                <input type="text" name="c_time" class="layui-input" id="test10" placeholder="激活时间">
                            </div>
                            <div class="layui-input-inline" style="width: 200px;">
                                <input type="text" name="d_time" class="layui-input" id="test11" placeholder="完成时间">
                            </div>
                            <div class="layui-input-inline" style="width: 120px;">
                                <select name="status">
                                    <option value=""></option>
                                    <?php
                                        foreach ($status as $k => $v) {
                                            echo '<option value="' . $k . '">' . $v . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="layui-input-inline" style="width: 120px;">
                                <button class="layui-btn layui-btn-sm layui-btn-normal" id="do_searh" lay-submit lay-filter="do_searh">搜索
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="layui-hide" id="test" lay-filter="test"></table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/html" id="barDemo">
        {{# if(d.j_status == '0'){ }}
            <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="edit">审核</a>
        {{# } }}
        {{# if(d.j_status != '1'){ }}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        {{# } }}
    </script>
</div>
<style>
    tr td .layui-table-cell {
        height: auto;
        font-size: 12px;
    }
</style>
</body>
<script src="/static/layui.js"></script>
<script>
    layui.use(['element', 'layer', 'form', 'table', 'laydate'], function () {
        var element = layui.element;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var laydate = layui.laydate;
        var layCharge = 0;
        laydate.render({elem: '#test10', type: 'datetime', range: true});
        laydate.render({elem: '#test11', type: 'datetime', range: true});
        table.render({
            elem: '#test'
            , url: '?m=user&c=jh_data'
            , cellMinheight: 80
            , height: 'full-110'
            , limit: 20
            , cols: [[
                {field: 'j_id', title: 'ID', width: 100, unresize: true,align:'center'}
                , {field: 'u_user', title: '会员信息', width: 200,align:'center'}
                , {field: 'j_type_name', title: '借款类型',align:'center'}
                , {field: 'j_bor_img', title: '借款凭证',align:'center'}
                , {field: 'j_sta_name', title: '状态',align:'center'}
                , {field: 'j_price', title: '金额',align:'center'}
                , {field: 'j_ctime', title: '申请时间',align:'center'}
                , {field: 'j_dtime', title: '完成时间',align:'center'}
                , {width: 180, align: 'center', toolbar: '#barDemo', title: '操作'}
            ]]
            , page: true
        });
        table.on('tool(test)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('删除后无法恢复，确定删除？', function (index) {
                    var j_id = data.j_id;
                    layui.$.post('?m=user&c=del_jihua', {'j_id': j_id}, function (retmsg) {
                        if (retmsg.role == 'error') {
                            alert('您当前没有操作权限');
                            top.location.href = '?m=index&c=index';
                        }
                        if (parseInt(retmsg.code) == 1) {
                            layer.msg(retmsg.msg);
                            obj.del();
                        } else {
                            layer.msg(retmsg.msg);
                        }
                    }, 'json');
                    layer.close(index);
                });
            } else if (obj.event === 'edit') {
                var j_id = data.j_id;
                layui.$.post('?m=user&c=shen_jihua', {'j_id': j_id}, function (retmsg) {
                    if (retmsg.role == 'error') {
                        alert('您当前没有操作权限');
                        top.location.href = '?m=index&c=index';
                    }
                    if (parseInt(retmsg.code) == 1) {
                        layer.msg(retmsg.msg);
                        obj.update({status: '<a class="layui-btn layui-btn-normal layui-btn-xs">已审核</a>'});
                        setTimeout(function () {
                            window.location.reload();
                        }, '1000')
                    } else {
                        layer.msg(retmsg.msg);
                    }
                }, 'json');
            }
        });
        form.on('submit(do_searh)', function (obj) {
            var field = obj.field;
            var url = '?m=user&c=jh_data&n_id=' + field.n_id + '&c_time=' + encodeURI(field.c_time) + '&d_time=' + encodeURI(field.d_time) + '&status=' + field.status + '&level=' + field.level;
            var tableIns = table.render({
                elem: '#test'
                , url: url
                , cellMinheight: 80
                , limit: 20
                , cols: [[
                    {field: 'j_id', title: 'ID', width: 100, unresize: true,align:'center'}
                    , {field: 'u_user', title: '会员信息', width: 200,align:'center'}
                    , {field: 'j_type_name', title: '借款类型',align:'center'}
                    , {field: 'j_bor_img', title: '借款凭证',align:'center'}
                    , {field: 'j_sta_name', title: '状态',align:'center'}
                    , {field: 'j_price', title: '金额',align:'center'}
                    , {field: 'j_ctime', title: '申请时间',align:'center'}
                    , {field: 'j_dtime', title: '完成时间',align:'center'}
                    , {width: 180, align: 'center', toolbar: '#barDemo', title: '操作'}
                ]]
                , page: true
            });
        });
    });
</script>
</html>