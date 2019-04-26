<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/7
 * Time: 10:24
 */

namespace app\sinterface\controller;


use app\common\controller\CommonBaseHome;
use think\Db;

class Dscanrecord extends CommonBaseHome
{
    /**
     * @@描述：扫码记录
     */
    public function index()
    {
        $data = [];
        $code = 0;
        $msg = '';
        $product = Db::name('product ')
            ->alias('a')
            ->join('product_code_info_visit_record w', 'a.product_id = w.product_id')
            ->join('admin s', 's.admin_id = a.admin_id')
            ->field('name,title')
            ->select();
        if (!empty($product)) {
            $data['code'] = $code;
            $data['msg'] =$msg;
        } else {
            $data['code'] = 1;
            $data['msg'] = '错误';
            return $data;
        }
        $scanlog =[];
        foreach ($product as $value) {
            $scanlog['scanlog'][] = array('name'=>$value['name'] . '公司' . $value['title'] . '产品被验证');
        }
        $data['data'] = $scanlog;
        return json($data);

    }
}