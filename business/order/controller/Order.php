<?php

namespace app\order\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/23
 * Time: 13:51
 */
class Order extends Controller
{
    /**
     * @return 订单首页
     */
    public function index()
    {
        $id = Session::get('adminid');
        $list = Db::name('integral_order')->where('admin_id', $id)->paginate(3);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @return 订单详细信息
     */
    public function details()
    {
        $name = Session::get('adminname');
        $param = $this->request->param();
        //根据订单id查询
        $id = htmlspecialchars(intval(isset($param['id']) ? $param['id'] : ''));
        $list = Db::name('integral_order')->where("id",$id)->find();
        $this->assign('list', $list);
        $this->assign('name', $name);
        return $this->fetch();
    }

    /**
     * 商家处理订单信息
     */
    public function add()
    {
        //获取商家提交的物流信息
        $param = $this->request->param();
        $order_no =  htmlspecialchars(isset($param['order_no']) ? $param['order_no'] : '');
        $log =  htmlspecialchars(isset($param['log']) ? $param['log'] : '');
        //判断订单是否支付
        if($param['data_pay'] == '未支付'){
            $this->error('订单未支付，请先提醒用户支付');
        }else{
            $data = [
                'order_no'=>$order_no,
                'delivery_express_id'=>$log,
            ];
            $res = Db::name('integral_order_detail')->insert($data);
            if($res){
                $this->success('订单处理完成','order/index');
            }else{
                $this->error('提交失败');
            }
        }
    }

    /**
     * 设置订单状态
     */
    public function status()
    {
        //获取订单状态 id
        $param = $this->request->param();
        $id =  htmlspecialchars(isset($param['id']) ? $param['id'] : '');
        $statu =  htmlspecialchars(isset($param['status']) ? $param['status'] : '');
        //更新订单状态
        $res = Db::name('integral_order')->where('id',$id)->update(['data_order'=>"$statu"]);
        if($res){
            return json($res);
        }

    }

}