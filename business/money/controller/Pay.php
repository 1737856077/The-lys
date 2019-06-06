<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 15:18
 */

namespace app\money\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Session;

class Pay extends Controller
{
    public function pagePay()
    {
       // Loader::import('onlinepay.alipay.index',EXTEND_PATH,'.php');
        //获取数据
        $param = $this->request->param();
        $WIDout_trade_no = $param['WIDout_trade_no'];
        $WIDsubject = $param['WIDsubject'];
        $WIDtotal_amount = $param['WIDtotal_amount'];
        //获取到商家现在的有效期
        $id = Session::get('bus_adminid');
        $year1 = Db::name('admin_business')->where('admin_id',$id)->field('expiration_date')->find();
        $num = implode(',',$year1);
        if($WIDsubject == 1){
            //添加数据库
            $data = [
                'order_no'=>$WIDout_trade_no,
                'admin_id'=>Session::get('adminid'),
                'amount'=>$WIDtotal_amount,
                'num'=>$WIDsubject,
                'pay_status'=>0,
                'pay_type'=>0,
                'pay_method'=>1,
                'create_time'=>time(),
                'stage'=>$num,
            ];
        }elseif ($WIDsubject == 2){
            //添加数据库
            $data = [
                'order_no'=>$WIDout_trade_no,
                'admin_id'=>Session::get('adminid'),
                'amount'=>$WIDtotal_amount,
                'num'=>$WIDsubject+1,
                'pay_status'=>0,
                'pay_type'=>0,
                'pay_method'=>1,
                'create_time'=>time(),
                'stage'=>$num,
            ];
        }elseif ($WIDsubject == 3){
            //添加数据库
            $data = [
                'order_no'=>$WIDout_trade_no,
                'admin_id'=>Session::get('adminid'),
                'amount'=>$WIDtotal_amount,
                'num'=>$WIDsubject+2,
                'pay_status'=>0,
                'pay_type'=>0,
                'pay_method'=>1,
                'create_time'=>time(),
                'stage'=>$num,
            ];
        }
        Db::name('order')->insert($data);
//        $WIDsubject='标题';
        $this->assign("WIDout_trade_no",$WIDout_trade_no);
        $this->assign("WIDsubject",$WIDsubject);
        $this->assign("WIDtotal_amount",$WIDtotal_amount);
        $this->assign("WIDbody",'描述');
        $this->assign("adminid",Session::get('bus_adminid'));
        return $this->fetch('preorder/suborder');
    }

}