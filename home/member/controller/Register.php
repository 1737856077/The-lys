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
        return $this->fetch();
    }

    /**
     * @desc:显示用户登录页面
     */
    public function login(){
        if(Session::has('username')){
            echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
        }else{
            return $this->fetch();
        }
    }

    /**
     * @desc:提交登录验证
     */
    public function checklogin(){
        $adminname=htmlspecialchars(trim($_POST['username']));
        $adminpwd=$_POST['pwd'];

        $map=array();
        $map['name']=array('eq',$adminname);
        $map['pwd']=array('eq',md5($adminpwd));
        $ModelAdmin=Db::name('member');
        $getoneAdmin=$ModelAdmin->where($map)->find();

        if(empty($getoneAdmin)){
            $this->error('用户名或密码错误!');
        }else{
            Session::delete('adminid');
            Session::delete('adminname');
            Session::set('adminid', $getoneAdmin["admin_id"]);
            Session::set('adminname', $getoneAdmin["name"]);
            //添加日志 begin
            $ModelAdmin->where('')->update(array());
            //添加日志 end
            echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
        }
    }

    /**
     * @desc:退出登录
     */
    public function unlogin(){
        //Session::clear();
        //添加日志 begin
        $_content=Session::get('adminname').'退出网站后台管理系统。';
        $ModelAdminOperateLog=Db::name('admin_operate_log');
        $dataAdminOperateLog=array("content"=>$_content,
            "admin_id"=>Session::get('adminid'),
            "create_ip"=>$_SERVER["REMOTE_ADDR"],
            "create_time"=>time(),
        );
        $ModelAdminOperateLog->insert($dataAdminOperateLog);
        //添加日志 end
        Session::delete('adminid');
        Session::delete('adminname');
        Session::delete('adminoskey');
        Session::delete('admin_data_type');
        Session::delete('admin_permissions');
        Session::delete('admin_role_id');

        echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
    }
}