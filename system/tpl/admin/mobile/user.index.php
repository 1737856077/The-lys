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
          <div class="layui-card-header">
			  <span style="float: right;">
			    <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_account">添加账户</button>
			    <button class="layui-btn layui-btn-sm layui-btn-normal" id="recover_user">回收站</button>
		      </span>
			  会员列表
			</div>
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
                    <div class="layui-input-inline" style="width: 200px;">
                      <input type="text" name="s_regt" class="layui-input" id="test10" placeholder="注册时间">
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
                        <button class="layui-btn layui-btn-sm layui-btn-danger" id="do_export" lay-submit lay-filter="do_export">导出</button>
                    </div>
                </div>			
			</div>
			<table class="layui-hide" id="test" lay-filter="test"></table>
			</div>
		</div>
		</div>
		</div>
		<script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-normal layui-btn-xs" href="?m=user&c=tree&id={{d.id}}">图谱</a>
            <br/>
            <a class="layui-btn  layui-btn-xs" lay-event="edit">编辑</a>
            <br/>
            <?php  if($this->config['w_shiming'] > 0){ ?>
            {{# if(d.m_rz == '0'){ }}
                <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="status">审核</a>
                <br/>
            {{# } }}
            <?php } ?>

            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
	</div>
    <div class="layui-form" lay-filter="lay-charge" id="lay-charge" style="display: none;">
        <div class="form-line">
            <input type="number" name="l_num" placeholder="负数为减,正数为加" lay-verify="number" class="layui-layer-input">
            <input type="hidden" name="l_uid" value="0" />
        </div>
        <div class="form-line">
            <textarea class="layui-layer-input" name="l_info" lay-verify="required" placeholder="操作说明"></textarea>
        </div>
        <div class="form-line">
            <button class="layui-btn layui-btn-sm layui-btn-normal" lay-submit lay-filter="lay-charge-submit">确认充值</button>
        </div>
    </div>
	<style>
			tr td .layui-table-cell{ height:auto; font-size:12px;}
			tr td .m_avatar{ width:42px; height:42px; float:left; border-radius:42px; margin-left:-5px; margin-right:5px; margin-top:8px;}
    </style>
</body>
<script src="/static/layui.js"></script>
	<script>
	function t_lock(uid){
		layui.$.post('?m=user&c=t_lock',{'uid':uid},function(ret){
			   layer.msg(ret.msg);
			   if(ret.code==1){
			    layui.$('#uid_'+uid).removeClass('layui-btn-normal');
			    layui.$('#uid_'+uid).addClass('layui-btn-danger');
			   	layui.$('#uid_'+uid).html('锁定');
			   }else{
			    layui.$('#uid_'+uid).removeClass('layui-btn-danger');
			    layui.$('#uid_'+uid).addClass('layui-btn-normal');
			   	layui.$('#uid_'+uid).html('正常');
			   }		
		},'json');			
	}
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
	  layui.$("#add_account").click(function(){
		  layer.open({
			  type: 2,
			  title: '开通账户',
			  closeBtn: 1,
			  scrollbar: false,
			  skin: 'layui-anim',
			  area:  ['460px', '600px'],
			  shadeClose: 0,
			  content:'?m=user&c=add_user'
		  });
	  });
      layui.$("#recover_user").click(function(){
          layer.open({
              type: 2,
              title: '回收站',
              closeBtn: 1,
              scrollbar: false,
              skin: 'layui-anim',
              area:  ['1000px', '600px'],
              shadeClose: 0,
              content:'?m=user&c=recover_user'
          });
      });


	  table.render({
		elem: '#test'
		,url:'?m=user&c=userlist&pid=<?php echo $pid;?>&tid=<?php echo $tid;?>'
		,cellMinheight: 80
		,height: 'full-110'
		,limit:20
		,cols: [[
               {field:'id',title:'ID', width:80,align:'center',unresize: true}
              ,{field:'m_user',title:'会员信息',width:150}
              <?php  if($this->config['w_shiming'] > 0){ ?>
              ,{field:'m_car_img',title:'证件',width:70}
              ,{field:'m_rz',title:'实名认证',width:90,align:'center',templet:'#Mrz'}
              <?php } ?>
              ,{field:'t_user',title:'推荐人',width:110,align:'center'}
              <?php
                if($this->config['w_hualuo']>0 or $this->config['w_frame'] > 1){
                    echo ",{field:'p_user',title:'节点人',width:110,align:'center'}";
              }?>
              ,{field:'m_yqm',title:'邀请码',width:80,align:'center'}
			  ,{field:'m_levels',title:'级别',width:80,align:'center'}
              ,{field:'c_num',title:'债务总额',align:'center'}
              ,{field:'c_ov_num',title:'匹配债务',align:'center'}
			  ,{field:'m_gender',title:'性别',width:60,align:'center'}
			  ,{field:'m_infos',title:'简介',align:'center'}
			  ,{field:'m_regtime',title:'注册时间',width:150}
			  ,{field:'lock',title:'锁定',width:70}
			  ,{align:'center', toolbar: '#barDemo',title:'操作',width:230}
		]]
		,page: true
	  });
      form.on('submit(lay-charge-submit)', function(obj){
          var field = obj.field;
          layui.$.post('?m=user&c=recharge',field,function(retmsg){
              layer.close(layCharge);
              if(retmsg.role == 'error'){
                  alert('您当前没有操作权限');
                  top.location.href='?m=index&c=index';
              }
              if(parseInt(retmsg.code)==1){
                  layer.msg(retmsg.msg);
                  table.reload('test');
                  setTimeout(function () {
                      window.location.reload();
                  },'1000')
              }else{
                  layer.msg(retmsg.msg);
              }
          },'json');
      });
      table.on('tool(test)', function(obj){
        var data = obj.data;
        if(obj.event === 'del'){
          layer.confirm('删除后将进入回收站，确定删除？', function(index){
            var userid=data.id;
            layui.$.post('?m=user&c=del',{'id':userid},function(retmsg){
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
        } else if(obj.event === 'edit'){
          var userid=data.id;
          layer.open({
              type: 2,
              title: '编辑会员',
              closeBtn: 1,
              scrollbar: false,
              skin: 'layui-anim',
              area:  ['460px', '600px'],
              shadeClose: 0,
              content:'?m=user&c=edit_user&id=' + userid
          });
        } else if(obj.event === 'recharge'){
            form.render();
            form.val("lay-charge", {'l_uid':data.id,'l_num':'','l_info':''});
            layCharge=layer.open({
                type: 1,
                title:'充值/减扣',
                content: layui.$('#lay-charge')
            });
        }else if(obj.event === 'status'){
            layer.confirm('确认审核通过当前会员的实名认证吗？', function(index){
                var userid=data.id;
                layui.$.post('?m=user&c=user_status',{'id':userid},function(res){
                    if(res.role == 'error'){
                        alert('您当前没有操作权限');
                        top.location.href='?m=index&c=index';
                    }
                    if(parseInt(res.status)==1){
                        layer.msg(res.msg);
                        setTimeout(function () {
                            window.location.reload();
                        },'500')
                    }else{
                        layer.msg(res.msg);
                    }
                },'json');
                layer.close(index);
            });
        }
      });
	  form.on('submit(do_searh)', function(obj){
		  var field = obj.field;
		  var url	='?m=user&c=userlist&pid=' + field.s_pid + '&tid=' + field.s_tid + '&s_name=' + encodeURI(field.s_name) + '&s_regt=' + encodeURI(field.s_regt) + '&s_level=' + field.s_level;
		  var tableIns = table.render({
			elem: '#test'
			,url:url
			,cellMinheight: 80
			,limit: 20
              ,cols: [[
                  {field:'id',title:'ID', width:80,align:'center',unresize: true}
                  ,{field:'m_user',title:'会员信息',width:150}
                  <?php  if($this->config['w_shiming'] > 0){ ?>
                  ,{field:'m_car_img',title:'证件',width:70}
                  ,{field:'m_rz',title:'实名认证',width:90,align:'center',templet:'#Mrz'}
                  <?php } ?>
                  ,{field:'t_user',title:'推荐人',width:110,align:'center'}
                  <?php
                  if($this->config['w_hualuo']>0 or $this->config['w_frame'] > 1){
                      echo ",{field:'p_user',title:'节点人',width:110,align:'center'}";
                  }?>
                  ,{field:'m_yqm',title:'邀请码',width:80,align:'center'}
                  ,{field:'m_levels',title:'级别',width:80,align:'center'}
                  ,{field:'c_num',title:'债务总额',align:'center'}
                  ,{field:'c_ov_num',title:'匹配债务',align:'center'}
                  ,{field:'m_gender',title:'性别',width:60,align:'center'}
                  ,{field:'m_infos',title:'简介',align:'center'}
                  ,{field:'m_regtime',title:'注册时间',width:150}
                  ,{field:'lock',title:'锁定',width:70}
                  ,{align:'center', toolbar: '#barDemo',title:'操作',width:230}
              ]]
			,page: true
		  }); 
	  });
      form.on('submit(do_export)', function(obj){
          var field = obj.field;
          var url	='/admin.php?m=user&c=export_list&pid=' + field.s_pid + '&tid=' + field.s_tid + '&s_name=' + encodeURI(field.s_name) + '&s_regt=' + encodeURI(field.s_regt) + '&s_level=' + field.s_level+ '&s_city=' + encodeURI(field.s_city);
          creatFrame(url);
      });
      function creatFrame(url){
          var frameid = "wexframe" + Math.random();
          var _iframe = document.createElement("iframe");
          _iframe.src = url
          _iframe.id  = frameid;
          _iframe.setAttribute("frameborder", "0", 0);
          _iframe.scrolling 	= "no";
          _iframe.style.width = "0px";
          _iframe.style.height= "0px";
          document.body.appendChild(_iframe);
      }
});	
</script>
<script type="text/html" id="Mrz">
    {{# if(d.m_rz == '0'){ }}
        <span style="background-color:#ff6b6b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">否</span>
    {{# } else { }}
        <span style="background-color:#46c37b; color:#fff; font-size:12px; line-height:22px; padding:0px 5px; display:inline-block; border-radius:2px;">是</span>
    {{# } }}
</script>
</html>