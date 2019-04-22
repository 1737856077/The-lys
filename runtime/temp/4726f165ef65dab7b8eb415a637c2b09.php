<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"C:\Users\Administrator\Desktop\suyuan\sy/integral/index\view\index.index.html";i:1555899361;}*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
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
            <span class="aui-center-title">积分对换中心</span>
        </div>
        <a href="javascript:;" class="aui-navBar-item">
            <i class="icon icon-sys"></i>
        </a>
    </header>
    <section class="aui-scrollView">
        <div class="aui-banner">
            <img src="/static/integral/img/banner.png" alt="">
        </div>
        <div class="divHeight"></div>
        <div class="aui-back-white">
            <div class="aui-flex b-line">
                <div class="aui-flex-box">
                    <h2>我的积分: <em><?php echo $integral; ?></em></h2>
                </div>
            </div>
            <!--<div class="aui-palace aui-palace-one">-->
                <!--<a href="javascript:" class="aui-palace-grid">-->
                    <!--<div class="aui-palace-grid-icon">-->
                        <!--<img src="/static/integral/img/icon-we-001.png" alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-palace-grid-text">-->
                        <!--<span>签到</span>-->
                    <!--</div>-->
                <!--</a>-->
                <!--<a href="javascript:" class="aui-palace-grid">-->
                    <!--<div class="aui-palace-grid-icon">-->
                        <!--<img src="/static/integral/img/icon-we-002.png" alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-palace-grid-text">-->
                        <!--<span>活动</span>-->
                    <!--</div>-->
                <!--</a>-->
                <!--<a href="javascript:" class="aui-palace-grid">-->
                    <!--<div class="aui-palace-grid-icon">-->
                        <!--<img src="/static/integral/img/icon-we-003.png"  alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-palace-grid-text">-->
                        <!--<span>积分</span>-->
                    <!--</div>-->
                <!--</a>-->
                <!--<a href="javascript:" class="aui-palace-grid">-->
                    <!--<div class="aui-palace-grid-icon">-->
                        <!--<img src="/static/integral/img/icon-we-004.png"  alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-palace-grid-text">-->
                        <!--<span>商城</span>-->
                    <!--</div>-->
                <!--</a>-->
            <!--</div>-->
            <!--<div class="divHeight"></div>-->
            <div class="aui-flex b-line">
                <div class="aui-flex-box">
                    <h3> <i class="icon icon-jf"></i> 热门兑换</h3>
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
                <!--<a href="javascript:;" class="aui-list-theme-item">-->
                    <!--<div class="aui-list-img">-->
                        <!--<img src="/static/integral/img/ad-002.png"  alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-list-title">-->
                        <!--<h3>维达抽纸3层M码</h3>-->
                        <!--<div class="aui-list-spell">-->
                            <!--<span>20000 <em>积分</em></span>-->
                        <!--</div>-->
                        <!--<button>立即兑换</button>-->
                    <!--</div>-->
                <!--</a>-->
                <!--<a href="javascript:;" class="aui-list-theme-item">-->
                    <!--<div class="aui-list-img aui-list-img-mar-top">-->
                        <!--<div class="aui-list-img-text">-->
                            <!--<h2>抵扣劵</h2>-->
                            <!--<p>￥20.00</p>-->
                        <!--</div>-->
                        <!--<img src="/static/integral/img/red.png" alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-list-title">-->
                        <!--<h3>20元折扣红包</h3>-->
                        <!--<div class="aui-list-spell">-->
                            <!--<span>20000 <em>积分</em></span>-->
                        <!--</div>-->
                        <!--<button>立即兑换</button>-->
                    <!--</div>-->
                <!--</a>-->
                <!--<a href="javascript:;" class="aui-list-theme-item">-->
                    <!--<div class="aui-list-img aui-list-img-mar-top">-->
                        <!--<div class="aui-list-img-text">-->
                            <!--<h2>抵扣劵</h2>-->
                            <!--<p>￥20.00</p>-->
                        <!--</div>-->
                        <!--<img src="/static/integral/img/red.png" alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-list-title">-->
                        <!--<h3>20元折扣红包</h3>-->
                        <!--<div class="aui-list-spell">-->
                            <!--<span>20000 <em>积分</em></span>-->
                        <!--</div>-->
                        <!--<button>立即兑换</button>-->
                    <!--</div>-->
                <!--</a>-->
                <!--<a href="javascript:;" class="aui-list-theme-item">-->
                    <!--<div class="aui-list-img aui-list-img-mar-top">-->
                        <!--<div class="aui-list-img-text">-->
                            <!--<h2>抵扣劵</h2>-->
                            <!--<p>￥20.00</p>-->
                        <!--</div>-->
                        <!--<img src="/static/integral/img/blue.png"  alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-list-title">-->
                        <!--<h3>20元折扣红包</h3>-->
                        <!--<div class="aui-list-spell">-->
                            <!--<span>20000 <em>积分</em></span>-->
                        <!--</div>-->
                        <!--<button>立即兑换</button>-->
                    <!--</div>-->
                <!--</a>-->
                <!--<a href="javascript:;" class="aui-list-theme-item">-->
                    <!--<div class="aui-list-img aui-list-img-mar-top">-->
                        <!--<div class="aui-list-img-text">-->
                            <!--<h2>抵扣劵</h2>-->
                            <!--<p>￥20.00</p>-->
                        <!--</div>-->
                        <!--<img src="/static/integral/img/blue.png" t alt="">-->
                    <!--</div>-->
                    <!--<div class="aui-list-title">-->
                        <!--<h3>20元折扣红包</h3>-->
                        <!--<div class="aui-list-spell">-->
                            <!--<span>20000 <em>积分</em></span>-->
                        <!--</div>-->
                        <!--<button>立即兑换</button>-->
                    <!--</div>-->
                <!--</a>-->
            </div>
        </div>
        <div class="divHeight"></div>
    </section>









    <footer class="aui-footer aui-footer-fixed">
        <a href="<?php echo url('index/index'); ?>"  class="aui-tabBar-item">
                    <span class="aui-tabBar-item-icon">
                        <i class="icon icon-loan"></i>
                    </span>
            <span  style="color: #4a4d54" class="aui-tabBar-item-text">首页</span>
        </a>
        <!--<a href="javascript:;" class="aui-tabBar-item">-->
                    <!--<span class="aui-tabBar-item-icon">-->
                        <!--<i class="icon icon-credit"></i>-->
                    <!--</span>-->
            <!--<span class="aui-tabBar-item-text">直达</span>-->
        <!--</a>-->
        <a href="<?php echo url('integral/index/index'); ?>" class="aui-tabBar-item">
                    <span class="aui-tabBar-item-icon">
                        <i class="icon icon-meTo"></i>
                    </span>
            <span style="color: #4a4d54" class="aui-tabBar-item-text">积分兑换</span>
        </a>
        <!--<a href="javascript:;" class="aui-tabBar-item">-->
                    <!--<span class="aui-tabBar-item-icon">-->
                        <!--<i class="icon icon-my"></i>-->
                    <!--</span>-->
            <!--<span class="aui-tabBar-item-text">关注</span>-->
        <!--</a>-->
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
