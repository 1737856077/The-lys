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
}