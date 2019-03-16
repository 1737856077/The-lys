<?php
namespace app\designtpl\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:模版管理
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Dtemplate.php 2019-03-11 09:37:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Dtemplate extends CommonAdmin
{
    /**
     * @描述：初始方法
     */
    public function _initialize(){
        parent::_initialize();
        // 模版分类
        $this->assign("ConfigTemplateDataType", \think\Config::get('data.template_data_type'));
        // 条码类型
        $this->assign("ConfigTemplateCodeType", \think\Config::get('data.template_code_type'));
        $ModelSystemConfig=Db::name('template_class');
        //使用场景
        $listUsageScenarios=array();
        $listUsageScenarios=$ModelSystemConfig->where("father_id=1")->order("sort_rank ASC,class_id ASC")->select();
        $this->assign("listUsageScenarios",$listUsageScenarios);
        //行业分类
        $listIndustry=array();
        $listIndustry=$ModelSystemConfig->where("father_id=2")->order("sort_rank ASC,class_id ASC")->select();
        $this->assign("listIndustry",$listIndustry);
    }

    /**
     * @描述：列表页面
     */
    public function  index(){
        $param = $this->request->param();
        //查询
        $SearchDataType = htmlspecialchars(isset($param['SearchDataType']) ? $param['SearchDataType'] : '') ;
        $SearchUsageScenariosId = intval(isset($param['SearchUsageScenariosId']) ? $param['SearchUsageScenariosId'] : '0') ;
        $SearchIndustryId = intval(isset($param['SearchIndustryId']) ? $param['SearchIndustryId'] : '0') ;
        $SearchCodeType = htmlspecialchars(isset($param['SearchCodeType']) ? $param['SearchCodeType'] : '') ;
        $paramUrl='';
        $paramUrl.='SearchDataType='.$SearchDataType;
        $paramUrl.='&SearchUsageScenariosId='.$SearchUsageScenariosId;
        $paramUrl.='&SearchIndustryId='.$SearchIndustryId;
        $paramUrl.='&SearchCodeType='.$SearchCodeType;
        $this->assign("SearchDataType",$SearchDataType);
        $this->assign("SearchUsageScenariosId",$SearchUsageScenariosId);
        $this->assign("SearchIndustryId",$SearchIndustryId);
        $this->assign("SearchCodeType",$SearchCodeType);

        $ModelTemplate=Db::name('template');
        $ModelTemplateContent=Db::name('template_content');

        $_where="1";

        if($SearchDataType !== ''){$_where.=" AND data_type='".intval($SearchDataType)."'";}
        if(!$SearchUsageScenariosId){$_where.=" AND usage_scenarios_id='$SearchUsageScenariosId'";}
        if(!$SearchIndustryId){$_where.=" AND industry_id='$SearchIndustryId'";}
        if($SearchCodeType !== ''){$_where.=" AND code_type='".intval($SearchCodeType)."'";}

        if($_where=='1'){$_where='';}
        $count = $ModelTemplate->where($_where)
            ->count();

        $resultArr=array();
        $List=$ModelTemplate->where($_where)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

        foreach($List as $key=>$value){
            // 查询模版内容
            $_getone=$ModelTemplateContent->where("template_id='$value[template_id]'")->find();
            $value['templateContent']=$_getone;
            $resultArr[]=$value;
        }

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }

    /**
     * desc:设置状态
     */
    public function setDataStatus(){
        $param = $this->request->param();
        $id=isset($param['id']) ? intval($param['id']) : 0 ;
        $ModelTemplate=Db::name('template');
        $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;
        $ModelTemplate->where("template_id='$id'")->setField('data_status',$Status);

        $this->success("操作成功",url("salesman/index"),3);
        exit;
    }

}