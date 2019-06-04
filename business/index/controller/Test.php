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
            return_msg(200,'ok',$res);
        }else{
           return_msg(400,'红包最小金额错误');
        }

    }
    public function test1($total=200, $num=20,$min=0.01) {

        $total=$total;//红包总额
        $num=$num;// 分成8个红包，支持8人随机领取
        $min=$min;//每个人最少能收到0.01元

        for ($i=1;$i<$num;$i++)
        {
            $safe_total=($total-($num-$i)*$min)/($num-$i);
            $money=mt_rand($min*100,$safe_total*100)/100;
            $total=$total-$money;
            echo '第'.$i.'个红包：'.$money.' 元，余额：'.$total.' 元 <br/>';
        }
        echo '第'.$num.'个红包：'.$total.' 元，余额：0 元';
    }
}