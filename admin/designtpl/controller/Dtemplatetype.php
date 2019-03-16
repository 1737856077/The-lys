<?php
namespace app\designtpl\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:模版-分类管理
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Dtemplatetype.php 2019-03-15 09:37:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Dtemplatetype extends CommonAdmin
{
    /**
     * @描述：初始方法
     */
    public function _initialize(){
        parent::_initialize();
    }

    /**
     * @描述：列表页面
     */
    public function  index(){
        $param = $this->request->param();
        //查询
        $father_id = intval(isset($param['father_id']) ? $param['father_id'] : '1') ;
        $this->assign("father_id",$father_id);

        $ModelSystemConfig=Db::name('template_class');
        $list=$ModelSystemConfig->where("father_id='$father_id'")->order("sort_rank ASC,class_id ASC")->select();

        $this->assign("count",count($list));
        $this->assign("list",$list);
        return $this->fetch();
    }

    /**
     * @desc :  添加
     */
    public function add(){
        $param = $this->request->param();
        $father_id=intval(isset($param['father_id']) ? trim($param['father_id']) : '1');
        if(empty($father_id)){echo 'paramer error!';exit;}

        $this->assign("father_id",$father_id);
        return $this->fetch();
    }

    /**
     * @desc : 添加-提交
     */
    public function insert(){
        $param = $this->request->post();
        $model=Db::name('template_class');

        $father_id=intval(isset($param['father_id']) ? trim($param['father_id']) : '0');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $sort_rank=intval(isset($param['sort_rank']) ? trim($param['sort_rank']) : '0');
        $data_status=intval(isset($param['data_status']) ? trim($param['data_status']) : '0');
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(!$father_id or empty($title) ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'father_id'=>$father_id,
            'level'=>'2',
            'title'=>$title,
            'sort_rank'=>$sort_rank,
            'data_status'=>$data_status,
            'data_desc'=>$data_desc,
            'update_time'=>$gettime,
        );
        $ReturnID=$model->insert($data);

        $this->success("操作成功",url("dtemplatetype/index").'?father_id='.$father_id,3);
        exit;
    }

    /**
     * @desc : 编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id = intval(isset($param['id']) ? $param['id'] : '0') ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelSystemConfig=Db::name('template_class');
        $getone=$ModelSystemConfig->where("class_id='$id'")->find();

        $this->assign("getone",$getone);
        return $this->fetch();
    }

    /**
     * @desc : 编辑-更新
     */
    public function update(){
        $param = $this->request->post();
        $model=Db::name('template_class');

        $class_id=intval(isset($param['class_id']) ? trim($param['class_id']) : '0');
        $father_id=intval(isset($param['father_id']) ? trim($param['father_id']) : '0');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $sort_rank=intval(isset($param['sort_rank']) ? trim($param['sort_rank']) : '0');
        $data_status=intval(isset($param['data_status']) ? trim($param['data_status']) : '0');
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(!$class_id or empty($title) ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'title'=>$title,
            'sort_rank'=>$sort_rank,
            'data_status'=>$data_status,
            'data_desc'=>$data_desc,
            'update_time'=>$gettime,
        );
        $ReturnID=$model->where("class_id='$class_id'")->update($data);

        $this->success("操作成功",url("dtemplatetype/index").'?father_id='.$father_id,3);
        exit;
    }

    /**
     * @desc : 设置状态
     */
    public function setDataStatus(){
        $param = $this->request->param();
        $id = intval(isset($param['id']) ? $param['id'] : '0') ;
        $father_id=intval(isset($param['father_id']) ? trim($param['father_id']) : '0');
        $Status=intval(isset($param['Status']) ? trim($param['Status']) : '0');
        if(empty($id)){echo 'paramer error!';exit;}

        $model=Db::name('template_class');
        $model->where("class_id='$id'")->update(array('data_status'=>$Status));

        $this->success("操作成功",url("dtemplatetype/index").'?father_id='.$father_id,3);
        exit;
    }

    /**
     * @desc : 删除
     */
    public function del(){
        $param = $this->request->param();
        $id = intval(isset($param['id']) ? $param['id'] : '0') ;
        $father_id=intval(isset($param['father_id']) ? trim($param['father_id']) : '0');
        $ids=isset($param['ids']) ? $param['ids']: [];
        if(empty($id) and empty($ids)){echo 'paramer error!';exit;}

        $model=Db::name('template_class');
        if(empty($ids)) {
            $model->where("class_id='$id'")->delete();
        }else{
            $model->whereIn('class_id',$ids)->delete();
        }

        $this->success("操作成功",url("dtemplatetype/index").'?father_id='.$father_id,3);
        exit;
    }

    /**
     * @desc : 排序
     */
    public function sortrank(){
        $param = $this->request->post();
        $model=Db::name('template_class');

        $father_id=intval(isset($param['father_id']) ? trim($param['father_id']) : '0');
        $sorts=isset($param['sorts']) ? $param['sorts']: [];

        if(!empty($sorts)){
            foreach ($sorts as $key=>$value){
                $value = intval($value);
                $model->where("class_id='$key'")->update(array('sort_rank'=>$value));
            }
        }
        $this->success("操作成功",url("dtemplatetype/index").'?father_id='.$father_id,3);
        exit;
    }
}