<?php

/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/7
 * Time: 14:22
 */

namespace app\sinterface\controller;
<<<<<<< HEAD
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

=======

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
>>>>>>> 3b2b557a1a198d01c5306ffaf5b3c128d53b9411
use app\common\controller\CommonBaseHome;
use think\Db;

class Dmapdate extends CommonBaseHome
{
    /*
     * @描述地图数据接口 省份数据
     */
    public function index()
    {
        $data = [];
        $code = 0;
        $msg = '';
        $data['code'] = $code;
        $data['msg'] = $msg;
        $Dscanrank = Db::name('region')->where('area_type', 2)->field('area_code')->select();

        foreach ($Dscanrank as $value) {
            $Dscanranks[] = Db::name('product_code_info_visit_record')
                ->where('adcode','like',substr($value['area_code'],0,2).'%' )
                ->field('count(province) value,province name,lng,lat')
                ->group('province')
                ->order('value')
                ->select();
        }
        foreach ($Dscanranks as $v)
        {
                if (!empty($v)){
                  $Dscanrankss[] = $v;
                }
        }
    foreach ($Dscanrankss as $ke=>$v){
         $coord = array($v[0]['lat'],$v[0]['lng']);
         $name = $v[0]['name'];
         $value =$v[0]['value'];
         $data['data'][] = array(
             'name'=>$name,
             'coord'=>$coord,
             'value'=>$value
         );
    }
        $data['code']=$code;
        $data['msg']=$msg;
        return json($data);
    }
}