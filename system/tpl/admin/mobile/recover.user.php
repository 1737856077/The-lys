<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo WEBNAME;?> - <?php echo WEBDESC;?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="stylesheet" href="/static/css/layui.css">
	<link rel="stylesheet" href="/static/css/main.css">
	<link rel="stylesheet" href="/static/css/login.css">
</head>

<body>
	<div class="layui-fluid" style="margin: 10px 0px;">
	    <div class="layui-row layui-col-space15">
      	<div class="layui-col-md12">
        <div class="layui-card">
			<div class="layui-card-body">
			<div class="layui-form" lay-filter="lay-search" id="lay-search">
                <div class="layui-inline">
                    <label class="layui-form-label-col" style="float:left">
                    <?php
                        if($tid){echo ' 推荐人ID:'.$tid;}
                    ?>
                    <input type="hidden" name="s_tid" value="<?php echo $tid;?>" />
                    <?php
                        if($pid){echo ' 节点人ID:'.$pid;}
                    ?>
                    <input type="hidden" name="s_pid" value="<?php echo $pid;?>" />
                     搜索：</label>
                    <div class="layui-input-inline" style="width:200px;">
                      <input type="text" name="s_name" placeholder="姓名/手机/微信" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width: 120px;">
                       <select name="s_level">
                       <option value=""></option>
                        <?php
                            foreach($u_levels as $k=>$v){
                                echo '<option value="'.$k.'">'.$v.'</option>';
                            }
                        ?>
                      </select>
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
            <br/>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="reply">恢复</a>
        </script>
	</div>
	<style>
			tr td .layui-table-cell{ height:auto; font-size:12px;}
			tr td .m_avatar{ width:42px; height:42px; float:left; border-radius:42px; margin-left:-5px; margin-right:5px; margin-top:8px;}
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
		,url:'?m=user&c=recover_data&pid=<?php echo $pid;?>&tid=<?php echo $tid;?>'
		,cellMinheight: 80
		,height: 'full-110'
		,limit:20
		,cols: [[
			   {field:'id',title:'ID', width:80, unresize: true}
			  ,{field:'m_user',title:'会员信息',width:150}
			  ,{field:'t_user',title:'推荐人',width:120}
			  <?php
				if($this->config['w_frame']>1){
				echo ",{field:'p_user',title:'节点人',width:120}";	
				}
			  ?>
			  ,{field:'m_levels',title:'级别',width:80}
			  ,{align:'center', toolbar: '#barDemo',title:'操作'}
		]]
		,page: true
	  });
      table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
              layer.confirm('删除后将永久不能恢复，确定删除？', function(index){
                var userid=data.id;
                layui.$.post('?m=user&c=user_del',{'id':userid},function(retmsg){
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
            }else if(obj.event === 'reply'){
                layer.confirm('恢复后用户将再次回到用户列表，确定恢复？', function(index){
                    var userid=data.id;
                    layui.$.post('?m=user&c=user_reply',{'id':userid},function(retmsg){
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

	  form.on('submit(do_searh)', function(obj){
		  var field = obj.field;
		  var url	='?m=user&c=recover_data&pid=' + field.s_pid + '&tid=' + field.s_tid + '&s_name=' + encodeURI(field.s_name) + '&s_level=' + field.s_level;
		  var tableIns = table.render({
			elem: '#test'
			,url:url
			,cellMinheight: 80
			,limit: 20
			,cols: [[
			   {field:'id',title:'ID', width:80, unresize: true}
			  ,{field:'m_user',title:'会员信息',width:150}
			  ,{field:'t_user',title:'推荐人',width:120}
			  <?php
				if($this->config['w_frame']>1){
					echo ",{field:'p_user',title:'节点人',width:120}";
				}
			  ?>
			  ,{field:'m_levels',title:'级别',width:80}
			  ,{align:'center', toolbar: '#barDemo',title:'操作'}
			]]
			,page: true
		  }); 
	  });
});	
	</script>
</html>