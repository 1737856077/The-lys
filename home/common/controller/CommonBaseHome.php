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
use think\Session;
class CommonBaseHome extends Controller
{

    public function __construct(Request $request){
        parent::__construct($request);
    }

    /**
     * @描述：初始化函数
     */
    public function  _initialize(){
        //查询网站配置信息
        $ModelWebConfigComm=Db::name('web_config');
        $getoneWebConfigComm=$ModelWebConfigComm->where("data_status='1'")
            ->order("id DESC")
            ->find();
        $this->assign('getoneWebConfigComm',$getoneWebConfigComm);
    }
}