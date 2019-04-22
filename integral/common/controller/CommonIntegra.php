<?php
namespace app\common\controller;
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:CommonAdmin.php 2018-04-05 13:50:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use think\Image;
use think\Session;
class CommonIntegra extends Controller
{
    /**
     * @描述：初始方法
     */
    public function _initialize(){
        parent::_initialize();

        if(!Session::has('memberid') ){
            echo "<script language=\"javascript\">window.open('/integral.php','_top');</script>";
            exit;
        }
    }

}