<?php
namespace app\admin\controller;

/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:分享注册
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Adminshare.php 2019-02-23 16:34:00 $
 */


use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Adminshare extends CommonAdmin
{
    /**
     * @描述：分享注册
     */
    public function  index()
    {
        $admin_id=Session::get('adminid');
        $share_url='http://'.$_SERVER['SERVER_NAME'].'/regin?fromUserId='.$admin_id;
        $this->assign("share_url",$share_url);
        $this->assign("admin_id",$admin_id);
        return $this->fetch();
    }
}