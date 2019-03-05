<?php
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @desc:系统角色管理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Systemrole.php 2018-07-12 07:50:00 $
 */

namespace app\auth\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Systemrole extends CommonAdmin
{
    /**
     * @描述：系统角色列表
     */
    public function  index(){
        $ModelSystemRole=Db::name('system_role');

        $_where="1";
        if($_where=='1'){$_where='';}
        $count = $ModelSystemRole->where($_where)->count();

        $resultArr=array();
        $List=$ModelSystemRole->where($_where)
            ->order('role_id ASC')
            ->select();

        $this->assign("count",$count);
        $this->assign("List",$List);
        return $this->fetch();
    }

    /**
     * @描述：添加信息
     */
    public function add(){
        return $this->fetch();
    }

    /**
     * @描述：添加提交
     */
    public function insert(){
        $param = $this->request->post();
        $ModelSystemRole=Db::name('system_role');

        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $data_status=isset($param['data_status']) ? intval($param['data_status']) : "0" ;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(empty($title)  ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'title'=>$title,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );

        $ReturnID=$ModelSystemRole->insert($data);

        $this->success("操作成功",url("systemrole/index"),3);
        exit;
    }

    /**
     * @描述：编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelSystemRole=Db::name('system_role');
        $getone=$ModelSystemRole->where("role_id='$id'")->find();

        $this->assign("getone",$getone);
        return $this->fetch();
    }

    /**
     * @描述：编辑提交
     */
    public function update(){
        $param = $this->request->post();
        $ModelSystemRole=Db::name('system_role');

        $role_id=isset($param['role_id']) ? intval($param['role_id']) : "0" ;
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $data_status=isset($param['data_status']) ? intval($param['data_status']) : "0" ;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(empty($title) or !$role_id){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'title'=>$title,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'update_time'=>$gettime,
        );

        $ReturnID=$ModelSystemRole->where("role_id='$role_id'")->update($data);

        $this->success("操作成功",url("systemrole/index"),3);
        exit;
    }

    /**
     * @描述：审核状态-操作处理
     */
    public function editinfo(){
        $param = $this->request->param();
        $ModelSystemRole=Db::name('system_role');
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if($param["action"]=="checkStatus"){//设置状态
            $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;
            $ModelSystemRole->where("role_id='$id'")->setField('data_status',$Status);
        }

        $this->success("操作成功",url("systemrole/index"),3);
        exit;
    }
}