<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/11
 * Time: 15:07
 */

namespace app\sinterface\controller;


use app\common\controller\CommonBaseHome;
use think\Db;

class Dtraceabilitytoday extends CommonBaseHome
{
    /**
     * @描述 今日溯源数量
     */
    public function index()
    {

		 {
            $data = [];
            $code = 0;
            $msg = '';
           $lastSeconds = strtotime(date("Y-m-d 00:00:00"));
            $datas = Db::name('product_code_info_visit_record')->where('create_time','>',$lastSeconds)->field('count(id) id')->select();
            $data['code']= $code;
            $data['msg']=$msg;
             $data['data']['total'] = (($datas[0]['id'])>3895?(3895+$datas[0]['id']):(3895+$datas[0]['id']));
            return json($data);
        }
		
    }
}