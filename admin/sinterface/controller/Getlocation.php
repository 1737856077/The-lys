<?php
namespace app\sinterface\controller;
/**
 * @[溯源系统] kedousuyuan Information Technology Co., Ltd.
 * @desc:网站前台-取得用户的地理信息
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Getlocation.php 2019-01-21 18:35:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use app\common\controller\CommonBaseHome;
class Getlocation extends CommonBaseHome
{
    public function insert(){
        $param = $this->request->post();
        $sn=isset($param['getLoaction_sn']) ? htmlentities(trim($param['getLoaction_sn'])) : '';
        $product_code_info_id=isset($param['getLoaction_productCodeInfoId']) ? htmlentities(trim($param['getLoaction_productCodeInfoId'])) : '';
        $accuracy=isset($param['accuracy']) ? htmlentities(trim($param['accuracy'])) : '';
        $adcode=isset($param['adcode']) ? htmlentities(trim($param['adcode'])) : '';
        $addr=isset($param['addr']) ? htmlentities(trim($param['addr'])) : '';
        $nation=isset($param['nation']) ? htmlentities(trim($param['nation'])) : '';
        $province=isset($param['province']) ? htmlentities(trim($param['province'])) : '';
        $city=isset($param['city']) ? htmlentities(trim($param['city'])) : '';
        $district=isset($param['district']) ? htmlentities(trim($param['district'])) : '';
        $lat=isset($param['lat']) ? htmlentities(trim($param['lat'])) : '';
        $lng=isset($param['lng']) ? htmlentities(trim($param['lng'])) : '';
        $gettime=time();
        $is_listing_area=0;//是否窜货（0：否；1：是；）

        $result=['code'=>'0',
            'msg'=>'success'
        ];
        if(empty($sn) or empty($product_code_info_id) or empty($accuracy)
            or empty($adcode)
        ){
            $result['code']='40001';
            $result['msg']='Necessary items should not be blank';
            echo $this->returnJson($result);
            exit;
        }

        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelProductCodeInfoVisitRecord=Db::name('product_code_info_visit_record');

        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id'")->find();
        if(empty($getoneProductCodeInfo)){
            $result['code']='40002';
            $result['msg']='Parameter error';
            echo $this->returnJson($result);
            exit;
        }
        //查看是否重复提交
        $count=$ModelProductCodeInfoVisitRecord->where("sn='$sn'")->count();
        if($count){
            $result['code']='40004';
            $result['msg']='No duplicate submission';
            echo $this->returnJson($result);
            exit;
        }
        // 查看是否窜货
        $getoneProductCode=$ModelProductCode->where("product_code_id='$getoneProductCodeInfo[product_code_id]'")->find();
        // 区
        if(!empty($getoneProductCode['listing_district'])){
            if($getoneProductCode['listing_district']!=$adcode){
                $is_listing_area=1;
            }
        // 市
        }else if(!empty($getoneProductCode['listing_city'])){
            $listing_left = substr($getoneProductCode['listing_city'],0,4);
            $listing_right = substr($adcode,0,4);
            if($listing_left!=$listing_right){
                $is_listing_area=1;
            }
        //省
        }else if(!empty($getoneProductCode['listing_province'])){
            $listing_left = substr($getoneProductCode['listing_province'],0,2);
            $listing_right = substr($adcode,0,2);
            if($listing_left!=$listing_right){
                $is_listing_area=1;
            }
        // 国家
        }else if(!empty($getoneProductCode['listing_nation'])){
            $listing_left = substr($getoneProductCode['listing_nation'],0,1);
            $listing_right = substr($adcode,0,1);
            if($listing_left!=$listing_right){
                $is_listing_area=1;
            }
        }

        $data=array('product_code_info_id'=>$product_code_info_id,
            'product_code_id'=>$getoneProductCodeInfo['product_code_id'],
            'product_id'=>$getoneProductCodeInfo['product_id'],
            'accuracy'=>$accuracy,
            'adcode'=>$adcode,
            'addr'=>$addr,
            'nation'=>$nation,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'lat'=>$lat,
            'lng'=>$lng,
            'sn'=>$sn,
            'is_listing_area'=>$is_listing_area,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );
        $returnID=$ModelProductCodeInfoVisitRecord->insert($data,true);
        // 更新统计查询次数code_cipher_query_time
		// 屏掉暗码查询统计
        //$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND code_cipher_query_time=0")->update(array('code_cipher_query_time'=>time()));
        //$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id'")->setInc('code_cipher_query_total',1);
		// 改到了Product.php控制器中统计
		//$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND code_plain_query_time=0")->update(array('code_plain_query_time'=>time()));
        //$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id'")->setInc('code_plain_query_total',1);
        if($returnID){
            echo $this->returnJson($result);
            exit;
        }else{
            $result['code']='40003';
            $result['msg']='Failed to add, please try again later';
            echo $this->returnJson($result);
            exit;
        }
    }
}