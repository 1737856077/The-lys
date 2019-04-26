<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 10:25
 */

namespace app\data\controller;


use think\Controller;

class Data extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}