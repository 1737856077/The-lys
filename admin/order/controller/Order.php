<?php
namespace app\order\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @desc:业务员管理类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Salesman.php 2018-05-06 09:37:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonAdmin;
class Order extends CommonAdmin
{
    /**
     * @描述：列表页面
     */
    public function  index(){
        $param = $this->request->param();
        //查询
        $SearchTitle = isset($param['SearchTitle']) ? $param['SearchTitle'] : '' ;
        $SearchTitle=urldecode($SearchTitle);
        $SearchSex = isset($param['SearchSex']) ? $param['SearchSex'] : '' ;
        $SearchIsVip = isset($param['SearchIsVip']) ? $param['SearchIsVip'] : '' ;
        $SearchEmail = isset($param['SearchEmail']) ? $param['SearchEmail'] : '' ;
        $SearchEmail=urldecode($SearchEmail);
        $SearchMobile = isset($param['SearchMobile']) ? $param['SearchMobile'] : '' ;
        $SearchMobile=urldecode($SearchMobile);
        $SearchCompanyName = isset($param['SearchCompanyName']) ? $param['SearchCompanyName'] : '' ;
        $SearchCompanyName=urldecode($SearchCompanyName);
        $paramUrl='';
        $paramUrl.='SearchTitle='.$SearchTitle;
        $paramUrl.='&SearchSex='.$SearchSex;
        $paramUrl.='&SearchIsVip='.$SearchIsVip;
        $paramUrl.='&SearchEmail='.$SearchEmail;
        $paramUrl.='&SearchMobile='.$SearchMobile;
        $paramUrl.='&SearchCompanyName='.$SearchCompanyName;
        $this->assign("SearchTitle",$SearchTitle);
        $this->assign("SearchSex",$SearchSex);
        $this->assign("SearchIsVip",$SearchIsVip);
        $this->assign("SearchEmail",$SearchEmail);
        $this->assign("SearchMobile",$SearchMobile);
        $this->assign("SearchCompanyName",$SearchCompanyName);

        $ModelSalesman=Db::name('member');

        $_where="1";
        if(!empty($SearchTitle)){ $_where.=" AND username LIKE '%".urldecode($SearchTitle)."%'"; }
        if($SearchSex == '0' or $SearchSex == '1'){$_where.=" AND sex='$SearchSex'";}
        if($SearchIsVip == '0' or $SearchIsVip == '1'){$_where.=" AND is_vip='$SearchIsVip'";}
        if(!empty($SearchEmail)){ $_where.=" AND email LIKE '%".urldecode($SearchEmail)."%'"; }
        if(!empty($SearchMobile)){ $_where.=" AND mobile LIKE '%".urldecode($SearchMobile)."%'"; }
        if(!empty($SearchCompanyName)){ $_where.=" AND company_name LIKE '%".urldecode($SearchCompanyName)."%'"; }

        if($_where=='1'){$_where='';}
        $count = $ModelSalesman->where($_where)
            ->count();

        $resultArr=array();
        $List=$ModelSalesman->where($_where)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

        foreach($List as $key=>$arr){
            $resultArr[]=$arr;
        }

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }
}