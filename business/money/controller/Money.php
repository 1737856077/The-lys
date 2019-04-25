<?php
namespace app\money\controller;
use think\Controller;
use think\Db;
use think\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/23
 * Time: 14:03
 */

class Money extends Controller
{
    /**
     * @return 财务首页
     */
    public function index()
    {
        //获取当前用户表的 余额
        $id = Session::get('adminid');
        $money = Db::name('admin_business')->where('id',$id)->field('account')->find();
        $this->assign('money',$money);
        return $this->fetch();
    }

}