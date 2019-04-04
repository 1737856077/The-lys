<?php
namespace app\paper\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:模版管理
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Dtemplate.php 2019-03-11 09:37:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Paper extends CommonAdmin
{
    /**
     * @描述：初始方法
     */
    public function _initialize(){
        parent::_initialize();

        // 纸张厚度单位
        $this->assign("ConfigPaperThicknessUnit", \think\Config::get('data.paper_thickness_unit'));
    }

    /**
     * @描述：列表页面
     */
    public function  index(){
        $param = $this->request->param();

        $model=Db::name('paper');
        $list=$model->where('data_type=0')
        ->order("sort_rank ASC,id ASC")->select();

        $this->assign("count",count($list));
        $this->assign("list",$list);
        return $this->fetch();
    }

    /**
     * @desc :  添加
     */
    public function add(){
        return $this->fetch();
    }

    /**
     * @desc : 添加-提交
     */
    public function insert(){
        $param = $this->request->post();
        $model=Db::name('paper');


        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $thickness=intval(isset($param['thickness']) ? trim($param['thickness']) : '0');
        $thickness_unit=htmlspecialchars(isset($param['thickness_unit']) ? trim($param['thickness_unit']) : '');
        $price=my_price(isset($param['thickness']) ? trim($param['price']) : 0.00);
        $sort_rank=intval(isset($param['sort_rank']) ? trim($param['sort_rank']) : '50');
        $data_status=intval(isset($param['data_status']) ? trim($param['data_status']) : '0');
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(empty($title) or !$thickness or empty($thickness_unit) or $price<=0){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'title'=>$title,
            'thickness'=>$thickness,
            'thickness_unit'=>$thickness_unit,
            'price'=>$price,
            'sort_rank'=>$sort_rank,
            'data_status'=>$data_status,
            'data_desc'=>$data_desc,
            'update_time'=>$gettime,
        );
        $ReturnID=$model->insert($data);

        $this->success("操作成功",url("paper/index"),3);
        exit;
    }

    /**
     * @desc : 编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id = intval(isset($param['id']) ? $param['id'] : '0') ;
        if(empty($id)){echo 'paramer error!';exit;}
        $model=Db::name('paper');
        $getone=$model->where("id='$id'")->find();

        $this->assign("getone",$getone);
        return $this->fetch();
    }

    /**
     * @desc : 编辑-更新
     */
    public function update(){
        $param = $this->request->post();
        $model=Db::name('paper');

        $id=intval(isset($param['id']) ? trim($param['id']) : '0');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $thickness=intval(isset($param['thickness']) ? trim($param['thickness']) : '0');
        $thickness_unit=htmlspecialchars(isset($param['thickness_unit']) ? trim($param['thickness_unit']) : '');
        $price=my_price(isset($param['thickness']) ? trim($param['price']) : 0.00);
        $sort_rank=intval(isset($param['sort_rank']) ? trim($param['sort_rank']) : '0');
        $data_status=intval(isset($param['data_status']) ? trim($param['data_status']) : '0');
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(!$id or empty($title) or !$thickness or empty($thickness_unit) or $price<=0 ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'title'=>$title,
            'thickness'=>$thickness,
            'thickness_unit'=>$thickness_unit,
            'price'=>$price,
            'sort_rank'=>$sort_rank,
            'data_status'=>$data_status,
            'data_desc'=>$data_desc,
            'update_time'=>$gettime,
        );
        $ReturnID=$model->where("id='$id'")->update($data);

        $this->success("操作成功",url("paper/index"),3);
        exit;
    }

    /**
     * @desc : 设置状态
     */
    public function setDataStatus(){
        $param = $this->request->param();
        $id = intval(isset($param['id']) ? $param['id'] : '0') ;
        $Status=intval(isset($param['Status']) ? trim($param['Status']) : '0');
        if(empty($id)){echo 'paramer error!';exit;}

        $model=Db::name('paper');
        $model->where("id='$id'")->update(array('data_status'=>$Status));

        $this->success("操作成功",url("paper/index"),3);
        exit;
    }

    /**
     * @desc : 删除
     */
    public function del(){
        $param = $this->request->param();
        $id = intval(isset($param['id']) ? $param['id'] : '0') ;
        $ids=isset($param['ids']) ? $param['ids']: [];
        if(empty($id) and empty($ids)){echo 'paramer error!';exit;}

        $model=Db::name('paper');
        if(empty($ids)) {
            $model->where("id='$id'")->delete();
        }else{
            $model->whereIn('id',$ids)->delete();
        }

        $this->success("操作成功",url("paper/index"),3);
        exit;
    }

    /**
     * @desc : 排序
     */
    public function sortrank(){
        $param = $this->request->post();
        $model=Db::name('paper');

        $sorts=isset($param['sorts']) ? $param['sorts']: [];

        if(!empty($sorts)){
            foreach ($sorts as $key=>$value){
                $value = intval($value);
                $model->where("id='$key'")->update(array('sort_rank'=>$value));
            }
        }
        $this->success("操作成功",url("paper/index"),3);
        exit;
    }
}