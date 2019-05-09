<?php
namespace app\wechat\controller;
/**
 * Created by PhpStorm.
 * User: Edianzu
 * Date: 2019/5/9
 * Time: 12:32
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\Cookie;
use think\model;
use think\Config;
class Test extends Controller
{
    public function index(){
        return $this->fetch();
    }
}