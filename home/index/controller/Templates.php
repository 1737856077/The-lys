<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/15
 * Time: 16:30
 */

namespace app\index\controller;


use app\common\controller\CommonBaseHome;
use JsonSchema\Uri\Retrievers\Curl;
use think\Db;

class Templates extends CommonBaseHome
{
    //查询当前会员的交易订单
    public function index()
    {
        $param  = $this->request->param();
        $member_id  = isset($param['id'])?intval($param['id']):0;
        if ($member_id){
            $member = Db::name('order');
            $End = $member->where('member_id',$member_id)->where('order_status',4)->select();
            $desigend = $member->where('member_id',$member_id)->where('order_status',3)->select();
            $design = $member->where('member_id',$member_id)->where('order_status',2)->select();
            $verify = $member->where('member_id',$member_id)->where('order_status',1)->select();
            $new = $member->where('member_id',$member_id)->where('order_status',0)->select();
            $data = $member->where('member_id',$member_id)->select();
            if (!empty($data)){
                $this->assign([
                    'data'=>$data,
                    'new'=>$new,
                    'verify'=>$verify,
                    'design'=>$design,
                    'designend'=>$desigend,
                    'End'=>$End
                ]);
                return $this->fetch();
            }else{
                $this->error('没有数据');
            }
        }else{
           $this->error('错误');
    }
    }

}