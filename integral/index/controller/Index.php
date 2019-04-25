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
     * 用户选择登录还是注册渲染模板
     */
    public function index(){

        if(Session::has('memberid')){
            //已经登录跳转到兑换首页
            $param = $this->request->param();
            //测试默认值 admin为传过来的为商家管理员的id
            Session::delete('admin_id');
            $admin_id = 4;
            Session::set('admin_id',$admin_id);
            $memberid = Session::get('memberid');
            $MemberData = Db::name('member')->where('id',$memberid)->field('uid')->find();
            $uid =$MemberData['uid'] ;
            //当前用户当前商家的积分总和
            $MemberIntegral = Db::name('member_integral_record')->where([
                'admin_id'=>$memberid,
                'uid'=>$uid
            ])->sum('price');
            if($MemberIntegral>1){
                $data = $MemberIntegral;
            }else{
                $data = '当前商家没有对应的积分';
            }
            //查询当前商家积分商品数据兑换展示首页
            $productData = Db::name('product_integral')->where('admin_id',$admin_id)->where('data_status',1)->limit(6)->select();
            $this->assign('data',$productData);
            $this->assign('integral',$data);
          return $this->fetch();
        }else{
            $this->redirect('logins',"",1,"请登录，1称后自动跳转到登录页面");
        }
    }
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
    public function login(){

        if(Session::has('memberid')){
            //$this->redirect("","",1,"已登录，1称后自动跳转");
            echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
        }else{
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
    public function unlogin(){
        //Session::clear();
        //添加日志 begin
        //添加日志 end
        Session::delete('memberid');
        Session::delete('username');
        return $this->fetch('index/index');
     }
}