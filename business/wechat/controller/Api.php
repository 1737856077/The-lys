<?php
namespace app\wechat\controller;
/**
 * Created by PhpStorm.
 * User: Edianzu
 * Date: 2019/5/5
 * Time: 8:56
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\wechat\controller\HomeCommonAction;
use \app\wechat\controller\HomeGetWinXinInfoAction;
class Api extends HomeCommonAction{

    private $GetUserOpenid="";

    public function index(){
        $GetWinXinInfoAction=new HomeGetWinXinInfoAction();
        $this->GetUserOpenid=$GetWinXinInfoAction->GetOpenid();
        echo $this->GetUserOpenid;
        exit;
    }
}