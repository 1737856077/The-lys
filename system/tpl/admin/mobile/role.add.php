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
    <link href="http://www.qingbigu.cn/static/libs/jstree/themes/default/style.min.css" rel="stylesheet">
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
<?php
if (intval($role_id) == 0) {
    ?>
    <div class="layui-card-header">
        角色添加
    </div>
    <div class="layui-card-body">
        <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
             style="padding:20px 20px 0px 0px;">
            <div class="layui-form-item">
                <label class="layui-form-label">角色名称</label>
<div class="layui-input-inline">
                    <input type="text" name="r_name" id="r_name" placeholder="请输入角色名称" autocomplete="off" class="layui-input">
                </div>
            </div>

          <!--  <div class="layui-form-item">
                <label class="layui-form-label">角色权限</label>
                <div class="layui-input-block" style="margin:0">
                    <div id="jstree" style="border: 1px solid #ccc;padding: 20px;margin-bottom: 36px"></div>
                </div>
                <div style="opacity: 0;position: absolute;z-index:-1" id="contentsd">
                    <?php /*echo $auth;*/?>
                </div>
            </div>-->
            <div class="layui-form-item">
                <label class="layui-form-label">角色权限</label>
                <div class="layui-input-block">
                    <div class="layui-input-block" style="margin:0" >
                        <div id="jstree" style="border: 1px solid #ccc;padding: 20px;margin-bottom: 36px"></div>
                    </div>
                    <div style="opacity: 0;position: absolute;z-index:-1" id="contentsd">
                        <?php echo $auth;?>
                    </div>

                </div>
            </div>
        </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <input type="button" lay-submit lay-filter="LAY-user-front-submit"  style="margin-right:60px" id="LAY-user-front-submit" value="确认"
                           class="layui-btn layui-btn-normal">
                    <input type="button" lay-submit lay-filter="LAY-user-front-success" id="LAY-user-front-success" value="全选"
                           class="layui-btn layui-btn-success"
                           style="margin-right:60px" >
                    <input type="button" lay-submit lay-filter="LAY-user-front-danger" id="LAY-user-front-danger" value="取消"
                           class="layui-btn layui-btn-danger">
                </div>
            </div>
        </div>
    </div>
    <script src="/static/layui.js"></script>
    <script src="/static/js/jquery-3.3.1.min.js"></script>
    <script src="/static/js/jstree.js"></script>
    <script>
        layui.use('form', function () {
            var $ = layui.$, form = layui.form;
            form.render();
            form.on('submit(LAY-user-front-submit)', function (obj) {
                var field = obj.field;
                field.ids=$("#jstree").jstree(true).get_checked()
                field.r_name=$('#r_name').val()
                layui.$.post('?m=index&c=role_add', field, function (data) {
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
    <script src="/static/js/jquery-3.3.1.min.js"></script>
    <script src="/static/js/jstree.js"></script>
    <script>
        var data = JSON.parse($("#contentsd").html());
        $('#jstree').jstree({
            'plugins': ['checkbox','types','themes','search'],
            "search" : {
                'show_only_matches' : true,
                'show_only_matches_children' : true
            },
            'types': {
                'default': {
                    'icon': true  // 删除默认图标
                },
                'aaa': {
                }
            },
            'checkbox': {  // 去除checkbox插件的默认效果
                'tie_selection': false,
                'keep_selected_style': false,
                'whole_node': true,
            },
            'core': {
                'multiple' : true,  // 可否多选

                'data' :formData(data),
                'dblclick_toggle': true   //允许tree的双击展开
            }
        });
        function formData(data) {
            var newData = [];
            data.forEach((item,i)=>{
                var children = [];
                var obj = {};
                obj['id'] = item.id;
                obj['text'] = item.a_name;
                obj['state'] = {opened:true};
                item.child.forEach((item2)=>{
                    var obj2 = {};
                    obj2.id = item2.id;
                    obj2.text = item2.a_name;
                    children.push(obj2)
                })
                obj.children = children;
                newData.push(obj);
            })
            return newData;
        }
      /*  $("#LAY-user-front-submit").on('click',function() {
            console.log($("#jstree").jstree(true).get_checked());
        })*/
        $("#LAY-user-front-success").on('click',function() {
            $("#jstree").jstree(true).check_all()
        })
        $("#LAY-user-front-danger").on('click',function() {
            $("#jstree").jstree(true).uncheck_all();
        })
    </script>

<?php
}else{
?>
    <div class="layui-card-header">
        角色编辑
    </div>
    <div class="layui-card-body">
        <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin"
             style="padding:20px 20px 0px 0px;">
            <div class="layui-form-item">
                <label class="layui-form-label">角色名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="r_name" id="r_name" placeholder="请输入角色名称" autocomplete="off" class="layui-input" value="<?php echo $role['r_name']?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">角色权限</label>
                <div class="layui-input-block">
                    <div class="layui-input-block" style="margin:0" >
                        <div id="jstree" style="border: 1px solid #ccc;padding: 20px;margin-bottom: 36px"></div>
                    </div>
                    <div style="opacity: 0;position: absolute;z-index:-1" id="contentsd">
                        <?php echo $auth;?>
                    </div>

                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <input type="button" lay-submit lay-filter="LAY-user-front-submit"  style="margin-right:60px" id="LAY-user-front-submit" value="确认"
                           class="layui-btn layui-btn-normal">
                    <input type="button" lay-submit lay-filter="LAY-user-front-success" id="LAY-user-front-success" value="全选"
                           class="layui-btn layui-btn-success"
                           style="margin-right:60px" >
                    <input type="button" lay-submit lay-filter="LAY-user-front-danger" id="LAY-user-front-danger" value="取消"
                           class="layui-btn layui-btn-danger">
                </div>
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
                field.ids=$("#jstree").jstree(true).get_checked()
                field.r_name=$('#r_name').val()
                layui.$.post('?m=index&c=role_edit&id=<?php echo $role_id; ?>', field, function (data) {
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
    <script src="/static/js/jquery-3.3.1.min.js"></script>
    <script src="/static/js/jstree.js"></script>
    <script>
        var data = JSON.parse($("#contentsd").html());
        $('#jstree').jstree({
            'plugins': ['checkbox','types','themes','search'],
            "search" : {
                'show_only_matches' : true,
                'show_only_matches_children' : true
            },
            'types': {
                'default': {
                    'icon': true  // 删除默认图标
                },
                'aaa': {
                }
            },
            'checkbox': {  // 去除checkbox插件的默认效果
                'tie_selection': false,
                'keep_selected_style': false,
                'whole_node': true,
            },
            'core': {
                'multiple' : true,  // 可否多选

                'data' :formData(data),
                'dblclick_toggle': true   //允许tree的双击展开
            }
        });
        function formData(data) {
            var newData = [];
            data.forEach((item,i)=>{
                var children = [];
                var obj = {};
                obj['id'] = item.id;
                obj['text'] = item.a_name;
                obj['state'] = {opened:true};
                if(item.is_checked == 1 && item.count==item.select) {
                    obj.state = {'checked' : true,opened:true}
                }
                item.child.forEach((item2)=>{
                    var obj2 = {};
                    obj2.id = item2.id;
                    obj2.text = item2.a_name;
                   // obj2.state = {'checked' : false}
                    if(item2.is_checked == 1) {
                        obj2.state = {'checked' : true}
                    }
                    children.push(obj2)
                })
                obj.children = children;
                newData.push(obj);
            })
            console.log(newData)
            return newData;
        }
    /*$("#LAY-user-front-submit").on('click',function() {
        console.log($("#jstree").jstree(true).get_checked());
    })*/
    $("#LAY-user-front-success").on('click',function() {
        $("#jstree").jstree(true).check_all()
    })
        $("#LAY-user-front-danger").on('click',function() {
            $("#jstree").jstree(true).uncheck_all();
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