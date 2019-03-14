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
        //本周访问
        $datas = Db::query(
            "SELECT id FROM sy_product WHERE YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d'),1) = YEARWEEK(now(),1) "
        );
        //上周访问
        $datass = Db::query(
            "SELECT id FROM sy_product WHERE YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d'),1) = YEARWEEK(now(),1)-1 "
        );
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

        //本周一时间戳
        $Monday = strtotime("previous monday");
        $Zon = $Monday;
        //上周一时间戳字段
        $Mondays = $Monday - (60 * 60 * 24 * 7);
        $Tuesday = $Monday + (60 * 60 * 24);
        $Tuesdays = $Mondays + (60 * 60 * 24);
        $Wednesday = $Tuesday + (60 * 60 * 24);
        $Wednesdays = $Tuesdays + (60 * 60 * 24);
        $Thursday = $Wednesday + (60 * 60 * 24);
        $Thursdays = $Wednesdays + (60 * 60 * 24);
        $Friday = $Thursday + (60 * 60 * 24);
        $Fridays = $Thursdays + (60 * 60 * 24);
        $Saturday = $Friday + (60 * 60 * 24);
        $Saturdays = $Fridays + (60 * 60 * 24);
        $Sunday = $Saturday + (60 * 60 * 24);
        $Sundays = $Saturdays + (60 * 60 * 24);
        $zhoumo = strtotime('next monday');//对照
        //查询
        $Monday = Db::query(" 
              SELECT COUNT(*) as id  FROM sy_product
            WHERE create_time
            BETWEEN $Monday AND $Tuesday
            ");
        $Mondays = Db::query(" 
              SELECT COUNT(*) as id FROM sy_product
            WHERE create_time
            BETWEEN $Mondays AND $Tuesdays
            ");
        $Tuesday = Db::query(" 
              SELECT COUNT(*) as id FROM sy_product
            WHERE create_time
            BETWEEN $Tuesday AND $Wednesday
            ");
        $Tuesdays = Db::query(" 
              SELECT COUNT(*) as id FROM sy_product
            WHERE create_time
            BETWEEN $Tuesdays AND $Wednesdays
            ");
        $Wednesday = Db::query(" 
              SELECT COUNT(*)  as id FROM sy_product
            WHERE create_time
            BETWEEN $Wednesday AND $Thursday
            ");
        $Wednesdays = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Wednesdays AND $Thursdays
            ");
        $Thursday = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Thursday AND $Friday
            ");
        $Thursdays = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Thursdays AND $Fridays
            ");
        $Friday = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Friday AND $Saturday
            ");
        $Fridays = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Fridays AND $Saturdays
            ");
        $Saturday = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Saturday AND $Sunday
            ");
        $Saturdays = Db::query(" 
              SELECT COUNT(*) as id FROM sy_product
            WHERE create_time
            BETWEEN $Saturdays AND $Sundays
            ");
        $zhouri = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Sunday AND $zhoumo
            ");
        $zhouris = Db::query(" 
              SELECT COUNT(*)as id FROM sy_product
            WHERE create_time
            BETWEEN $Sunday AND $Zon
            ");
        $logData = array([
            'name' => '周一',
            'value' => $Monday[0]['id'],
            'value1' => $Mondays[0]['id'],],
            [
                'name' => '周二',
                'value' => $Tuesday[0]['id'],
                'value1' => $Tuesdays[0]['id'],

            ],
            [
                'name' => '周三',
                'value' => $Wednesday[0]['id'],
                'value1' => $Wednesdays[0]['id'],
            ],
            [
                'name' => '周四',
                'value' => $Thursday[0]['id'],
                'value1' => $Thursdays[0]['id'],
            ],
            [
                'name' => '周五',
                'value' => $Friday[0]['id'],
                'value1' => $Fridays[0]['id'],
            ],
            [
                'name' => '周六',
                'value' => $Saturday[0]['id'],
                'value1' => $Saturdays[0]['id'],
            ], [
                'name' => '周日',
                'value' => $zhouri[0]['id'],
                'value1' => $zhouris[0]['id'],

            ],
        );

        // 总溯源：完成、未完成
        $perCount_WC = Db::name('product_code_info')->where("data_status=1 AND code_cipher_query_total > 0")->count();
        $perCount_WWC = Db::name('product_code_info')->where("data_status=1 AND code_cipher_query_total < 1")->count();
        $perCount=array(
            array('value'=>$perCount_WC,'name'=>'完成'),
            array('value'=>$perCount_WWC,'name'=>'未完成')
        );

        $Dcolligates['totalCompany'] = $totalCompany[0]['totalCompany'];
        $Dcolligates['totalProduct'] = $totalProduct[0]['totalProduct'];
        $Dcolligates['visitlog'] = $visitlog;
        $Dcolligates['scanData'] = $scanData;
        $Dcolligates['logData'] = $logData;
        $Dcolligates['perCount'] = $perCount;
        $data['data'] = $Dcolligates;
        return json($data);
    }
}