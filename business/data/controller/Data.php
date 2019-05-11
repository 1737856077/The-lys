<?php
namespace app\data\controller;
use think\Controller;
use think\Db;
use think\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/28
 * Time: 11:14
 */

class Data extends Controller
{
    /**
     * @return 商家管理数据中心显示
     */
    public function index()
    {
        $id = Session::get('adminid');
        //查询扫码记录
        /*$product = Db::name('product ')
            ->alias('a')
            ->join('product_code_info_visit_record w', 'a.product_id = w.product_id')
            ->join('admin s', 's.admin_id = a.admin_id')
            ->field('name,title')
            ->select();*/
        $product = Db::name('product_code_info')->where('admin_id',$id)->where('code_status',1)->select();
        $count = count($product);
//        dump($count);die; 
        //兑换的产品数量数据
        $id = Session::get('adminid');
        $con = Db::name('integral_order')->where('admin_id',$id)->field('order_no')->select();
        $count2 = count($con);
//        dump($count2);die;
        $this->assign('count',$count);
        $this->assign('count2',$count2);
        return $this->fetch();
    }

}