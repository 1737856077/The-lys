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
        //查询会员表 显示用户的积分信息
        //查询该商家的所有用户
        $member = Db::name('member')->where('admin_id', $id)->select();
        //根据用户查询出对应uid
        $uid = '';
        foreach ($member as $value => $k) {
            $uid[] = Db::name('member')->where('username', $k['username'])->field('uid')->find();
        }
        //根据uid 查询对应的订单号
        $order = '';
        foreach ($uid as $v => $k1) {
            $order[] = Db::name('member_integral_record ')->where('uid', $k1['uid'])->sum('price');
        }
        //合并数组数据
        $arr = [];
        foreach ($member as $value=>$k){
            $k['price'] =$order["$value"];
            $arr[] = $k;
        }
        //分页样式
        /*$url= 'http://'.$_SERVER['HTTP_HOST']."/business.php/integral_info/information/index/;
        $page=isset($_GET['page'])? $_GET['page']:1;
        $show=show_array(Session::get('page'),$url);
        $this->assign('page',$show);//传到模板显示*/
        $this->assign('list',$arr);
        return $this->fetch();
    }
}