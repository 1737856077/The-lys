<?php
namespace app\salesman\controller;
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @desc:业务管理员-授权类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Salesmanbusiness.php 2018-05-07 18:24:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Salesmanbusiness extends CommonAdmin
{
    /**
     * @描述：初始方法
     */
    public function _initialize(){
        parent::_initialize();
        //管理员状态
        $this->assign("ConfigBusinessStatus", \think\Config::get('data.admin_status'));
    }

    /**
     * @描述：商家列表
     */
    public function  index()
    {
        $param = $this->request->param();
        //查询
        $salesman_id = isset($param['salesman_id']) ? htmlspecialchars(urldecode($param['salesman_id'])) : '';
        if(empty($salesman_id)){echo 'paramer error salesman_id!';exit;}
        $SearchTitle = isset($param['SearchTitle']) ? htmlspecialchars(urldecode($param['SearchTitle'])) : '';
        $paramUrl = '';
        $paramUrl .= 'SearchTitle=' . $SearchTitle;
        $this->assign("SearchTitle", $SearchTitle);

        $ModelSalesman=Db::name('admin');
        $ModelSalesmanBusiness=Db::name('salesman_business');

        $getoneSalesman=$ModelSalesman->where("admin_id='$salesman_id'")->find();
        $this->assign("getoneSalesman", $getoneSalesman);
        $_where = "data_type=2";
        if (!empty($SearchTitle)) {
            $_where .= " AND title LIKE '%" . urldecode($SearchTitle) . "%'";
        }

        if ($_where == '1') {
            $_where = '';
        }
        $count = $ModelSalesman->where($_where)->count();

        $resultArr = array();
        $List = $ModelSalesman->where($_where)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'), false, ['query' => $this->request->get('', '', 'urlencode')]);
        $show = $List->render();

        foreach ($List as $key => $value) {
            //查看是否已被关连
            $getoneSalesmanBusiness = $ModelSalesmanBusiness->where("business_id='$value[admin_id]'")->find();
            if (empty($getoneSalesmanBusiness)) {
                $value['business_salesman_id'] ='';
            } else {
                $value['business_salesman_id'] = $getoneSalesmanBusiness['salesman_id'];
            }
            $resultArr[] = $value;
        }

        $this->assign("count", $count);
        $this->assign("List", $resultArr);
        $this->assign("page", $show);
        $this->assign('paramUrl', $paramUrl);
        return $this->fetch();
    }

    /**
     * @描述：查看关连商家
     */
    public function info(){
        $param = $this->request->param();
        $salesman_id = isset($param['salesman_id']) ? htmlspecialchars(urldecode($param['salesman_id'])) : '';
        if(empty($salesman_id)){echo 'paramer error salesman_id!';exit;}

        $SearchTitle = isset($param['SearchTitle']) ? htmlspecialchars(urldecode($param['SearchTitle'])) : '';
        $paramUrl = '';
        $paramUrl .= 'SearchTitle=' . $SearchTitle;
        $this->assign("SearchTitle", $SearchTitle);
        $this->assign("ConfigVillageStatus", \think\Config::get('data.village_status'));

        $ModelSalesman=Db::name('admin');
        $ModelSalesmanBusiness=Db::name('salesman_business');

        $getoneSalesman=$ModelSalesman->where("admin_id='$salesman_id'")->find();
        $this->assign("getoneSalesman", $getoneSalesman);
        $_where = "data_type=2";
        if (!empty($SearchTitle)) {
            $_where .= " AND name LIKE '%" . urldecode($SearchTitle) . "%'";
        }

        //查看业务现关连的小区
        $listSalesmanBusiness=$ModelSalesmanBusiness->where("salesman_id='$salesman_id'")->select();
        if(count($listSalesmanBusiness)){
            $_business_uuids=array();
            foreach($listSalesmanBusiness as $k=>$v){
                $_business_uuids[$k]=$v['business_id'];
            }
            $_business_uuids=implode("','",$_business_uuids);
            $_where.=" AND admin_id IN ('$_business_uuids')";
        }else{
            $_where .= ' AND 0';
        }

        if ($_where == '1') {
            $_where = '';
        }
        $count = $ModelSalesman->where($_where)->count();

        $resultArr = array();
        $List = $ModelSalesman->where($_where)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'), false, ['query' => $this->request->get('', '', 'urlencode')]);
        $show = $List->render();

        foreach ($List as $key => $value) {
            $resultArr[] = $value;
        }

        $this->assign("count", $count);
        $this->assign("List", $resultArr);
        $this->assign("page", $show);
        $this->assign('paramUrl', $paramUrl);
        return $this->fetch();
    }

    /**
     * @描述：业务员管理员授权
     */
    public function ajax_auth(){
        $param = $this->request->param();
        $salesman_id = isset($param['salesman_id']) ? intval(urldecode($param['salesman_id'])) : 0;
        $business_id = isset($param['business_id']) ? htmlspecialchars(urldecode($param['business_id'])) : '';

        $returnArray=array('code'=>'0',
            'msg'=>'',
        );
        if(empty($salesman_id) or empty($business_id)){
            $returnArray['code']='-1';
            $returnArray['msg']='参数错误！';
        }
        $ModelSalesmanBusiness=Db::name('salesman_business');
        $count=$ModelSalesmanBusiness->where("business_id='$business_id' AND salesman_id='$salesman_id'")->count();
        if($count){//删除
            $ModelSalesmanBusiness->where("business_id='$business_id' AND salesman_id='$salesman_id'")->delete();
        }else{//insert
            $gettime=time();
            $data=array('salesman_id'=>$salesman_id,
                'business_id'=>$business_id,
                'create_time'=>$gettime,
                'update_time'=>$gettime,
            );
            $ModelSalesmanBusiness->insert($data);
        }

        echo json_encode($returnArray);exit;
    }
}