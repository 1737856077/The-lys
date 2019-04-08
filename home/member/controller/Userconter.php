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
        $region = Db::name('region')->where('area_type', 2)->field('area_name,area_code')->select();
        $DistrictModel = Db::name('region');
        $Place = $DistrictModel->where('area_code', $data[0]['district'])->field('area_name,area_parent_id')->find();
        $si = $DistrictModel->where('area_code', $Place['area_parent_id'])->field('area_name,area_parent_id')->find();
        $s = $DistrictModel->where('area_code', $si['area_parent_id'])->field('area_name,area_parent_id')->find();
        $Place = $s['area_name'] . "-" . $si['area_name'] . "-" . $Place['area_name'];
        $this->assign([
            "place" => $Place,
            'data' => $data,
            'industry' => $industry,
            'title' => $title,
            'region' => $region,

        ]);
        return $this->fetch();
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
            ])->move("static/uploads/");

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
        $member_id = Session::get('memberid');
        Session::delete('userimg');
        $MemberData = Db::name('member')->where('member_id', $member_id)->find();
        Session::set('userimg', $MemberData['img']);
        if ($result == true) {
            $this->success('更新成功', '/index.php/member/userconter/index');
        }
        $this->success('更新成功', '/index.php/member/userconter/index');

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

    /**
     * @desc:用户中心-左侧菜单
     */
    public function menu()
    {
        return $this->fetch();
    }

}