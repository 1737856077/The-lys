<?php
namespace app\common\controller;
/**
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:CommonBase.php 2018-03-26 14:18:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use think\Image;

class CommonBaseHome extends Controller
{

    public function __construct(Request $request){
        parent::__construct($request);
    }

    /**
     * @描述：初始化函数
     */
    public function  _initialize(){

    }

    public function returnStrC($str){
        $ConfigDataCInterface=\think\Config::get('data.c_interface');
        return $ConfigDataCInterface['begin_str'].$str.$ConfigDataCInterface['end_str'];
    }

    public function returnJson($data){
        return json_encode($data);
    }
}