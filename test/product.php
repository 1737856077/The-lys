<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
3.1	商家登录接口
<form action="http://suyuan.51upstar.com/admin.php/sinterface/business/login" enctype="multipart/form-data" method="post">
用户名：<input type="text" name="username" value="liuqingyan" /><br />
密码：<input type="text" name="password" value="123456" /><br />
<input type="submit" value="提交" />
</form>

3.1	产品模版查询接口
<form action="http://suyuan.51upstar.com/admin.php/sinterface/producttemplate/template_list" enctype="multipart/form-data" method="post">
用户ID：<input type="text" name="user_id" value="2" /><br />
<input type="submit" value="提交" />
</form>

3.2	产品码上传接口
<form action="http://suyuan.51upstar.com/admin.php/sinterface/productcode/insert" enctype="multipart/form-data" method="post">
用户ID：<input type="text" name="user_id" value="2" /><br />
模板id：<input type="text" name="template_id" value="9d6261a4472f4e1fcdb38812246ee96f" /><br />
上市时间：<input type="text" name="market_time" value="<?php echo time();?>" /><br />
码数：<input type="text" name="product_code_num" value="2000" /><br />
码开始：<input type="text" name="product_code_begin" value="2000" /><br />
码结束：<input type="text" name="product_code_end" value="4000" /><br />
添加时间：<input type="text" name="create_time" value="<?php echo time();?>" /><br />
<input type="submit" value="提交" />
</form>

3.3	产品码查询接口
<form action="http://suyuan.51upstar.com/admin.php/sinterface/product/index" enctype="multipart/form-data" method="post">
用户ID：<input type="text" name="user_id" value="2" /><br />
产品码id：<input type="text" name="product_code_id" value="f38a303b07d28b8704d84f6103c2dff8" /><br />
码序号：<input type="text" name="product_code_no" value="2003" /><br />
<input type="submit" value="提交" />
</form>

3.4	网站前台-取得用户的地理信息
<form action="http://suyuan.localhost/admin.php/sinterface/getlocation/insert" enctype="multipart/form-data" method="post">
产品码详细记录ID：<input type="text" name="getLoaction_productCodeInfoId" value="1fda1b522f91532340a0dd453177d1c7" /><br />
地区代码1：<input type="text" name="accuracy" value="10000" /><br />
地区代码2：<input type="text" name="adcode" value="310114" /><br />
地址描述：<input type="text" name="addr" value="上海市" /><br />
国家，一级：<input type="text" name="nation" value="中国" /><br />
省，二级：<input type="text" name="province" value="上海" /><br />
城市，三级：<input type="text" name="city" value="上海市" /><br />
区、镇，四级：<input type="text" name="district" value="嘉定区" /><br />
经度：<input type="text" name="lat" value="31.37482" /><br />
纬度：<input type="text" name="lng" value="121.26621" /><br />
<input type="submit" value="提交" />
</form>
</body>
</html>