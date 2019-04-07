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
use app\member\controller\Data;
use think\Paginator;
use app\common\controller\CommonBase;
class Userconter extends CommonBase
{
    public function _initialize()
    {
        parent::_initialize();
        // 打印模式
        $this->assign("ConfigPreorderPrintMode", \think\Config::get('data.preorder_print_mode'));
        // 排序方式
        $this->assign("ConfigPreorderPrintSort", \think\Config::get('data.preorder_print_sort'));
    }

    /**
     * @用户中心
     */
    public function index()
    {

        $id = Session::get('memberid');
        $data = Db::name('member')->where('member_id', $id)->select();
        $industryid = $data[0]['industry_id'];
        $industry = Db::name('system_config')->where('id', $industryid)->field('title')->find();
        $title = Db::name('system_config')->field('title,id')->select();
        $orders = Db::name('member')->where('member_id', $id)->select();
        if (isset($orders[0]['district'])) {
            $order = $orders[0]['district'];
            $regions = Db::name('region')->where('area_code', $order)->select();
            $regionss = $regions[0]['area_parent_id'];
            $regionss = Db::name('region')->where('area_code', $regionss)->select();
            $regionsss = $regionss[0]['area_parent_id'];
            $regionsss = Db::name('region')->where('area_code', $regionsss)->select();
            //查看数据库
            $databases = Db::name('custom_database')->where('member_id', $id)->select();
            $n = Db::name('custom_database')->where('member_id', $id)->field('count(member_id) id')->select();
            $this->assign('databases', $databases);
            $this->assign('n', $n);

            //查询本会员的个人模板
            $checkorder = Db::name('template');
            $Popular = $checkorder->where('member_id', $id)->where('data_type', 1)->select();

            foreach ($Popular as $k => $value) {
                $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $Popular[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
                $Popular[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
                $Popular[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
                $Popular[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
                $Popular[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height']) ? $Populars[0]['lable_size_height'] : '';
                $Popular[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
            }

            //最新模板
            $newtemplate = Db::name('template')
                ->where('member_id', $id)
                ->where('data_type', 1)
                ->order('create_time desc')
                ->limit(4)
                ->select();
            foreach ($newtemplate as $k => $value) {
                $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $newtemplate[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
                $newtemplate[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
                $newtemplate[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
                $newtemplate[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
                $newtemplate[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height']) ? $Populars[0]['lable_size_height'] : '';
                $newtemplate[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
            }

            $this->orders();
            $order = $regionsss[0]['area_name'] . '-' . $regionss[0]['area_name'] . '-' . $regions[0]['area_name'];
            $region = Db::name('region')->where('area_type', 2)->field('area_name,area_code')->select();
            unset($title[0]);
            unset($title[1]);
            $this->assign([
                'newtemplate' => $newtemplate,
                'template' => $Popular,
                'order' => $order,
                'data' => $data,
                'industry' => $industry,
                'title' => $title,
                'region' => $region,
                'order' => $order,
            ]);
        } else {
            //查看数据库
            $databases = Db::name('custom_database')->where('member_id', $id)->select();
            $n = Db::name('custom_database')->where('member_id', $id)->field('count(member_id) id')->select();
            $this->assign('databases', $databases);
            $this->assign('n', $n);
            $this->orders();
            $checkorder = Db::name('template ');
            $region = Db::name('region')->where('area_type', 2)->field('area_name,area_code')->select();

            $newtemplate = Db::name('template')
                ->where('member_id', $id)
                ->where('data_type', 1)
                ->order('create_time desc')
                ->limit(4)
                ->select();
            foreach ($newtemplate as $k => $value) {
                $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $newtemplate[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
                $newtemplate[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
                $newtemplate[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
                $newtemplate[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
                $newtemplate[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height']) ? $Populars[0]['lable_size_height'] : '';
                $newtemplate[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
            }
            $checkorder = Db::name('template');
            $Popular = $checkorder->where('member_id', $id)->where('data_type', 1)->select();

            foreach ($Popular as $k => $value) {
                $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $Popular[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
                $Popular[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
                $Popular[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
                $Popular[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
                $Popular[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height'])?$Populars[0]['lable_size_height'] : '';
                $Popular[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
            }
            $this->orders();
            $this->assign([
                'newtemplate' => $newtemplate,
                'template' => $Popular,
                'data' => $data,
                'industry' => $industry,
                'title' => $title,
                'region' => $region,

            ]);
        }
        return $this->fetch();
    }

    /**
     * 订单查找
     */
    public function SeekTemplate()
    {
        $param = $this->request->param();
        $Member_Id = Session::get('memberid');
        $order = $param['order'];
        $map['template_title'] = ['like', '%' . $order . '%'
            ,
            'member_id' => $Member_Id,
        ];
        $TemplateModel = Db::name('order');
        $data = $TemplateModel->where($map)->select();
        //订单模板详情
        foreach ($data as $k => $value) {
            $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
            $data[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
            $data[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
            $data[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
            $data[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
            $data[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height']) ? $Populars[0]['lable_size_height'] : '';
            $data[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
        }
        if (!empty($data)) {
            $data = json($data);
            return $data;
        }
        if (empty($data)) {
            $maps['order_no'] = ['like', '%' . $order . '%'];
            $data = $TemplateModel->where($maps)->select();
            foreach ($data as $k => $value) {
                $Populars = Db::name('template_content')->where('template_id', $value['template_id'])->field('paper_size_long,paper_size_wide,paper_size_unit,lable_size_wide,lable_size_height,lable_size_unit')->select();
                $data[$k]['paper_size_long'] = isset($Populars[0]['paper_size_long']) ? $Populars[0]['paper_size_long'] : '';
                $data[$k]['paper_size_wide'] = isset($Populars[0]['paper_size_wide']) ? $Populars[0]['paper_size_wide'] : '';
                $data[$k]['paper_size_unit'] = isset($Populars[0]['paper_size_unit']) ? $Populars[0]['paper_size_unit'] : '';
                $data[$k]['lable_size_wide'] = isset($Populars[0]['lable_size_wide']) ? $Populars[0]['lable_size_wide'] : '';
                $data[$k]['lable_size_height'] = isset($Populars[0]['lable_size_height']) ? $Populars[0]['lable_size_height'] : '';
                $data[$k]['lable_size_unit'] = isset($Populars[0]['lable_size_unit']) ? $Populars[0]['lable_size_unit'] : '';
            }
            if (empty($data)) {
                $data = [
                    'Status' => 1,
                    'code' => 200,
                    'msg' => '没有数据'
                ];
                return json($data);
            }
            return json($data);
        }
    }

    /**
     * 市区保存
     */
    public function shi()
    {
        $param = $this->request->post();
        $shi = Db::name('region')
            ->where('area_parent_id', isset($param['shi']['area_code']) ? $param['shi']['area_code'] : $param['shi'])
            ->field('area_name,area_code')
            ->select();
        return json($shi);
    }

    /**
     *  保存用户信息
     */
    public function save()
    {
        $id = Session::get('memberid');
        $data = $this->request->param();

        $data['pwd'] = isset($data['pwd']) ? intval($data['pwd']) : 0;
        $data['title'] = isset($data['title']) ? htmlspecialchars($data['title']) : 0;
        $data['sheng'] = isset($data['sheng']) ? $data['sheng'] : '';
        $datas = array();
        $request = Request::instance();
        $file = $request->file('img');
        if ($file) {
            $info = $file->validate([
                'size' => 9048576,
                'ext' => 'jpeg,jpg,png,bmp'
            ])->move('home/uploads/');
            if ($info) {
                $datas['img'] = $info->getSaveName();//头像
            } else {
                $this->error($file->getError());
            }
        }
        if ($data['password']) {
            $rule = ([
                'password|密码' => 'length:6,20|alphaNum',
            ]);
            $datapwd = [
                'password' => $data['password'],
            ];
            $validate = new Validate($rule);
            $result = $validate->check($datapwd);
            if (true !== $result) {
                $this->error($validate->getError());
            }

            $pwd = htmlspecialchars(md5($data['password']));
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
        if ($data['sheng']) {
            $datas['nation'] = 1;
            $datas['province'] = $data['sheng'];
            $datas['city'] = $data['city'];
            $datas['district'] = $data['qu'];
        }
            $datas['sex'] = $data['sex'];
        if (!empty($data['title'])) {
            $datas['industry_id'] = $data['title'];
        }
        $datas['update_time'] = time();
        $result = Db::name('member')->where('member_id', $id)->update($datas);
        if ($result == true) {
            $this->success('更新成功', '/index.php/member/userconter/index');
        }
        $this->success('更新成功', '/index.php/member/userconter/index');

    }

    /**
     *  订单
     */
    public function orders()
    {
        $data = Session::get('memberid');

        $member_id = isset($data) ? Session::get('memberid') : 0;
        if ($member_id) {
            $member = Db::name('order');
            $template = Db::name('template');
            $datas = $member->where('member_id', $member_id)->select();
            $data = array();
            foreach ($datas as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $data[] = $v;
            }

            $Ends = $member->where('member_id', $member_id)->where('order_status', 4)->select();//订单完成
            $End = array();
            foreach ($Ends as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $End[] = $v;
            }
            $desigends = $member->where('member_id', $member_id)->where('order_status', 3)->select();//设计结束
            $desigend = array();
            foreach ($desigends as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $desigend[] = $v;
            }
            $designs = $member->where('member_id', $member_id)->where('order_status', 2)->select();//设计中
            $design = array();
            foreach ($designs as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $design[] = $v;
            }
            $verifys = $member->where('member_id', $member_id)->where('order_status', 1)->select();//已核实
            $verify = array();
            foreach ($verifys as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $verify[] = $v;
            }
            $news = $member->where('member_id', $member_id)->where('order_status', 0)->select();//新提交
            $new = array();
            foreach ($news as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $new[] = $v;
            }
            if (!empty($data)) {
                $this->assign([
                    'orderdata' => $data,
                    'new' => $new,
                    'verify' => $verify,
                    'design' => $design,
                    'designend' => $desigend,
                    'End' => $End
                ]);

            }
        } else {
            $this->error('错误');
        }
    }

    /**
     * 模板详情
     */
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
        $templats_id = isset($param['template_id']) ? $param['template_id'] : 0;
        $member_id = isset($member_id) ? $member_id : 0;
        $data = Db::name('template')->where('template_id', $templats_id)->select();
        $data[0]['data_type'] = 1;
        $data[0]['member_id'] = $member_id;

        unset($data[0]['template_id']);
        $datas = $data[0];
        $datas['update_time'] = time();
        $datass = Db::name('template')->insertGetId($datas);
        //获取模板对应的内容
        $template_coontent = Db::name('template_content')->where('template_id', $templats_id)->find();
        unset($template_coontent['id']);
        $template_coontent['create_time'] = time();
        $template_coontent['template_id'] = $datass;

        $template_content_result = Db::name('template_content')->insert($template_coontent);

        if ($template_content_result) {
            $this->success('获取成功', '/index.php');
        } else {
            $this->error();
        }
    }

    public function orderdetails()
    {
        $param = $this->request->param();
        $orderid = isset($param['id']) ? $param['id'] : '';
        $data = Db::name('order')->where(['id' => $orderid])->select();
        $this->assign('data', $data);
        return $this->fetch();

    }

    /**
     * @内容
     */
    public function content()
    {
        $param = $this->request->param();
        $templateid = isset($param['templateid']) ? $param['templateid'] : 0;
        if (empty($templateid)) {
            $this->error('请求出错');
        }
        $data = Db::name('template')->where('template_id', $templateid)->select();
        $content = Db::name('template_content')->where('template_id', $templateid)->select();
        $zhizhang = Db::name('paper')->select();
        $member_id = $data['0']['member_id'];
        $username = Db::name('member')->where('member_id', $member_id)->field('username')->find();
        $this->assign('username', $username);
        $this->assign('content', $content);
        $this->assign('data', $data);
        $this->assign('zhizhang', $zhizhang);
        return $this->fetch();
    }

    /**
     * @获取订单
     */
    public function sub()
    {
        $param = $this->request->param();
        $paper = isset($param['type']) ? $param['type'] : 0;
        $mumber = intval(isset($param['number']) ? trim($param['number']) : 0);
        $cmtype = isset($param['cmtype']) ? htmlspecialchars($param['cmtype']) : 0;
        $tempid = intval(isset($param['tempid']) ? trim($param['tempid']) : 0);
        $paperdata = Db::name('paper')->where('id', $paper)->select();
        $username = htmlspecialchars(isset($param['username']) ? $param['username'] : 0);
        $tempdata = Db::name('template_content')->where('template_id', $tempid)->select();
        $temptadata = Db::name('template')->where('template_id', $tempid)->select();
        if (!empty($paperdata)) {
            $price = $paperdata[0]['price'];
            $atm = $mumber * $price;//支付金额
            foreach ($temptadata as $k => $v) {
                $data['template_title'] = $v['title'];
                $data['img'] = $v['img'];

            }
            $data['order_no'] = date("d") . date("his") . mt_rand(10000, 99999);//订单号
            foreach ($tempdata as $k => $v) {
                $data['template_id'] = $v['template_id'];
                $data['paper_size_long'] = $v['paper_size_long'];
                $data['paper_size_wide'] = $v['paper_size_wide'];
                $data['paper_size_unit'] = $v['paper_size_unit'];
                $data['paper_direction'] = $v['paper_direction'];

            }
            $data['print_num'] = $mumber;
            $data['price'] = $atm;
            $memberid = $temptadata[0]['member_id'];
            $memberdata = Db::name('member')->where('member_id', $memberid)->select();

            foreach ($memberdata as $k => $v) {
                $data['member_id'] = $v['member_id'];
                $data['name'] = $v['real_name'];
                $data['email'] = $v['email'];
                $data['moblie'] = $v['mobile'];
            }
            $data['score_pay'] = $atm;
            $data['score_real_pay'] = $atm;
            $data['create_time'] = time();
            $data['username'] = $username;
            $this->assign('data', $data);
            return $this->fetch();
        } else {
            $paperdata = Db::name('paper')->where('id', $paper)->select();
            $tempdata = Db::name('template_content')->where('template_id', $tempid)->select();
            $temptadata = Db::name('template')->where('template_id', $tempid)->select();
            foreach ($temptadata as $k => $v) {
                $data['template_title'] = $v['title'];

            }
            $data['order_no'] = date("d") . date("his") . mt_rand(10000, 99999);
            foreach ($tempdata as $k => $v) {
                $data['paper_size_long'] = $v['paper_size_long'];
                $data['paper_size_wide'] = $v['paper_size_wide'];
                $data['paper_size_unit'] = $v['paper_size_unit'];
                $data['paper_direction'] = $v['paper_direction'];

            }
            $data['print_num'] = $mumber;
            $data['username'] = $username;
            $memberid = $temptadata[0]['member_id'];
            $memberdata = Db::name('member')->where('member_id', $memberid)->select();
            foreach ($memberdata as $k => $v) {
                $data['name'] = $v['real_name'];
                $data['email'] = $v['email'];
                $data['moblie'] = $v['mobile'];
            }
            $data['create_time'] = time();
            $data = Db::name('order')->insert($data);

            if ($data) {
                $this->success('提交成功', '/index.php/member/userconter/orders');
            } else {
                $this->error('提交失败请检查');
            }
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
        $tempalte_id = isset($param['template_id']) ? $param['template_id'] : 0;
        if (!empty($tempalte_id)) {
            $Modeorder = Db::name('order');
            $param['pay_status'] = 0;
            $data = $Modeorder->insert($param);
            if ($data) {
                $this->success('取消支付成功', '/index.php/member/userconter/orders');
            } else {
                $this->error('取消失败', '/index.php/member/userconter/orders');
            }
        }
    }

}