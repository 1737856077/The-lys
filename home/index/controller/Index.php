<?php
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-首页处理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Index.php 2018-07-22 19:32:00 $
 */
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;

class Index extends  Controller
{

    public function index(){

        if(Session::has('adminname')){
            return $this->fetch();
        }else{
            $this->redirect('login',"",1,"请登录，1称后自动跳转到登录页面");
        }
    }

    public function main(){
        return $this->fetch();

    }

    public function header(){
        return $this->fetch();
    }

    public function menu(){
        return $this->fetch();
    }

    /*
     * 用户登录
     */
    public function login(){

        if(Session::has('adminname')){
            //$this->redirect("","",1,"已登录，1称后自动跳转");
            echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
        }else{
            return $this->fetch();
        }
    }

    public function checklogin(){
        $adminname=htmlspecialchars(trim($_POST['adminname']));
        $adminpwd=$_POST['adminpwd'];

        $map=array();
        $map['name']=array('eq',$adminname);
        $map['pwd']=array('eq',md5($adminpwd));
        $ModelAdmin=Db::name('admin');
        $getoneAdmin=$ModelAdmin->where($map)->find();

        if(empty($getoneAdmin)){
            $this->error('用户名或密码错误!');
        }else{
            Session::set('adminid', $getoneAdmin["admin_id"]);
            Session::set('adminname', $getoneAdmin["name"]);
            Session::set('adminoskey', $getoneAdmin["oskey"]);
            Session::set('admin_permissions', $getoneAdmin["permissions"]);
            //添加日志 begin
            $_content=$getoneAdmin['name'].'登录网站后台管理系统。';
            $ModelAdminOperateLog=Db::name('admin_operate_log');
            $dataAdminOperateLog=array("content"=>$_content,
                                       "admin_id"=>Session::get('adminid'),
                                       "create_ip"=>$_SERVER["REMOTE_ADDR"],
                                       "create_time"=>time(),
            );
            $ModelAdminOperateLog->insert($dataAdminOperateLog);

            //添加日志 end
            echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
            //$this->redirect("","",1,"欢迎 ".$tmpname." 登录，1称后自动跳转");
        }
    }

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

        echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
    }


}

