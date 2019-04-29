<?php
namespace app\public_address\controller;
use think\Controller;

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
        return $this->fetch();
    }
}