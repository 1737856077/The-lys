<?php
namespace app\product\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品-溯源统计
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Productvisit.php 2019-02-17 11:01:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonBase;
class Productvisit extends CommonBase
{
    /**
     * @desc：产品-溯源统计列表
     */
    public function index(){
        $param = $this->request->param();
        $product_id=isset($param['product_id']) ? htmlspecialchars($param['product_id']) : '' ;
        if(empty($product_id)){echo 'paramer error!';exit;}

        $SearchProvinceID = isset($param['ProvinceID']) ? htmlspecialchars($param['ProvinceID']) : '';
        $SearchCityID = isset($param['CityID']) ? htmlspecialchars($param['CityID']) : '' ;
        $SearchDistrictID = isset($param['DistrictID']) ? htmlspecialchars($param['DistrictID']) : '' ;
        $this->assign("ProvinceID",$SearchProvinceID);
        $this->assign("CityID",$SearchCityID);
        $this->assign("DistrictID",$SearchDistrictID);

        $this->assign("param",$param);

        $ModelProduct=Db::name('product');
        $ModelAdmin=Db::name('admin');
        $ModelRegion=Db::name('region');
        $ModelProductCodeInfoVisitRecord=Db::name('product_code_info_visit_record');

        $getoneProduct=$ModelProduct->where("product_id='$product_id'")->find();
        $this->assign("getoneProduct",$getoneProduct);

        //搜索赋初值 begin
        $ProvinceIDHtml=$CityIDHtml=$DistrictIDHtml="";
        //省份
        $listProvince=$ModelRegion->where("data_status=1 AND area_parent_id='1'")
            ->order('id ASC')
            ->select();
        foreach($listProvince as $arr){
            $_SELECTED = $arr['area_code']==$SearchProvinceID ? "selected=\"selected\"" : "" ;
            $ProvinceIDHtml.="<option value=\"$arr[area_code]\" $_SELECTED >|-- $arr[area_name]</option>";
        }
        $this->assign("ProvinceIDHtml",$ProvinceIDHtml);

        //地级市
        $listCity=$ModelRegion->where("data_status=1 AND area_parent_id='$SearchProvinceID'")
            ->order('id ASC')
            ->select();
        foreach($listCity as $arr){
            $_SELECTED = $arr['area_code']==$SearchCityID ? "selected=\"selected\"" : "" ;
            $CityIDHtml.="<option value=\"$arr[area_code]\" $_SELECTED >|-- $arr[area_name]</option>";
        }
        $this->assign("CityIDHtml",$CityIDHtml);

        //区县
        $listDistrict=$ModelRegion->where("data_status=1 AND area_parent_id='$SearchCityID'")
            ->order('id ASC')
            ->select();
        foreach($listDistrict as $arr){
            $_SELECTED = $arr['area_code']==$SearchDistrictID ? "selected=\"selected\"" : "" ;
            $DistrictIDHtml.="<option value=\"$arr[area_code]\" $_SELECTED >|-- $arr[area_name]</option>";
        }
        $this->assign("DistrictIDHtml",$DistrictIDHtml);

        //搜索赋初值 end
        $_where="1";
        $_where.=" AND product_id='$product_id'";
        if($SearchProvinceID and $SearchCityID and $SearchDistrictID){
            $_where.=" AND district='$SearchDistrictID'";
        }else if($SearchProvinceID and $SearchCityID){
            $_where.=" AND city='$SearchCityID'";
        }else if($SearchProvinceID){
            $_where.=" AND province='$SearchCityID'";
        }
        if($_where=='1'){$_where='';}

        $list=$ModelProductCodeInfoVisitRecord->where($_where)
            ->group('province')
            ->select();
        $count=$ModelProductCodeInfoVisitRecord->where($_where)
            ->count();
        $_list=array();
        foreach ($list as $key=>$value){
            //统计
            $_count=$ModelProductCodeInfoVisitRecord->where("product_id='$product_id' AND province='$value[province]'")->count();
            $value['total']=$_count;
            $_list[]=$value;
        }

        //print_r($_list);exit;
        $this->assign("list",$_list);
        $this->assign("count",$count);
        return $this->fetch();
    }

    /**
     * @描述：查看溯源详细
     */
    public function info(){
        $param = $this->request->param();
        $product_id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        $province = isset($param['province']) ? htmlspecialchars($param['province']) : '';
        if(empty($product_id) or empty($province)){echo 'paramer error!';exit;}
        $this->assign("product_id",$product_id);
        $this->assign("province",urldecode($province));
        $this->assign("param",$param);

        $ModelProduct=Db::name('product');
        $ModelAdmin=Db::name('admin');
        $ModelRegion=Db::name('region');
        $ModelProductCodeInfoVisitRecord=Db::name('product_code_info_visit_record');

        $getoneProduct=$ModelProduct->where("product_id='$product_id'")->find();
        $this->assign("getoneProduct",$getoneProduct);

        $_where="1";
        if(!empty($product_id)){ $_where.=" AND product_id='$product_id'"; }
        if(!empty($province)){ $_where.=" AND province='".urldecode($province)."'"; }
        if($_where=='1'){$_where='';}

        $count = $ModelProductCodeInfoVisitRecord->where($_where)
            ->count();
        $list=$ModelProductCodeInfoVisitRecord->where($_where)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$list->render();

        $this->assign("count",$count);
        $this->assign("list",$list);
        $this->assign("page",$show);
        return $this->fetch();
    }


}