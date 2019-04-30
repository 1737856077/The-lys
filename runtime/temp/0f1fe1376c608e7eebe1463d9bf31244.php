<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"C:\Users\Administrator\Desktop\suyuan\sy/integral/member\view\index.index.html";i:1556279950;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户中心</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link href="/static/integral/css/user.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/static/integral/js/jquery.js"></script>
    <script type="text/javascript" src="/static/integral/js/jquery-1.7.2.min.js"></script>
</head>
<body>
<section class="aui-flexView">
    <?php if(!empty($member_data)): ?>  <section class="aui-scrollView">
    <div class="aui-flex aui-flex-user b-line">
        <div class="aui-ona-user">
            <?php if(empty($member_data['img'])): ?>
            <form class="form1" action="" enctype="multipart/form-data">
            <img src="/static/integral/img/user.png"  alt=""> <input onchange="save()" name="img" type="file" style="display:block;width:70px;height: 70px;opacity:0;margin-top: -70px;position:absolute" />
            </form>
                <?php else: ?>
            <form action=""  class="form1" enctype="multipart/form-data">
                <img src="<?php echo $member_data['img']; ?>"  alt=""> <input onchange="save()" name="img" type="file" style="display:block;width:70px;height: 70px;opacity:0;margin-top: -70px;position:absolute" />
            </form>
            <?php endif; ?>
        </div>
        <script>
            function save() {
                var form = new FormData(document.getElementsByClassName("form1"));
                $.ajax({
                    //几个参数需要注意一下
                    type: "POST",//方法类型
                    dataType: "json",//预期服务器返回的数据类型
                    url: "/integral.php/member/index/userimg" ,//url
                    data: form,
                    success: function (result) {
                      alert(1)
                    },
                });
            }

        </script>
        <div class="aui-flex-box">
            <h2><?php echo $member_data['username']; ?></h2>
        </div>
    </div>
    <div class="aui-palace">
        <a href="/integral.php/member/index/integrals/uid/<?php echo $member_data['uid']; ?>" class="aui-palace-grid">
            <div class="aui-palace-grid-icon">
                <img src="/static/integral/img/icon-time-002.png"  alt="">
            </div>
            <div class="aui-palace-grid-text">
                <h2>积分详情</h2>
            </div>
        </a>
            <a href="/integral.php/member/index/sorder/uid/<?php echo $member_data['uid']; ?>" class="aui-palace-grid">
            <div class="aui-palace-grid-icon">
                <img src="/static/integral/img/icon-time-003.png" alt="">
            </div>
            <div class="aui-palace-grid-text">
                <h2>我的订单</h2>
            </div>
        </a>
    </div>
    <div class="divHeight"></div>
    <div class="aui-course-list">
        <div class="divHeight"></div>
        <a href="/integral.php/member/index/sorder/uid/<?php echo $member_data['uid']; ?>" class="aui-flex b-line">
            <div class="aui-cou-img">
                <img src="/static/integral/img/icon-tag-004.png"  alt="">
            </div>
            <div class="aui-flex-box">
                <h2>我的订单</h2>
            </div>
            <div class="aui-arrow">
                <p></p>
            </div>
        </a>
        <a href="/integral.php/member/index/integrals/uid/<?php echo $member_data['uid']; ?>" class="aui-flex b-line">
            <div class="aui-cou-img">
                <img src="/static/integral/img/icon-tag-005.png" alt="">
            </div>
            <div class="aui-flex-box">
                <h2>积分详情</h2>
            </div> <div class="aui-arrow">
            <p></p>
        </div>
        </a>
        <a href="/integral.php/member/order/site/uid/<?php echo $member_data['uid']; ?>" class="aui-flex b-line">
            <div class="aui-cou-img">
                <img src="/static/integral/img/icon-tag-006.png"  alt="">
            </div>
            <div class="aui-flex-box">
                <h2>我的地址</h2>
            </div>
            <div class="aui-arrow">
                <p></p>
            </div>
        </a>
        <!--<a href="javascript:;" class="aui-flex">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-007.png" alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>更换身份</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p>更换后原身份作废</p>-->
            <!--</div>-->
        <!--</a>-->
        <!--<div class="divHeight"></div>-->
        <!--<a href="javascript:;" class="aui-flex">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-008.png" alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>交易风险</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p></p>-->
            <!--</div>-->
        <!--</a>-->
        <!--<div class="divHeight"></div>-->
        <!--<a href="javascript:;" class="aui-flex b-line">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-009.png"  alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>分享</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p></p>-->
            <!--</div>-->
        <!--</a>-->
        <!--<a href="javascript:;" class="aui-flex b-line">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-010.png"  alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>设置</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p></p>-->
            <!--</div>-->
        <!--</a>-->
        <!--<a href="javascript:;" class="aui-flex b-line">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-011.png"  alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>关于我们</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p></p>-->
            <!--</div>-->
        <!--</a>-->
        <!--<a href="javascript:;" class="aui-flex b-line">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-012.png" alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>意见反馈</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p></p>-->
            <!--</div>-->
        <!--</a>-->
        <!--<a href="javascript:;" class="aui-flex b-line">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-013.png"  alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>联系我们</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p></p>-->
            <!--</div>-->
        <!--</a>-->
        <!--<a href="javascript:;" class="aui-flex b-line">-->
            <!--<div class="aui-cou-img">-->
                <!--<img src="/static/integral/img/icon-tag-014.png"  alt="">-->
            <!--</div>-->
            <!--<div class="aui-flex-box">-->
                <!--<h2>版本更新</h2>-->
            <!--</div>-->
            <!--<div class="aui-arrow">-->
                <!--<p>当前版本1.2.0</p>-->
            <!--</div>-->
        <!--</a>-->

    </div>
    <div style="height:60px;"></div>

</section>
    <?php else: ?>
    1234
    <?php endif; ?>


    <footer class="aui-footer aui-footer-fixed">
        <a href="<?php echo url('index/index/index'); ?>"  class="aui-tabBar-item">
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
