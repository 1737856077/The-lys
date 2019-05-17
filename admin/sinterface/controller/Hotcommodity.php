<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 13:49
 */

namespace app\sinterface\controller;


use app\common\controller\CommonBaseHome;
use think\Db;

class Hotcommodity extends CommonBaseHome
{
    /**
     * 热门商品
     */
    public function index()
    {
        $sql = "SELECT `product_id`,COUNT(`product_id`) AS c FROM `sy_integral_order` GROUP BY `product_id` ORDER BY c DESC LIMIT 10";
        $data = Db::query($sql);
        $res = array();
        $num = Db::name('integral_order')->count('id');
        foreach($data as $k=>$v)
        {
            $d['title'] = Db::name('product_integral')->where('product_id',$v['product_id'])->find()['title'];
            $d['num'] = $v['c'];
            $d['ratio'] = round(($v['c']/$num)*100)."%";
            $res[] = $d;
        }
        return return_msg(200,'ok',$res);
    }
}