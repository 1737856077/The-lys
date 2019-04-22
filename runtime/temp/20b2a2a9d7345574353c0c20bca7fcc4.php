<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"C:\Users\Administrator\Desktop\suyuan\sy/integral/integral\view\index.details.html";i:1555904735;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>商品详情</title>
    <link type="text/css" rel="stylesheet" href="/static/integral/css/common1.css">
    <link  type="text/css" rel="stylesheet" href="/static/integral/css/commodity.css">
    <link  type="text/css" rel="stylesheet" href="/static/integral/css/style1.css">
</head>
<body>
<div class="commodity_top">  <a href="javascript:void(0)" class="commodity_02">
    <?php if(empty($data['images'])): ?>
    <img src="/static/integral/img/nopic-107.png" alt="">
    <?php else: ?>
    <img src="/static/uploads/business/<?php echo $data['images']; ?>"  alt="">
    <?php endif; ?>
</a>


</div>
<div class="commodity_banner">
    <a href="javascript:void(0)" class="commodity_top_l">
        <?php if(empty($data['images'])): ?>
        <img src="/static/integral/img/nopic-107.png" alt="">
        <?php else: ?>
        <img src="/static/uploads/business/<?php echo $data['images']; ?>"  alt="">
        <?php endif; ?>
        <span><?php echo $data['title']; ?></span>
    </a>
    <div class="commodity_title">
        <a href=""><h3><?php echo $data['data_desc']; ?></h3></a>
        <div style="color: red">
            <span>¥</span>
            <p><?php echo $data['integral']; ?></p>积分</div>
    </div>
    <p class="fugu"><?php echo $data['content']; ?></p>
</div>
<div class="scon">
    <div class="send w500">
    </div>
</div>
<div class="comm_footer">
    <ul>
        <form action="<?php echo url('order/index/index'); ?>">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">
            <input type="hidden" name="admin_id" value="<?php echo $data['admin_id']; ?>">
            <input type="hidden" name="appid" value="<?php echo $data['appid']; ?>">
            <input class="comm_f_04"   type="submit" value="立即兑换">
        </form>
    </ul>
</div>
<footer class="aui-footer aui-footer-fixed">
    <a href="<?php echo url('index/index/index'); ?>"  class="aui-tabBar-item">
                    <span class="aui-tabBar-item-icon">
                        <i class="icon icon-loan"></i>
                    </span>
        <span  style="color: #4a4d54" class="aui-tabBar-item-text">首页</span>
    </a>
    <a href="<?php echo url('integral/index/index'); ?>" class="aui-tabBar-item">
                    <span class="aui-tabBar-item-icon">
                        <i class="icon icon-meTo"></i>
                    </span>
        <span style="color: #4a4d54" class="aui-tabBar-item-text">积分兑换</span>
    </a>
    <a href="<?php echo url('member/index/index'); ?>" class="aui-tabBar-item ">
                    <span class="aui-tabBar-item-icon">
                        <i class="icon icon-find"></i>
                    </span>
        <span style="color: #4a4d54" class="aui-tabBar-item-text">我的</span>
    </a>
</footer>
</body>
</html>