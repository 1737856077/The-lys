
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
	<link rel="stylesheet" href="/static/css/login.css">
</head>

<body>
<div class="layui-fluid" style="margin: 10px 0px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">
			  <span style="float: right;">
			  <button class="layui-btn layui-btn-sm layui-btn-normal">
              	<a href="?m=index&c=role_add" style="text-decoration:none; color:#fff;">添加角色</a>
              </button>
		      </span>
         	  角色管理
          </div>
          <div class="layui-card-body">
              <div style="width:100%; margin-top:10px;">
              	<table class="layui-hide" id="weblist" lay-filter="weblist"></table>
              </div>
              <!--<script type="text/html" id="barDemo">
                  {{# if(d.id > '1'){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs"  href="?m=index&c=role_edit&id={{d.id}}">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                  {{# } }}
              </script>-->
              <script type="text/html" id="barDemo">
                  <a class="layui-btn layui-btn-normal layui-btn-xs"  href="?m=index&c=role_edit&id={{d.id}}">编辑</a>
                  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
              </script>
          </div>
        </div>
    </div>
  </div>
</div>
<script src="/static/layui.js"></script>
<script>
	layui.use(['element','layer','form','table'], function(){
	  var element 	= layui.element;	
	  var layer 	= layui.layer;
	  var form 		= layui.form;
	  var table 	= layui.table;
	  table.render({
		elem: '#weblist'
		,url:'?m=index&c=role_data'
		,cellMinheight: 80
		,height: 'full-110'
		,limit: 20
		,cols: [[
		   {field:'id', title:'ID', width:80, unresize: true}
		  ,{field:'r_name', title:'角色名称'}
		  ,{field:'r_addtime', title:'添加时间'}
		  ,{fixed:'right', align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: true
	  });
	  
	  table.on('tool(weblist)', function(obj){
		var data = obj.data;
		if(obj.event === 'del'){
		  layer.confirm('删除后将不能恢复，确定删除？', function(index){
			var webid=data.id;
			layui.$.post('?m=index&c=role_del',{'id':webid},function(retmsg){
                if(retmsg.role == 'error'){
                    alert('您当前没有操作权限');
                    top.location.href='?m=index&c=index';
                }
				if(parseInt(retmsg.code)==1){
				   layer.msg(retmsg.msg);
				   obj.del();
				}else{
				   layer.msg(retmsg.msg);
				}
			},'json');
			layer.close(index);
		  });
		}
	  });
	});	
</script>
</body>
</html>