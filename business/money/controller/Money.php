<?php
namespace app\money\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/23
 * Time: 14:03
 */

class Money extends Controller
{
    /**
     * @return 财务首页
     */
    public function index()
    {
        //获取当前用户表的 余额
        $id = Session::get('bus_adminid');
        $money = Db::name('admin_business')->where('id',$id)->field('account')->find();
        $this->assign('money',$money);
        return $this->fetch();
    }

    /**
     * @return 消费明细查询
     */
    public function consumption()
    {
        //查询当前商家下的用户
        $id = Session::get('bus_adminid');
        $mon = Db::name('order')->where('admin_id',$id)->paginate(5);
        $this->assign('list',$mon);
        return $this->fetch();
    }
    //支付订单页
    public function money()
    {
        return $this->fetch();
    }
    //订单 金额
    public function status()
    {
        //获取续费时间
        $param = $this->request->param();
        $status = htmlspecialchars(isset($param['WIDsubject']) ? $param['WIDsubject'] : '');
        //判断金额
        if($status == 1){
            $money = 0.01;
        }elseif ($status == 2){
            $money = 2*0.01;
        }elseif ($status == 3){
            $money = 3*0.01;
        }
//        dump($money);die;
        return json($money);
    }

    /**
     * 计算续费后 到期时间
     */
    public function time()
    {
        //获取该商家续费年数
        $id = Session::get('bus_adminid');
        $year = Db::name('order')->where('admin_id',$id)->field('num')->find();
        $num = implode(',',$year);
        //获取商家到期时间
        $year1 = Db::name('admin_business')->where('admin_id',$id)->field('expiration_date')->find();
        $num2 = implode(',',$year1);
        //计算续费时间
        $new_time = $num*365*24*60*60;
        $new = date('Y-m-d H:i:s',$num2+$new_time);
        $new1 = strtotime($new);
        $res = Db::name('admin_business')->where('admin_id',$id)->update(['expiration_date'=>$new1]);
        $this->redirect('index/index/index');
    }

    /**
     * @return 发票申请
     */
    public function invoice()
    {
        if(Request::instance()->isPost()){
            //申请逻辑
            $param = $this->request->param();
            //验证信息
            $validate = new Validate(
                [
                    'price' => 'require',
                    'title' => 'require',
                    'taxpayer_number' => 'require',
                    'express_address' => 'require',
                    'phone' => 'require',
                ]);
            $data1 = ([
                'price' => $param['price'],
                'title' => $param['title'],
                'taxpayer_number' => $param['taxpayer_number'],
                'express_address' => $param['express_address'],
                'phone' => $param['phone'],
            ]);
            if (!$validate->check($data1)) {
                $this->error($validate->getError(),'money/invoice');
            }
            //添加数据
            $data = [
                'price' => $param['price'],
                'title' => $param['title'],
                'taxpayer_number' => $param['taxpayer_number'],
                'invoice_id' => my_returnUUID(),
                'data_status' => 0,
                'express_address' => $param['express_address'],
                'admin_id' => Session::get('adminid'),
                'create_time' => time(),
                'phone' => $param['phone'],
                'account' => $param['account'],
            ];
            $res = Db::name('business_invoice')->insert($data);
            if($res){
                $this->success('已提交申请','money/index');
            }else{
                $this->success('提交申请失败');
            }

        }else{
            //获取该商家 消费金额总数
            $id = Session::get('bus_adminid');
            $num = Db::name('order')->where('admin_id',$id)->sum('amount');
            $this->assign('num',$num);
            return $this->fetch();
        }

    }

    /**
     * @return 发票申请列表
     */
    public function invoice_list()
    {
        //查询发票申请列表
        $id = Session::get('bus_adminid');
        $list = Db::name('business_invoice')->where('admin_id',$id)->order('id','desc')->paginate(5);
        $this->assign('list',$list);
        return $this->fetch();
    }

}