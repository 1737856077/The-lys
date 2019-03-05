<?php
namespace app\qrcode\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:二维码统计类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Qrreport.php 2018-09-24 19:19:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonBase;
class Qrreport extends CommonBase
{
    /**
     * @描述：统计主界面
     */
    public function  index(){
        $param = $this->request->param();
        //查询
        $SearchTitle = isset($param['SearchTitle']) ? trim(htmlspecialchars(urldecode($param['SearchTitle']))) : '' ;
        $paramUrl='';
        $paramUrl.='SearchTitle='.$SearchTitle;
        $this->assign("SearchTitle",$SearchTitle);

        $ModelAdmin=Db::name('admin');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');

        //加入权限 begin
        $_whereIn=[];
        //商家管理员
        if(Session::get('admin_data_type')=='2') {
            $_whereIn['admin_id']=['in', $this->CommBusinesIDs];
        }
        //业务员
        if(Session::get('admin_data_type')=='1' and Session::get('admin_role_id')=='2'){
            $_whereIn['admin_id']=['in', $this->CommBusinesIDs];
        }
        //加入权限 end
        $_where="data_type=2";
        if(!empty($SearchTitle)){
            $_where .= " AND name LIKE '%".urldecode($SearchTitle)."%' ";
        }
        if($_where=='1'){$_where='';}
        $count = $ModelAdmin->where($_where)
            ->where($_whereIn)
            ->count();
        $resultArr=array();
        $list=$ModelAdmin->where($_where)
            ->where($_whereIn)
            ->order('admin_id ASC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$list->render();
        foreach($list as $key=>$value){
            //总二维码
            $countQrTotal=$ModelProductCodeInfo->where("admin_id='$value[admin_id]'")->count();
            $value['countQrTotal']=$countQrTotal;
            //已激活二维码
            $countQrTotalYJH=$ModelProductCodeInfo->where("admin_id='$value[admin_id]' AND data_status=1")->count();
            $value['countQrTotalYJH']=$countQrTotalYJH;
            //未激活二维码
            $countQrTotalWJH=$ModelProductCodeInfo->where("admin_id='$value[admin_id]' AND data_status=0")->count();
            $value['countQrTotalWJH']=$countQrTotalWJH;
            $resultArr[]=$value;
        }
        $this->assign("count",$count);
        $this->assign("list",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }

    /**
     * @描述：统计详细页面
     */
    public function  productlist(){
        $param = $this->request->param();
        //查询
        $admin_id = isset($param['admin_id']) ? trim(htmlspecialchars(urldecode($param['admin_id']))) : 0 ;
        $SearchTitle = isset($param['SearchTitle']) ? trim(htmlspecialchars(urldecode($param['SearchTitle']))) : '' ;
        $search_create_begin = isset($param['search_create_begin']) ? trim(htmlspecialchars(urldecode($param['search_create_begin']))) : '' ;
        $search_create_end = isset($param['search_create_end']) ? trim(htmlspecialchars(urldecode($param['search_create_end']))) : '' ;
        $search_qr_open_begin = isset($param['search_qr_open_begin']) ? trim(htmlspecialchars(urldecode($param['search_qr_open_begin']))) : '' ;
        $search_qr_open_end = isset($param['search_qr_open_end']) ? trim(htmlspecialchars(urldecode($param['search_qr_open_end']))) : '' ;
        $paramUrl='';
        $paramUrl.='SearchTitle='.$SearchTitle;
        $paramUrl.='&search_create_begin='.$search_create_begin;
        $paramUrl.='&search_create_end='.$search_create_end;
        $paramUrl.='&search_qr_open_begin='.$search_qr_open_begin;
        $paramUrl.='&search_qr_open_end='.$search_qr_open_end;
        $this->assign("SearchTitle",$SearchTitle);
        $this->assign("search_create_begin",$search_create_begin);
        $this->assign("search_create_end",$search_create_end);
        $this->assign("search_qr_open_begin",$search_qr_open_begin);
        $this->assign("search_qr_open_end",$search_qr_open_end);

        $ModelAdmin=Db::name('admin');
        $ModelProduct=Db::name('product');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');

        //查询商家信息
        if(!$admin_id){echo 'paramer error!';exit;}
        $getoneAdmin=$ModelAdmin->where("admin_id='$admin_id'")->find();
        $this->assign("getoneAdmin",$getoneAdmin);

        $_where="1";
        $_whereCodeInfo="1";
        if(!empty($SearchTitle)){
            $_where .= " AND title LIKE '%".urldecode($SearchTitle)."%'";
        }
        //二维码生产日期
        if(!empty($search_create_begin) and !empty($search_create_end)){
            $_whereCodeInfo.=" AND (create_time BETWEEN ".strtotime($search_create_begin.' 00:00:00')." AND ".strtotime($search_create_end.' 23:59:59').")";
        }
        //二维码激活日期
        if(!empty($search_qr_open_begin) and !empty($search_qr_open_end)){
            $_whereCodeInfo.=" AND (qr_open_time BETWEEN ".strtotime($search_qr_open_begin.' 00:00:00')." AND ".strtotime($search_qr_open_end.' 23:59:59').")";
        }

        if($_where=='1'){$_where='';}
        if($_whereCodeInfo=='1'){$_whereCodeInfo='';}
        $count = $ModelProduct->where($_where)
            ->count();
        $resultArr=array();
        $list=$ModelProduct->where($_where)
            ->order('data_status DESC,id ASC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$list->render();
        foreach($list as $key=>$value){
            //总二维码
            $countQrTotal=$ModelProductCodeInfo->where("product_id='$value[product_id]'")
                ->where($_whereCodeInfo)
                ->count();
            $value['countQrTotal']=$countQrTotal;
            //已激活二维码
            $countQrTotalYJH=$ModelProductCodeInfo->where("product_id='$value[product_id]' AND data_status=1")
                ->where($_whereCodeInfo)
                ->count();
            $value['countQrTotalYJH']=$countQrTotalYJH;
            //未激活二维码
            $countQrTotalWJH=$ModelProductCodeInfo->where("product_id='$value[product_id]' AND data_status=0")
                ->where($_whereCodeInfo)
                ->count();
            $value['countQrTotalWJH']=$countQrTotalWJH;
            $resultArr[]=$value;
        }
        $this->assign("count",$count);
        $this->assign("list",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }
}