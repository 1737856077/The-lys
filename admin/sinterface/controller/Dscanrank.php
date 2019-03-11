<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/7
 * Time: 10:29
 */

namespace app\sinterface\controller;


use app\common\controller\CommonBaseHome;
use think\Db;

class Dscanrank extends CommonBaseHome
{
    public function index()
    {
        /**
         * @@描述:地区扫码排行接口
         */
        $data = [];
        $code = 0;
        $msg = '';
        //地区排行榜
        $Dscanrank = Db::name('product_code_info_visit_record')
            ->field('count(province) value,province name')
            ->group('province')
            ->order('value desc')->select();
        $Dscanranks['areaData']= $Dscanrank;
        if (!empty($Dscanrank)) {
          $data['code'] = $code;
          $data['msg']=$msg;
          $data['data']= $Dscanranks;
        }else{
            $data['code'] = 0;
            $data['msg']='请求错误';
        }
    return json( $data);
    }
}