<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/18
 * Time: 9:50
 */

namespace app\index\controller;

use think\Db;
use think\Session;
use think\Controller;

class Index extends Controller
{
    /**
     * 测试
     */
    public function test()
    {
      return json(1);
    }

    /**
     * 显示商家商品未登录
     */
    public function product()
    {
        $param = $this->request->param();
        $code_info_id = htmlspecialchars(isset($param['code_info_id']) ? $param['code_info_id'] : '');
        if (!$code_info_id) {
            echo '参数错误';
            die();
        }
        $data = Db::name('product_code_info')->where('compress_code', $code_info_id)->find();
        if ($data) {
            if ($data['code_status'] == 1) {
                echo "<script language=\"javascript\">alert('无效二维码');</script>";
            }
        }
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 显示当前扫码商家的产品
     */
    public function index()
    {

        if (Session::has('memberid')) {
            //已经登录跳转到兑换首页
            Session::set('admin_id', Session::get('admin_id'));
            $memberid = Session::get('memberid');
            $MemberData = Db::name('member')->where('id', $memberid)->field('uid')->find();
            $uid = $MemberData['uid'];
            //当前用户积分总和
//            $MemberIntegral = Db::name('member_integral_record')->where([
//                'uid'=>$uid
//            ])->sum('price');a
            $MemberIntegral = Db::name('member')->where([
                'uid' => $uid
            ])->field('invoice_money')->find();
            if ($MemberIntegral['invoice_money'] > 0.01) {
                $data = $MemberIntegral['invoice_money'];
            } else {
                $data = '当前商家没有对应的积分';
            }
            //查询当前商家积分商品数据兑换展示首页
            $productData = Db::name('product_integral')->where('admin_id', Session::get('admin_id'))->where('data_status', 1)->limit(6)->select();
            $this->assign('data', $productData);
            $this->assign('integral', $data);
            return $this->fetch();
        } else {
            $param = $this->request->param();
            //测试默认值 admin为传过来的为商家管理员的id
            $compress_code = htmlspecialchars(isset($param['compress_code']) ? $param['compress_code'] : '');
            $data = Db::name('product_code_info')->where('compress_code', $compress_code)->find();
            if (empty($data)) {
                echo '参数错误';
                exit();
            }
            Session::delete('admin_id');
            Session::set('admin_id', $data['admin_id']);
            Session::delete('compress_code');
            Session::set('compress_code', $compress_code);
            $this->redirect('logins', "", 1, "请登录，1称后自动跳转到登录页面");
        }
    }
//    public function index(){
//        $param = $this->request->param();
//        $code_info_id = htmlspecialchars(isset($param['code_info_id'])?$param['code_info_id']:'');
//        if (empty($code_info_id)){
//            echo '参数错误';exit();
//        }
//        $data = Db::name('product_code_info')->where('compress_code',$code_info_id)->find();
//        if ($data){
//            $admin_id = $data['admin_id'];
//        }
//        $productData = Db::name('product_integral')->where('admin_id',$admin_id)->where('data_status',1)->limit(6)->select();
//        $this->assign('data',$productData);
//
//
//            $param = $this->request->param();
//        $code_info_id = htmlspecialchars(isset($param['code_info_id'])?$param['code_info_id']:'');
//        if (!$code_info_id){
//
//        }
//        $data = Db::name('product_code_info')->where('compress_code',$code_info_id)->find();
//        if ($data){
//            $admin_id = $data['admin_id'];
//        }
//            Session::delete('admin_id');
//            Session::set('admin_id',$admin_id);
//            $memberid = Session::get('memberid');
//            $MemberData = Db::name('member')->where('id',$memberid)->field('uid')->find();
//            $uid =$MemberData['uid'] ;
//            //当前用户积分总和
////            $MemberIntegral = Db::name('member_integral_record')->where([
////                'uid'=>$uid
////            ])->sum('price');a
//            $MemberIntegral = Db::name('member')->where([
//                'uid'=>$uid
//            ])->field('invoice_money')->find();
//            if($MemberIntegral['invoice_money']>0.01){
//                $data = $MemberIntegral['invoice_money'];
//            }else{
//                $data = '当前商家没有对应的积分';
//            }
//            //查询当前商家积分商品数据兑换展示首页
//            $productData = Db::name('product_integral')->where('admin_id',$admin_id)->where('data_status',1)->limit(6)->select();
//            $this->assign('data',$productData);
//            $this->assign('integral',$data);
//          return $this->fetch();
//    }
    /**
     * 登录注册页面
     */
    public function logins()
    {

        return $this->fetch();
    }

    /**
     * 用户登录页面
     */
    public function login()
    {

        if (Session::has('memberid')) {
            //$this->redirect("","",1,"已登录，1称后自动跳转");
            echo "<script language=\"javascript\">window.open('" . url('index/index') . "','_top');</script>";
        } else {
            return $this->fetch();
        }
    }

    /**
     * @用户注册页面
     */
    public function register()
    {
        return $this->fetch();
    }

    /**
     * @用户忘记密码页面
     */
    public function forgetpwd()
    {
        return $this->fetch();
    }

    /**
     * 退出登录
     */
    public function unlogin()
    {
        Session::delete('memberid');
        Session::delete('username');
        echo "请扫码登录";die();
    }

    /**
     * 领取积分
     */
    public function integral()
    {
        if (!Session::has('memberid')) {
            echo "<script language=\"javascript\">window.open('/integral.php','_top');</script>";
            exit;
        }
        $data = Db::name('product_code_info')->where('compress_code', Session::get('compress_code'))->find();
        if ($data) {
            if ($data['code_status'] == 1) {
                echo "<script language=\"javascript\">alert('无效二维码');</script>";
            }
        }
        $member_data = Db::name('member')->where('id', Session::get('memberid'))->find();
        $this->assign('data', $data);
        $this->assign('member_data', $member_data);
        return $this->fetch();
    }

    /**
     * 领取积分保存
     */
    public function getIntegral()
    {
        if (!Session::has('memberid')) {
            echo "<script language=\"javascript\">window.open('/integral.php','_top');</script>";
            exit;
        }
        $param = $this->request->param();
        $code = htmlspecialchars(isset($param['code']) ? $param['code'] : '');
        if (empty($code)) {
            echo "<script language=\"javascript\">alert('参数错误');</script>";die();
        }
        $member_data = Db::name('member')->where('id', Session::get('memberid'))->find();
        $integral_data = Db::name('product_code_info')->where('compress_code', $code)->find();
        if ($integral_data['code_status'] == 1) {
            echo "<script language=\"javascript\">alert('无效二维码');</script>";die();
        }
        $data =  Db::name('product_code_info')->where('compress_code', $code)->find();
        $member = Db::name('member')->where('id',Session::get('memberid'))->find();
        $array = [
          'integral_record_id'=>my_returnUUID(),
            'uid'=>$member['uid'],
            'price'=>$data['integral_num'],
            'product_code_info_id'=>$data['product_code_info_id'],
            'integral_type'=>0,
            'admin_id'=>Session::get('admin_id'),
            'data_type'=>0,
            'create_time'=>time()
        ];
        $res = Db::name('member_integral_record')->insert($array);
        if (!$res){
            echo '领取失败';
            die();
        }
        $integral_num = $integral_data['integral_num'];
        $member_integral_num = $member_data['invoice_money'];
        $num = $integral_num + $member_integral_num;
        $res = Db::name('member')->where('id', Session::get('memberid'))->update(['invoice_money' => $num]);
        if ($res) {
            Db::name('product_code_info')->where('compress_code', $code)->update(['code_status' => 1]);
            Db::name('product_code_info')->where('compress_code', $code)->update(['integral_num' => 0]);
            return $this->redirect('index/index/index');
        } else {
            echo '领取失败';
            die();
        }
    }
    /**
     * 更新密码
     */
    public function uppwd()
    {
        $param = $this->request->param();
        $mobile = htmlspecialchars(isset($param['mobile'])?$param['mobile']:'');
        $code =htmlspecialchars(isset($param['code'])?$param['code']:'');
        $pwd = htmlspecialchars(isset($param['pwd'])?$param['pwd']:'');
        $pwds = htmlspecialchars(isset($param['pwds'])?$param['pwds']:'');
        if (empty($mobile)) {
            return_msg(400, '请输入手机号!');
        }
        /*********** 检查用户手机是否注册 *******/
        $member_res = Db::name('member')->where('moblie',$mobile)->find();
        if (empty($member_res)){
            return_msg(400,'用户不存在');
        }
        /*********** 检测是否超时  ***********/
        $last_time = session($mobile . '_last_send_time');
        if (!$code){
            return_msg(400, '请输入验证码');
        }
        if (time() - $last_time > 60) {
            return_msg(400, '验证超时,请在一分钟内验证!');
        }
        /*********** 检测验证码是否正确  ***********/
        $md5_code = md5($mobile . '_' . md5($code));
        if (session($mobile . "_code") !== $md5_code) {
            return_msg(400, '验证码不正确!');
        }
        /*********** 不管正确与否,每个验证码只验证一次  ***********/
        session($mobile . '_code', null);
        if (!$pwd==$pwds){
            return_msg(400,'两次输入的密码不一致');
        }
        $res = Db::name('member')->where('moblie',$mobile)->insert(['pwd'=>$pwd]);
        if (!$res){
            return_msg(400,'更新失败');
        }
        return_msg(200,'更新成功');
    }
}