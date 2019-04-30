<?php
namespace app\public_address\controller;
use think\Controller;
use think\Db;
use think\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/28
 * Time: 15:11
 */

class Wpa extends Controller
{
    /**
     * @return 微信公众号列表
     */
    public function index()
    {
        //查询已有公众号
        $id = Session::get('adminid');
        $weChap = Db::name('wechat_menu')->where('admin_id',$id)->select();
        $this->assign('weChap',$weChap);
        return $this->fetch();
    }

    /**
     * @return 查看公众号详情
     */
    public function info()
    {
        $this->error('未完成');die;
        return $this->fetch();
    }

    /**
     * @return 管理设置
     */
    public function set()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(isset($param['id']) ? $param['id'] : '');
        $con = Db::name('wechat_menu')->where('id',$id)->find();
        $this->assign('content',$con);
        return $this->fetch();
    }
}