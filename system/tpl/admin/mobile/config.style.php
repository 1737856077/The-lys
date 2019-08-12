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
<style type="text/css">
.layui-form-switch{ margin-top:-4px;}
.layui-form-item .layui-input-inline{ width:auto;}
.layui-form-label{ width:auto;}
.layui-upload-list{ padding:10px; border-radius: 8px; <?php if($this->config['w_temp']<4){ echo 'background:'.$this->config['w_color1'].';';}?>}
</style>
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">
         	  首页菜单设置
              <span style="float: right;">
			  <button class="layui-btn layui-btn-sm layui-btn-normal" id="add_menu">添加菜单</button>
		      </span>
          </div>
          <div class="layui-card-body">
            <table class="layui-table">
            <thead>
              <tr>
                <th>编号</th>
                <th>菜单名称</th>
                <th>链接地址</th>
                <th>菜单图标</th>
                <th>排序</th>
                <th>操作</th>
              </tr> 
            </thead>
            <tbody>
            <?php
				$x=1;
            	foreach($styles as $l){
			?>
              <tr><form name="form_<?php echo $l['s_id'];?>" id="form_<?php echo $l['s_id'];?>">
                <td><?php echo $x; ?></td>
                <td>
                    <div class="layui-inline" style="width:120px;">
                        <input type="text" name="s_name" class="layui-input" value="<?php echo $l['s_name'];?>">
                    </div>
                </td>
                <td>
                    <div class="layui-inline" style="width:200px;">
                        <input type="text" name="s_url" class="layui-input" value="<?php echo $l['s_url'];?>">
                    </div>
                </td>
                <td>
                  <div class="layui-inline">
                      <input type="hidden" name="s_icon" value="<?php echo $l['s_icon'];?>" id="s_icon_<?php echo $x;?>">
                      <div class="layui-input-inline">
                          <div class="layui-upload-list"><img class="s_icon_img" id="s_icon_img_<?php echo $x;?>" src="<?php echo $l['icon_img'];?>" width="30"></div>
                      </div>
                      <div class="layui-input-inline">
                          <button type="button" class="layui-btn layui-btn-xs" id="s_icon_btn_<?php echo $x;?>">重新上传</button>
                      </div>
                  </div>
               </td>
                <td>
                    <div class="layui-inline" style="width:50px;">
                        <input type="text" name="s_sort" class="layui-input" value="<?php echo $l['s_sort'];?>">
                    </div>
                </td>
                <td>
                    <a class="layui-btn layui-btn-normal layui-btn-xs" href="javascript:save_level(<?php echo $l['s_id'];?>);">保存</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" href="javascript:del_level(<?php echo $l['s_id'];?>);">移除</a>
                </td>
                </form>
              </tr>
            <?php	
				$x++;
				}
			?>
            </tbody>
          </table>
          </div>
        </div>
    </div>
  </div>
</div>
<script src="/static/layui.js"></script>
<script>
	var $;
	layui.use(['form','upload','element'], function(){
		$ = layui.$,form = layui.form,upload = layui.upload,element = layui.element;
		form.render();
		
		layui.$("#add_menu").click(function(){
		  layer.open({
			  type: 2,
			  title: '添加菜单',
			  closeBtn: 1,
			  scrollbar: false,
			  skin: 'layui-anim',
			  area:  ['460px', '600px'],
			  shadeClose: 0,
			  content:'?m=config&c=add_menu'
		  });
		});	  
		
			<?php
				$btnid=0;
				foreach($styles as $l){
				$btnid+=1;
			?>	
			upload.render({
				 elem: '#s_icon_btn_<?php echo $btnid?>'
				,url: '?m=config&c=upload'
				,before: function(obj){obj.preview(function(index, file, result){$('#s_icon_img_<?php echo $btnid?>').attr('src', result);});}
				,done: function(res){if(res.code > 0){return layer.msg('上传失败');}else{$('#s_icon_<?php echo $btnid?>').val(res.msg);}
				}
			});
			<?php }?>
  	});
	function del_level(id){
		var formdata=new FormData();
		formdata.append("s_id",id);
		var xhr		=new XMLHttpRequest();
		xhr.open("post","?m=config&c=removestyle");
		xhr.send(formdata);
		xhr.onload=function(res){
			if(xhr.status==200){
				window.location.reload();
			}
		}
	}
	function save_level(id){
		var form	=document.querySelector('#form_'+id);
		var formdata=new FormData(form);
		formdata.append("s_id",id);
		var xhr		=new XMLHttpRequest();
		xhr.open("post","?m=config&c=style");
		xhr.send(formdata);
		xhr.onload=function(res){
		    console.log(xhr)
			/*if(xhr.status==200){
				alert('设置成功');
				window.location.reload();
			}*/
		}
    }		
</script>
</body>
</html>