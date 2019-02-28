<?php
namespace app\design\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-用户注册
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Register.php 2019-02-28 19:32:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;
class Online extends CommonBaseHome
{
    public function index(){
        return $this->fetch();
    }
}