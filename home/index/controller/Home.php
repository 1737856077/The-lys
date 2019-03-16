<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/15
 * Time: 12:59
 */

namespace app\index\controller;
use think\Config;
use think\Controller;
use think\Validate;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;

class Home extends CommonBaseHome
{
    //默认数据
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
    //首页
    public function index()
    {

        //最新发布
        $tuesday = time() - 60 * 60 * 84;
        $tuesdays = time() - 60 * 60 * 48;
        $time = time();       //AND data_status=1 AND data_type=0

        $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesday AND  $time    ORDER BY create_time DESC");
        if (!empty($New)) {
            $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesdays AND  $time   ORDER BY create_time DESC");
        }
        //热门排序
        $Popular = Db::name('template ')->field('template_id ,title, get_nums')->order('get_nums desc')->select();
        //综合排序
        $cas = Db::name('template')->field('show_nums,get_nums')->order('show_nums+get_nums desc')->field('title')->select();;
        $this->assign(
            [
                'New' => $New,
                'Popular' => $Popular,
                'cas' => $cas
            ]
        );
        return $this->fetch();
    }
    //点击栏目筛选 栏目查模板
    public function chaxuns()
    {
        //点击栏目查询
        $chaxun = Db::name('template');
        $param = $this->request->param();
        $_where = " data_status=1 AND data_type=0";
        $where = array();
        foreach ($param as $key=>$value){
          $where[]=$_where.=" AND "." $key".'='."$value ";
        }
      $_where = end($where);
        $count = $chaxun->where($_where)
            ->select();
      return json($count);
//        if (!empty($param['industry_id']) AND !empty($param['tag_type_id'])) {
//            $_where .= " AND industry_id =" . urldecode($param['industry_id']) . " AND industry_id =" . urldecode($param['industry_id']);
//        } else {
//            if (!empty($param['industry_id'])) {
//                $_where .= " AND industry_id =" . urldecode($param['industry_id']);
//            }
//            if (!empty($param['tag_type_id'])) {
//                $_where .= " AND tag_type_id =" . urldecode($param['tag_type_id']);
//            }
//        }

    }
    //详情页数据 模板查内容
    public function bianji()
    {
        //模板数据
        $param = $this->request->param();
        $data = Db::name('template_content')->where('template_id', $param['id'])->select();
        return json($data);
    }
    //搜索功能 模糊搜索
    public function ss()
    {
        //模糊搜索
        $value = input('value');
        if ($value) {
            $map['title'] = ['like', '%' . $value . '%'];
            $searchres = db('template ')->where($map)->order('template_id desc')->select();
            $this->assign(array(
                'data' => $searchres,
                'value' => $value
            ));
            return $this->fetch();
        } else {
            $this->assign(array(
                'data' => null,
                'value' => '暂无数据'
            ));
        }
    }
}