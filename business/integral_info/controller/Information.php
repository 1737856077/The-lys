<?php
namespace app\integral_info\controller;
use think\Controller;
use think\Db;
use think\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/22
 * Time: 16:06
 */

class Information extends Controller
{
    /**
     * @return 积分信息
     */
    public function index()
    {
        $id = Session::get('adminid');
        $name = Session::get('adminname');
        $list = Db::name('member')->where('admin_id',$id)->paginate(2);
        $this->assign('list',$list);
        $this->assign('name',$name);
//        dump($list);die;
        return $this->fetch();
    }
}