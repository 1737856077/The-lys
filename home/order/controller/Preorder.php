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

    public function index(){
        $param = $this->request->param();
        $templateId=intval(isset($param['templateId']) ? trim($param['templateId']) : '0');
        if(!$templateId){echo '非法操作！';exit;}

        // 查询模版信息
        $ModelTemplate=Db::name('template');
        $ModelTemplateContent=Db::name('template_content');

        $getoneTemplate=$ModelTemplate->where("template_id='$templateId'")->find();
        $ModelTemplateContent->where("")->find();


        return $this->fetch();
    }
}