<?php
namespace app\admin\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Admin.php 2018-04-05 13:50:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;

class Admin extends \app\common\controller\CommonAdmin
{
    /**
     * @描述：管理员列表页面
     */
    public function index(){
        $Admin=Db::name('admin');
        $ModelSystemRole=Db::name('system_role');

        $list=$Admin->order('admin_id ASC')->select();
        foreach($list as $key=>$val){
            //查询角色名称
            $_getoneSystemRole=$ModelSystemRole->where("role_id='$val[role_id]'")->find();
            $list[$key]['role_title']=$_getoneSystemRole['title'];
        }

        $this->assign("list",$list);

        return $this->fetch();
    }

    /**
     * @描述：添加管理员页面
     */
    public function add(){
        //查询所有角色
        $ModelSystemRole=Db::name('system_role');
        $listSystemRole=$ModelSystemRole->where("data_status=1")
            ->order('role_id ASC')
            ->select();
        $this->assign("listSystemRole",$listSystemRole);
        return $this->fetch();
    }

    /**
     * @描述：提交添加管理员表单方法
     */
    public function insert(){
        $param = $this->request->post();
        $ModelAdmin=Db::name('admin');
        $name=htmlspecialchars(trim($param['name']));
        $count=$ModelAdmin->where("name='$name'")->count();
        if($count){ $this->error("操作失败，用户名已存在"); }

        $data=array();
        $data['name']=$name;
        $data['pwd']=md5(trim($param['pwd']));
        $data['role_id']=isset($param['role_id']) ? intval($param['role_id']) : 0;
        $data['data_type']=isset($param['data_type']) ? intval($param['data_type']) : 0  ;
        $tel=htmlspecialchars(isset($param['tel']) ? trim($param['tel']) : '');
        $data['tel']=$tel;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $data['data_desc']=$data_desc;

        if(!empty($data)){

            if($ModelAdmin->insert($data)){
                //$this->success("操作成功");
                //添加日志 begin
                $_content="添加管理员";
                $ModelAdminOperateLog=Db::name('admin_operate_log');
                $dataAdminOperateLog=array("content"=>$_content,
                                           "admin_id"=>Session::get('adminid'),
                                           "create_ip"=>$_SERVER["REMOTE_ADDR"],
                                           "create_time"=>time(),
                );
                $ModelAdminOperateLog->insert($dataAdminOperateLog);
                //添加日志 end
                $this->success("操作成功",url("admin/index"),3);
            }else{
                $this->error("操作失败");
            }
        }else{
            $this->error("数据错误！");
        }

    }

    /**
     * @描述：显示编辑管理员信息页面
     */
    public function edit(){
        $param = $this->request->param();

        //查询所有角色
        $ModelSystemRole=Db::name('system_role');
        $listSystemRole=$ModelSystemRole->where("data_status=1")
            ->order('role_id ASC')
            ->select();
        $this->assign("listSystemRole",$listSystemRole);

        $admin_id=isset($param["id"]) ? intval($param["id"]) : 0 ;
        if($admin_id){
            $Admin=Db::name('admin');
            $data=$Admin->where("admin_id='$admin_id'")->find();
            /*dump($data);*/
            if(!empty($data)){

                $this->assign("data",$data);
                return $this->fetch();
            }else{
                $this->error("没有此数据！");
            }

        }else{
            $this->error("数据错误！");
        }
    }

    /**
     * @描述：提交编辑管理员表单方法
     */
    public function update(){
        $param = $this->request->post();
        $Admin=Db::name('admin');
        $data=array();
        $admin_id=intval(trim($param['admin_id']));
        $data['role_id']=isset($param['role_id']) ? intval($param['role_id']) : 0;
        $data['data_type']=isset($param['data_type']) ? intval($param['data_type']) : 0  ;
        $tel=htmlspecialchars(isset($param['tel']) ? trim($param['tel']) : '');
        $data['tel']=$tel;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $data['data_desc']=$data_desc;

        if(!empty($data)){
            $result=$Admin->where("admin_id='$admin_id'")->update($data);
            //echo $result;
            if($result === false){
                $this->error("操作失败");
            }else{
                //添加日志 begin
                $_content="编辑管理员信息。";
                $ModelAdminOperateLog=Db::name('admin_operate_log');
                $dataAdminOperateLog=array("content"=>$_content,
                    "admin_id"=>Session::get('adminid'),
                    "create_ip"=>$_SERVER["REMOTE_ADDR"],
                    "create_time"=>time(),
                );
                $ModelAdminOperateLog->insert($dataAdminOperateLog);
                //添加日志 end
                $this->success("操作成功",url("admin/index"),3);
            }
        }else{
            $this->error("数据错误！");
        }
    }

    /**
     * @描述：删除管理员
     */
    public function delete(){
        $param = $this->request->param();
        $id=intval($param["id"]);
        //dump($id);
        if(!empty($id)){
            $Admin=Db::name('admin');
            $Admin->delete($id);
            //添加日志 begin
            $_content="删除管理员。";
            $ModelAdminOperateLog=Db::name('admin_operate_log');
            $dataAdminOperateLog=array("content"=>$_content,
                                       "admin_id"=>Session::get('adminid'),
                                       "create_ip"=>$_SERVER["REMOTE_ADDR"],
                                       "create_time"=>time(),
            );
            $ModelAdminOperateLog->insert($dataAdminOperateLog);
            //添加日志 end
            $this->success("操作成功",url("admin/index"),3);
        }else{
            $this->error("数据错误！");
        }

    }

    /**
     * @描述：登录者修改自己的密码
     */
    public function modifypwd(){
        $map=array();
        $map['name']=array('eq',Session::get("adminname"));
        $Admin=Db::name('admin');
        $getoneAdmin=$Admin->where($map)->find();
        $this->assign('getoneAdmin',$getoneAdmin);
        return $this->fetch();
    }
    public function modifypwds(){
        $param = $this->request->param();
        $admin_id = htmlspecialchars(isset($param['admin_id'])?intval(trim($param['admin_id'])):'');
        $Admin=Db::name('admin');
        $getoneAdmin=$Admin->where("admin_id",$admin_id)->find();
        return json($getoneAdmin);
    }

    /**
     * @描述：登录者修改自己的密码提交表单数据
     */
    public function modifypwdupdate(){
        $param = $this->request->post();
        $type=isset($param['type']) ? $param['type'] : '' ;

            $id=intval(trim($param['admin_id']));
            $adminpwd1=trim($param['adminpwd1']);
            $adminpwd2=trim($param['adminpwd2']);
            $adminpwd3=trim($param['adminpwd3']);
            if(empty($adminpwd1) or empty($adminpwd2) or empty($adminpwd3)){$this->error("必填项不能为空！");}
            if($adminpwd2!=$adminpwd3){$this->error("新密码二次不相同！");}

            $map=array();
            $map['admin_id']=array('eq',$id);
            $map['pwd']=array('eq',md5($adminpwd1));
            $Admin=Db::name('admin');
            $count=$Admin->where($map)->count();
            if(!$count){
                $this->error("老密码错误！");

            }else{
                $data=array();
                $data['pwd']=md5($adminpwd2);
                $falg=$Admin->where(['admin_id'=>$id])->update($data);

                if($falg!==false){
                    //添加日志 begin
                    $_content="修改自己的登录密码。";
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

                    //$this->redirect("Index/login","",1,"操作成功，请重新登录，1称后自动跳转");
                    echo "<script language=\"javascript\">alert('操作成功，请重新登录');window.open('/admin.php','_top');</script>";
                }else{
                    $this->error("数据错误！");
                }
            }

    }

    /**
     * @描述：显示重置管理员密码页面
     */
    public function setpwd(){
        $param = $this->request->param();

        $admin_id=isset($param["id"]) ? intval($param["id"]) : 0 ;
        if($admin_id){
            $Admin=Db::name('admin');
            $data=$Admin->where("admin_id='$admin_id'")->find();
            /*dump($data);*/
            if(!empty($data)){

                $this->assign("data",$data);
                return $this->fetch();
            }else{
                $this->error("没有此数据！");
            }

        }else{
            $this->error("数据错误！");
        }
    }

    /**
     * @描述：重置管理员密码提交表单
     */
    public function setpwdupdate(){
        $param = $this->request->post();

        $id=intval(trim($param['admin_id']));
        $name=trim($param['name']);
        $pwd=trim($param['pwd']);

        if(empty($id) or empty($pwd)){$this->error("必填项不能为空！");}

        $map=array();
        $map['admin_id']=array('eq',$id);
        $Admin=Db::name('admin');


            $data=array();
            $data['pwd']=md5($pwd);
            $falg=$Admin->where(['admin_id'=>$id])->update($data);

            if($falg!==false){
                //添加日志 begin
                $_content="重置了{$name}密码。";
                $ModelAdminOperateLog=Db::name('admin_operate_log');
                $dataAdminOperateLog=array("content"=>$_content,
                                           "admin_id"=>Session::get('adminid'),
                                           "create_ip"=>$_SERVER["REMOTE_ADDR"],
                                           "create_time"=>time(),
                );
                $ModelAdminOperateLog->insert($dataAdminOperateLog);
                //添加日志 end

                $this->success("操作成功",url("admin/index"),3);

            }else{
                $this->error("数据错误！",url("admin/index"),3);
            }


    }

    /**
     * @描述：审核状态-操作处理
     */
    public function editinfo(){
        $param = $this->request->param();
        $modelAdmin=Db::name('admin');
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if($param["action"]=="checkStatus"){//设置状态
            $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;
            $modelAdmin->where("admin_id='$id'")->setField('data_status',$Status);
        }

        $this->success("操作成功",url("admin/index"),3);
        exit;
    }
}