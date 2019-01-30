<?php
namespace app\salesman\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:业务员管理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Salesman.php 2018-05-06 09:37:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Salesman extends CommonAdmin
{
    /**
     * @描述：业务员列表页面
     */
    public function  index(){
        $param = $this->request->param();
        //查询
        $SearchTitle = isset($param['SearchTitle']) ? $param['SearchTitle'] : '' ;
        $SearchTitle=urldecode($SearchTitle);
        $SearchTel = isset($param['SearchTel']) ? $param['SearchTel'] : '' ;
        $SearchTel=urldecode($SearchTel);
        $paramUrl='';
        $paramUrl.='SearchTitle='.$SearchTitle;
        $paramUrl.='&SearchTel='.$SearchTel;
        $this->assign("SearchTitle",$SearchTitle);
        $this->assign("SearchTel",$SearchTel);

        $ModelSalesman=Db::name('admin');
        $ModelSalesmanBusiness=Db::name('salesman_business');

        //加入权限 begin
        $_whereInSalesman=[];//当前业务员
        //业务员
        if(Session::get('admin_data_type')=='1' and Session::get('admin_role_id')=='2'){
            $_whereInSalesman['admin_id']=['in', intval(Session::get('adminid'))];
        }
        //加入权限 end

        $_where="1 AND role_id=2";
        if(!empty($SearchTitle)){ $_where.=" AND name LIKE '%".urldecode($SearchTitle)."%'"; }
        if(!empty($SearchTel)){ $_where.=" AND tel LIKE '%".urldecode($SearchTel)."%'"; }
//echo $_where;exit;
        if($_where=='1'){$_where='';}
        $count = $ModelSalesman->where($_where)
            ->where($_whereInSalesman)
            ->count();

        $resultArr=array();
        $List=$ModelSalesman->where($_where)
            ->where($_whereInSalesman)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

        foreach($List as $key=>$arr){
            //统计业务员的商家总数
            $countSalesmanBusiness=$ModelSalesmanBusiness->where("salesman_id='$arr[admin_id]'")->count();
            $arr['count_business']=$countSalesmanBusiness;

            //查询所管理的商家
            $_BusinessIDs=$_listBusiness=array();
            $_listSalesmanBusiness=$ModelSalesmanBusiness->where("salesman_id='$arr[admin_id]'")->select();
            foreach ($_listSalesmanBusiness as $k=>$v){
                $_BusinessIDs[]=$v['business_id'];
            }
            if(count($_BusinessIDs)){
                $_listBusiness=$ModelSalesman->whereIn('admin_id',$_BusinessIDs)->select();
            }
            $arr['listBusiness']=$_listBusiness;

            $resultArr[]=$arr;
        }

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
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
        $ModelSalesman=Db::name('salesman');

        $name=htmlspecialchars(isset($param['name']) ? trim($param['name']) : '');
        $tel=htmlspecialchars(isset($param['tel']) ? trim($param['tel']) : '');
        $pwd='';
        $data_status=isset($param['data_status']) ? intval($param['data_status']) : 0 ;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(empty($name) or empty($tel)   ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        //验证是否存在相同
        $count=$ModelSalesman->where("name='$name'")->count();
        if($count){
            echo '<script language="javascript">alert("业务员已存在相同！");history.go(-1);</script>';
            exit;
        }

        $data=array('salesman_id'=>my_returnUUID(),
            'name'=>$name,
            'pwd'=>$pwd,
            'tel'=>$tel,
            'data_status'=>$data_status,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );

        $ReturnID=$ModelSalesman->insert($data);

        $this->success("操作成功",url("salesman/index"),3);
        exit;
    }

    /**
     * @描述：编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelSalesman=Db::name('salesman');
        $getone=$ModelSalesman->where("salesman_id='$id'")->find();

        $this->assign("getone",$getone);
        return $this->fetch();
    }

    /**
     * @描述：编辑提交
     */
    public function update(){
        $param = $this->request->post();
        $ModelSalesman=Db::name('salesman');

        $salesman_id=htmlspecialchars(isset($param['salesman_id']) ? trim($param['salesman_id']) : '');
        $tel=htmlspecialchars(isset($param['tel']) ? trim($param['tel']) : '');
        $data_status=isset($param['data_status']) ? intval($param['data_status']) : 0 ;
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();

        if(empty($salesman_id) or empty($tel)  ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'tel'=>$tel,
            'data_status'=>$data_status,
            'data_desc'=>$data_desc,
            'update_time'=>$gettime,
        );

        $ReturnID=$ModelSalesman->where("salesman_id='$salesman_id'")->update($data);

        $this->success("操作成功",url("salesman/index"),3);
        exit;
    }

    /**
     * @描述：审核状态-操作处理
     */
    public function editinfo(){
        $param = $this->request->param();
        $ModelSalesman=Db::name('admin');
        $id=isset($param['id']) ? intval($param['id']) : 0 ;

        if($param["action"]=="checkStatus"){//设置状态
            $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;

            $ModelSalesman->where("admin_id='$id'")->setField('job_status',$Status);
        }

        $this->success("操作成功",url("salesman/index"),3);
        exit;
    }
}