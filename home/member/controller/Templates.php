<?php
namespace app\member\controller;
/**
 * Created by PhpStorm.
 * User: Edianzu
 * Date: 2019/4/7
 * Time: 15:31
 */
use think\Controller;
use think\View;
use think\Validate;
use think\Request;
use think\Db;
use think\Session;
use app\member\controller\Data;
use think\Paginator;
use app\common\controller\CommonBase;
class Templates extends CommonBase
{
    public function _initialize()
    {
        parent::_initialize();
        // 打印模式
        $this->assign("ConfigPreorderPrintMode", \think\Config::get('data.preorder_print_mode'));
        // 排序方式
        $this->assign("ConfigPreorderPrintSort", \think\Config::get('data.preorder_print_sort'));
    }

    /**
     * @用户中心
     */
    public function index()
    {
        $id = Session::get('memberid');
        //查询本会员的个人模板
        $checkorder = Db::name('template');
        $Popular = $checkorder->where('member_id', $id)->where('data_type', 1)->select();

        foreach ($Popular as $k => $value) {
            $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $Popular[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
            $Popular[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
            $Popular[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
            $Popular[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
            $Popular[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height']) ? $Populars[0]['lable_size_height'] : '';
            $Popular[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
        }

        //最新模板
        $newtemplate = Db::name('template')
            ->where('member_id', $id)
            ->where('data_type', 1)
            ->order('create_time desc')
            ->limit(4)
            ->select();
        foreach ($newtemplate as $k => $value) {
            $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $newtemplate[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
            $newtemplate[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
            $newtemplate[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
            $newtemplate[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
            $newtemplate[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height']) ? $Populars[0]['lable_size_height'] : '';
            $newtemplate[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
        }

        $this->assign([
            'newtemplate' => $newtemplate,
            'template' => $Popular,
        ]);

        return $this->fetch();
    }
}