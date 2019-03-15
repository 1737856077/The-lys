<?php
namespace app\index\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-首页处理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Index.php 2018-07-22 19:32:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;
class Index extends  CommonBaseHome
{
    public function _initialize()
    {
        parent::_initialize();
        // 模版分类
        $data = $this->assign("ConfigTemplateDataType", \think\Config::get('data.template_data_type'));
        // 条码类型
        $this->assign("ConfigTemplateCodeType", \think\Config::get('data.template_code_type'));
        $ModelSystemConfig = Db::name('system_config');
        //使用场景
        $listUsageScenarios = array();
        $listUsageScenarios = $ModelSystemConfig->where("father_id=1")->order("sort_rank ASC,id ASC")->select();
        $data = $this->assign("listUsageScenarios", $listUsageScenarios);
        //行业分类
        $listIndustry = array();
        $listIndustry = $ModelSystemConfig->where("father_id=2")->order("sort_rank ASC,id ASC")->select();
        $this->assign("listIndustry", $listIndustry);

        //查询网站配置信息
        $ModelWebConfigComm = Db::name('web_config');
        $getoneWebConfigComm = $ModelWebConfigComm->where("data_status='1'")
            ->order("id DESC")
            ->find();
        $this->assign('getoneWebConfigComm', $getoneWebConfigComm);
    }
    public function index(){
        //最新发布
        $tuesday = time() - 60 * 60 * 84;
        $tuesdays = time() - 60 * 60 * 48;
        $time = time();       //AND data_status=1 AND data_type=0

        $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesday AND  $time    ORDER BY create_time DESC");
        if (!empty($New)) {
            $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesdays AND  $time   ORDER BY create_time DESC");
        }
        //热门排序
        $Popular = Db::name('template ')->field('template_id ,title, get_nums')->order('get_nums desc')->select();
        //综合排序
        $cas = Db::name('template')->field('show_nums,get_nums')->order('show_nums+get_nums desc')->field('title')->select();;
        $this->assign(
            [
                'New' => $New,
                'Popular' => $Popular,
                'cas' => $cas
            ]
        );
        return $this->fetch();
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

