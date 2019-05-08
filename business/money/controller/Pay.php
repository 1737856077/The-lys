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
        //Loader::import('demo.index',EXTEND_PATH,'.php');
        $WIDsubject='标题';
        $this->assign("WIDout_trade_no",'订单号');
        $this->assign("WIDsubject",$WIDsubject);
        $this->assign("WIDtotal_amount",'0.01');
        $this->assign("WIDbody",'描述');
        return $this->fetch('preorder/suborder');
    }

}