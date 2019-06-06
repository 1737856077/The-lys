<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/19
 * Time: 13:42
 */

namespace app\member\controller;

use app\common\controller\CommonIntegra;
use think\Db;
use think\Request;
use think\Session;

class Index extends CommonIntegra
{
    /**
     * 测试
     */
    public function test()
    {
        return $this->fetch();
    }

    public function index()
    {
        $member_id = Session::get('memberid');
        $member_data = Db::name('member')->where('id', $member_id)->find();
        $this->assign('member_data', $member_data);
        return $this->fetch();
    }

    /**
     * 渲染用户添加发货地址界面
     */
    public function site()
    {
        $param = $this->request->param();
        $product_id = isset($param['id']) ? $param['id'] : '';
        $memberid = Session::get('memberid');
        $member_data = Db::name('member')->where('id', $memberid)->find();
        $this->assign('member_data', $member_data);
        $region = Db::name('region')->where('area_type', 2)->field('area_name,area_code')->select();
        $this->assign('region', $region);
        $this->assign('product_id', $product_id);
        return $this->fetch();
    }

    /**
     * 查询地区
     */
    public function shi()
    {
        $param = $this->request->post();
        $shi = Db::name('region')
            ->where('area_parent_id', isset($param['shi']['area_code']) ? $param['shi']['area_code'] : $param['shi'])
            ->field('area_name,area_code')
            ->select();
        return json($shi);

    }

    /**
     * 保存发货地址
     */
    public function sitesave()
    {

        $param = $this->request->param();

        $save = htmlspecialchars(isset($param['save']) ? $param['save'] : '');
        $uid = htmlspecialchars(isset($param['uid']) ? $param['uid'] : '');
        $admin_id = htmlspecialchars(isset($param['admin_id']) ? $param['admin_id'] : '');
        $name = htmlspecialchars(isset($param['name']) ? $param['name'] : '');
        $tel = htmlspecialchars(isset($param['tel']) ? $param['tel'] : '');
        $sheng = htmlspecialchars(isset($param['sheng']) ? $param['sheng'] : '');
        $shi = htmlspecialchars(isset($param['city']) ? $param['city'] : '');
        $qu = htmlspecialchars(isset($param['qu']) ? $param['qu'] : '');
        $jie = htmlspecialchars(isset($param['jie']) ? $param['jie'] : '');
        $address = htmlspecialchars(isset($param['address']) ? $param['address'] : '');
        $code = htmlspecialchars(isset($param['code']) ? $param['code'] : '');
        $data_type = htmlspecialchars(isset($param['data_type']) ? $param['data_type'] : '');
        $data_status = htmlspecialchars(isset($param['data_status']) ? $param['data_status'] : '');
        $site = htmlspecialchars(trim(isset($param['site']) ? $param['site'] : ''));
        //接收到的地区为默认添加地区
        if (empty($save)) {
            if (!empty($qu) and !empty($uid) and !empty($name)) {
                $data = array(
                    'rceiving_address_id' => my_returnUUID(),
                    'uid' => $uid,
                    'admin_id' => $admin_id,
                    'name' => $name,
                    'tel' => $tel,
                    'area_country_id' => 1,
                    'province_id' => $sheng,
                    'city_id' => $shi,
                    'county_id' => $qu,
                    'address' => $address,
                    'code' => $code,
                    'user_type' => 0,
                    'data_type' => $data_type,
                    'data_status' => $data_status,
                    'create_time' => time()
                );
                $res = Db::name('rceiving_address')->insertGetId($data);
                //保存默认
                if ($data_type == 1) {
                    Db::name('rceiving_address')->where('uid', $uid)->update(['data_type' => 0]);
                    Db::name('rceiving_address')->where('id', $res)->update(['data_type' => 1]);
                }
                if ($res) {
                    return json(1);
                } else {
                    return json(0);
                }
            } else {
                return json(-1);
            }
        } else {
            if (!empty($qu) and !empty($uid) and !empty($name)) {
                $data = array(
                    'rceiving_address_id' => my_returnUUID(),
                    'uid' => $uid,
                    'admin_id' => $admin_id,
                    'name' => $name,
                    'tel' => $tel,
                    'area_country_id' => 1,
                    'province_id' => $sheng,
                    'city_id' => $shi,
                    'county_id' => $qu,
                    'address' => $address,
                    'code' => $code,
                    'user_type' => 0,
                    'data_type' => $data_type,
                    'data_status' => $data_status,
                    'create_time' => time()
                );
                $res = Db::name('rceiving_address')->where('id', $site)->update($data);
                //保存默认
                if ($data_type == 1) {
                    Db::name('rceiving_address')->where('uid', $uid)->update(['data_type' => 0]);
                    Db::name('rceiving_address')->where('id', $site)->update(['data_type' => 1]);
                }

                if ($res) {
                    return json(1);
                } else {
                    return json(0);
                }
            } else {
                return json(-1);
            }
        }
    }

    /**
     * 保存用户头像
     */
    public function userimg()
    {
        $param = $this->request->param();
        $uid = htmlspecialchars(isset($param['uid']) ? $param['uid'] : '');
        $request = Request::instance();
        $file = $request->file('img');
        if ($file) {
            $info = $file->validate([
                'size' => (1024 * 1024) * 1,
                'ext' => 'jpeg,jpg,png,bmp'
            ])->move("static/integral/user");
            if ($info) {
                $datas['img'] = "/static/integral/user/" . $info->getSaveName();//头像
                Session::set('userimg', $datas['img']);
            } else {
                $this->error($file->getError());
            }
        }
        $res = Db::name('member')->where('uid', $uid)->update(['img' => $datas['img']]);
        if ($res) {
            return json(1);
        } else {
            return json(0);
        }
    }
    //用户头像未完成页面ajax提交失败

    /**
     * 积分详情-
     */
    public function integrals()
    {

        $param = $this->request->param();
        $uid = htmlspecialchars(trim(($param['uid']) ? $param['uid'] : ''));
        $record_mdol = Db::name('member_integral_record');
        $record_data = $record_mdol->where('uid', $uid)->order('create_time desc')->select();
        $MemberIntegral = Db::name('member')->where([
            'uid' => $uid
        ])->field('invoice_money')->find();
        if ($MemberIntegral['invoice_money'] > 0.01) {
            $data = $MemberIntegral['invoice_money'];
        } else {
            $data = '当前商家没有对应的积分';
        }
        $zhong = $record_mdol->where('uid', $uid)->where('integral_type=0 or integral_type=1')->field('price')->sum('price');
        $x = $record_mdol->where('uid', $uid)->where('integral_type=2')->field('price')->sum('price');
        $this->assign('zhong', $zhong);
        $this->assign('x', $x);
        $this->assign('data', $record_data);
        $this->assign('invoice_money', $data);
        return $this->fetch();
    }

    /**
     * 自动收货
     */
    public function consignee($uid)
    {
        if (!$uid) {
            echo '参数错误';
            exit();
        }
        $data = Db::name('integral_order')->where('uid', $uid)->select();
        //收货时间上限
        $times = 60 * 60 * 24 * 15;
        foreach ($data as $k => $v) {
            if (time() > ($v['create_time'] + $times)) {
                Db::name('integral_order')->where('order_no', $v['order_no'])->update(['data_order' => 4]);
            }
        }
    }

    /**
     * 订单中心
     */
    public function sorder()
    {
        $param = $this->request->param();
        $uid = htmlspecialchars(isset($param['uid']) ? $param['uid'] : '');
        if (!$uid) {
            echo '参数错误';
            exit();
        }
        $this->consignee($uid);
        $order_model = Db::name('integral_order');
        $order_data = $order_model->where('uid', $uid)->order('create_time')->select();
        foreach ($order_data as $k => $v) {
            $dat = Db::name('product_integral')->where('product_id', $v['product_id'])->field('images,title')->find();
            $v['img'] = $dat['images'];
            $v['title'] = $dat['title'];
            $order_data[$k] = $v;
        }
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/integral.php/member/index/sorder/" . "uid/" . $uid;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $data = page_array(4, $page, $order_data, 1);
        $show = show_array(Session::get('page'), $url);
        $this->assign('page', $show);//传到模板显示
        $this->assign('data', $data);//数据
        return $this->fetch('');
    }

    /**
     * 确认收货
     */
    public function affirm()
    {
        $param = $this->request->param();
        $order_no = htmlspecialchars(isset($param['order_no']) ? $param['order_no'] : '');
        if (!$order_no) {
            echo '参数错误';
            exit();
        }
        $data = Db::name('integral_order')->where('order_no', $order_no)->update(['data_order' => 4]);
        if ($data) {
            return json(1);
        } else {
            return json(0);
        }
    }

    /**
     * 删除订单
     */
    public function deorder()
    {
        $param = $this->request->param();
        $order_no = htmlspecialchars(isset($param['order_no']) ? $param['order_no'] : '');
        if (!$order_no) {
            echo '<script language="javascript">alert("参数错误");history.go(-1);</script>';
            die();
        }
        $res = Db::name('integral_order')->where('order_no', $order_no)->delete();
        Db::name('integral_order_detail')->where('order_no', $order_no)->delete();
        if ($res) {
            return json(1);
        } else {
            return json(0);
        }
    }

    /**
     * 渲染用户中心
     */
    public function user()
    {
        $member_id = Session::get('memberid');
        $member_data = Db::name('member')->where('id', $member_id)->find();
        $this->assign('member_data', $member_data);
        return $this->fetch();
    }

    /**
     * 购物车页面渲染
     */
    public function shopping()
    {
        $data = Db::name('shopping')->where('member_id', Session::get('memberid'))->select();
        $arr = [];
        foreach ($data as $k => $v) {
            $arr[] = Db::name('product_integral')->where('product_id', $v['product_id'])->find();
            $arr[$k]['id'] = $v['id'];
            $arr[$k]['number'] = $v['number'];
        }
        $this->assign('data', $arr);
        return $this->fetch();
    }

    /**
     * 删除商品
     */
    public function dproduct()
    {
        $param = $this->request->param();
        $product_id = htmlspecialchars(isset($param['id']) ? $param['id'] : '');
        $res = Db::name('shopping')->where('product_id', $product_id)->delete();
        if ($res) {
            return_msg('200', '删除成功');
        } else {
            return_msg('400', '删除失败');
        }
    }

    /**
     * 提交订单
     */
    public function suborder()
    {
        $param = $this->request->param();
        $memberid = Session::get('memberid');
        $rr = isset($param['product_id']) ? $param['product_id'] : '';
        if (!$rr) {
//            return_msg(400, '没有订单！', '');
//            return $this->redirect('member/index/shopping',['msg'=>'没有选择订单']);
            echo "<script>alert('请选择要购买的订单!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
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
            if ($data['total']<$v[1]){
                $title = $data['title'];
                $num = $data['total'];
                echo "<script>alert('".$title."的最大数量不能超过".$num."');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
            }
            $data['num'] = $v[1];
            $data['money'] = round($data['integral'] * $data['num'], 4);
            $data['shopping'] = $v[0];
            $res[] = $data;
        }
        $sum = 0;
        foreach ($res as $k => $v) {
            $sum += $v['money'];
        }
        $meber_data = Db::name('member')->where('id', $memberid)->find();
        $uid = isset($meber_data['uid']) ? $meber_data['uid'] : '';
        $member_rceiving_address_data = Db::name('rceiving_address')->where('uid',$uid)->where('data_type',1)->find();
        $this->assign('rceiving_address',$member_rceiving_address_data);
        $this->assign('data',$res);
        $this->assign('sum',$sum);
        return $this->fetch();

    }
}