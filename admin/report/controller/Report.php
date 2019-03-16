<?php
namespace app\report\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:统计报表
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Report.php 2019-03-11 09:37:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Report extends CommonAdmin
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
        $SearchBeginTime = isset($param['SearchBeginTime']) ? $param['SearchBeginTime'] : date('Y-m-d') ;
        $SearchEndTime = isset($param['SearchEndTime']) ? $param['SearchEndTime'] : date('Y-m-d') ;
        $SearchUsername = htmlspecialchars(isset($param['SearchUsername']) ? $param['SearchUsername'] : '') ;
        $this->assign("SearchBeginTime",$SearchBeginTime);
        $this->assign("SearchEndTime",$SearchEndTime);
        $this->assign("SearchUsername",$SearchUsername);

        $SearchBeginTime=strtotime($SearchBeginTime.' 00:00:00');
        $SearchEndTime=strtotime($SearchEndTime.' 23:59:59');

        $modelOrder=Db::name('order');
        $modelMember=Db::name('member');
        $modelTemplate=Db::name('template');

        $_whereOrder = '1';
        $_whereMember = '1';
        $_whereTemplate = '1';

        $_whereOrder .= " AND create_time BETWEEN $SearchBeginTime AND $SearchEndTime";
        $_whereMember .= " AND create_time BETWEEN $SearchBeginTime AND $SearchEndTime";
        $_whereTemplate .= " AND create_time BETWEEN $SearchBeginTime AND $SearchEndTime";
        if(!empty($SearchUsername)){
            $getoneMember=$modelMember->where("username='$SearchUsername'")->find();
            $_whereOrder .= " AND username='$SearchUsername'";
            $_whereMember .= " AND username='$SearchUsername'";
            $_whereTemplate .= " AND member_id='$getoneMember[member_id]'";
        }
        if($_whereOrder == '1'){$_whereOrder = '';}
        if($_whereMember == '1'){$_whereMember = '';}
        if($_whereTemplate == '1'){$_whereTemplate = '';}

        //订单数
        $countOrderTotal=$modelOrder->where("pay_status=1")
            ->where($_whereOrder)
            ->count();
        $this->assign("countOrderTotal",$countOrderTotal);

        //订单金额
        $sumOrderTotalPrice=$modelOrder->where("pay_status=1")
            ->where($_whereOrder)
            ->sum('score_real_pay');
        $this->assign("sumOrderTotalPrice",$sumOrderTotalPrice);

        //用户数
        $countMemberTotal=$modelMember->where($_whereMember)->count();
        $this->assign("countMemberTotal",$countMemberTotal);

        //模版库数量
        $countTemplateTotal=$modelTemplate->where($_whereTemplate)->count();
        $this->assign("countTemplateTotal",$countTemplateTotal);

        return $this->fetch();
    }

}