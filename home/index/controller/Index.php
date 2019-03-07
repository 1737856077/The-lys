<?php
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-首页处理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Index.php 2018-07-22 19:32:00 $
 */
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;

class Index extends  Controller
{
    public function index(){
        echo "<script language=\"javascript\">window.location.href='http://www.kedousuyuan.com/';</script>";
        exit;
    }
}

