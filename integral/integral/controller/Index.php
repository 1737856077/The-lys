<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/19
 * Time: 13:45
 */
namespace app\integral\controller;

use app\common\controller\CommonIntegra;
use think\Db;
use think\Session;

class Index extends CommonIntegra
{
    /**
     * @商品中心
     */
    public function index()
    {
        $admin_id = Session::get('admin_id');
        $productData = Db::name('product_integral')->where('admin_id',$admin_id)->where('data_status',1)->select();
        $this->assign('data',$productData);
        return $this->fetch();
    }
    /**
     * 商品详情
     */
    public function details()
    {
        $param = $this->request->param();
        $productId = $param['id'];
        $productData = Db::name('product_integral')->where('id',$productId)->find();
        $productData['data_desc'] = html_entity_decode($productData['data_desc']);
        $this->assign('data',$productData);
        return $this->fetch();
    }


}