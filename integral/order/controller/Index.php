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
use think\Model;
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
        if (empty($id) or empty($poduct_id) or empty($admin_id) ) {
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
//        dump($product_integral_data);die();
        //查询收货地址默认注册没有收货地址请添加
        $member_rceiving_address_data = Db::name('rceiving_address')->where('uid',$uid)->where('data_type',1)->find();
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
    /**
     * 提交订单
     */
    public function suborder()
    {
        $param = $this->request->param();
        $description = htmlspecialchars(trim(isset($param['description'])?$param['description']:''));
        $product_id = htmlspecialchars(trim(isset($param['product_id'])?$param['product_id']:''));
        $uid = htmlspecialchars(trim(isset($param['uid'])?$param['uid']:''));
        $integral = htmlspecialchars(trim(intval(isset($param['integral'])?$param['integral']:'')));
        $num = htmlspecialchars(intval(isset($param['num'])?$param['num']:''));
        $appid = htmlspecialchars(isset($param['appid'])?$param['appid']:'');
        $admin_id = htmlspecialchars(intval(isset($param['admin_id'])?$param['admin_id']:''));
        $rceiving_address_id = htmlspecialchars(isset($param['rceiving_address_id'])?$param['rceiving_address_id']:'');
        if (empty($product_id) or  empty($uid) or empty($rceiving_address_id)){
            echo '<script language="javascript">alert("参数错误！");history.go(-1);</script>';
            exit;
        }
        $order_no = date("ymdhis").mt_rand(1000,9999);
        $product_data = Db::name('product_integral')->where('product_id',$product_id)->find();
        if (empty($product_data)){
            echo '<script language="javascript">alert("无商品内容！");history.go(-1);</script>';
            exit;
        }
        $member_data = Db::name('member')->where('uid',$uid)->find();
        if (empty($member_data)){
            echo '<script language="javascript">alert("参数错误！");history.go(-1);</script>';
            exit;
        }
        //计算积分
        $price = $product_data['integral'];
        if ($num<1){
            echo '<script language="javascript">alert("购买商品不能小于1件！");history.go(-1);</script>';
            exit;
        }
        $price_total = ($price*$num);
        $pay_total = $price_total;
        $pay_real = $price_total;
        $pay_real_account = ($member_data['invoice_money']-$price_total);//用户剩余积分
        //库存是否足够
        $nums = Db::name('product_integral')->where('product_id',$product_id)->field('total')->find()['total'];
        $nums = $nums-$num;
        if ($nums<0.01){
            echo '<script language="javascript">alert("库存不足！");history.go(-1);</script>';
            exit;
        }
        if ($pay_real_account<0.01){
            echo '<script language="javascript">alert("账户余额不足！");history.go(-1);</script>';
            exit;
        }
        //订单
        Db::name('member')->where('uid',$uid)->update(['invoice_money'=>$pay_real_account]);
        $members_data = Db::name('member')->where('uid',$uid)->find();
        if ($member_data['invoice_money']==$members_data['invoice_money']){
            $data_pay=0;
        }else{
            $data_pay=1;
        }
        $data = [
          'order_no'=>$order_no,
          'product_id'=>$product_id,
            'uid'=>$uid,
            'price'=>$price,
            'num'=>$num,
            'price_total'=>$price_total,
            'pay_total'=>$price_total,
            'pay_real'=>$pay_real,
            'pay_real_account'=>$pay_real_account,
            'appid'=>$appid,
            'admin_id'=>$admin_id,
            'description'=>$description,
            'data_pay'=>$data_pay,
            'data_order'=>0,
            'create_time'=>time()
        ];
        $rceiving_address_model = Db::name('rceiving_address');
        $region_model = Db::name('region');
        //订单详情表
        $rceiving_address_data = $rceiving_address_model->where('rceiving_address_id',$rceiving_address_id)->find();
        $data_detail = [
            'order_no'=>$order_no,
            'consignee_contacts'=>$rceiving_address_data['name'],
            'consignee_tel'=>$rceiving_address_data['tel'],
            'consignee_province_id'=>$rceiving_address_data['province_id'],
            'consignee_city_id'=>$rceiving_address_data['city_id'],
            'consignee_county_id'=>$rceiving_address_data['county_id'],
            'consignee_address'=>$rceiving_address_data['address'],
            'consignee_code'=>$rceiving_address_data['code'],
            'pay_remind'=>0,
            'pay_time'=>time()

        ];
        //减少库存
        $prres = Db::name('product_integral')->where('product_id',$product_id)->update(['total'=>$nums]);
        //积分操作
        $member_integral_record_mode = Db::name('member_integral_record');
        $member_integral_record_data = [
            'intrgral_record_id' => my_returnUUID(),
            'uid'=>$uid,
            'price'=>$price_total,
            'order_no'=>$order_no,
            'integral_type'=>2,
            'appid'=>$appid,
            'admin_id'=>$admin_id,
            'data_type'=>1,
            'create_time'=>time()
        ];
        $member_integral_record_res = $member_integral_record_mode->insert($member_integral_record_data);
        if (!$member_integral_record_res){

        }
        $integral_order_detail_res = Db::name('integral_order_detail')->insertGetId($data_detail);
        if (!$integral_order_detail_res){

        }

        $integral_order_res = Db::name('integral_order')->insertGetId($data);
        return $this->corder($integral_order_detail_res,$integral_order_res);

    }
    /**
     * 查看订单
     */
    public function corder($a,$b)
    {
        $integral = Db::name('integral_order_detail')->where('id',$a)->find();
        $integral_order = Db::name('integral_order')->where('id',$b)->find();
        $product = Db::name('product_integral')->where('product_id',$integral_order['product_id'])->find();
        $this->assign('product',$product);
        $this->assign('data',$integral_order);
        $this->assign('integral',$integral);
        $this->assign([
           'sheng'=>Db::name('region')->where('area_code',$integral['consignee_province_id'])->find()['area_name'],
            'shi'=>Db::name('region')->where('area_code',$integral['consignee_city_id'])->find()['area_name'],
            'qu'=>Db::name('region')->where('area_code',$integral['consignee_county_id'])->find()['area_name'],
        ]);
        return $this->fetch();
    }
}