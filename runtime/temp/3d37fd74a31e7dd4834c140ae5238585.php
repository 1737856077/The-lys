<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"C:\phpStudy\PHPTutorial\WWW\sy/business/integral_info\view\information.index.html";i:1555987497;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <style type="text/css">[uib-typeahead-popup].dropdown-menu {
        display: block;
    }</style>
    <style type="text/css">.uib-time input {
        width: 50px;
    }</style>
    <style type="text/css">[uib-tooltip-popup].tooltip.top-left > .tooltip-arrow, [uib-tooltip-popup].tooltip.top-right > .tooltip-arrow, [uib-tooltip-popup].tooltip.bottom-left > .tooltip-arrow, [uib-tooltip-popup].tooltip.bottom-right > .tooltip-arrow, [uib-tooltip-popup].tooltip.left-top > .tooltip-arrow, [uib-tooltip-popup].tooltip.left-bottom > .tooltip-arrow, [uib-tooltip-popup].tooltip.right-top > .tooltip-arrow, [uib-tooltip-popup].tooltip.right-bottom > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.top-left > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.top-right > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.bottom-left > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.bottom-right > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.left-top > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.left-bottom > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.right-top > .tooltip-arrow, [uib-tooltip-html-popup].tooltip.right-bottom > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.top-left > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.top-right > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.bottom-left > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.bottom-right > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.left-top > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.left-bottom > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.right-top > .tooltip-arrow, [uib-tooltip-template-popup].tooltip.right-bottom > .tooltip-arrow, [uib-popover-popup].popover.top-left > .arrow, [uib-popover-popup].popover.top-right > .arrow, [uib-popover-popup].popover.bottom-left > .arrow, [uib-popover-popup].popover.bottom-right > .arrow, [uib-popover-popup].popover.left-top > .arrow, [uib-popover-popup].popover.left-bottom > .arrow, [uib-popover-popup].popover.right-top > .arrow, [uib-popover-popup].popover.right-bottom > .arrow, [uib-popover-html-popup].popover.top-left > .arrow, [uib-popover-html-popup].popover.top-right > .arrow, [uib-popover-html-popup].popover.bottom-left > .arrow, [uib-popover-html-popup].popover.bottom-right > .arrow, [uib-popover-html-popup].popover.left-top > .arrow, [uib-popover-html-popup].popover.left-bottom > .arrow, [uib-popover-html-popup].popover.right-top > .arrow, [uib-popover-html-popup].popover.right-bottom > .arrow, [uib-popover-template-popup].popover.top-left > .arrow, [uib-popover-template-popup].popover.top-right > .arrow, [uib-popover-template-popup].popover.bottom-left > .arrow, [uib-popover-template-popup].popover.bottom-right > .arrow, [uib-popover-template-popup].popover.left-top > .arrow, [uib-popover-template-popup].popover.left-bottom > .arrow, [uib-popover-template-popup].popover.right-top > .arrow, [uib-popover-template-popup].popover.right-bottom > .arrow {
        top: auto;
        bottom: auto;
        left: auto;
        right: auto;
        margin: 0;
    }

    [uib-popover-popup].popover, [uib-popover-html-popup].popover, [uib-popover-template-popup].popover {
        display: block !important;
    }</style>
    <style type="text/css">.uib-datepicker-popup.dropdown-menu {
        display: block;
        float: none;
        margin: 0;
    }

    .uib-button-bar {
        padding: 10px 9px 2px;
    }</style>
    <style type="text/css">.uib-position-measure {
        display: block !important;
        visibility: hidden !important;
        position: absolute !important;
        top: -9999px !important;
        left: -9999px !important;
    }

    .uib-position-scrollbar-measure {
        position: absolute !important;
        top: -9999px !important;
        width: 50px !important;
        height: 50px !important;
        overflow: scroll !important;
    }

    .uib-position-body-scrollbar-measure {
        overflow: scroll !important;
    }</style>
    <style type="text/css">.uib-datepicker .uib-title {
        width: 100%;
    }

    .uib-day button, .uib-month button, .uib-year button {
        min-width: 100%;
    }

    .uib-left, .uib-right {
        width: 100%
    }</style>
    <style type="text/css">.ng-animate.item:not(.left):not(.right) {
        -webkit-transition: 0s ease-in-out left;
        transition: 0s ease-in-out left
    }</style>
    <style type="text/css">@charset "UTF-8";
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide:not(.ng-hide-animate) {
        display: none !important;
    }

    ng\:form {
        display: block;
    }

    .ng-animate-shim {
        visibility: hidden;
    }

    .ng-anchor {
        position: absolute;
    }</style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>积分信息页</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="https://weixin.zijiahei.com/web/resource/images/favicon.ico">
    <link href="/static/business/css/bootstrap.css" rel="stylesheet">
    <link href="/static/business/css/common.css" rel="stylesheet">
    <script src="/static/business/s.txt"></script>
    <script type="text/javascript">
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
        window.sysinfo = {
            'uid': '1', 'isfounder': 1,
            'family': 'x',
            'siteroot': 'https://weixin.zijiahei.com/',
            'siteurl': 'https://weixin.zijiahei.com/web/index.php?c=user&a=profile&do=bind',
            'attachurl': 'https://weixin.zijiahei.com/attachment/',
            'attachurl_local': 'https://weixin.zijiahei.com/attachment/',
            'attachurl_remote': '',
            'module': {'url': '', 'name': ''},
            'cookie': {'pre': '1b74_'},
            'account': null,
            'server': {'php': '5.4.45'},
        };
    </script>
    <script>var require = {urlArgs: 'v=20170915'};</script>
    <script type="text/javascript" src="/static/business/js/jquery-1.js"></script>
    <script type="text/javascript" src="/static/business/js/bootstrap.js"></script>
    <script type="text/javascript" src="/static/business/js/util.js"></script>
    <script type="text/javascript" src="/static/business/js/common.js"></script>
    <script type="text/javascript" src="/static/business/js/require.js"></script>
</head>
<body>
<div class="loader" style="display:none">
    <div class="la-ball-clip-rotate">
        <div></div>
    </div>
</div>
<div data-skin="default" class="skin-default ">
    <div class="head">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container ">
                <div class="navbar-header">
                    <a class="navbar-brand" href="https://weixin.zijiahei.com/">
                        <img src="/static/business/img/logo.png" class="pull-left" width="110px" height="35px">
                        <span class="version hidden">1.6.7</span>
                    </a>
                </div>

            </div>
        </nav>
    </div>

    <div class="main">
        <div class="container">
            <a href="javascript:;" class="js-big-main button-to-big color-gray" title="加宽">宽屏</a>
            <div class="panel panel-content main-panel-content ">
                <div class="content-head panel-heading main-panel-heading">
                    <span class="font-lg"><i class="wi wi-setting"></i> 商家管理</span></div>
                <div class="panel-body clearfix main-panel-body menu-fixed">
                    <div class="left-menu" style="min-height: 490px;">
                        <div class="left-menu-content">

                            <div class="left-menu-content">

                                <div class="panel panel-menu">
                                    <div class="panel-heading">
                                    <span class="no-collapse">公众号<i
                                            class="wi wi-appsetting pull-right setting"></i></span>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item ">
                                            <a href="https://weixin.zijiahei.com/web/index.php?c=account&amp;a=manage&amp;account_type=1"
                                               class="text-over">
                                                <i class="wi wi-wechat"></i>
                                                微信公众号 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href="https://weixin.zijiahei.com/web/index.php?c=module&amp;a=manage-system&amp;account_type=1"
                                               class="text-over">
                                                <i class="wi wi-wx-apply"></i>
                                                公众号应用 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href="https://weixin.zijiahei.com/web/index.php?c=system&amp;a=template&amp;"
                                               class="text-over">
                                                <i class="wi wi-wx-template"></i>
                                                微官网模板 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href="https://weixin.zijiahei.com/web/index.php?c=system&amp;a=platform&amp;"
                                               class="text-over">
                                                <i class="wi wi-exploitsetting"></i>
                                                微信开放平台 </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="panel panel-menu">
                                    <div class="panel-heading">
                                    <span class="no-collapse">积分商城<i
                                            class="wi wi-appsetting pull-right setting"></i></span>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item ">
                                            <a href="/business.php/qrcode/productcode/index"
                                               class="text-over">
                                                <i class="wi wi-user"></i>
                                                积分码列表 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href="/business.php/qrcode/createqrcode/add"
                                               class="text-over">
                                                <i class="wi wi-user"></i>
                                                生成积分码 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href=""
                                               class="text-over">
                                                <i class="wi wi-user-group"></i>
                                                积分信息 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href="/business.php/gift/gift/gift"
                                               class="text-over">
                                                <i class="wi wi-co-founder"></i>
                                                礼品管理 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href=""
                                               class="text-over">
                                                <i class="wi wi-co-founder"></i>
                                                订单管理 </a>
                                        </li>
                                        <li class="list-group-item ">
                                            <a href=""
                                               class="text-over">
                                                <i class="wi wi-co-founder"></i>
                                                财务中心 </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="right-content" style="min-height: 490px;">
                        <ul class="we7-page-tab">
                            <li class="active"><a
                                    href="https://weixin.zijiahei.com/web/index.php?c=user&amp;a=display&amp;">积分信息</a>
                            </li>

                        </ul>
                        <div class="keyword-list-head clearfix we7-margin-bottom">
                            <form action="" method="get">
                                <input type="hidden" name="c" value="user">
                                <input type="hidden" name="a" value="display">
                                <input type="hidden" name="do" value="">
                                <input type="hidden" name="type" value="">
                                <!--<div class="input-group pull-left col-sm-4">
                                    <input type="text" name="username" id="" class="form-control" placeholder="搜索用户名">
                                    <span class="input-group-btn"><button class="btn btn-default"><i
                                            class="fa fa-search"></i></button></span>
                                </div>-->
                            </form>

                        </div>
                        <table class="table we7-table table-hover table-manage vertical-middle ng-scope"
                               id="js-users-display" ng-controller="UsersDisplay">
                            <colgroup>
                                <col width="150px">
                                <col width="150px">
                                <col width="180px">
                                <col width="140px">
                                <col width="140px">
                                <col width="140px">
                                <col width="160px">
                                <col width="150px">
                                <col width="150px">
                            </colgroup>
                            <tbody>
                            <tr>
                                <th class="text-left">用户名</th>
                                <th>所属商家</th>
                                <th>联系方式</th>
                                <th>积分余额</th>
                                <th>已消费积分</th>
                            </tr>
                            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr ng-repeat="user in users" ng-if="users" class="ng-scope">
                                <td class="text-left ng-binding" ng-bind="user.username"><?php echo $vo['username']; ?></td>
                                <td class="text-left ng-binding" ng-bind="user.username"><?php echo $name; ?></td>
                                <td class="color-default ng-binding" ng-bind="user.maxaccount"><?php echo $vo['moblie']; ?></td>
                                <td class="color-default ng-binding" ng-bind="user.maxwxapp"><?php echo $vo['invoice_money']; ?></td>
                                <td class="color-default ng-binding" ng-bind="user.maxwebapp">000</td>
                            </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                        <div class="text-right">
                            <?php echo $list->render(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid footer text-center" role="footer">
        <div class="friend-link">
            红包管理系统
        </div>
        <div class="copyright">红包管理系统</div>
        <div></div>
    </div>
</div>

</body>
</html>