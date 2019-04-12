<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/15
 * Time: 16:30
 */

namespace app\index\controller;


use app\common\controller\CommonBaseHome;
use JsonSchema\Uri\Retrievers\Curl;
use think\Db;
use think\paginator\driver\Bootstrap;
use think\Session;

class Templates extends CommonBaseHome
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

    /**
     * @模板中心
     */

    public function _initialize()
    {

        parent::_initialize();
        $a = request()->action();
        $c = request()->controller();
        $m = request()->module();
        $this->url = '/' . $m . '/' . $c . '/' . $a;
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

    public function templates()
    {
        $Popular = Db::name('template ')->where('data_type',0)->where('data_status',1)->order('get_nums desc')->select();
        foreach($Popular as $k=>$value){
            $member = Db::name('member')->where('member_id',$value['member_id'])->find();
            $UserNames = Db::name('admin')->where('admin_id',$value['admin_id'])->field('name')->select();
            $Popular[$k]['username']=isset($member['username'])?$member['username']:'';
            $Popular[$k]['userimg']=isset($member['img'])?$member['img']:'';
            $Populars= Db::name('template_content')->where('template_id',$value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $Popular[$k]['paper_size_long']=isset($Populars[0]['paper_size_long'])?$Populars[0]['paper_size_long']:'';
            $Popular[$k]['paper_size_wide']=isset($Populars[0]['paper_size_wide'])?$Populars[0]['paper_size_wide']:'';
            $Popular[$k]['paper_size_unit']=isset($Populars[0]['paper_size_unit'])?$Populars[0]['paper_size_unit']:'';
            $Popular[$k]['lable_size_wide']=isset($Populars[0]['lable_size_wide'])?$Populars[0]['lable_size_wide']:'';
            $Popular[$k]['lable_size_height']=isset($Populars[0]['lable_size_height'])?$Populars[0]['lable_size_height']:'';
            $Popular[$k]['lable_size_unit']=isset($Populars[0]['lable_size_unit'])?$Populars[0]['lable_size_unit']:'';
        }
        $this->page($Popular,'Popular','page',8);
        return $this->fetch();
    }

    //查询当前会员的交易订单
    public function index()
    {
        $param = $this->request->param();
        $member_id = isset($param['id']) ? intval($param['id']) : 0;
        if ($member_id) {
            $member = Db::name('order');
            $End = $member->where('member_id', $member_id)->where('order_status', 4)->select();
            $desigend = $member->where('member_id', $member_id)->where('order_status', 3)->select();
            $design = $member->where('member_id', $member_id)->where('order_status', 2)->select();
            $verify = $member->where('member_id', $member_id)->where('order_status', 1)->select();
            $new = $member->where('member_id', $member_id)->where('order_status', 0)->select();
            $data = $member->where('member_id', $member_id)->select();
            if (!empty($data)) {
                $this->assign([
                    'data' => $data,
                    'new' => $new,
                    'verify' => $verify,
                    'design' => $design,
                    'designend' => $desigend,
                    'End' => $End
                ]);
                return $this->fetch();
            } else {
                $this->error('没有数据');
            }
        } else {
            $this->error('错误');
        }
    }

    /**
     * @模板详情
     */
    public function content()
    {
        $param = $this->request->param();
        $templateid = intval(isset($param['template_id']) ? trim($param['template_id']) : 0);
        if (!$templateid) {
            echo '非法操作';
            exit();
        }
        $templateData = Db::name('template')->where('template_id', $templateid)->find();
        $template_content_data = Db::name('template_content')->where('template_id',$templateid)->find();
        $this->assign(
            [
                'templatData'=>$templateData,
                'template_content_data'=>$template_content_data
            ]
        );
        return $this->fetch();
    }


    /**
     * @筛选栏目
     */
    public function chaxuns()
    {
        //点击栏目查询
        $chaxun = Db::name('template');
        $param = $this->request->param();
        //栏目id值
        $IndustryId = isset($param['IndustryId'])?$param['IndustryId']:'';
        $UsageScenariosId = isset($param['UsageScenariosId'])?$param['UsageScenariosId']:'';
        $ConfigTemplateCodeTypeId = isset($param['ConfigTemplateCodeTypeId'])?$param['ConfigTemplateCodeTypeId']:'';
        $_where = " data_status=1 AND data_type=0";
        if(empty($IndustryId)and empty($UsageScenariosId) and empty($ConfigTemplateCodeTypeId)){
            $data = $chaxun->where($_where)->select();
            //查询模板详情信息 模板发布人

            foreach($data as $k=>$value){
                $member = Db::name('member')->where('member_id',$value['member_id'])->find();
                $data[$k]['username']=isset($member['username'])?$member['username']:'';
                $data[$k]['userimg']=isset($member['img'])?$member['img']:'';
                $Populars= Db::name('template_content')->where('template_id',$value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $data[$k]['paper_size_long']=isset($Populars[0]['paper_size_long'])?$Populars[0]['paper_size_long']:'';
                $data[$k]['paper_size_wide']=isset($Populars[0]['paper_size_wide'])?$Populars[0]['paper_size_wide']:'';
                $data[$k]['paper_size_unit']=isset($Populars[0]['paper_size_unit'])?$Populars[0]['paper_size_unit']:'';
                $data[$k]['lable_size_wide']=isset($Populars[0]['lable_size_wide'])?$Populars[0]['lable_size_wide']:'';
                $data[$k]['lable_size_height']=isset($Populars[0]['lable_size_height'])?$Populars[0]['lable_size_height']:'';
                $data[$k]['lable_size_unit']=isset($Populars[0]['lable_size_unit'])?$Populars[0]['lable_size_unit']:'';
            }
            //未选择条件的数据
            return $data;
        }

        $where = array();
        //判断
        $where[] = $_where .=((!empty($IndustryId)? " AND industry_id =". $IndustryId:'').(!empty($UsageScenariosId)? " AND usage_scenarios_id =". $UsageScenariosId:'').(!empty($ConfigTemplateCodeTypeId)? " AND code_type =". $ConfigTemplateCodeTypeId:''));

        $_where = end($where);
        $count = $chaxun->where($_where)
            ->select();
        //查询模板详情信息 模板发布人
        foreach($count as $k=>$value){
            $member = Db::name('member')->where('member_id',$value['member_id'])->find();
            $count[$k]['username']=isset($member['username'])?$member['username']:'';
            $count[$k]['userimg']=isset($member['img'])?$member['img']:'';
            $Populars= Db::name('template_content')->where('template_id',$value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $count[$k]['paper_size_long']=isset($Populars[0]['paper_size_long'])?$Populars[0]['paper_size_long']:'';
            $count[$k]['paper_size_wide']=isset($Populars[0]['paper_size_wide'])?$Populars[0]['paper_size_wide']:'';
            $count[$k]['paper_size_unit']=isset($Populars[0]['paper_size_unit'])?$Populars[0]['paper_size_unit']:'';
            $count[$k]['lable_size_wide']=isset($Populars[0]['lable_size_wide'])?$Populars[0]['lable_size_wide']:'';
            $count[$k]['lable_size_height']=isset($Populars[0]['lable_size_height'])?$Populars[0]['lable_size_height']:'';
            $count[$k]['lable_size_unit']=isset($Populars[0]['lable_size_unit'])?$Populars[0]['lable_size_unit']:'';
        }
        return $count;
        $this->page($count,'Populars','page',20);

    }
}