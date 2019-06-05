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
use \app\common\controller\CommonBase;
class CommonAdmin extends CommonBase
{
    public function __construct(Request $request){

        parent::__construct($request);
    }

    /**
     * @描述：初始方法
     */
    public function _initialize(){
        parent::_initialize();

        if(!Session::has('bus_adminname') ){
            echo "<script language=\"javascript\">window.open('/business.php','_top');</script>";
            exit;
        }
    }

}