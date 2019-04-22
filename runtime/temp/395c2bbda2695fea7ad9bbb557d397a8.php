<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"C:\Users\Administrator\Desktop\suyuan\sy/integral/member\view\index.site.html";i:1555924979;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>添加地址</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes">
    <meta name="browsermode" content="application">
    <meta name="x5-fullscreen" content="true">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" type="text/css" href="/static/integral/css/lxs_index.css"/>
    <link rel="stylesheet" type="text/css" href="/static/integral/css/lxsHeadFoot.css">
    <link rel="stylesheet" type="text/css" href="/static/integral/css/order_new.css" />
    <script src="/static/integral/js/jquery-2.1.4.min.js" ></script>
    <script src="/static/integral/js/jquery.js" ></script>
    <script src="/static/integral/js/jquery-1.7.2.min.js" ></script>
    <script></script>
    <style>
        .check{
            border-radius: .05rem;
            width: 1.58rem;
            height:1.58rem;
            border: .02rem solid #0D1529;
            color: #0D1529;
            top: 0;
            left: -.5rem;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
        .aui-list-spell input
        {

            width: 100%;
            text-decoration:none;
            background: #ff4646;
            color: #3f84bc;
            text-align: center;
            display: block;
            margin-top: 10px;
            padding: 10px 30px 10px 30px;
            font-size:16px;
            font-family: 微软雅黑,宋体,Arial,Helvetica,Verdana,sans-serif;
            font-weight:bold;
            border-radius:3px;

            -webkit-transition:all linear 0.30s;
            -moz-transition:all linear 0.30s;
            transition:all linear 0.30s;

        }
        select {
            /*Chrome和Firefox里面的边框是不一样的，所以复写了一下*/
            border: solid 0px #000;

            /*很关键：将默认的select选择框样式清除*/
            appearance:none;
            -moz-appearance:none;
            -webkit-appearance:none;

            /*在选择框的最右侧中间显示小箭头图片*/
            background: url("http://ourjs.github.io/static/2015/arrow.png") no-repeat scroll right center transparent;


            /*为下拉小箭头留出一点位置，避免被文字覆盖*/
            padding-right: 14px;
        }


        /*清除ie的默认选择框样式清除，隐藏下拉箭头*/
        select::-ms-expand { display: none; }
    </style>
</head>
<body>

<div class="content">
    <div style="background: #FF4945" class="headTop">
        <a href="javascript:history.go(-1)" style="color: azure" class="back"><<<<i class="iconBack"></i></a><span>地址填写</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
    </div>
</div>
<?php echo dump($member_data); ?>

<div class="j_main m-main">

    <form  class="form1" id="form1" >
        <input type="hidden" name="uid" value="<?php echo $member_data['uid']; ?>">
        <input type="hidden" name="admin_id" value="<?php echo $member_data['admin_id']; ?>">
        <div class="tit">
            <i></i>地址详情
        </div>
        <div class="txt">
            <dl>
                <dt>姓名</dt>
                <input type="text" name="name" placeholder="请填写联系姓名" value="">
            </dl>
            <dl>
                <dt>手机</dt>
                <input type="text" name="tel" value="<?php echo $member_data['moblie']; ?>">
            </dl>
            <dl class="J_price">
                <dt>请选择地址</dt>
            </dl>
            <dl>
                <select style="" id="sheng" name="sheng">
                    <option value="">请选择省份</option>
                    <?php if(is_array($region) || $region instanceof \think\Collection || $region instanceof \think\Paginator): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value='<?php echo $vo['area_code']; ?>'><?php echo $vo['area_name']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>

            </dl>
            <dl>
                <select style="" id="city"  name="city">
                    <option value="">请选择城市</option>
                </select>

            </dl>
            <dl>

                <select style="" id="qu"  name="qu">
                    <option value="">请选择区</option>
                </select>

            </dl>
            <dl>
                <select style="" id="jie"  name="jie">
                    <option value="">请选择街道</option>
                </select>
            </dl>
            <dl class="J_price">
                <dt>详细地址</dt>
                <input type="text" name="address" value="">
            </dl>
            <dl class="J_price">
                <dt>邮政编码</dt>
                <input type="text" name="code" value="">
            </dl>
            <input type="hidden" name="data_type" value="0">
            <input type="hidden" name="data_status" value="1">
            <dl class="J_price">
                <dt>设为默认地址</dt>
                <input type="checkbox" class="check" name="data_type" value="1" />
            </dl>
        </div>
        <div class="txt txt2 J_baoxian">
        </div>
     <div class="aui-list-spell">
                <input type="button" value="保存" onclick="login()">
        </div>
    </form>
</div>
<script src="/static/integral/js/min_com.js"></script>
<script src="/static/integral/js/order_xianlu.js"></script>
<script type="text/javascript">
    function login() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo url('member/index/sitesave'); ?>" ,//url
            data: $('#form1').serialize(),
            success: function (result) {
            switch (result) {
                case -1:
                    alert('请填写信息');
                    break;
                case 0:
                    alert("添加失败");
                    break;
                default:
                    alert('添加成功')
                    // window.location.href="<?php echo url('order/index/index'); ?>"
            }
            }

        });
    }
</script>
<script>

    $("#sheng").change(function () {
        var sheng = $('#sheng').val();
        $.ajax({
            type: 'post',
            url: '/integral.php/member/index/shi',
            data: 'shi=' + $('#sheng').val(),
            dataType: "json",
            success: function (data) {
                var option = "", shi = '';
                document.getElementById("city").options.length = 0;
                document.getElementById("city").add(new Option("请选择城市",""));
                document.getElementById("qu").options.length = 0;
                document.getElementById("qu").add(new Option("请选择区",""));
                document.getElementById("jie").options.length = 0;
                document.getElementById("jie").add(new Option("请选择街道",""));
                for (var i = 0; i < data.length; i++) {
                    if (shi == '') shi = data[i];

                    option += "<option value='" + data[i]['area_code'] + "'>" + data[i]['area_name'] + "</option>";
                }
                $("#city").append(option);
                set_qu(sheng, shi);
            }
        })
        $("#city").change(function () {
            var sheng = $('#sheng').val();
            var shi = this.value;
            set_qu(sheng, shi);

        })

        function set_qu(sheng, shi) {

            $.ajax({
                type: 'post',
                url: '/integral.php/member/index/shi',
                data: {'shi': sheng, 'shi': shi},
                dataType: "json",
                success: function (data) {
                    document.getElementById("qu").options.length = 0;
                    document.getElementById("qu").add(new Option("请选择区",""));
                    document.getElementById("jie").options.length = 0;
                    document.getElementById("jie").add(new Option("请选择街道",""));
                    var html = "";
                    for (i = 0; i < data.length; i++) {
                        html += "<option value='" + data[i]['area_code'] + "'>" + data[i]['area_name'] + "</option>";
                    }
                    $('#qu').append(html);
                }
            })
        }

        $("#qu").change(function () {
            var shi = $('#qu').val();
            var shi = this.value;
            set_qu1(shi);

        })

        function set_qu1(shi) {

            $.ajax({
                type: 'post',
                url: '/integral.php/member/index/shi',
                data: {'shi': shi},
                dataType: "json",
                success: function (data) {
                    var html = "";
                    document.getElementById("jie").options.length = 0;
                    document.getElementById("jie").add(new Option("请选择街道",""));
                    for (i = 0; i < data.length; i++) {
                        html += "<option value='" + data[i]['area_code'] + "'>" + data[i]['area_name'] + "</option>";
                    }
                    $('#jie').append(html);
                }
            })
        }
    })</script>
</body>
</html>