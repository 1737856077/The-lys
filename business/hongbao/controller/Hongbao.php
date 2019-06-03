<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3
 * Time: 10:50
 */

namespace app\hongbao\controller;


use app\common\controller\CommonBase;
use think\Db;

class Hongbao extends CommonBase
{
    public function index()
    {
        $region = Db::name('region')->where('area_type',2)->field('area_name,area_code')->select();
        $this->assign('region',$region);
        return $this->fetch();
    }
    public function shi()
    {
        $param = $this->request->post();
        $shi = Db::name('region')
            ->where('area_parent_id',isset($param['shi']['area_code']) ? $param['shi']['area_code'] : $param['shi'])
            ->field('area_name,area_code')
            ->select();
        return json($shi);

    }
}