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
	<div class="layui-fluid" style="padding: 10px 15px;">
	    <div class="layui-row layui-col-space15">
      	<div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">
			  余额明细
			</div>
			<div class="layui-card-body">
			<div class="layui-form" lay-filter="lay-search" id="lay-search">
					<div class="layui-inline">
                    	<label class="layui-form-label-col" style="float:left">用户ID：</label>
						<div class="layui-input-inline" style="width:200px;">
						  <input type="text" name="s_id" value="<?php echo $user_id;?>" placeholder="用户ID" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-input-inline" style="width: 200px;">
						  <input type="text" name="s_regt" class="layui-input" id="test10" placeholder="日期范围">
						</div>
						<div class="layui-input-inline" style="width: 120px;">
						 <button class="layui-btn layui-btn-sm layui-btn-normal" id="do_searh" lay-submit lay-filter="do_searh">搜索</button>
						</div>
					</div>			
			</div>
			<table class="layui-hide" id="test" lay-filter="test"></table>
			</div>
		</div>
		</div>
		</div>
		<script type="text/html" id="barDemo">	  
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
	</div>
	    <style>
    tr td .layui-table-cell{ height:auto; font-size:12px;}
    </style>
</body>
<script src="/static/layui.js"></script>
	<script>
  layui.use(['element','layer','form','table','laydate'], function(){
	  var element 	= layui.element;	
	  var layer 	= layui.layer;
	  var form 		= layui.form;
	  var table 	= layui.table;
	  var laydate 	= layui.laydate;
	  var layCharge = 0;

	  laydate.render({
		elem: '#test10'
		,type: 'datetime'
		,range: true
	  });
	  table.render({
		elem: '#test'
		,url:'?m=user&c=log_list&id=<?php echo $user_id?>'
		,cellMinheight: 80
		,height: 'full-110'
		,limit:20
		,cols: [[
		   {field:'id', title:'ID', width:80, unresize: true}
		  ,{field:'l_uid', title:'会员信息'}
		  ,{field:'l_type', title:'账户',width:120}
		  ,{field:'l_num', title:'金额',width:120}
		  ,{field:'l_info', title:'备注'}
		  ,{field:'l_time', title:'时间'}
		  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: true
	  });
    
  table.on('tool(test)', function(obj){
    var data = obj.data;
    if(obj.event === 'del'){
      layer.confirm('删除后将不能恢复，确定删除？', function(index){
		var l_id=data.id;
		layui.$.post('?m=user&c=del_log',{'id':l_id},function(retmsg){
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
	  form.on('submit(do_searh)', function(obj){
		  var field = obj.field;
		  var url	='?m=user&c=log_list&id=' + field.s_id + '&s_regt=' + encodeURI(field.s_regt);
		  var tableIns = table.render({
			elem: '#test'
			,url:url
			,cellMinheight: 80
			,limit: 20
			,cols: [[
			   {field:'id', title:'ID', width:80, unresize: true}
			  ,{field:'l_uid', title:'会员信息'}
			  ,{field:'l_type', title:'账户',width:120}
			  ,{field:'l_num', title:'金额',width:120}
			  ,{field:'l_info', title:'备注'}
			  ,{field:'l_time', title:'时间'}
			  ,{width:200, align:'center', toolbar: '#barDemo',title:'操作'}
			]]
			,page: true
		  }); 
	  });
	  

});	
	</script>
</html>