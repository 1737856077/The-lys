<?php
namespace app\product\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品内容类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Templatecontent.php 2018-07-06 11:01:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonBase;
class Productcontent extends CommonBase
{
    /**
     * @desc：产品模版内容列表
     */
    public function index(){
        $param = $this->request->param();
        $product_id=isset($param['product_id']) ? htmlspecialchars($param['product_id']) : '' ;
        if(empty($product_id)){echo 'paramer error!';exit;}

        $this->assign("param",$param);

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelAdmin=Db::name('admin');

        $getoneProduct=$ModelProduct->where("product_id='$product_id'")->find();
        $this->assign("getoneProduct",$getoneProduct);

        $list=$ModelProductContent->where("product_id='$product_id'")
            ->order('data_sort ASC,create_time ASC')
            ->select();
        $this->assign("list",$list);
        return $this->fetch();
    }

    /**
     * @描述：添加信息
     */
    public function add(){
        $param = $this->request->param();
        $product_id=isset($param['product_id']) ? htmlspecialchars($param['product_id']) : '' ;
        if(empty($product_id)){echo 'paramer error!';exit;}

        $this->assign("param",$param);

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');

        $getoneProduct=$ModelProduct->where("product_id='$product_id'")->find();
        $this->assign("getoneProduct",$getoneProduct);
        return $this->fetch();
    }

    /**
     * @描述：添加提交
     */
    public function insert(){
        $param = $this->request->post();
        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelAdmin=Db::name('admin');

        $product_id=htmlspecialchars(isset($param['product_id']) ? trim($param['product_id']) : '');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $content=htmlspecialchars(isset($param['content']) ? trim($param['content']) : '');
        $data_sort=htmlspecialchars(isset($param['data_sort']) ? intval($param['data_sort']) : 0);
        $data_status=htmlspecialchars(isset($param['data_status']) ? intval($param['data_status']) : 0);
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();
        $admin_id=Session::get('adminid') ;

        if(empty($product_id) or empty($title) or empty($content)
        ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }

        //查看是否存在相同名称
        $count=$ModelProductContent->where("title='$title'")->count();
        if($count){
            echo '<script language="javascript">alert("名称已存在！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'product_content_id'=>my_returnUUID(),
            'product_id'=>$product_id,
            'title'=>$title,
            'content'=>$content,
            'data_sort'=>$data_sort,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );
        $ReturnID=$ModelProductContent->insert($data);
        if($ReturnID){
            $this->success("操作成功",url("productcontent/index").'?product_id='.$product_id,3);
        }else{
            $this->error("操作失败",url("productcontent/index").'?product_id='.$product_id,3);
        }
        exit;
    }

    /**
     * @描述：编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelAdmin=Db::name('admin');
        $getone=$ModelProductContent->where("product_content_id='$id'")->find();
        $getoneProduct=$ModelProduct->where("product_id='$getone[product_id]'")->find();

        $this->assign("getone",$getone);
        $this->assign("getoneProduct",$getoneProduct);
        return $this->fetch();
    }

    /**
     * @描述：编辑提交
     */
    public function update(){
        $param = $this->request->post();
        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');

        $product_content_id=htmlspecialchars(isset($param['product_content_id']) ? trim($param['product_content_id']) : '');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $content=htmlspecialchars(isset($param['content']) ? trim($param['content']) : '');
        $data_sort=htmlspecialchars(isset($param['data_sort']) ? intval($param['data_sort']) : 0);
        $data_status=htmlspecialchars(isset($param['data_status']) ? intval($param['data_status']) : 0);
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();
        $admin_id=Session::get('adminid') ;

        if(empty($product_content_id) or empty($title) or empty($content)
        ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }

        //查看是否存在相同名称
        $count=$ModelProductContent->where("title='$title' AND product_content_id!='$product_content_id'")->count();
        if($count){
            echo '<script language="javascript">alert("名称已存在！");history.go(-1);</script>';
            exit;
        }
        $getone=$ModelProductContent->where("product_content_id='$product_content_id'")->find();
        $data=array(
            'title'=>$title,
            'content'=>$content,
            'data_sort'=>$data_sort,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'update_time'=>$gettime,
        );
        $ReturnID=$ModelProductContent->where("product_content_id='$product_content_id'")->update($data);
        if($ReturnID!==false){
            $this->success("操作成功",url("productcontent/index").'?product_id='.$getone['product_id'],3);
        }else{
            $this->error("操作失败",url("productcontent/index").'?product_id='.$getone['product_id'],3);
        }
        exit;
    }

    /**
     * @描述：操作处理设置-审核状态
     */
    public function editinfo(){
        $param = $this->request->param();
        $action=isset($param["action"]) ? $param["action"] : '' ;
        $id=htmlspecialchars(isset($param['id']) ? trim($param['id']) : '');
        $product_id=htmlspecialchars(isset($param['product_id']) ? trim($param['product_id']) : '');

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');

        $getoneProduct=$ModelProduct->where("product_id='$product_id'")->find();
        if($action=="checkStatus"){//状态审核
            $getoneProductContent=$ModelProductContent->where("product_content_id='$id'")->find();
            $product_id=$getoneProductContent['product_id'];
            $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;
            $ModelProductContent->where("product_content_id='$id'")->setField('data_status',$Status);
        }
        $this->success("操作成功",url("productcontent/index").'?product_id='.$product_id,3);
        exit;
    }

    /**
     * @描述：操作处理设置-排序
     */
    public function savesort(){
        $param = $this->request->param();
        $action=isset($param["action"]) ? $param["action"] : '' ;
        $id=htmlspecialchars(isset($param['id']) ? trim($param['id']) : '');
        $product_id=htmlspecialchars(isset($param['product_id']) ? trim($param['product_id']) : '');

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');

        //全选 all
        if($action=="save"){
            $sqt=isset($param['sqt']) ? $param['sqt'] : array();
            $IDs=isset($param['IDs']) ? $param['IDs'] : array();
            $SortRank=isset($param['SortRank']) ? $param['SortRank'] : array();
            $checkclass=$param['checkclass'];

            if($checkclass=="3") {//排序
                foreach ($IDs as $id) {
                    $SortRank[$id] = intval($SortRank[$id]);
                    $ModelProductContent->where("product_content_id='$id'")->setField('data_sort', $SortRank[$id]);
                }
            }
        }

        $this->success("操作成功",url("productcontent/index").'?product_id='.$product_id,3);
        exit;
    }
}