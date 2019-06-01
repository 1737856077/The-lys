<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/4/29
 * Time: 11:44
 */

namespace app\sinterface\controller;


use think\Db;
use think\Session;

class Foodsafety
{
    /**
     * @描述：实时预警接口
     */
    public function index()
    {
        $data = [];
        $code = 0;
        $msg = '';
        $news_data = Db::name('news')->where('index_show',1)->where('index_show',1)->select();
        $res = [];
        foreach($news_data as $k=>$v){
            $res[]=['name'=>$v['title']];
        }
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['data']['foodSafetyInfo']=$res;
        return json($data);
    }
}