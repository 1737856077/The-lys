<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"C:\Users\Administrator\Desktop\suyuan\sy/integral/integral\view\index.index.html";i:1555902243;}*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>全部商品</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="/static/integral/css/style1.css" rel="stylesheet" type="text/css" />
</head>
<body>
<section class="aui-flexView">
    <header class="aui-navBar aui-navBar-fixed">
        <a href="javascript:;" class="aui-navBar-item">
            <i class="icon "></i>
        </a>
        <div class="aui-center">
            <span class="aui-center-title">商品中心</span>
        </div>
        <a href="javascript:;" class="aui-navBar-item">
            <i class="icon icon-sys"></i>
        </a>
    </header>
    <section class="aui-scrollView">
        <div class="divHeight"></div>
        <div class="aui-back-white">
            <div class="aui-flex b-line">
                <div class="aui-flex-box">
                    <h3> <i class="icon icon-jf"></i>全部商品</h3>
                </div>
            </div>
            <div class="aui-list-theme">
                <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$pdata): ?>
                <a href="<?php echo url('integral/index/details',['id'=>$pdata['id']]); ?>" class="aui-list-theme-item">
                    <div class="aui-list-img">

                        <?php if(empty($pdata['images'])): ?>
                        <img src="/static/integral/img/nopic-107.png"  alt="">
                        <?php else: ?>
                        <img src="/static/uploads/business/<?php echo $pdata['images']; ?>"  alt="">
                        <?php endif; ?>
                    </div>
                    <div class="aui-list-title">
                        <h3><?php echo $pdata['title']; ?></h3>
                        <div class="aui-list-spell">
                            <span><?php echo $pdata['integral']; ?> <em>积分</em></span>
                        </div>
                        <button>立即兑换</button>
                    </div>
                </a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="divHeight"></div>
    </section>


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
</section>
</body>

</html>
