<?php
namespace app\order\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-用户注册
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Register.php 2019-02-28 19:32:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBase;
class Preorder extends CommonBase
{
    /**
     * @描述：初始化函数
     */
    public function  _initialize(){
        parent::_initialize();

        // 打印模式
        $this->assign("ConfigPreorderPrintMode", \think\Config::get('data.preorder_print_mode'));
        // 排序方式
        $this->assign("ConfigPreorderPrintSort", \think\Config::get('data.preorder_print_sort'));
    }

    /**
     * @desc: 显示下单信息
     */
    public function index(){
        $param = $this->request->param();
        $templateId=intval(isset($param['templateId']) ? trim($param['templateId']) : '0');
        if(!$templateId){echo '非法操作！';exit;}
        $this->assign("memberid",Session::get('memberid'));

        // 查询模版信息
        $ModelTemplate=Db::name('template');
        $ModelTemplateContent=Db::name('template_content');
        $ModelPaper=Db::name('paper');

        $getoneTemplate=$ModelTemplate->where("template_id='$templateId'")->find();
        $getoneTemplateContent=$ModelTemplateContent->where("template_id='$getoneTemplate[template_id]'")->find();
        $this->assign("getoneTemplate",$getoneTemplate);
        $this->assign("getoneTemplateContent",$getoneTemplateContent);

        // 查询纸张信息
        $listPaper=$ModelPaper->where("data_status='1'")->order('sort_rank ASC,id ASC')->select();
        $this->assign("listPaper",$listPaper);

        return $this->fetch();
    }

    /**
     * @desc: 提交订单
     */
    public function suborder(){
        print_r($_POST);
        exit;
    }
}