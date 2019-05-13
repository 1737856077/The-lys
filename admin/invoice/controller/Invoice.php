<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 9:46
 */
namespace app\invoice\controller;
use think\Controller;
use think\Db;
use think\Request;

class invoice extends Controller
{
    /**
     * @return 发票管理
     */
    public function index()
    {
        //查询申请工单
        $list = Db::name('business_invoice')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * @param $id 工单的id
     * @return 处理工单信息
     */
    public function edit($id)
    {
        if(Request::instance()->isPost()){
            //处理逻辑

        }else{
            //获取待处理工单信息
            $list = Db::name('business_invoice')->where('id',$id)->find();
            $this->assign('list',$list);
//            dump($list);die;
            return $this->fetch();
        }
    }
}