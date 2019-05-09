<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 15:18
 */

namespace app\money\controller;

use think\Controller;
use think\Loader;

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
//        dump($WIDsubject);die;
//        $WIDsubject='标题';
        $this->assign("WIDout_trade_no",$WIDout_trade_no);
        $this->assign("WIDsubject",$WIDsubject);
        $this->assign("WIDtotal_amount",$WIDtotal_amount);
        $this->assign("WIDbody",'描述');
        return $this->fetch('preorder/suborder');
    }

}