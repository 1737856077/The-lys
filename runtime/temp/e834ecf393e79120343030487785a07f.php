<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"C:\Users\Administrator\Desktop\suyuan\sy/integral/order\view\index.index.html";i:1556279950;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>订单填写</title>
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
    <script src="/static/integral/js/jquery-1.7.2.min.js" ></script>
    <script src="/static/integral/js/jquery.js" ></script>

    <script></script>
    <style>

        input[type="number"] {
            -moz-appearance: textfield;

    </style>
</head>
<body>

<div class="content">
    <div style="background: #FF4945" class="headTop">
        <a href="javascript:history.go(-1)" style="color: azure" class="back"><<<<i class="iconBack"></i></a><span>订单填写</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#num").change(function(){
            var price =$("#price").text() ;
            var num =$("#num").val() ;
            $(".num").val(num)
            var prices = price*num;
            $(".integral").text(prices)

            // $.ajax({
            //     //几个参数需要注意一下
            //     type: "POST",//方法类型
            //     dataType: "json",//预期服务器返回的数据类型
            //     url: "/users/login" ,//url
            //     data: $('#form1').serialize(),
            //     success: function (result) {
            //
            //     },
            //
            // });
        });
    });
</script>
<script>
    // $(document).ready(function(){
    //     $("#save").click(function(){
    //         $.ajax({
    //             //几个参数需要注意一下
    //             type: "POST",//方法类型
    //             dataType: "json",//预期服务器返回的数据类型
    //             url: "/integral.php/order/index/suborder" ,//url
    //             data:1,
    //             success: function (result) {
    //                     alert(1)
    //             },
    //
    //         });
    //     });
    // });
</script>

<div class="j_main m-main">

    <form>

        <div class="tit">
            <i></i>填写订单详情
        </div>
        <div class="txt">
            <dt>
                <?php if(empty($product_data['images'])): ?>
                <img style="width: 100%" src="/static/integral/img/nopic-107.png"  alt="">
                <?php else: ?>
                <img style="width: 100%" src="/static/uploads/business/<?php echo $product_data['images']; ?>"  alt="">
                <?php endif; ?>
            </dt>
            <dl>
                <dt>商品名称</dt>
                <dd class="line30"><?php echo $product_data['title']; ?></dd>
            </dl>
            <dl>
                <dt>产品</dt>
                <dd class="line30" ><?php echo $product_data['data_desc']; ?></dd>
            </dl>
            <dl>
                <dt>产品单价</dt>
                <dd ><span style="float: left" id="price"><?php echo $product_data['integral']; ?></span></dd>
            </dl>
            <dl>
                <dt>购买数量</dt>
                    <input style="border: 1px solid" id="num"   class="num" type="text"  value="" name="num"></dd>
            </dl>
        </div>
        <div class="txt txt2 J_baoxian">
        </div>
        <script type="text" id="j_baoxian_con"> <dl> <dt> <a href="javascript:;" class="j_baoxian_tit J_baoxian_info">*title*</a> <input type="hidden" name="*name1*" value="*id*" /> <input type="hidden" name="*name2*" value="*price*" /> </dt> <dd> <font><span class="j_baoxian_c">*price_c*</span><i class="more"></i></font> </dd> </dl> </script>
        <?php if(empty($rceiving_address)): ?>
        <div class="tit">
            <i></i><a href="<?php echo url('member/index/site'); ?>">请添加收地址货</a>
        </div>
        <?php else: ?>
        <div class="tit">
            <i></i>收货地址确认
        </div>
        <div class="txt">
            <dl>
                <dt>姓名</dt>
                <dd><input maxlength="20" type="text"  name="truename" class="o_man" placeholder="" value="<?php echo $rceiving_address['name']; ?>"></dd>
            </dl>
            <dl>
                <dt>地址</dt>
                <dd class="pd0"><input type="text" name="mobiletel" id="n_mobiletel" class="o_number"   value="<?php echo $rceiving_address['address']; ?>"></dd><dd style="width:8rem;-webkit-box-flex:inherit">
            </dd>
            </dl>
        </div>
        <?php endif; ?>

    </form>

    <form class="form1" action="/integral.php/order/index/suborder" method="post"  name="form1">
        <div class="tit">
            <i></i>添加备注
        </div>
        <div class="txt">
            <input type="text" name="description" placeholder="备注" value="">
        </div>
    <div class="submintFix">
        <dl>
            <dt>
                <div class="price">
                    订单总额 <em>￥<em  class="integral"></em></em>
                </div>
            </dt>

                <input type="hidden" name="product_id" value="<?php echo $product_data['product_id']; ?>">
                <input type="hidden" name="uid" value="<?php echo $member_data['uid']; ?>">
                <input type="hidden" name="integral" value="<?php echo $product_data['integral']; ?>">
                <input type="hidden" class="num" name="num" value="">
                <input type="hidden" name="appid" value="<?php echo $product_data['appid']; ?>">
                <input type="hidden" name="admin_id" value="<?php echo $product_data['admin_id']; ?>">
                <input type="hidden" name="rceiving_address_id" value="<?php echo $rceiving_address['rceiving_address_id']; ?>">
                <dd class="sbmFix"><button type="submit" class="save" id="save">提交订单</button></dd>
            </form>
        </dl>
    </div>
</div>
<script src="/static/integral/js/min_com.js"></script>
<script src="/static/integral/js/order_xianlu.js"></script>
</body>
</html>