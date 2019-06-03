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
        $data = Db::name('product_code_info')->where('compress_code', $code_info_id)->field('integral_num')->find();
        $money = implode(',',$data);
        Session::set('money',$money);
        $this->assign('code_info_id',$code_info_id);
        return $this->fetch();
    }
}

