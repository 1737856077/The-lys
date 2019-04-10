<?php

namespace app\index\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-首页处理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Index.php 2018-07-22 19:32:00 $
 */

use think\Controller;
use think\Validate;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\paginator\driver\Bootstrap;
use app\common\controller\CommonBaseHome;

class Index extends CommonBaseHome
{
    /**
     * @数据分页
     */
    public $url;

    public function page($data, $name, $page, $listRow = '')
    {
        if (!is_array($data) || empty($data) || empty($name) || empty($page)) {
            return false;
        }
        if (empty($listRow)) {
            $listRow = intval(config('paginate')['list_rows']);
        }

        $curPage = input('page') ? input('page') : 1;
        $showData = array_slice($data, ($curPage - 1) * $listRow, $listRow, true);
        $p = Bootstrap::make($showData, $listRow, $curPage, count($data), false, ['var_page' => 'page', 'path' => url($this->url), 'fragment' => '',]);

        $p->appends($_GET);
        $this->assign($name, $p);
        $this->assign($page, $p->render());
    }

    public function _initialize()
    {
        parent::_initialize();
        // 模版分类
        $data = $this->assign("ConfigTemplateDataType", \think\Config::get('data.template_data_type'));
        // 条码类型
        $this->assign("ConfigTemplateCodeType", \think\Config::get('data.template_code_type'));
        $ModelSystemConfig = Db::name('system_config');
        //使用场景
        $listUsageScenarios = array();
        $listUsageScenarios = $ModelSystemConfig->where("father_id=1")->order("sort_rank ASC,id ASC")->select();
        $data = $this->assign("listUsageScenarios", $listUsageScenarios);
        //行业分类
        $listIndustry = array();
        $listIndustry = $ModelSystemConfig->where("father_id=2")->order("sort_rank ASC,id ASC")->select();
        $this->assign("listIndustry", $listIndustry);

        //查询网站配置信息
        $ModelWebConfigComm = Db::name('web_config');
        $getoneWebConfigComm = $ModelWebConfigComm->where("data_status='1'")
            ->order("id DESC")
            ->find();
        $this->assign('getoneWebConfigComm', $getoneWebConfigComm);
    }

    public function index()
    {
        //最新发布
        $tuesday = time() - 60 * 60 * 84;
        $tuesdays = time() - 60 * 60 * 48;
        $time = time();       //AND data_status=1 AND data_type=0
        $MemberModel = Db::name('member');
        $MemberData = $MemberModel->where('member_id', Session::get('memberid'))->find();//用户信息
        $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesday AND  $time    ORDER BY create_time DESC");
        if (empty($New)) {
            $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesdays AND  $time   ORDER BY create_time DESC");
            if (empty($New)) {
                $New = Db::name('template')->where('data_type', 0)->where('data_status', 1)->order('create_time desc')->select();;
            }
        }

        foreach ($New as $k => $value) {
            $UserNamess = Db::name('admin')->where('admin_id', $value['admin_id'])->field('name')->select();
            $New[$k]['username'] = isset($UserNamess[0]['name']) ? $UserNamess[0]['name'] : '';
            $News = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $New[$k]['paper_size_long'] = isset($News[$k]['paper_size_long']) ? $News[$k]['paper_size_long'] : '';
            $New[$k]['paper_size_wide'] = isset($News[$k]['paper_size_wide']) ? $News[$k]['paper_size_wide'] : '';
            $New[$k]['paper_size_unit'] = isset($News[$k]['paper_size_unit']) ? $News[$k]['paper_size_unit'] : '';
            $New[$k]['lable_size_wide'] = isset($News[$k]['lable_size_wide']) ? $News[$k]['lable_size_wide'] : '';
            $New[$k]['lable_size_height'] = isset($News[$k]['lable_size_height']) ? $News[$k]['lable_size_height'] : '';
            $New[$k]['lable_size_unit'] = isset($News[$k]['lable_size_unit']) ? $News[$k]['lable_size_unit'] : '';

        }
        //热门排序
        $Popular = Db::name('template ')->where('data_type', 0)->where('data_status', 1)->order('get_nums desc')->select();
        foreach ($Popular as $k => $value) {
            $UserNames = Db::name('admin')->where('admin_id', $value['admin_id'])->field('name')->select();
            $Popular[$k]['username'] = isset($UserNames[0]['name']) ? $UserNames[0]['name'] : '';
            $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $Popular[$k]['paper_size_long'] = isset($Populars[$k]['paper_size_long']) ? $Populars[$k]['paper_size_long'] : '';
            $Popular[$k]['paper_size_wide'] = isset($Populars[$k]['paper_size_wide']) ? $Populars[$k]['paper_size_wide'] : '';
            $Popular[$k]['paper_size_unit'] = isset($Populars[$k]['paper_size_unit']) ? $Populars[$k]['paper_size_unit'] : '';
            $Popular[$k]['lable_size_wide'] = isset($Populars[$k]['lable_size_wide']) ? $Populars[$k]['lable_size_wide'] : '';
            $Popular[$k]['lable_size_height'] = isset($Populars[$k]['lable_size_height']) ? $Populars[$k]['lable_size_height'] : '';
            $Popular[$k]['lable_size_unit'] = isset($Populars[$k]['lable_size_unit']) ? $Populars[$k]['lable_size_unit'] : '';

        }
        $New = array_slice($New,0,4);
        $Popular = array_slice($Popular,0,4);
        $this->assign(
            [
                'MemberData' => $MemberData,
                'New' => $New,
                'Popular' => $Popular,
            ]
        );
        return $this->fetch();
    }

    /**
     * 首页点击查询
     */
    public function templates()
    {
        $param = $this->request->param();
        $Trade = isset($param['id']) ? intval($param['id']) : '';
        $SystemModel = Db::name('system_config');
        $SystemData = $SystemModel->where('id', $Trade)->find();
        //判断点击的是 标签 行业 场景中的哪一个 1 行业 2场景 null 标签
        if ($SystemData['father_id'] == 1) {
            //行业
            $TemalateModel = Db::name('template');
            $TemplateData = $TemalateModel->where([
                'data_type' => 0,
                'data_status' => 1,
                'industry_id'=>$SystemData['id']
            ])->select();
            foreach ($TemplateData as $k => $value) {
                $UserNames = Db::name('admin')->where('admin_id', $value['admin_id'])->field('name')->select();
                $TemplateData[$k]['username'] = isset($UserNames[0]['name']) ? $UserNames[0]['name'] : '';
                $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $TemplateData[$k]['paper_size_long'] = isset($Populars[$k]['paper_size_long']) ? $Populars[$k]['paper_size_long'] : '';
                $TemplateData[$k]['paper_size_wide'] = isset($Populars[$k]['paper_size_wide']) ? $Populars[$k]['paper_size_wide'] : '';
                $TemplateData[$k]['paper_size_unit'] = isset($Populars[$k]['paper_size_unit']) ? $Populars[$k]['paper_size_unit'] : '';
                $TemplateData[$k]['lable_size_wide'] = isset($Populars[$k]['lable_size_wide']) ? $Populars[$k]['lable_size_wide'] : '';
                $TemplateData[$k]['lable_size_height'] = isset($Populars[$k]['lable_size_height']) ? $Populars[$k]['lable_size_height'] : '';
                $TemplateData[$k]['lable_size_unit'] = isset($Populars[$k]['lable_size_unit']) ? $Populars[$k]['lable_size_unit'] : '';

            }
            $this->page($TemplateData,'Popular','page',4);
            return $this->fetch('templates/templates');
        } elseif ($SystemData['father_id'] == 2) {
            //场景
            $TemalateModel = Db::name('template');
            $TemplateData = $TemalateModel->where([
                'data_type' => 0,
                'data_status' => 1,
                'usage_scenarios_id'=>$SystemData['id']
            ])->select();
            foreach ($TemplateData as $k => $value) {
                $UserNames = Db::name('admin')->where('admin_id', $value['admin_id'])->field('name')->select();
                $TemplateData[$k]['username'] = isset($UserNames[0]['name']) ? $UserNames[0]['name'] : '';
                $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $TemplateData[$k]['paper_size_long'] = isset($Populars[$k]['paper_size_long']) ? $Populars[$k]['paper_size_long'] : '';
                $TemplateData[$k]['paper_size_wide'] = isset($Populars[$k]['paper_size_wide']) ? $Populars[$k]['paper_size_wide'] : '';
                $TemplateData[$k]['paper_size_unit'] = isset($Populars[$k]['paper_size_unit']) ? $Populars[$k]['paper_size_unit'] : '';
                $TemplateData[$k]['lable_size_wide'] = isset($Populars[$k]['lable_size_wide']) ? $Populars[$k]['lable_size_wide'] : '';
                $TemplateData[$k]['lable_size_height'] = isset($Populars[$k]['lable_size_height']) ? $Populars[$k]['lable_size_height'] : '';
                $TemplateData[$k]['lable_size_unit'] = isset($Populars[$k]['lable_size_unit']) ? $Populars[$k]['lable_size_unit'] : '';

            }

            $this->page($TemplateData,'Popular','page',4);
            return $this->fetch('');
        } else {
            //标签

        }



    }
}

