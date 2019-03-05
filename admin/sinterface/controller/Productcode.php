<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20 0020
 * Time: 下午 10:41
 */

namespace app\sinterface\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\model;
use app\common\controller\CommonBaseHome;
class Productcode extends CommonBaseHome
{
    /**
     * @描述：产品码上传接口
     */
    public function insert(){
        $param = $this->request->post();
        $user_id=isset($param['user_id']) ? intval(trim($param['user_id'])) : 0;
        $template_id=isset($param['template_id']) ? htmlentities(trim($param['template_id'])) : '';
        $market_time=isset($param['market_time']) ? intval(trim($param['market_time'])) : 0;
        $product_code_num=isset($param['product_code_num']) ? intval(trim($param['product_code_num'])) : 0;
        $product_code_begin=isset($param['product_code_begin']) ? intval(trim($param['product_code_begin'])) : 0;
        $product_code_end=isset($param['product_code_end']) ? intval(trim($param['product_code_end'])) : 0;
        $create_time=isset($param['create_time']) ? intval(trim($param['create_time'])) : 0;
        $gettime=time();

        if(!$user_id  or empty($template_id)  or !$product_code_num
            or !$product_code_begin  or !$product_code_end or !$create_time
            or !$market_time
        ){
            echo $this->returnStrC('Fail');
            exit;
        }

        $ModelProductCode=Db::name('product_code');
        $ModelTemplate=Db::name('product');

        $getoneTemplate=$ModelTemplate->where("product_id='$template_id'")->find();
        if(empty($getoneTemplate)){
            echo $this->returnStrC('Fail');
            exit;
        }

        $dataProductCode=array('product_code_id'=>my_returnUUID(),
            'product_id'=>$template_id,
            'title'=>$getoneTemplate['title'],
            'market_time'=>$market_time,
            'product_code_begin'=>$product_code_begin,
            'product_code_end'=>$product_code_end,
            'product_code_num'=>$product_code_num,
            'admin_id'=>$user_id,
            'data_type'=>2,
            'create_time'=>$create_time,
            'update_time'=>$gettime,
            );

        $returnID=$ModelProductCode->insert($dataProductCode);
        if($returnID){
            echo $this->returnStrC('Success');
            exit;
        }else{
            echo $this->returnStrC('Fail');
            exit;
        }
    }
}