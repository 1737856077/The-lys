<?php
/**
 * @[蝌蚪码码溯源系统] kedoumama suyuan system Information Technology Co., Ltd.
 * @desc:首页报表信息类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Homereport.php 2018-04-12 14:12:00 $
 */

namespace app\index\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Loader;
use \app\common\controller\CommonBase;
use lib\Excel\PHPExcel;
class Homereport extends CommonBase
{
    /**
     * @desc  首页-统计报表
     */
    public function index(){
        $ModelVillage=Db::name('village');
        $ModelVillageVuildingRoom=Db::name('village_building_room');
        $ModelBillDetails=Db::name('bill_details');
        $ModelSystemConfig=Db::name('system_config');

        //加入权限 begin
        $_whereIn=[];
        if(Session::has('manager_name')) {
            $_whereIn['village_uuid']=['in', $this->CommVillageUUIDs];
        }
        //加入权限 end

        //小区统计：总小区数量
        $countVillage=$ModelVillage->where($_whereIn)->count();
        $this->assign("countVillage",$countVillage);

        //用户统计：总用户量
        $countVillageVuildingRoom=$ModelVillageVuildingRoom->where($_whereIn)->count();
        $this->assign("countVillageVuildingRoom",$countVillageVuildingRoom);

        //缴费总金额：总的缴费金额
        $sumBillDetailsTotalAmount=$ModelBillDetails->where($_whereIn)
            ->sum('bill_entry_amount');
        //$sumBillDetailsTotalAmount=my_price($sumBillDetailsTotalAmount,2);
        $this->assign("sumBillDetailsTotalAmount",my_price($sumBillDetailsTotalAmount,2));

        //已缴金额：总的已缴金额
        $sumBillDetailsTotalAmountYJ=$ModelBillDetails->where("bill_status='FINISH_PAYMENT'")
            ->where($_whereIn)
            ->sum('bill_entry_amount');
        //$sumBillDetailsTotalAmountYJ=my_price($sumBillDetailsTotalAmountYJ,2);
        $this->assign("sumBillDetailsTotalAmountYJ",my_price($sumBillDetailsTotalAmountYJ,2));

        //未缴金额：总的未缴金额
        $sumBillDetailsTotalAmountWJ=$ModelBillDetails->where("bill_status!='FINISH_PAYMENT'")
            ->where($_whereIn)
            ->sum('bill_entry_amount');
        //$sumBillDetailsTotalAmountWJ=my_price($sumBillDetailsTotalAmountWJ,2);
        $this->assign("sumBillDetailsTotalAmountWJ",my_price($sumBillDetailsTotalAmountWJ,2));

        //逾期金额：总的逾期金额
        $sumBillDetailsTotalAmountYQ=$ModelBillDetails->where("bill_status='OUT_OF_DATE'")
            ->where($_whereIn)
            ->sum('bill_entry_amount');
        //$sumBillDetailsTotalAmountYQ=my_price($sumBillDetailsTotalAmountYQ,2);
        $this->assign("sumBillDetailsTotalAmountYQ",my_price($sumBillDetailsTotalAmountYQ,2));

        //缴费类型统计：统计缴费类型
        $listSystemConfig=$ModelSystemConfig->where("father_id=1")
            ->select();
        foreach ($listSystemConfig as $key=>$val){
            //总缴费金额
            $_sumBillDetailsTotalAmount=$ModelBillDetails->where('cost_type_id='.$val['id'])
                ->where($_whereIn)
                ->sum('bill_entry_amount');
            //$_sumBillDetailsTotalAmount=my_price($_sumBillDetailsTotalAmount,2);
            //$_sumBillDetailsTotalAmount=str_replace(',','',$_sumBillDetailsTotalAmount);
            $listSystemConfig[$key]['sumTotalAmount']=my_price($_sumBillDetailsTotalAmount,2);
            //按类型-统计缴费比例=类型总缴费金额/所有类型的总缴费金额
            $listSystemConfig[$key]['sumTotalAmountBL']=my_price($_sumBillDetailsTotalAmount/$sumBillDetailsTotalAmount,5)*1000;

            //已缴费金额
            $_sumBillDetailsTotalAmountYJF=$ModelBillDetails->where('cost_type_id='.$val['id'].' AND bill_status=\'FINISH_PAYMENT\'')
                ->where($_whereIn)
                ->sum('bill_entry_amount');
            //$_sumBillDetailsTotalAmountYJF=my_price($_sumBillDetailsTotalAmountYJF,2);
            //$_sumBillDetailsTotalAmountYJF=str_replace(',','',$_sumBillDetailsTotalAmountYJF);
            $listSystemConfig[$key]['sumTotalAmountYJF']=my_price($_sumBillDetailsTotalAmountYJF,2);

            //计算缴费率，缴费率=已缴费金额/总缴费金额
            if($_sumBillDetailsTotalAmountYJF>0){
                $AmountFateJFL=my_price(($_sumBillDetailsTotalAmountYJF/$_sumBillDetailsTotalAmount),4)*100;
            }else{
                $AmountFateJFL=0.00;
            }
            $listSystemConfig[$key]['AmountFateJFL']=$AmountFateJFL;
        }
        $this->assign("listSystemConfig",$listSystemConfig);

        return $this->fetch();
    }
}