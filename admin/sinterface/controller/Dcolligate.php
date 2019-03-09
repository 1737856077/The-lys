<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/6
 * Time: 10:50
 */

namespace app\sinterface\controller;


use app\common\controller\CommonBaseHome;
use think\Db;

class Dcolligate extends CommonBaseHome
{


    /**
     * @描述:综合统计接口
     */
    public function index()
    {
        $data = [];
        $Dcolligates = [];
        $code = 0;
        //查询累计企业
        $totalCompany = Db::name('admin')->where('data_type=1 AND data_status=1')->field('count(data_type) totalCompany')->select();
        //累计产品
        $totalProduct = Db::name('product')->where('data_status=1')->field('count(id) totalProduct')->select();
        //每月登记的溯源产品
        $visitlog = Db::query("
                         SELECT DATE_FORMAT(FROM_UNIXTIME(create_time),'%m') AS name,COUNT(*) AS value
						 FROM sy_product
						 WHERE `create_time`
						 BETWEEN UNIX_TIMESTAMP(now()) - 31556926
						 AND UNIX_TIMESTAMP(now())
						 GROUP BY name");
        //查询每月扫码的数量
        $scanData = Db::query("
                         SELECT DATE_FORMAT(FROM_UNIXTIME(create_time),'%m') AS name,COUNT(*) AS value
						 FROM sy_product_code_info_visit_record
						 WHERE `create_time`
						 BETWEEN UNIX_TIMESTAMP(now()) - 31556926
						 AND UNIX_TIMESTAMP(now())
						 GROUP BY name");

        if (!empty($totalCompany) and !empty($totalProduct) and !empty($visitlog) and !empty($scanData)) {
            $data['code'] = 0;
            $data['msg'] = '';
        } else {
            $data['code'] = 1;
            $data['msg'] = '查询失败';
            return json($data);
        }
        $Dcolligates['totalCompany'] = $totalCompany[0]['totalCompany'];
        $Dcolligates['totalProduct'] = $totalProduct[0]['totalProduct'];
        $Dcolligates['visitlog'] = $visitlog;
        $Dcolligates['scanData'] = $scanData;

        $data['data'] = $Dcolligates;
        return json($data);
    }
}