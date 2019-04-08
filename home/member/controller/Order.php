<?php

namespace app\member\controller;
/**
 * Created by PhpStorm.
 * User: Edianzu
 * Date: 2019/4/7
 * Time: 15:45
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

class Order extends CommonBase
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
     * @desc:订单中心
     */
    public function index()
    {

        $id = Session::get('memberid');
        $data = Db::name('member')->where('member_id', $id)->select();
        $this->assign([
            'data' => $data
        ]);
        $this->orders();
        return $this->fetch();
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

        //查询模板图片


        if (!empty($data)) {
            $template = Db::name('template');
            $datas = array();
            foreach ($data as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $datas[] = $v;
            }echo 1;
            $this->assign('orderdata', $datas);
            return $this->fetch('index');
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
            $template = Db::name('template');
            $datas = array();
            foreach ($data as $k => $v) {
                $v['img'] = $template->where('template_id', $v['id'])->field('img')->find()['img'];
                $datas[] = $v;
            }
            $this->assign('orderdata', $datas);
            return $this->fetch('index');
        }
    }
}