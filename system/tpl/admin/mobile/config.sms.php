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
          <div class="layui-card-header">
         	  短信设置
          </div>
         <div class="layui-card-body">
            <div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
              <div class="layui-form-item cols">
                <label class="layui-form-label">短信账户</label>
                <div class="layui-inline">
                <div class="layui-input-inline" style="width:600px;">
                	<input type="text" name="w_user_name" class="layui-input" value="<?php echo $sms['w_user_name'];?>">
                </div>
                <label class="layui-form-label-col">注册地址 http://www.smsbao.com/</label>
                </div>
              </div>
              <div class="layui-form-item cols">
                <label class="layui-form-label">账户密码</label>
                <div class="layui-inline" style="width:600px;">
                	<input type="password" name="w_user_pass" class="layui-input" value="<?php echo $sms['w_user_pass'];?>">
                </div>
              </div>
               <div class="layui-form-item cols">
                <label class="layui-form-label">注册验证</label>
                <div class="layui-inline">
                  <input type="radio" name="w_user_reg" value="0" title="关闭" <?php echo $sms['w_user_reg']==0?'checked':''?>>
                  <input type="radio" name="w_user_reg" value="1" title="开启" <?php echo $sms['w_user_reg']==1?'checked':''?>>
                </div>
              </div>
              <div class="layui-form-item cols">
                <label class="layui-form-label">短信模板</label>
                <div class="layui-inline">
                    <div class="layui-input-inline" style="width:600px;">
                      <textarea name="w_user_reg_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_reg_sms'];?></textarea>
                    </div>
                    <label class="layui-form-label-col">{NAME}:姓名,{CODE}:验证码</label>
                </div>
              </div>
               <div class="layui-form-item cols">
                <label class="layui-form-label">找回密码</label>
                <div class="layui-inline">
                  <input type="radio" name="w_user_rep" value="0" title="关闭" <?php echo $sms['w_user_rep']==0?'checked':''?>>
                  <input type="radio" name="w_user_rep" value="1" title="开启" <?php echo $sms['w_user_rep']==1?'checked':''?>>
                </div>
              </div>
              <div class="layui-form-item cols">
                <label class="layui-form-label">短信模板</label>
                <div class="layui-inline">
                    <div class="layui-input-inline" style="width:600px;">
                      <textarea name="w_user_rep_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_rep_sms'];?></textarea>
                    </div>
                    <label class="layui-form-label-col">{NAME}:姓名,{CODE}:验证码</label>
                </div>
              </div>
               <div class="layui-form-item cols">
                <label class="layui-form-label">订单通知</label>
                <div class="layui-inline">
                  <input type="radio" name="w_user_dnt" value="0" title="关闭" <?php echo $sms['w_user_dnt']==0?'checked':''?>>
                  <input type="radio" name="w_user_dnt" value="1" title="开启" <?php echo $sms['w_user_dnt']==1?'checked':''?>>
                </div>
              </div>
              <div class="layui-form-item cols">
                <label class="layui-form-label">短信模板</label>
                <div class="layui-inline">
                    <div class="layui-input-inline" style="width:600px;">
                      <textarea name="w_user_dnt_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_dnt_sms'];?></textarea>
                    </div>
                    <label class="layui-form-label-col">{NAME}:姓名</label>
                </div>
              </div>
               <div class="layui-form-item cols">
                <label class="layui-form-label">审核通知</label>
                <div class="layui-inline">
                  <input type="radio" name="w_user_snt" value="0" title="关闭" <?php echo $sms['w_user_snt']==0?'checked':''?>>
                  <input type="radio" name="w_user_snt" value="1" title="开启" <?php echo $sms['w_user_snt']==1?'checked':''?>>
                </div>
              </div>
              <div class="layui-form-item cols">
                <label class="layui-form-label">短信模板</label>
                <div class="layui-inline">
                    <div class="layui-input-inline" style="width:600px;">
                      <textarea name="w_user_snt_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_snt_sms'];?></textarea>
                    </div>
                    <label class="layui-form-label-col">{NAME}:姓名</label>
                </div>
              </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">收款码验证</label>
                    <div class="layui-inline">
                        <input type="radio" name="w_user_pay" value="0" title="关闭" <?php echo $sms['w_user_pay']==0?'checked':''?>>
                        <input type="radio" name="w_user_pay" value="1" title="开启" <?php echo $sms['w_user_pay']==1?'checked':''?>>
                    </div>
                </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">短信模板</label>
                    <div class="layui-inline">
                        <div class="layui-input-inline" style="width:600px;">
                            <textarea name="w_user_pay_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_pay_sms'];?></textarea>
                        </div>
                        <label class="layui-form-label-col">{NAME}:姓名,{CODE}:验证码</label>
                    </div>
                </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">实名认证</label>
                    <div class="layui-inline">
                        <input type="radio" name="w_user_sm" value="0" title="关闭" <?php echo $sms['w_user_sm']==0?'checked':''?>>
                        <input type="radio" name="w_user_sm" value="1" title="开启" <?php echo $sms['w_user_sm']==1?'checked':''?>>
                    </div>
                </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">短信模板</label>
                    <div class="layui-inline">
                        <div class="layui-input-inline" style="width:600px;">
                            <textarea name="w_user_sm_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_sm_sms'];?></textarea>
                        </div>
                        <label class="layui-form-label-col">{NAME}:姓名</label>
                    </div>
                </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">上传债务</label>
                    <div class="layui-inline">
                        <input type="radio" name="w_user_upzw" value="0" title="关闭" <?php echo $sms['w_user_upzw']==0?'checked':''?>>
                        <input type="radio" name="w_user_upzw" value="1" title="开启" <?php echo $sms['w_user_upzw']==1?'checked':''?>>
                    </div>
                </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">短信模板</label>
                    <div class="layui-inline">
                        <div class="layui-input-inline" style="width:600px;">
                            <textarea name="w_user_upzw_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_upzw_sms'];?></textarea>
                        </div>
                        <label class="layui-form-label-col">{NAME}:姓名</label>
                    </div>
                </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">付款提醒</label>
                    <div class="layui-inline">
                        <input type="radio" name="w_user_qrsk" value="0" title="关闭" <?php echo $sms['w_user_qrsk']==0?'checked':''?>>
                        <input type="radio" name="w_user_qrsk" value="1" title="开启" <?php echo $sms['w_user_qrsk']==1?'checked':''?>>
                    </div>
                </div>
                <div class="layui-form-item cols">
                    <label class="layui-form-label">短信模板</label>
                    <div class="layui-inline">
                        <div class="layui-input-inline" style="width:600px;">
                            <textarea name="w_user_qrsk_sms" placeholder="" class="layui-textarea"><?php echo $sms['w_user_qrsk_sms'];?></textarea>
                        </div>
                        <label class="layui-form-label-col">{NAME}:姓名,{CODE}:验证码</label>
                    </div>
                </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-front-submit" value="保存设置" class="layui-btn layui-btn-normal">
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<script src="/static/layui.js"></script> 
<script>
  layui.use(['form','upload'], function(){
    var $ = layui.$,form = layui.form,upload = layui.upload;
		form.render();
		form.on('submit(LAY-user-front-submit)', function(obj){
			var field = obj.field;			
			layui.$.post('?m=config&c=sms',field,function(data){
                if(data.role == 'error'){
                    alert('您当前没有操作权限');
                    top.location.href='?m=index&c=index';
                }
				if(data.status==1){
					layer.msg('设置成功', {offset: '15px',icon: 1,time: 1000}, function(){location.reload();});		
				}else{
					layer.msg('操作失败:'+data.msg);
				}
			},'json');
		});
  })
  </script>
</body>
</html>