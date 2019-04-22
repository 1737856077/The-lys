<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/22
 * Time: 10:46
 */

namespace app\order\controller;

use app\common\controller\CommonIntegra;
use think\Db;
use think\Session;

class Index extends CommonIntegra
{
    //订单填写页面
    public function index()
    {
        $param = $this->request->param();
        //查询基本信息
        $id = htmlspecialchars(isset($param['id']) ? $param['id'] : '');
        $poduct_id = htmlspecialchars(isset($param['product_id']) ? $param['product_id'] : '');
        $admin_id = htmlspecialchars(isset($param['admin_id']) ? $param['admin_id'] : '');
        $appid = htmlspecialchars(isset($param['appid']) ? $param['appid'] : '');
        $memberid = Session::get('memberid');
        if (empty($id) or empty($poduct_id) or empty($admin_id) or empty($appid)) {
            echo '请求错误';
            exit();
        }
        $member_mode = Db::name('member');//会员表
        $meber_data = $member_mode->where('id', $memberid)->find();
        $uid = isset($meber_data['uid']) ? $meber_data['uid'] : '';
        if (empty($uid)) {
            echo '请求错误';
            exit();
        }
        //查询商品信息
        $product_integral_data = Db::name('product_integral')->where('product_id', $poduct_id)->where('data_status',1)->find();
        //查询收货地址默认注册没有收货地址请添加
        $member_rceiving_address_data = Db::name('rceiving_address')->where('uid',$uid)->where('data_type',1)->select();
        dump($member_rceiving_address_data);die();
        $this->assign([
            'rceiving_address'=>$member_rceiving_address_data,
            'member_data'=>$meber_data,
            'product_data' => $product_integral_data,
            'id' => $id,
            'uid' => $uid,
            'product_id' => $poduct_id,
            'admin_id' => $admin_id,
            'appid' => $appid,
            'memberid' => $memberid
        ]);
        return $this->fetch();
    }
}