<?php
namespace app\salesman\controller;
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @desc:业务管理员-业务员分成
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Divideinto.php 2018-05-20 19:04:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Divideinto extends CommonAdmin
{
    public function index(){
        $param = $this->request->param();
        //查询
        $SearchTitle = isset($param['SearchTitle']) ? $param['SearchTitle'] : '' ;
        $SearchTitle=urldecode($SearchTitle);
        $SearchTel = isset($param['SearchTel']) ? $param['SearchTel'] : '' ;
        $SearchTel=urldecode($SearchTel);
        $SearchBeginTime = isset($param['SearchBeginTime']) ? $param['SearchBeginTime'] : '' ;
        $SearchEndTime = isset($param['SearchEndTime']) ? $param['SearchEndTime'] : '' ;

        $ModelSalesman=Db::name('admin');
        $ModelSalesmanVillage=Db::name('salesman_village');
        $ModelBillDetails=Db::name('bill_details');

        //加入权限 begin
        $_whereIn=[];
        $_whereInSalesman=[];//当前业务员
        //业务员
        if(Session::get('admin_data_type')=='1' and Session::get('admin_role_id')=='2'){
            $_whereIn['village_uuid']=['in', $this->CommVillageUUIDs];
            $_whereInSalesman['admin_id']=['in', intval(Session::get('adminid'))];
        }
        //加入权限 end

        $_where="1 AND role_id=2 ";
        $_where_bill_details="1";
        if(!empty($SearchTitle)){ $_where.=" AND name LIKE '%".urldecode($SearchTitle)."%'"; }
        if(!empty($SearchTel)){ $_where.=" AND tel LIKE '%".urldecode($SearchTel)."%'"; }

        if ((isset($param["SearchBeginTime"]) && $param["SearchBeginTime"] !== '')
            and (isset($param["SearchEndTime"]) && $param["SearchEndTime"] !== '') ) {
            $_timeBegin=strtotime($param["SearchBeginTime"]." 00:00:00");
            $_timeEnd=strtotime($param["SearchEndTime"]." 23:59:59");
            $_where_bill_details.=" AND (pay_time BETWEEN $_timeBegin AND $_timeEnd)";
        }else{
            $_timeBegin=strtotime("2018-01-01 00:00:00");
            $_timeEnd=strtotime(date("Y-m-d")." 23:59:59");
            $_where_bill_details.=" AND (pay_time BETWEEN $_timeBegin AND $_timeEnd)";
            $SearchBeginTime='2018-01-01';
            $SearchEndTime=date("Y-m-d");
        }

        if($_where=='1'){$_where='';}
        if($_where_bill_details=='1'){$_where_bill_details='';}
        $count = $ModelSalesman->where($_where)
            ->where($_whereInSalesman)
            ->count();

        $resultArr=array();
        $List=$ModelSalesman->where($_where)
            ->where($_whereInSalesman)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

        foreach($List as $arr){
            //统计业务小区信息
            $listSalesmanVillage=$ModelSalesmanVillage->where("salesman_id='$arr[admin_id]'")->select();
            $arr['count_village']=count($listSalesmanVillage);
            $arr['sum_BillEntryAmount']=0.00;
            $arr['sum_BillEntryAmountYZF']=0.00;
            $arr['sum_BillEntryAmountWZF']=0.00;
            //取得小区ID
            if(count($listSalesmanVillage)){
                $_village_uuids=array();
                foreach($listSalesmanVillage as $k=>$v){
                    $_village_uuids[$k]=$v['village_uuid'];
                }
                $_village_uuids=implode("','",$_village_uuids);
                //总金额
                $sumBillEntryAmount=$ModelBillDetails->where("village_uuid IN ('$_village_uuids') ")
                    ->where($_where_bill_details)
                    ->sum('bill_entry_amount');
                $arr['sum_BillEntryAmount']=$sumBillEntryAmount;
                //已支付
                $sumBillEntryAmountYZF=$ModelBillDetails->where("village_uuid IN ('$_village_uuids') 
                                                           AND bill_status='FINISH_PAYMENT' ")
                    ->where($_where_bill_details)
                    ->sum('bill_entry_amount');
                $arr['sum_BillEntryAmountYZF']=$sumBillEntryAmountYZF;
                //未支付
                $sumBillEntryAmountWZF=$ModelBillDetails->where("village_uuid IN ('$_village_uuids') 
                                                           AND bill_status!='FINISH_PAYMENT' ")
                    ->where($_where_bill_details)
                    ->sum('bill_entry_amount');
                $arr['sum_BillEntryAmountWZF']=$sumBillEntryAmountWZF;

            }

            $resultArr[]=$arr;
        }

        //总统计 begin
        //总金额
        $sumTotal=$ModelBillDetails->where($_where_bill_details)
            ->where($_whereIn)
            ->sum('bill_entry_amount');
        //已支付
        $sumTotalYZF=$ModelBillDetails->where(" bill_status='FINISH_PAYMENT' ")
            ->where($_where_bill_details)
            ->where($_whereIn)
            ->sum('bill_entry_amount');
        //未支付
        $sumTotalWZF=$ModelBillDetails->where(" bill_status!='FINISH_PAYMENT' ")
            ->where($_where_bill_details)
            ->where($_whereIn)
            ->sum('bill_entry_amount');

        $data=array(
            "sumTotal"=>price($sumTotal),
            "sumTotalYZF"=>price($sumTotalYZF),
            "sumTotalWZF"=>price($sumTotalWZF),
        );
        $this->assign("data",$data);
        //总统计 end

        $paramUrl='';
        $paramUrl.='SearchTitle='.$SearchTitle;
        $paramUrl.='&SearchTel='.$SearchTel;
        $paramUrl.='&SearchBeginTime='.$SearchBeginTime;
        $paramUrl.='&SearchEndTime='.$SearchEndTime;
        $this->assign("SearchTitle",$SearchTitle);
        $this->assign("SearchTel",$SearchTel);
        $this->assign("SearchBeginTime",$SearchBeginTime);
        $this->assign("SearchEndTime",$SearchEndTime);

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }
}