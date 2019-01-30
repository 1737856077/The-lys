<?php
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:系统节点管理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Systemnode.php 2018-07-14 11:57:00 $
 */

namespace app\auth\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Systemnode extends CommonAdmin
{
    /**
     * @描述：系统节点列表
     */
    public function  index(){
        $ModelSystemNode=Db::name('system_node');

        $_where="1";
        $_where .= ' AND class_id=0';
        if($_where=='1'){$_where='';}
        $count = $ModelSystemNode->where($_where)->count();

        $resultArr=array();
        $List=$ModelSystemNode->where($_where)
            ->order('data_status DESC,data_sort ASC,node_id ASC')
            ->select();
        foreach ($List as $key=>$value){
            //查询子类
            $listTwo=$ModelSystemNode->where('class_id='.$value['node_id'])
                ->order('data_status DESC,data_sort ASC,node_id ASC')
                ->select();
            $value['list']=$listTwo;
            $resultArr[]=$value;
        }

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        return $this->fetch();
    }

    /**
     * @描述：添加信息
     */
    public function add(){
        $ModelSystemNode=Db::name('system_node');
        $listSystemNode=$ModelSystemNode->where('class_id=0')
            ->order('data_sort ASC,node_id ASC')
            ->select();
        $this->assign("listSystemNode",$listSystemNode);
        return $this->fetch();
    }

    /**
     * @描述：添加提交
     */
    public function insert(){
        $param = $this->request->post();
        $ModelSystemNode=Db::name('system_node');

        $class_id=isset($param['class_id']) ? intval($param['class_id']) : "0" ;
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $content=htmlspecialchars(isset($param['content']) ? trim($param['content']) : '');
        $data_status=isset($param['data_status']) ? intval($param['data_status']) : "0" ;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(empty($title) or empty($content)  ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'class_id'=>$class_id,
            'title'=>$title,
            'content'=>$content,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );

        $ReturnID=$ModelSystemNode->insert($data);

        $this->success("操作成功",url("systemnode/index"),3);
        exit;
    }

    /**
     * @描述：编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelSystemNode=Db::name('system_node');
        $getone=$ModelSystemNode->where("node_id='$id'")->find();

        $listSystemNode=$ModelSystemNode->where('class_id=0 AND node_id!='.$id)
            ->order('data_sort ASC,node_id ASC')
            ->select();
        $this->assign("listSystemNode",$listSystemNode);

        $this->assign("getone",$getone);
        return $this->fetch();
    }

    /**
     * @描述：编辑提交
     */
    public function update(){
        $param = $this->request->post();
        $ModelSystemNode=Db::name('system_node');

        $node_id=isset($param['node_id']) ? intval($param['node_id']) : "0" ;
        $class_id=isset($param['class_id']) ? intval($param['class_id']) : "0" ;
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $content=htmlspecialchars(isset($param['content']) ? trim($param['content']) : '');
        $data_status=isset($param['data_status']) ? intval($param['data_status']) : "0" ;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(empty($title) or empty($content) or !$node_id){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'class_id'=>$class_id,
            'title'=>$title,
            'content'=>$content,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );

        $ReturnID=$ModelSystemNode->where("node_id='$node_id'")->update($data);

        $this->success("操作成功",url("systemnode/index"),3);
        exit;
    }

    /**
     * @描述：审核状态-操作处理
     */
    public function editinfo(){
        $param = $this->request->param();
        $ModelSystemNode=Db::name('system_node');
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if($param["action"]=="checkStatus"){//设置状态
            $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;
            $ModelSystemNode->where("node_id='$id'")->setField('data_status',$Status);
        }
        //全选 all
        if($param["action"]=="save"){
            $sqt=isset($param['sqt']) ? $param['sqt'] : array();
            $IDs=isset($param['IDs']) ? $param['IDs'] : array();
            $SortRank=isset($param['SortRank']) ? $param['SortRank'] : array();
            $checkclass=$param['checkclass'];

            if($checkclass=="5"){//审核通过
                if(count($sqt)){
                    foreach($sqt as $id){
                        $ModelSystemNode->where("node_id='$id'")->setField('data_status',"1");
                    }
                }
            }else if($checkclass=="6"){//取消审核
                if(count($sqt)){
                    foreach($sqt as $id){
                        $ModelSystemNode->where("node_id='$id'")->setField('data_status',"0");
                    }
                }

            }
        }
        $this->success("操作成功",url("systemnode/index"),3);
        exit;
    }
}