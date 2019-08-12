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
<link rel="stylesheet" href="/static/css/jquery.orgchart.css">
<script src="/static/js/jquery-3.3.1.min.js"></script> 
<script src="/static/layui.js"></script> 
<script src="/static/js/jquery.orgchart.js"></script>
<script language="javascript">
    $(function() {
        var datascource = <?php echo $xxx;?>;
        $('#chart-container').orgchart({
            'data': datascource,
            'nodeContent': 'title'
        });
    });
</script>
</head>
<body>
<div class="layui-fluid" style="margin: 10px 0px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">团队架构</div>
          <div class="layui-card-body">
            <div id="chart-container"></div>
          </div>
        </div>
    </div>
  </div>
</div>
</body>
</html>