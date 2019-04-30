<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 11:50
 */

namespace app\member\controller;


use app\common\controller\CommonIntegra;
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
        foreach ($rceiving_address_data as $k => $v) {
            $v['sheng'] = Db::name('region')->where('area_code', $v['province_id'])->find()['area_name'];
            $v['shi'] = Db::name('region')->where('area_code', $v['city_id'])->find()['area_name'];
            $v['qu'] = Db::name('region')->where('area_code', $v['county_id'])->find()['area_name'];
           $rceiving_address_datas[]=$v;
        }
        $this->assign('data',$rceiving_address_datas);
        return $this->fetch();
    }
    /**
     * 删除地址
     */
    public function deletesite()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:''));
        if (empty($id)){
            echo "参数错误";
            exit();
        }
        $res = Db::name('rceiving_address')->where('id',$id)->delete();
        if ($res){
            return json(1);
        }else{
            return json(0);
        }
    }
    /**
     * 修改地址
     */
    public function createsite()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:''));
        if (!$id){
            echo '参数错误';
            exit();
        }
        $memberid = Session::get('memberid');
        $member_data = Db::name('member')->where('id', $memberid)->find();
        $this->assign('member_data', $member_data);
        $region = Db::name('region')->where('area_type', 2)->field('area_name,area_code')->select();
        $this->assign('region', $region);
        $data = Db::name('rceiving_address')->where('id',$id)->find();
        $data['sheng'] = Db::name('region')->where('area_code',$data['province_id'])->find()['area_name'];
        $data['shi'] = Db::name('region')->where('area_code',$data['city_id'])->find()['area_name'];
        $data['qu'] = Db::name('region')->where('area_code',$data['county_id'])->find()['area_name'];
        $this->assign('data',$data);
        return $this->fetch();
    }
}