<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/18
 * Time: 10:32
 */

namespace app\index\controller;

use app\common\controller\CommonBaseHome;
use think\Controller;
use think\Db;
use think\Session;
use think\View;
use think\Request;
class Index extends Controller
{

    public function _initialize(){
        $name = Session::get('bus_adminname');
        $id = Session::get('bus_adminid');
            $list = Db::name('admin_business')
                ->alias('b')
                ->field("a.name,b.*")
                ->join('admin a','b.admin_id = a.admin_id')
                ->where('b.admin_id',$id)
                ->select();
            $count = count($list);
            $this->assign('count',$count);
            $this->assign('list',$list);
            $this->assign('name',$name);
//            return $this->fetch();

    }
    public function admin()
    {if(Session::has('bus_adminname')){
        return $this->fetch(); }else{
    $this->redirect('login',"",1,"请登录，1称后自动跳转到登录页面");
    }
    }
    /**
     * @return 商家首页(默认加载积分商城)
     */
    public function index()
    {

        if(Session::has('bus_adminname')){
            return $this->fetch(); }else{
            $this->redirect('login',"",1,"请登录，1称后自动跳转到登录页面");
        }

    }

    /**
     * @return 登陆
     */
    public function login(){

        if(Session::has('bus_adminname')){
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
        $data_type = $ModelAdmin->where($map)->field('data_type')->find();
        if(empty($getoneAdmin)){
            $this->error('用户名或密码错误!');
        }elseif ($data_type['data_type'] != 2){
            $this->error('此用户没有登录权限!');
        }else{
            //取得权限信息
            $ModelSystemRoleAuth=Db::name('system_role_auth');
            $ModelSystemNode=Db::name('system_node');
            //查询当前角色的所有权限
            $listSystemRoleAuth=$ModelSystemRoleAuth->where("role_id='$getoneAdmin[role_id]'")->select();
            $role_nodes=array();
            foreach ($listSystemRoleAuth as $key=>$val){
                //取得路径
                $_getoneSystemNode=$ModelSystemNode->where("node_id='$val[node_id]'")->find();
                $role_nodes[]=$_getoneSystemNode['content'];
            }
            $role_nodes=implode('|',$role_nodes);
            $role_nodes=explode('|',$role_nodes);
            $role_nodes=json_encode($role_nodes);

            //清楚后台系统的登录信息 begin
            Session::delete('bus_adminid');
            Session::delete('bus_adminname');
            Session::delete('bus_adminoskey');
            Session::delete('bus_admin_data_type');
            Session::delete('bus_admin_permissions');
            Session::delete('bus_admin_role_id');
            //清楚后台系统的登录信息end
            Session::delete('bus_adminid');
            Session::delete('bus_adminname');
            Session::delete('bus_adminoskey');
            Session::delete('bus_admin_data_type');
            Session::delete('bus_admin_permissions');
            Session::delete('bus_admin_role_id');
            Session::set('bus_adminid', $getoneAdmin["admin_id"]);
            Session::set('bus_adminname', $getoneAdmin["name"]);
            Session::set('bus_adminoskey', $getoneAdmin["oskey"]);
            Session::set('bus_admin_data_type',$getoneAdmin["data_type"]);
            Session::set('bus_admin_permissions', $role_nodes);
            Session::set('bus_admin_role_id',$getoneAdmin["role_id"]);
            //添加日志 begin
            $_content=$getoneAdmin['name'].'登录网站后台管理系统。';
            $ModelAdminOperateLog=Db::name('admin_operate_log');
            $dataAdminOperateLog=array("content"=>$_content,
                "admin_id"=>Session::get('bus_adminid'),
                "create_ip"=>$_SERVER["REMOTE_ADDR"],
                "create_time"=>time(),
            );
            $ModelAdminOperateLog->insert($dataAdminOperateLog);

            //添加日志 end
            echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
            //$this->redirect("","",1,"欢迎 ".$tmpname." 登录，1称后自动跳转");
        }
    }

    /**
     * 退出
     */
    public function unlogin(){
        //Session::clear();
        //添加日志 begin
        $_content=Session::get('bus_adminname').'退出网站后台管理系统。';
        $ModelAdminOperateLog=Db::name('admin_operate_log');
        $dataAdminOperateLog=array("content"=>$_content,
            "admin_id"=>Session::get('bus_adminid'),
            "create_ip"=>$_SERVER["REMOTE_ADDR"],
            "create_time"=>time(),
        );
        $ModelAdminOperateLog->insert($dataAdminOperateLog);
        //添加日志 end
        Session::delete('bus_adminid');
        Session::delete('bus_adminname');
        Session::delete('bus_adminoskey');
        Session::delete('bus_admin_data_type');
        Session::delete('bus_admin_permissions');
        Session::delete('bus_admin_role_id');

        echo "<script language=\"javascript\">window.open('".url('index/index')."','_top');</script>";
    }
    public function main(){
        return $this->fetch();

    }

    public function header(){
        $param = $this->request->param();
        $indexc=isset($param['indexc']) ? $param['indexc'] : 'home';
        $this->assign('indexc',$indexc);
        return $this->fetch();
    }

    /**
     * @desc:积分商城的右侧菜单
     */
    public function menu(){
        return $this->fetch();
    }

    /**
     * @desc:加载微信公众号的主页面
     */
    public function indexwechat(){
        return $this->fetch();
    }

    /**
     * @desc:微信公众号的右侧菜单
     */
    public function menuwechat(){
        return $this->fetch();
    }

    /**
     * @desc:加载红包系统的主页面
     */
    public function indexredsystem(){
        return $this->fetch();
    }

    /**
     * @desc:红包系统的右侧菜单
     */
    public function menuredsystem(){
        return $this->fetch();
    }
}