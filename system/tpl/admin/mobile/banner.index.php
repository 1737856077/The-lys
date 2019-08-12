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
</head>

<body>
<div class="layui-fluid" style="margin: 10px 0px;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header" style="padding: 5rem auto;">
                    广告管理
                    <div class="layui-input-inline" style="width:80px;float: right;">
                        <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_banner">添加广告</button>
                    </div>
                </div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="BannerList" lay-filter="BannerList"></table>
                    <script type="text/html" id="barDemo">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                    </script>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .layui-table-cell {
        height: auto;
        line-height: 40px;
    }
</style>

<script src="/static/layui.js"></script>
<script>
    layui.use(['element','layer','table'], function(){
        var element = layui.element;
        var layer 	= layui.layer;
        var table 	= layui.table;
        layui.$("#add_banner").click(function(){
            layer.open({
                type: 2,
                title: '添加图片',
                closeBtn: 1,
                scrollbar: false,
                skin: 'layui-anim',
                area:  ['420px', '600px'],
                shadeClose: 0,
                content:'/admin.php?m=config&c=banner_add'
            });
        });

        table.render({
            elem: '#BannerList'
            ,url:'?m=config&c=banner_list'
            ,cellMinheight: 80
            ,height: 'full-110'
            ,limit: 20
            ,cols: [[
                 {field:'id', title:'ID', width:80,align:'center', unresize: true}
                ,{field:'b_name', title:'图片名称'}
                ,{field:'b_img', title:'图片展示'}
                ,{field:'b_link', title:'图片链接',align:'center'}
                ,{field:'b_pos', title:'图片位置',align:'center'}
                ,{field:'b_index', title:'排序',align:'center'}
                ,{field:'b_time', title:'时间',align:'center'}
                ,{title:'操作',width:160, align:'center', toolbar: '#barDemo'}
            ]]
            ,page: false
        });
        table.on('tool(BannerList)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('删除后将不能恢复，确定删除？', function(index){
                    var banner_id = data.id;
                    layui.$.post('?m=config&c=banner_del',{id:banner_id},function(res){
                        if(res.role == 'error'){
                            alert('您当前没有操作权限');
                            top.location.href='?m=index&c=index';
                        }
                        if(parseInt(res.code)==1){
                            layer.msg(res.msg);
                            obj.del();
                        }else{
                            layer.msg(res.msg);
                        }
                    },'json');
                    layer.close(index);
                });
            }

            if(obj.event === 'edit'){
                var banner_id = data.id;
                layer.open({
                    type: 2,
                    title: '编辑图片',
                    closeBtn: 1,
                    scrollbar: false,
                    skin: 'layui-anim',
                    area:  ['420px', '600px'],
                    shadeClose: 0,
                    content:'/admin.php?m=config&c=banner_edit&id=' + banner_id
                });
            }

        })
    });
</script>
</body>
</html>