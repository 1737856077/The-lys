<?php
namespace app\order\controller;
use think\Controller;

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
        return $this->fetch();
    }
}