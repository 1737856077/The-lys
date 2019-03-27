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
    /**
     * @用户中心
     */
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
                return $this->fetch();
            } else {
                return $this->error('没有数据');
            }
        } else {
            $this->error('请求错误');
        }
    }

    /**
     * @获取模板
     */
    public function hqmuban()
    {
        $param = request()->param();
        $member_id = Session::get('memberid');
        $templats_id = isset($param['temaplate_id']) ? $param['temaplate_id'] : 0;
        $member_id = isset($member_id) ? $member_id : 0;
        $data = Db::name('template')->where('template_id', $templats_id)->select();
        $data[0]['data_type'] = 1;
        $data[0]['member_id'] = $member_id;
        unset($data[0]['template_id']);
        $datas = $data[0];
        $datas['update_time']=time();
        $datass = Db::name('template')->insertGetId($datas);
        $content = Db::name('template_content')->where('template_id',$templats_id)->select()[0];
        unset($content['id']);
        $content['update_time']=time();
        $content['template_id']=$datass;
        $contents = Db::name('template_content')->insert($content);
        if ($datas) {
            $this->success( '获取成功','/index.php');
        } else {
            $this->error();
        }
    }
    public function orderdetails()
    {
        $param = $this->request->param();
        $orderid = isset($param['id'])?$param['id']:'';
        $data = Db::name('order')->where(['id'=>$orderid])->select();
        $this->assign('data',$data);
        return $this->fetch();

    }

    /**
     * @查看模板内容
     */
    public function content()
    {
        $param = $this->request->param();
        $templateid= isset($param['templateid'])?$param['templateid']:0;
        if (empty($templateid)){
            $this->error('请求出错');
        }
        $data = Db::name('template')->where('template_id',$templateid)->select();
        $content = Db::name('template_content')->where('template_id',$templateid)->select();
        $zhizhang = Db::name('paper')->select();
        $this->assign('content',$content);
        $this->assign('data',$data);
        $this->assign('zhizhang',$zhizhang);
            return $this->fetch();
    }
    /**
     * @获取订单
     */
    public function sub()
    {
        $param = $this->request->param();
        $paper = isset($param['type'])?$param['type']:0;
        $mumber=isset($param['number'])?$param['number']:0;
        $cmtype = isset($param['cmtype'])?$param['cmtype']:0;
        $tempid = isset($param['tempid'])?$param['tempid']:0;
        dump($param);
        $paperdata = Db::name('paper')->where('id',$paper)->select();
        $tempdata = Db::name('template_content')->where('template_id',$tempid)->select();
        $temptadata = Db::name('template')->where('template_id',$tempid)->select();
        dump($paperdata);
        if (!empty($paperdata)){
            $price = $paperdata[0]['price'];
            $atm  = $mumber*$price;//支付金额
            foreach ($temptadata as $k=>$v){
                $data['template_title']=$v['title'];
                $data['img']=$v['img'];

            }
            $data['order_no'] = date("d").date("his").mt_rand(10000,99999);//订单号
            foreach ($tempdata as $k=>$v){
                $data['template_id']=$v['template_id'];
               $data['paper_size_long'] = $v['paper_size_long'];
                $data['paper_size_wide'] = $v['paper_size_wide'];
                 $data['paper_size_unit'] = $v['paper_size_unit'];
                $data['paper_direction'] = $v['paper_direction'];

            }
            $data['print_num'] = $mumber;
            $data['price'] = $atm;
            $memberid = $temptadata[0]['member_id'];
            $memberdata =  Db::name('member')->where('member_id',$memberid)->select();

            foreach ($memberdata as $k=>$v){
                $data['member_id']=$v['member_id'];
                $data['name'] = $v['real_name'];
                $data['email'] = $v['email'];
                $data['moblie'] =$v['mobile'];
            }
            $data['score_pay'] = $atm;
            $data['score_real_pay'] = $atm;
            $data['create_time'] = time();
           $this->assign('data',$data);
           return $this->fetch();
        }else{
            $paperdata = Db::name('paper')->where('id',$paper)->select();
            $tempdata = Db::name('template_content')->where('template_id',$tempid)->select();
            $temptadata = Db::name('template')->where('template_id',$tempid)->select();
            foreach ($temptadata as $k=>$v){
                $data['template_title']=$v['title'];

            }
            $data['order_no'] = date("d").date("his").mt_rand(10000,99999);
            foreach ($tempdata as $k=>$v){
                $data['paper_size_long'] = $v['paper_size_long'];
                $data['paper_size_wide'] = $v['paper_size_wide'];
                $data['paper_size_unit'] = $v['paper_size_unit'];
                $data['paper_direction'] = $v['paper_direction'];

            }
            $data['print_num'] = $mumber;
            $memberid = $temptadata[0]['member_id'];
            $memberdata =  Db::name('member')->where('member_id',$memberid)->select();
            foreach ($memberdata as $k=>$v){
                $data['name'] = $v['real_name'];
                $data['email'] = $v['email'];
                $data['moblie'] =$v['mobile'];
            }
            $data['create_time'] = time();
            $data = Db::name('order')->insert($data);
            if ($data){
                $this->success('提交成功','/index.php/member/userconter/orders');
            }else{
            $this->error('提交失败请检查');}
        }
    }
    /**
     * @取消支付
     */
    public function qxzf()
    {
        $param = $this->request->param();
        unset($param['img']);
        unset($param['tempalteid']);
        unset($param['memberid']);
        $tempalte_id =isset($param['template_id'])?$param['template_id']:0;
        if (!empty($tempalte_id)){
            $Modeorder = Db::name('order');
            $param['pay_status']=0;
            $data = $Modeorder->insert($param);
            if ($data){
                $this->success('取消支付成功','/index.php/member/userconter/orders');
            }else{
                $this->error('取消失败','/index.php/member/userconter/orders');
            }
        }
    }

}