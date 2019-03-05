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
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );
        $returnID=$ModelProductCodeInfoVisitRecord->insert($data);
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