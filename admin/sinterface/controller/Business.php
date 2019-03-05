<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20 0020
 * Time: 下午 8:21
 */
namespace app\sinterface\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\model;
use app\common\controller\CommonBaseHome;
class Business extends CommonBaseHome
{
    /**
     * @描述：商家登录接口
     */
    public function login(){
        $param = $this->request->post();
        $username=isset($param['username']) ? htmlentities(trim($param['username'])) : '';
        $password=isset($param['password']) ? trim($param['password']) : '';
        $pwd=md5($password);

        if(empty($username) or empty($password)){
            echo $this->returnStrC('Fail');
            exit;
        }

        $ModelAdmin=Db::name('admin');
        $getoneAdmin=$ModelAdmin->where("name='$username' 
                                        AND pwd='$pwd'
                                        AND data_type=2
                                        AND data_status=1
                                        ")
            ->find();
        if(empty($getoneAdmin)){
            echo $this->returnStrC('Fail');
            exit;
        }

        echo $this->returnStrC($getoneAdmin['admin_id'].'|'.$getoneAdmin['name']);
        exit;
    }
}