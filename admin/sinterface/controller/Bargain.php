<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 14:33
 */

namespace app\sinterface\controller;


use app\common\controller\CommonBaseHome;
use think\Db;

class Bargain extends CommonBaseHome
{
    /**
     * 统计表
     */
    public function index()
    {
        $order_model = Db::name('integral_order');
        $jishu = (60 * 60 * 24);
        $one = strtotime("previous monday");
        $two =$one+$jishu;
        $three = $two+$jishu;
        $four = $three+$jishu;
        $five = $four+$jishu;
        $six = $five+$jishu;
        $seven = $six+$jishu;
        $data = [
            $one,
            $two,
            $three,
            $four,
            $five,
            $six,
            $seven,
        ];
        $time = strtotime(date("Y-m-d",time()));
        $res = [];
        foreach ($data as $k=>$v){

            if ($k<6){
                $d = $k+1;
            }
            $Monday = Db::query(" 
              SELECT SUM(price_total) as price_total,COUNT(*) as nums ,SUM(num) as num  FROM sy_integral_order
            WHERE create_time
            BETWEEN $data[$k] AND $data[$d] 
            ");
            $res[] = $Monday;
        }
        $data = [];
        foreach ($res as $vv=>$kk)
        {
            $data[] = $kk[0];
        }
        return_msg(200,'成功',$data);
    }
}