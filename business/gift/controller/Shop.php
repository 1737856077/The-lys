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
class Shop extends Controller
{
    /**
     * @return 礼品列表
     */
    public function index()
    {
        //查询所有类
        $id = Session::get('bus_adminid');
        $list = Db::name('class')->where('admin_id', $id)->select();
        $count = count($list);
        $list1 = [];
        //遍历查询出分类
        foreach ($list as $k=>$v){
            $v['title'] = Db::name('class')->where('id',$v['pid'])->field('name')->find()['name'];
            $list1[] = $v;
        }
        $this->assign('list', $list1);
        $this->assign('count', $count);
        return $this->fetch();
    }

    /**
     * @return 添加分类
     */
    public function add()
    {
        $id = Session::get('bus_adminid');
        if(Request::instance()->isPost()){
            //获取添加数据
            $name = input('post.name');
            $pid = input('post.pid');
            //验证信息
            $validate = new Validate(
                [
                    'name' => 'require',
                    'pid' => 'require',
                ]);
            $data1 = ([
                'name' => $name,
                'pid' => $pid,
            ]);
            if (!$validate->check($data1)) {
                $this->error($validate->getError(),'shop/add');
            }
            $data = [
              'name'=>$name,
              'pid'=>$pid,
              'admin_id'=>$id,
              'create_time'=>time(),
            ];
            $res = Db::name('class')->insert($data);
            if ($res) {
                return $this->success('添加成功', 'shop/index');
            } else {
                return $this->error('添加失败');
            }
        }else{
            $name1 = Db::name('class')->where('admin_id',$id)->select();
            $this->assign('name',$name1);
            return $this->fetch();
        }
    }

    /**
     * @return 删除分类
     */
    public function del()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(intval(isset($param['id']) ? $param['id'] : ''));
        //根据id查询出分类
        $list = Db::name('class')->where('pid',$id)->find();
        if(!empty($list)){
            return json('1');
        }else{
            $del = Db::name('class')->where('id',$id)->delete();
            return json('2');
        }

    }

}