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
        $list = Db::name('business_invoice')->where('data_status','<',3)->order('id','desc')->select();
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
            $param = $this->request->param();
            if($param['delivery_express_id'] == 1){
                $kuaidi = '顺丰快递';
            }else{
                $kuaidi = '中通快递';
            }
            $data = [
                'invoice_tax_number'=>$param['invoice_tax_number'],
                'delivery_express_id'=>$kuaidi,
                'delivery_express_number'=>$param['delivery_express_number'],
                'delivery_send_time'=>time(),
                'data_status'=>3,
            ];
            $res = Db::name('business_invoice')->where('id',$id)->update($data);
            if($res){
                $this->success('处理成功','invoice/index');
            }else{
                $this->error('处理失败');
            }
        }else{
            //获取待处理工单信息
            $list = Db::name('business_invoice')->where('id',$id)->find();
            $this->assign('list',$list);
//            dump($list);die;
            return $this->fetch();
        }
    }
}