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
        //获取生码总积分
        $id = Session::get('bus_adminid');
        $num = Db::name('product_code')->where('admin_id',$id)->field('num')->select();
        $count = count($num);
        $integral = '';
        foreach ($num as $k=>$v){
            $integral += $v['num'];
        }
        //获取扫码的积分
        $integral1 = Db::name('member')->where('admin_id',$id)->sum('invoice_money');
        //已兑换商品所用积分
        $integral2 = Db::name('integral_order')->where('admin_id',$id)->sum('pay_real');
        //剩余积分总数
        $integral3 = $integral1-$integral2;

        $this->assign('integral',$integral);
        $this->assign('integral1',$integral1);
        $this->assign('integral2',$integral2);
        $this->assign('integral3',$integral3);
        $this->assign('count', $count);
        return $this->fetch();
    }
}