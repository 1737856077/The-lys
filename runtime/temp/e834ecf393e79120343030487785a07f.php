<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"C:\Users\Administrator\Desktop\suyuan\sy/integral/order\view\index.index.html";i:1555926079;}*/ ?>
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


<div class="j_main m-main">

    <form action="" method="post" name="form_1">

        <div class="tit">
            <i></i>填写订单详情
        </div>
        <div class="txt">
            <dt style="width: 96.5%;text-align: center">
                <?php if(empty($product['images'])): ?>
                <img src="/static/integral/img/nopic-107.png"  alt="">
                <?php else: ?>
                <img src="/static/uploads/business/<?php echo $pdata['images']; ?>"  alt="">
                <?php endif; ?>
            </dt>
            <dl>
                <dt>商品名称</dt>
                <dd class="line30"><?php echo $product_data['title']; ?></dd>
            </dl>
            <dl>
                <dt>产品</dt>
                <dd class="line30"><?php echo $product_data['data_desc']; ?></dd>
            </dl>
            <dl>
                <dt>产品单价</dt>
                <dd>￥<?php echo $product_data['integral']; ?></dd>
            </dl>
            <dl class="J_price">
                <dt>购买数量</dt>
                <dd class="box-flex-1 price pd0" id="adult_price_span">
                    <span><span id="price_d"></span></span></dd><dd class="box-flex-2"><span class="subadd j_num"><span class="sub" data-type="adults"></span><input id="j_price_d_num" type="text" min="1" max="999" class="text_num" value="1" name="adult_num"><span class="add" data-type="adults"></span></span></dd>
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
            <i></i>收货地址确认<a href="<?php echo url('member/index/site'); ?>">请添加收地址货</a>
        </div>
        <div class="txt">
            <dl>
               
            </dl>
        </div>
        <?php endif; ?>

    </form>
    <div class="submintFix">
        <dl>
            <dt>
                <div class="price">
                    订单总额 <span>￥<em class="j_all_money"></em></span>
                </div>
            </dt>
            <dd class="sbmFix"><button type="button" id="save">提交订单</button></dd>
        </dl>
    </div>
</div>
<script src="/static/integral/js/min_com.js"></script>
<script src="/static/integral/js/order_xianlu.js"></script>
</body>
</html>