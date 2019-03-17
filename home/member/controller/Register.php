<?php
namespace app\member\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-用户注册
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Register.php 2019-02-28 19:32:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;
class Register extends CommonBaseHome
{
    /**
     * @desc:显示用户注册页面
     */
    public function index(){
        $param = $this->request->param();
        $fromUserId=intval(isset($param['fromUserId']) ? trim($param['fromUserId']) : '0');
        $this->assign("fromUserId",$fromUserId);
        return $this->fetch();
    }

    /**
     * @desc: 验证用户名是否可用
     */
    public function checkname(){
        $param = $this->request->post();
        $username=htmlspecialchars(isset($param['username']) ? trim($param['username']) : '');

        $result=array('code'=>'0','msg'=>'');
        if(empty($username)){
            $result['code']='-1';
            $result['msg']='请输入用户名！';
            echo json_encode($result);
            exit;
        }

        $modelMember=Db::name('member');
        $count=$modelMember->where("username='$username'")->count();
        if($count){
            $result['code']='-2';
            $result['msg']='用户名已存在相同！';
            echo json_encode($result);
            exit;
        }

        echo json_encode($result);
        exit;
    }

    /**
     * @desc:提交登录验证
     */
    public function regin(){
        $param = $this->request->post();
        $fromUserId=intval(isset($param['fromUserId']) ? trim($param['fromUserId']) : '0');
        $username=htmlspecialchars(isset($param['username']) ? trim($param['username']) : '');
        $pwd=isset($param['pwd']) ? trim($param['pwd']) : '';
        $email=htmlspecialchars(isset($param['email']) ? trim($param['email']) : '');
        $gettime=time();

        if(empty($username) or empty($pwd) ){
            echo '<script language="javascript">alert("请输入用户名和密码！");history.go(-1);</script>';
            exit;
        }

        $pwd=md5($pwd);
        $modelMember=Db::name('member');
        $getone=$modelMember->where("username='$username'")->find();
        if(!empty($getone)){
            echo '<script language="javascript">alert("用户名已存在相同！");history.go(-1);</script>';
            exit;
        }

        $data=array('username'=>$username,
            'pwd'=>$pwd,
            'email'=>$email,
            'from_user_id'=>$fromUserId,
            'last_login_time'=>$gettime,
            'data_status'=>'1',
            'create_time'=>$gettime,
            'update_time'=>$gettime
            );
        $memberid=$modelMember->insertGetId($data);
        if(!$memberid){
            echo '<script language="javascript">alert("服务器忙，请稍后再试！");history.go(-1);</script>';
            exit;
        }

        Session::delete('memberid');
        Session::delete('username');
        Session::set('memberid', $memberid);
        Session::set('username', $username);
        //添加日志 begin
        //添加日志 end
        echo "<script language=\"javascript\">window.open('".url('member/index')."','_top');</script>";
    }

    /**
     * @desc:显示用户登录页面
     */
    public function login(){
        if(Session::has('username')){
            echo "<script language=\"javascript\">window.open('".url('member/index')."','_top');</script>";
        }else{
            return $this->fetch();
        }
    }

    /**
     * @desc:提交登录验证
     */
    public function checklogin(){
        $param = $this->request->post();
        $username=htmlspecialchars(isset($param['username']) ? trim($param['username']) : '');
        $pwd=isset($param['pwd']) ? trim($param['pwd']) : '';

        if(empty($username) or empty($pwd) ){
            echo '<script language="javascript">alert("请输入用户名和密码！");history.go(-1);</script>';
            exit;
        }

        $pwd=md5($pwd);
        $modelMember=Db::name('member');
        $getone=$modelMember->where("username='$username' AND pwd='$pwd'")->find();
        if(empty($getone)){
            echo '<script language="javascript">alert("用户名或密码错误！");history.go(-1);</script>';
            exit;
        }

        Session::delete('memberid');
        Session::delete('username');
        Session::set('memberid', $getone["member_id"]);
        Session::set('username', $getone["username"]);
        //添加日志 begin
        //添加日志 end
        echo "<script language=\"javascript\">window.open('".url('member/index')."','_top');</script>";
    }

    /**
     * @desc:退出登录
     */
    public function unlogin(){
        //Session::clear();
        //添加日志 begin
        //添加日志 end
        Session::delete('memberid');
        Session::delete('username');

        echo "<script language=\"javascript\">window.open('".url('member/index')."','_top');</script>";
    }
}