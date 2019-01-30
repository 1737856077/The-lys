<?php
namespace app\common\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
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

        if(!Session::has('adminname') ){
            echo "<script language=\"javascript\">window.open('/admin.php','_top');</script>";
            exit;
        }
    }

}