<?php
namespace app\product\controller;

/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品模版管理
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Producttemplate.php 2019-05-22 09:58:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Paginator;
use think\File;
use think\Image;
use \app\common\controller\CommonBase;
class Producttemplate extends CommonBase
{
    public function index(){
        echo '产品模版管理页面';
    }
}