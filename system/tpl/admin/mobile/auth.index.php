
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
			  <button class="layui-btn layui-btn-sm layui-btn-normal" id="role_add">添加权限</button>
		      </span>
         	  权限管理
          </div>
          <div class="layui-card-body">
              <div style="width:100%; margin-top:10px;">
              	<table class="layui-hide" id="weblist" lay-filter="weblist"></table>
              </div>			 
			  <script type="text/html" id="barDemo">
				  <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
<!--                  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>-->
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
	  layui.$("#role_add").click(function(){
		  layer.open({
			  type: 2,
			  title: '添加权限',
			  closeBtn: 1,
			  scrollbar: false,
			  skin: 'layui-anim',
			  area:  ['420px', '600px'],
			  shadeClose: 0,
			  content:'?m=index&c=auth_add'
		  });
	  });	
	  table.render({
		elem: '#weblist'
		,url:'?m=index&c=auth_data'
		,cellMinheight: 80
		,height: 'full-110'
		,limit: 20
		,cols: [[
		   {field:'id', title:'ID', width:80, unresize: true}
		  ,{field:'a_name', title:'权限名称', width:150}
		  ,{field:'a_ctl', title:'控制器'}
		  ,{field:'a_fun', title:'方法'}
		  ,{field:'a_level', title:'等级'}
		  ,{field:'a_addtime', title:'时间'}
		  ,{fixed:'right', width:300, align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: false
	  });
	  
	  table.on('tool(weblist)', function(obj){
		var data = obj.data;
		if(obj.event === 'edit'){
		  var webid=data.id;
		  layer.open({
			  type: 2,
			  title: '修改权限',
			  closeBtn: 1,
			  scrollbar: false,
			  skin: 'layui-anim',
			  area:  ['420px', '600px'],
			  shadeClose: 0,
			  content:'?m=index&c=auth_edit&id='+webid
		  });
		}
	  });
	});	
</script>
</body>
</html>