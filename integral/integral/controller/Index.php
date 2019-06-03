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
use think\view\driver\Think;

class Index extends CommonIntegra
{
    public function test()
    {
        $admin_id = Session::get('admin_id');
        $productData = Db::name('product_integral')->where('admin_id', $admin_id)->where('data_status', 1)->select();
        $this->assign('data', $productData);
        return $this->fetch();


    }

    /**
     * @商品中心
     */
    public function index()
    {

        $data = Db::name('class')->where([
            'admin_id' => Session::get('admin_id'),
            'pid' => 0
        ])->select();
        $one = Db::name('class')->where('pid', isset($data[0]['id']) ? $data['0']['id'] : '')->select();
        $this->assign('data', $data);
        $this->assign('one', $one);
        return $this->fetch();
    }

    /**
     * 商品详情
     */
    public function details()
    {
        $param = $this->request->param();
        $productId = $param['id'];
        $productData = Db::name('product_integral')->where('id', $productId)->find();
        $productData['data_desc'] = html_entity_decode($productData['data_desc']);
        $this->assign('data', $productData);
        return $this->fetch();
    }

    /**
     * 加入购物车
     */
    public function saveshopping()
    {
        $param = $this->request->param();
        $title = htmlspecialchars(isset($param['title']) ? $param['title'] : '');
        $product_id = htmlspecialchars(isset($param['product_id']) ? $param['product_id'] : '');
        $number = htmlspecialchars(isset($param['number']) ? $param['number'] : '');
        $nn = Db::name('shopping')->where('product_id', $product_id)->find();
        if (empty($nn)) {
            $data = [
                'title' => $title,
                'product_id' => $product_id,
                'admin_id' => Session::get('admin_id'),
                'member_id' => Session::get('memberid'),
                'number' => $number,
                'update_time' => time(),
                'create_time' => time()
            ];
            $res = Db::name('shopping')->insert($data);
            if ($res) {
                return_msg('200', '添加成功');
            } else {
                return_msg('400', '喏,出错辽');
            }
        } else {
            $data = [
                'number' => $nn['number'] + $number,
                'update_time' => time(),

            ];
            $res = Db::name('shopping')->where('product_id', $product_id)->update($data);
            if ($res) {
                return_msg('200', '添加成功');
            } else {
                return_msg('400', '喏,出错辽');
            }
        }

    }

    /**
     * 查询商品
     */
    public function type()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id']) ? $param['id'] : ''));
        if (!$id) {
            return_msg('400', '数据错误');
        }
        $data = Db::name('class')->where('pid', $id)->select();
        if ($data) {
            return_msg('200', '查询成功', $data);
        } else {
            return_msg('400', '没有数据呢');
        }

    }

    /**
     * 商品列表
     */
    public function prolist()
    {
        $admin_id = Session::get('admin_id');
        $param = $this->request->param();
        $id = htmlspecialchars(isset($param['id']) ? $param['id'] : '');
        if (!$id) {
            echo "<script>alert('参数错误!');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
            exit();
        }

        $productData = Db::name('product_integral')->where('class_id',$id)->where('data_status', 1)->select();
        $this->assign('data', $productData);
        return $this->fetch();
    }
}