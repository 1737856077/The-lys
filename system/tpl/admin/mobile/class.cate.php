
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
			  <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_account">添加分类</button>
		      </span>
         	  分类管理
          </div>
          <div class="layui-card-body">
              <div style="width:100%; margin-top:10px;">
              	<table class="layui-hide" id="weblist" lay-filter="weblist"></table>
              </div>			 
			  <script type="text/html" id="barDemo">
				  <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
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
	  layui.$("#add_account").click(function(){
		  layer.open({
			  type: 2,
			  title: '添加分类',
			  closeBtn: 1,
			  scrollbar: false,
			  skin: 'layui-anim',
			  area:  ['420px', '600px'],
			  shadeClose: 0,
			  content:'?m=class&c=addcate'
		  });
	  });	
	  table.render({
		elem: '#weblist'
		,url:'?m=class&c=catelist'
		,cellMinheight: 80
		,height: 'full-110'
		,limit: 20
		,cols: [[
		   {field:'id', title:'ID', width:80, unresize: true}
		  ,{field:'c_name', title:'分类名称'}
		  ,{field:'c_img', title:'图标',style:'height:60px'}
		  ,{field:'c_title', title:'副标题'}
		  ,{field:'c_index', title:'排序'}
		  ,{fixed:'right', width:300, align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: true
	  });
	  
	  table.on('tool(weblist)', function(obj){
		var data = obj.data;
		if(obj.event === 'del'){
		  layer.confirm('删除后将不能恢复，确定删除？', function(index){
			var webid=data.id;
			layui.$.post('?m=class&c=delcate',{'id':webid},function(retmsg){
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
		
		if(obj.event === 'edit'){
		  var webid=data.id;
		  layer.open({
			  type: 2,
			  title: '修改分类',
			  closeBtn: 1,
			  scrollbar: false,
			  skin: 'layui-anim',
			  area:  ['420px', '600px'],
			  shadeClose: 0,
			  content:'?m=class&c=editcate&id='+webid
		  });
		}
	  });
	});	
</script>
<style>
.laytable-cell-1-c_img.layui-table-cell{height:auto;} 
</style>
</body>
</html>