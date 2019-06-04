<?php
namespace app\hongbao\controller;
use think\Controller;
use think\Db;
use think\Session;

class Index extends Controller
{
    //进入红包领取页
    public function index()
    {
        //查询码附带金额 存入session
        $param = $this->request->param();
        $code_info_id = htmlspecialchars(isset($param['code_info_id']) ? $param['code_info_id'] : '');
        $data = Db::name('red_envelopes_info')->where('compress_code', $code_info_id)->field('price_max')->find();
        $data1 = Db::name('red_envelopes_info')->where('compress_code', $code_info_id)->field('price_min')->find();
        $price_max = implode(',',$data);
        $price_min = implode(',',$data1);
        //获取随机金额
        if ($price_max<$price_min){
            $data = mt_rand($price_max,$price_min);//基数红包//用于最小值除外的基数
            $res = [];//红包池
            for ($i=3;$i<100;$i++){
                $mx = $price_min/$i;
                if ($mx<$price_max){
                    $mx = $price_max+mt_rand(10,50);
                    if($mx>$price_min/2){
                        $mx = $mx/2;
                    }
                }
                $r = mt_rand($price_max,$mx);
                if ($r>100){
                    $res[]=$r;
                }
            }
            $res[]=  $data;
            $money =  array_rand($res);
            Session::set('money',$res[$money]);
        }else{
            return_msg(400,'红包最小金额错误');
        }
        $this->assign('code_info_id',$code_info_id);
        return $this->fetch();
    }
    //红包领取明细
    public function indexList()
    {
        //遍历领取数据
        $id = Session::get('adminid');
        $list = Db::name('openid')->where('admin_id',$id)->order('id','desc')->paginate(5);
        $con = count($list);
        //查询出商家账户剩余金额
        $business_money = Db::name('red_envelopes')->where('admin_id',$id)->field('price_total')->find();
        $business_money1 = implode(',',$business_money);
        //查询出用户领取总金额
        $user_money = Db::name('openid')->where('admin_id',$id)->sum('money');
        //计算剩余金额
        $surplus = $business_money1-$user_money;
        Session::set('surplus',$surplus);
//        dump($Surplus);die;
        $this->assign('list',$list);
        $this->assign('count',$con);
        $this->assign('surplus_money',$surplus);
        return $this->fetch();
    }
}

