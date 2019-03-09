<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/7
 * Time: 14:02
 */

namespace app\sinterface\controller;


use app\common\controller\CommonBase;
use think\Db;

class Dearlywarning extends CommonBase
{
    /**
     * @描述：实时预警接口
     */
    public function index()
    {
        $data = [];
        $code = 0;
        $msg = '';
        $dearlywarning = Db::name('product_code_info_visit_record ')
            ->where('is_listing_area', 1)
            ->alias('a')
            ->join('product_code w', 'a.product_code_id = w.product_code_id')
            ->join('admin s', 'w.admin_id = s.admin_id')
            ->field('s.name')
            ->select();
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['data']=['warningInfo'=>[]];
        $warningInfo=[];
        foreach ($dearlywarning as $k => $v) {
            $warningInfo[] = array('name'=>$v['name'] . '公司产品疑似被窜货');
        }
        $data['data']['warningInfo']=$warningInfo;
        return json($data);
    }
}