<?php

namespace app\gift\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/19
 * Time: 11:25
 */
class Gift extends Controller
{
    /**
     * @return 礼品列表
     */
    public function gift()
    {
        $id = Session::get('adminid');
        $list = Db::name('product_integral')->where('admin_id', $id)->paginate(2);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @return 添加礼品
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            //提交逻辑
            $id = Session::get('adminid');
            $title = input('post.title');
            $total = input('post.total');
            $integral = input('post.integral');
            $data_desc = input('post.data_desc');
            $request = Request::instance();
            $file = $request->file('images');
            $validate = new Validate(
                [
                    'title' => 'require',
                    'total' => 'require',
                    'integral' => 'require',
                    'data_desc' => 'require',
                ]);
            $data1 = ([
                'title' => $title,
                'total' => $total,
                'integral' => $integral,
                'data_desc' => $data_desc,
            ]);
            if (!$validate->check($data1)) {
                dump($validate->getError());
            }
            if ($file) {
                $info = $file->validate([
                    'size' => (1024 * 1024) * 1,
                    'ext' => 'jpeg,jpg,png,bmp'
                ])->move("static/uploads/business/");
                if ($info) {
                    $data = [
                        'title' => $title,
                        'total' => $total,
                        'integral' => $integral,
                        'data_desc' => $data_desc,
                        'admin_id' => $id,
                        'images' => $info->getSaveName(),
                        'create_time' => time(),
                    ];
                } else {
                    $this->error($file->getError());
                }
            }
            $res = Db::name('product_integral')->insert($data);
            if ($res) {
                return $this->success('添加成功', 'gift/gift');
            } else {
                return $this->error('添加失败');
            }
        } else {
            return $this->fetch();
        }

    }

    /**
     * 编辑礼品
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()) {
            $title = input('post.title');
            $total = input('post.total');
            $integral = input('post.integral');
            $data_desc = input('post.data_desc');
            $request = Request::instance();
            $file = $request->file('images');
            //验证信息
            $validate = new Validate(
                [
                    'title' => 'require',
                    'total' => 'require',
                    'integral' => 'require',
                    'data_desc' => 'require',
                ]);
            $data1 = ([
                'title' => $title,
                'total' => $total,
                'integral' => $integral,
                'data_desc' => $data_desc,
            ]);
            if (!$validate->check($data1)) {
                dump($validate->getError());
            }
            if ($file) {
                $info = $file->validate([
                    'size' => (1024 * 1024) * 1,
                    'ext' => 'jpeg,jpg,png,bmp'
                ])->move("static/uploads/business/");
                $data = [];
                if ($info) {
                    $data = [
                        'title' => $title,
                        'total' => $total,
                        'integral' => $integral,
                        'data_desc' => $data_desc,
                        'images' => $info->getSaveName(),
                        'updata_time' => time(),
                    ];
                } else {
                    $this->error($file->getError());
                }
            }
//            dump($data);
            $res = Db::name('product_integral')->where('id', $id)->update($data);
            if ($res) {
                return $this->success('编辑成功', 'gift/gift');
            } else {
                return $this->error('编辑失败');
            }
        } else {
            $content = Db::name('product_integral')->where("id", $id)->find();
            $this->assign('content', $content);
            return $this->fetch();
        }
    }

    /**
     * 礼品状态管理
     */
    public function status($id)
    {
        $content = Db::name('product_integral')->where('id', $id)->field('data_status')->find();
        if ($content['data_status'] == 1) {
            $res = Db::name('product_integral')->where('id', $id)->update(['data_status' => 0]);
        } else {
            $res = Db::name('product_integral')->where('id', $id)->update(['data_status' => 1]);
        }
        if ($res) {
            return $this->success('切换成功','gift/gift');
        } else {
            return $this->success('切换失败');
        }
    }

}