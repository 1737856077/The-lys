<?php
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:角色授权管理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Roleauth.php 2018-07-14 13:58:00 $
 */

namespace app\auth\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Roleauth extends CommonAdmin
{
    /**
     * @描述：系统节点列表
     */
    public function  index(){
        $param = $this->request->param();
        $role_id=isset($param['role_id']) ? intval($param['role_id']) : 0 ;
        if(!($role_id)){echo 'paramer error!';exit;}

        $ModelSystemNode=Db::name('system_node');
        $ModelSystemRole=Db::name('system_role');
        $ModelSystemRoleAuth=Db::name('system_role_auth');
        $getoneSystemRole=$ModelSystemRole->where("role_id='$role_id'")->find();
        $this->assign("getoneSystemRole",$getoneSystemRole);
        //查询当前角色的所有权限
        $listSystemRoleAuth=$ModelSystemRoleAuth->where("role_id=$role_id")->select();
        $role_node_ids=array();
        foreach ($listSystemRoleAuth as $key=>$val){
            $role_node_ids[]=$val['node_id'];
        }
        $this->assign("role_node_ids",$role_node_ids);

        $_where="1";
        $_where .= ' AND class_id=0 AND data_status=1 ';
        if($_where=='1'){$_where='';}
        $count = $ModelSystemNode->where($_where)->count();

        $resultArr=array();
        $List=$ModelSystemNode->where($_where)
            ->order('data_sort ASC,node_id ASC')
            ->select();
        foreach ($List as $key=>$value){
            //查询子类
            $listTwo=$ModelSystemNode->where('data_status=1 AND class_id='.$value['node_id'])
                ->order('data_sort ASC,node_id ASC')
                ->select();
            $value['list']=$listTwo;
            $resultArr[]=$value;
        }

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        return $this->fetch();
    }

    /**
     * @描述：更新权限-操作处理
     */
    public function editinfo(){
        $param = $this->request->param();
        $ModelSystemRole=Db::name('system_role');
        $ModelSystemRoleAuth=Db::name('system_role_auth');
        $role_id=isset($param['role_id']) ? htmlspecialchars($param['role_id']) : '' ;
        if(empty($role_id)){echo 'paramer error!';exit;}
        $getoneSystemRole=$ModelSystemRole->where("role_id='$role_id'")->find();

        //全选 all
        if($param["action"]=="save"){
            $node_id=isset($param['node_id']) ? $param['node_id'] : array();
            $checkclass=$param['checkclass'];

            if($checkclass=="21"){//更新权限
                if(count($node_id)){
                    $ModelSystemRoleAuth->where("role_id='$role_id' AND node_id NOT IN (".implode(',',$node_id).")")->delete();
                    foreach($node_id as $id){
                        //查看是否已存在
                        $_count=$ModelSystemRoleAuth->where("role_id='$role_id' AND node_id='$id' ")->count();
                        if(!$_count){
                            $_data=array('role_id'=>$role_id,
                                'node_id'=>$id,
                            );
                            $ModelSystemRoleAuth->insert($_data);
                        }
                    }
                }else{
                    $ModelSystemRoleAuth->where("role_id='$role_id'")->delete();
                }
            }
        }

        $this->success("操作成功",url("systemrole/index")."?role_id=$role_id",3);
        exit;
    }


}