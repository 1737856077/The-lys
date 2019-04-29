<?php
namespace app\data\controller;
use think\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/28
 * Time: 11:14
 */

class Data extends Controller
{
    /**
     * @return 商家管理数据中心显示
     */
    public function index()
    {
        //查询扫码数量
        $content = file_get_contents('http://suyuan.localhost/admin.php/sinterface/dcolligate/index');
        $this->assign('content',$content);
        return $this->fetch();
    }
}