<?php
namespace app\member\controller;
/**
 * @用户中心首页
 * User: lys
 * Date: 2019/3/18
 * Time: 9:24
 */

use think\Controller;
use think\View;
use think\Validate;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBase;
class Userconter extends  CommonBase
{
    public function index(){
       $id = Session::get('memberid');
       $data = Db::name('member')->where('member_id',$id)->select();
       $industryid =$data[0]['industry_id'];
       $industry =Db::name('system_config')->where('id',$industryid)->field('title')->find();
       $title = Db::name('system_config')->field('title,id')->select();
       $orders = Db::name('member')->where('member_id',$id)->select();
      if ($orders[0]['district']){
          $order = $orders[0]['district'];
          $regions = Db::name('region')->where('area_code',$order)->select();
          $regionss = $regions[0]['area_parent_id'];
          $regionss = Db::name('region')->where('area_code',$regionss)->select();
          $regionsss = $regionss[0]['area_parent_id'];
          $regionsss = Db::name('region')->where('area_code',$regionsss)->select();
          $order =$regionsss[0]['area_name'].'-'.$regionss[0]['area_name'].'-'.$regions[0]['area_name'];
           $region = Db::name('region')->where('area_type',2)->field('area_name,area_code')->select();
          unset($title[0]);
          unset($title[1]);
          $this->assign([
              'order'=>$order,
              'data'=>$data,
              'industry'=>$industry,
              'title'=>$title,
              'region'=>$region,
              'order'=>$order,
          ]);
      }else{
          $region = Db::name('region')->where('area_type',2)->field('area_name,area_code')->select();

          $this->assign([
              'data'=>$data,
              'industry'=>$industry,
              'title'=>$title,
              'region'=>$region,
              'order'=>0,

          ]);
      }
       return $this->fetch();
    }
    public function shi()
    {
        $param = $this->request->post();
        $shi = Db::name('region')
            ->where('area_parent_id', isset($param['shi']['area_code']) ? $param['shi']['area_code'] : $param['shi'])
            ->field('area_name,area_code')
            ->select();
        return json($shi);
    }
    public function save()
    {
        $id = Session::get('memberid');
        $data = $this->request->param();
        $data['pwd'] =isset( $data['pwd']) ? intval( $data['pwd']) : 0 ;
        $data['title'] =isset($data['title']) ?htmlspecialchars($data['title']) : 0 ;
        $data['sheng'] = isset($data['sheng'])?$data['sheng']:'';
        $datas = array();
        $request = Request::instance();
        $file = $request->file('img');
        if ($file) {
            $info = $file->validate([
                'size' => 1048576,
                'ext' => 'jpeg,jpg,png,bmp'
            ])->move('home/uploads/');
            if ($info) {
                $datas['img'] = $info->getSaveName();//头像
            } else {
                $this->error($file->getError());
            }
        }

        if ($data['pwd']) {
            $rule = ([
                'pwd|密码' => 'length:6,20|alphaNum',
            ]);
            $datapwd = [
                'pwd' => $data['pwd'],
            ];
            $validate = new Validate($rule);
            $result = $validate->check($datapwd);
            if (true !== $result) {
                $this->error($validate->getError());
            }

            $pwd = htmlspecialchars(md5($data['pwd']));
            $datas['pwd'] = $pwd;
        }
        if ($data['title']) {
            $rule = ([
                'title|行业' => 'require',
            ]);
            $datahy = [
                'title' => $data['title'],
            ];
            $validate = new Validate($rule);
            $result = $validate->check($datahy);
            if (true !== $result) {
                return $validate->getError();
            }
        }
       if ($data['sheng'])
       {
           $datas['nation']=1;
           $datas['province']=$data['sheng'];
           $datas['city']=$data['city'];
           $datas['district']=$data['qu'];
       }

            $datas['industry_id'] = $id;
            $datas['update_time'] = time();
            $result = Db::name('member')->where('member_id',$id)->update($datas);
            if ($result == true){
                $this->success('更新成功','/index.php/member/userconter/index');
            }
    $this->success('更新成功','/index.php/member/userconter/index');

    }
    public function orders()
    {
        $data= Session::get('memberid');
        $member_id = isset($data)? Session::get('memberid') : 0;
        if ($member_id) {
            $member = Db::name('order');
            $End = $member->where('member_id', $member_id)->where('order_status', 4)->select();//订单完成
            $desigend = $member->where('member_id', $member_id)->where('order_status', 3)->select();//设计结束
            $design = $member->where('member_id', $member_id)->where('order_status', 2)->select();//设计中
            $verify = $member->where('member_id', $member_id)->where('order_status', 1)->select();//已核实
            $new = $member->where('member_id', $member_id)->where('order_status', 0)->select();//新提交
            $data = $member->select();
            if (!empty($data)) {
                $this->assign([
                    'data' => $data,
                    'new' => $new,
                    'verify' => $verify,
                    'design' => $design,
                    'designend' => $desigend,
                    'End' => $End
                ]);

                return $this->fetch();
            } else {
                $this->error('没有数据');
            }
        } else {
            $this->error('错误');
        }
    }
    public function template()
    {
        $id = Session::get('memberid');
        if ($id) {
            $checkorder = Db::name('template ');
            $data = $checkorder->where('member_id', $id)->where('data_type', 1)->select();
            if (!empty($data)) {
                $this->assign('data', $data);
                dump($data);die();
                return $this->fetch();
            } else {
                return $this->error('没有数据');
            }
        } else {
            $this->error('请求错误');
        }
    }
    public function hqmuban()
    {
        $param = request()->param();
        $member_id = Session::get('memberid');
        $templats_id = isset($param['template_id']) ? $param['template_id'] : 0;
        $member_id = isset($member_id) ? $member_id : 0;
        $data = Db::name('template')->where('template_id', $templats_id)->select();
        $data[0]['data_type'] = 1;
        $data[0]['member_id'] = $member_id;
        unset($data[0]['template_id']);
        $datas = Db::name('template ')->insert($data[0]);
        if ($datas) {
            $this->success('获取成功', 'index/home/index');
        } else {
            $this->error('获取失败');
        }
    }
    public function orderdetails()
    {
        $param = $this->request->param();
//        $memberid = Session::get('memberid');
        $orderid = isset($param['id'])?$param['id']:'';
        $data = Db::name('order')->where(['id'=>$orderid])->select();
        $this->assign('data',$data);
        return $this->fetch();

    }

}