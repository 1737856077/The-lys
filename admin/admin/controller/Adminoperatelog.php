<?php
namespace app\admin\controller;
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Adminoperatelog.php 2018-04-05 10:46:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Paginator;

class Adminoperatelog extends \app\common\controller\CommonAdmin
{
    /**
     * @描述：管理员操作记录列表
     */
    public function index(){
        $param = $this->request->param();
        $ModelAdmin=Db::name('admin');
        $ModelAdminOperateLog=Db::name('admin_operate_log');

        $admin_id=Session::get('adminid');
        $List=$ModelAdminOperateLog->where("admin_id='$admin_id'")->order("id DESC")
                                   ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();
        $_list=array();
        foreach($List as $key=>$value){
            $getoneAdmin=$ModelAdmin->where("admin_id='$value[admin_id]'")->find();
            $_arr=$value;
            $_arr["admin_name"]=$getoneAdmin["name"];
            $_list[]=$_arr;
        }

        $this->assign("List",$_list);
        $this->assign("page",$show);
        return $this->fetch();
    }
}