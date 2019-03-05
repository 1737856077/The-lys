<?php
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Region.php 2018-04-05 20:52:00 $
 */

namespace app\region\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
class Region extends Controller
{
    public function index(){

    }

    /**
     * @描述：根据ID取得子级列表
     */
    public function ajax_region(){
        $param = $this->request->param();
        $area_code=$param['id'];
        $ModelRegion=Db::name('region');
        $list=$ModelRegion->where("data_status=1 AND area_parent_id='$area_code'")
                        ->order('id ASC')
                        ->select();
        $_list=array();
        foreach($list as $key=>$val){
            $_arr=array();
            $_arr['ID']=$val['area_code'];
            $_arr['TITLE']=$val['area_name'];
            $_list[]=$_arr;
        }
        echo json_encode($_list);
        exit;
    }


}