<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/29
 * Time: 17:43
 */

namespace app\index\controller;


use think\Controller;

class Test extends Controller
{
    public function index()
    {
     return $this->hongbao();
    }
    public function hongbao($min=100,$max=500)
    {

        if ($min<$max){
            $data = mt_rand($min,$max);//基数红包//用于最小值除外的基数
            $res = [];//红包池
            for ($i=3;$i<100;$i++){
                $mx = $max/$i;
                if ($mx<$min){
                    $mx = $min+mt_rand(10,50);
                    if($mx>$max/2){
                        $mx = $mx/2;
                    }
                }
                $r = mt_rand($min,$mx);
                if ($r>100){
                    $res[]=$r;
                }
            }
            $res[]=  $data;
            $money =  array_rand($res);
            dump($res[$money]);
        }else{
           return_msg(400,'红包最小金额错误');
        }

    }
}