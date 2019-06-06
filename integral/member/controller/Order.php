<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 11:50
 */

namespace app\member\controller;


use app\common\controller\CommonIntegra;
use think\Cookie;
use think\Db;
use think\Session;

class order extends CommonIntegra
{
    /**
     * 订单详情
     */
    public function orderdetail()
    {
        $param = $this->request->param();
        $order_no = htmlspecialchars(trim($param['order_no']) ? $param['order_no'] : '');
        if (empty($order_no)) {
            echo '参数错误';
            exit();
        }

        $integral_order_data = Db::name('integral_order')->where('order_no', $order_no)->find();
        $integral_order_detail_Data = Db::name('integral_order_detail')->where('order_no', $order_no)->find();
        $product = Db::name('product_integral')->where('product_id', $integral_order_data['product_id'])->find();
        $this->assign('product', $product);
        $this->assign('integral_order_data', $integral_order_data);
        $this->assign('integral_order_detail_data', $integral_order_detail_Data);
        $this->assign([
            'sheng' => Db::name('region')->where('area_code', $integral_order_detail_Data['consignee_province_id'])->find()['area_name'],
            'shi' => Db::name('region')->where('area_code', $integral_order_detail_Data['consignee_city_id'])->find()['area_name'],
            'qu' => Db::name('region')->where('area_code', $integral_order_detail_Data['consignee_county_id'])->find()['area_name'],
        ]);
        return $this->fetch();
    }


    /**
     * 地址管理
     */
    public function site()
    {
        $param = $this->request->param();
        $uid = htmlspecialchars(trim(isset($param['uid'])) ? $param['uid'] : '');
        if (empty($uid)) {
            echo '参数错误';
            die();
        }
        $rceiving_address_data = Db::name('rceiving_address')->where('uid', $uid)->select();
        $rceiving_address_datas = [];
        foreach ($rceiving_address_data as $k => $v) {
            $v['sheng'] = Db::name('region')->where('area_code', $v['province_id'])->find()['area_name'];
            $v['shi'] = Db::name('region')->where('area_code', $v['city_id'])->find()['area_name'];
            $v['qu'] = Db::name('region')->where('area_code', $v['county_id'])->find()['area_name'];
            $rceiving_address_datas[] = $v;
        }
        $this->assign('data', $rceiving_address_datas);
        return $this->fetch();
    }

    /**
     * 删除地址
     */
    public function deletesite()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id']) ? $param['id'] : ''));
        if (empty($id)) {
            echo "参数错误";
            exit();
        }
        $res = Db::name('rceiving_address')->where('id', $id)->delete();
        if ($res) {
            return json(1);
        } else {
            return json(0);
        }
    }

    /**
     * 修改地址
     */
    public function createsite()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id']) ? $param['id'] : ''));
        if (!$id) {
            echo '参数错误';
            exit();
        }
        $memberid = Session::get('memberid');
        $member_data = Db::name('member')->where('id', $memberid)->find();
        $this->assign('member_data', $member_data);
        $region = Db::name('region')->where('area_type', 2)->field('area_name,area_code')->select();
        $this->assign('region', $region);
        $data = Db::name('rceiving_address')->where('id', $id)->find();
        $data['sheng'] = Db::name('region')->where('area_code', $data['province_id'])->find()['area_name'];
        $data['shi'] = Db::name('region')->where('area_code', $data['city_id'])->find()['area_name'];
        $data['qu'] = Db::name('region')->where('area_code', $data['county_id'])->find()['area_name'];
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 设为默认
     */
    public function sitedf()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(isset($param['id']) ? $param['id'] : '');
        $uid = htmlspecialchars(isset($param['uid']) ? $param['uid'] : '');
        if (!$id or !$uid) {
            echo '请求错误';
        }
        $data = Db::name('rceiving_address')->where('uid', $uid)->update(['data_type' => 0]);
        $datas = Db::name('rceiving_address')->where('id', $id)->update(['data_type' => 1]);
        if ($datas) {
            return json(1);
        } else {
            return json(0);
        }
    }

    /**
     * 购物车订单
     */
    public function sco()
    {
        $param = $this->request->param();
        $rceiving_address_id = htmlspecialchars(isset($param['rceiving_address_id']) ? $param['rceiving_address_id'] : '');
        $description = htmlspecialchars(isset($param['description']) ? $param['description'] : '');
        $memberid = Session::get('memberid');
        $jieguo = [];
        $rr = isset($param['product_id']) ? $param['product_id'] : '';
        if (!$rr) {
            return_msg(400, '没有订单！', '');
        }
        $data = [];
        foreach ($param['product_id'] as $k => $v) {
            $data[] = explode('.', $v);
        }
        //查询订单数据
        $res = [];
        foreach ($data as $k => $v) {

            $product_id = Db::name('shopping')->where('id', $v[0])->find()['product_id'];
            $data = Db::name('product_integral')->where('product_id', $product_id)->find();
            $data['num'] = $v[1];
            $data['money'] = round($data['integral'] * $data['num'], 4);
            $data['shopping'] = $v[0];

            $i_num = $data['total'];
            $nums = $i_num - $v[1];
            if ($nums < 0) {
                return_msg(400, '商品库存不足', '');
            }
            if ($v[1] < 1) {
                return_msg(400, '购买商品不能小于一件', '');
            }
            //查询地址
            if (empty($rceiving_address_id)) {
                return_msg(400, '请添加收货地址', '');
            }
            //
            $res[] = $data;
        }
        $sum = 0;
        foreach ($res as $k => $v) {
            $sum += $v['money'];
        }

        $member_data = Db::name('member')->where('id', Session::get('memberid'))->find();

        $uid = $member_data['uid'];
        $pay_real_account = ($member_data['invoice_money'] - $sum);//用户剩余积分
        if ($pay_real_account < 0.01) {
            return_msg(400, '积分不足', '');
        }

        $dd = Db::name('member')->where('id', Session::get('memberid'))->update(['invoice_money'=>$pay_real_account]);
        if (empty($dd)) {
            return_msg(500, '意外的错误', '');
        }

        //分割提交订单
        $data = [];
        foreach ($param['product_id'] as $k => $v) {
            $data[] = explode('.', $v);
        }
       //查询订单数据
        $res = [];
        foreach ($data as $k => $v) {
            $product_id = Db::name('shopping')->where('id', $v[0])->find()['product_id'];
            $data = Db::name('product_integral')->where('product_id', $product_id)->find();
            $order_no = date('ymdhis').mt_rand(1000,9999).substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            $data['num'] = $v[1];
            $data['money'] = round($data['integral'] * $data['num'], 4);
            $data['shopping'] = $v[0];
            $arr = [
                'order_no' =>$order_no ,
                'product_id' => $data['product_id'],
                'uid' => $member_data['uid'],
                'price' => $data['integral'],
                'num' => $data['num'],
                'price_total' => $data['money'],
                'pay_total' => $data['money'],
                'pay_real' => $data['money'],
                'pay_real_account' => $pay_real_account,
                'admin_id' => Session::get('admin_id'),
                'description' => $description,
                'pay_type' => 2,
                'data_pay' => 1,
                'data_order' => 0,
                'data_status' => 1,
                'data_status' => 1
                , 'create_time' => time(),
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

            $prres = Db::name('product_integral')->where('product_id',$product_id)->update(['total'=>$nums]);
            //积分操作
            $member_integral_record_mode = Db::name('member_integral_record');
            $member_integral_record_data = [
                'integral_record_id' => my_returnUUID(),
                'uid'=>$uid,
                'price'=>$data['money'],
                'order_no'=>$order_no,
                'integral_type'=>2,
                'admin_id'=>Session::get('admin_id'),
                'data_type'=>1,
                'create_time'=>time()
            ];   $member_integral_record_res = $member_integral_record_mode->insert($member_integral_record_data);
//        if (!$member_integral_record_res){
//
//        }

            $integral_order_detail_res = Db::name('integral_order_detail')->insertGetId($data_detail);
            if (!$integral_order_detail_res){

            }

            $integral_order_res = Db::name('integral_order')->insertGetId($arr);
//        return $this->corder($integral_order_detail_res,$integral_order_res);
            //插入成功的id
            if(!empty($member_integral_record_res) and !empty($integral_order_detail_res)  and !empty($integral_order_res) )
            {
                $jieguo[$integral_order_res] = $integral_order_res;
            }
            $product_id = Db::name('shopping')->where('id', $v[0])->delete();
        }
       Cookie::set('data',$jieguo);
        return_msg(200,'购买成功','');
    }
    /**
     *跳转
     */
    public function sc()
    {
        return $this->fetch();
    }
}