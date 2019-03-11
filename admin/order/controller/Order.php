<?php
namespace app\order\controller;
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
class Order extends CommonAdmin
{
    /**
     * @描述：初始方法
     */
    public function _initialize(){
        parent::_initialize();
        // 订单状态
        $this->assign("ConfigOrderStatus", \think\Config::get('data.order_status'));
        // 支付状态
        $this->assign("ConfigPayStatus", \think\Config::get('data.pay_status'));
    }

    /**
     * @描述：列表页面
     */
    public function  index(){
        $param = $this->request->param();
        //查询
        $SearchUsername = htmlspecialchars(isset($param['SearchUsername']) ? $param['SearchUsername'] : '') ;
        $SearchOrderNo = htmlspecialchars(isset($param['SearchOrderNo']) ? $param['SearchOrderNo'] : '') ;
        $SearchEmail = isset($param['SearchEmail']) ? $param['SearchEmail'] : '' ;
        $SearchOrderStatus = isset($param['SearchOrderStatus']) ? $param['SearchOrderStatus'] : '' ;
        $SearchOrderDate = isset($param['SearchOrderDate']) ? $param['SearchOrderDate'] : '' ;
        $SearchTemplateTitle = htmlspecialchars(isset($param['SearchTemplateTitle']) ? $param['SearchTemplateTitle'] : '') ;
        $paramUrl='';
        $paramUrl.='SearchUsername='.$SearchUsername;
        $paramUrl.='&SearchOrderNo='.$SearchOrderNo;
        $paramUrl.='&SearchEmail='.$SearchEmail;
        $paramUrl.='&SearchOrderStatus='.$SearchOrderStatus;
        $paramUrl.='&SearchOrderDate='.$SearchOrderDate;
        $paramUrl.='&SearchTemplateTitle='.$SearchTemplateTitle;
        $this->assign("SearchUsername",$SearchUsername);
        $this->assign("SearchOrderNo",$SearchOrderNo);
        $this->assign("SearchEmail",$SearchEmail);
        $this->assign("SearchOrderStatus",$SearchOrderStatus);
        $this->assign("SearchOrderDate",$SearchOrderDate);
        $this->assign("SearchTemplateTitle",$SearchTemplateTitle);

        $ModelOrder=Db::name('order');

        $_where="1";
        if(!empty($SearchUsername)){ $_where.=" AND username LIKE '%".urldecode($SearchUsername)."%'"; }
        if(!empty($SearchOrderNo)){ $_where.=" AND order_no='".urldecode($SearchOrderNo)."'"; }
        if(!empty($SearchEmail)){ $_where.=" AND email LIKE '%".urldecode($SearchEmail)."%'"; }
        if($SearchOrderStatus !== ''){$_where.=" AND order_status='".intval($SearchOrderStatus)."'";}
        if(!empty($SearchOrderDate)){
            $SearchOrderDate_Begin=strtotime($SearchOrderDate,' 00:00:00');
            $SearchOrderDate_End=strtotime($SearchOrderDate,' 23:59:59');
            $_where.=" AND create_time BETWEEN $SearchOrderDate_Begin AND $SearchOrderDate_End";
        }
        if(!empty($SearchTemplateTitle)){ $_where.=" AND template_title LIKE '%".urldecode($SearchTemplateTitle)."%'"; }

        if($_where=='1'){$_where='';}
        $count = $ModelOrder->where($_where)
            ->count();

        $resultArr=array();
        $List=$ModelOrder->where($_where)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

        foreach($List as $key=>$arr){
            $resultArr[]=$arr;
        }

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }

    /**
     * @desc : 编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelOrder=Db::name('order');
        $getone=$ModelOrder->where("order_no='$id'")->find();

        $this->assign("getone",$getone);
        return $this->fetch();
    }

    /**
     * @描述：编辑提交
     */
    public function update(){
        $param = $this->request->post();
        $model=Db::name('order');

        $order_no=htmlspecialchars(isset($param['order_no']) ? trim($param['order_no']) : '');
        $order_status=intval(isset($param['order_status']) ? trim($param['order_status']) : '0');
        $gettime=time();

        if(empty($member_id)  or empty($email)   ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }
        $data=array(
            'order_status'=>$order_status,
            'update_time'=>$gettime,
        );

        $ReturnID=$model->where("order_no='$order_no'")->update($data);

        $this->success("操作成功",url("order/index"),3);
        exit;
    }

    /**
     * @desc : 详细
     */
    public function info(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelOrder=Db::name('order');
        $getone=$ModelOrder->where("order_no='$id'")->find();

        $this->assign("getone",$getone);
        return $this->fetch();
    }
}