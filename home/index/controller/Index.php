<?php
namespace app\index\controller;
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-首页处理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Index.php 2018-07-22 19:32:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;
class Index extends  CommonBaseHome
{
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
    public function index(){
        //最新发布
        $tuesday = time() - 60 * 60 * 84;
        $tuesdays = time() - 60 * 60 * 48;
        $time = time();       //AND data_status=1 AND data_type=0

        $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesday AND  $time    ORDER BY create_time DESC");
        if (empty($New)) {
            $New = Db::query("  SELECT *    FROM sy_template WHERE  data_status=1 AND data_type=0 AND create_time BETWEEN $tuesdays AND  $time   ORDER BY create_time DESC");
                if (empty($New)){
                    $New = Db::name('template')->where('data_type',0)->order('create_time desc')->select();;
                }
        }

        foreach($New as $k=>$value){

            $News= Db::name('template_content')->where('template_id',$value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $New[$k]['paper_size_long']=isset($News['paper_size_long'])?$News['paper_size_long']:'';
            $New[$k]['paper_size_wide']=isset($News['paper_size_wide'])?$News['paper_size_wide']:'';
            $New[$k]['paper_size_unit']=isset($News['paper_size_unit'])?$News['paper_size_unit']:'';
            $New[$k]['lable_size_wide']=isset($News['lable_size_wide'])?$News['lable_size_wide']:'';
            $New[$k]['lable_size_height']=isset($News['lable_size_height'])?$News['lable_size_height']:'';
            $New[$k]['lable_size_unit']=isset($News['lable_size_unit'])?$News['lable_size_unit']:'';

        }
        //热门排序
        $Popular = Db::name('template ')->order('get_nums desc')->select();
        foreach($Popular as $k=>$value){
            $Populars= Db::name('template_content')->where('template_id',$value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select()[0];
            $Popular[$k]['paper_size_long']=isset($Populars['paper_size_long'])?$Populars['paper_size_long']:'';
            $Popular[$k]['paper_size_wide']=isset($Populars['paper_size_wide'])?$Populars['paper_size_wide']:'';
            $Popular[$k]['paper_size_unit']=isset($Populars['paper_size_unit'])?$Populars['paper_size_unit']:'';
            $Popular[$k]['lable_size_wide']=isset($Populars['lable_size_wide'])?$Populars['lable_size_wide']:'';
            $Popular[$k]['lable_size_height']=isset($Populars['lable_size_height'])?$Populars['lable_size_height']:'';
            $Popular[$k]['lable_size_unit']=isset($Populars['lable_size_unit'])?$Populars['lable_size_unit']:'';

        }
        //综合排序
        $cas = Db::name('template')->order('show_nums+get_nums desc')->select();;

        foreach($cas as $k=>$value){
            $cass= Db::name('template_content')->where('template_id',$value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select()[0];
            $cas[$k]['paper_size_long']=isset($cass['paper_size_long'])?$cass['paper_size_long']:'';
            $cas[$k]['paper_size_wide']=isset($cass['paper_size_wide'])?$cass['paper_size_wide']:'';
            $cas[$k]['paper_size_unit']=isset($cass['paper_size_unit'])?$cass['paper_size_unit']:'';
            $cas[$k]['lable_size_wide']=isset($cass['lable_size_wide'])?$cass['lable_size_wide']:'';
            $cas[$k]['lable_size_height']=isset($cass['lable_size_height'])?$cass['lable_size_height']:'';
            $cas[$k]['lable_size_unit']=isset($cass['lable_size_unit'])?$cass['lable_size_unit']:'';
        }
        $this->assign(
            [
                'New' => $New,
                'Popular' => $Popular,
                'cas' => $cas
            ]
        );
        return $this->fetch();
    }
}

