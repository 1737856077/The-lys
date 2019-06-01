<?php
namespace app\order\controller;
/**
 * @[蝌蚪溯源] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:支付宝在线支付示例
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Preorder.php 2019-02-28 19:32:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
class Preorder extends Controller
{
    /**
     * @desc:提交订单
     */
    public function suborder()
    {
        $WIDsubject='标题';
        $this->assign("WIDout_trade_no",'订单号');
        $this->assign("WIDsubject",$WIDsubject);
        $this->assign("WIDtotal_amount",'0.01');
        $this->assign("WIDbody",'描述');
        return $this->fetch('preorder/suborder');
    }
}