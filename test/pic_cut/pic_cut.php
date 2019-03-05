<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<input type="file" name="file1" id="file1" onchange="alert(this.value);" />
<input type="button" id="ipnut1" name="ipnut1" value="提交" onclick="onchange_test();" />
<script type="text/javascript">
function onchange_test(){
	document.getElementById("file1").value='C:\fakepath\22.png';
}
</script>
</body>
</html>