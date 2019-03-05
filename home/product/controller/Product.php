<?php
namespace app\product\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-产品信息类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Product.php 2018-10-08 19:32:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\model;
use app\common\controller\CommonBase;
class Product extends CommonBase
{
    /**
     * @描述：产品信息接口
     */
    public function index(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        $gettime=time();

        $code=1;
        if(empty($product_code_info_id)
        ){
            //echo "数据错误！";
            $code=0;
        }

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();

        if($code==1){
            $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
                ->find();
            if(empty($getoneProductCodeInfo)){
                $code=0;
            }
        }

        if($code==1){
            //查询产品码是否真的
            $getoneProductCode=$ModelProductCode->where("product_code_id='$getoneProductCodeInfo[product_code_id]' ")
                ->find();
            if(empty($getoneProductCode)){
                $code=0;
            }
        }
        if($code==1){
            //查询产品信息
            $getoneProduct=$ModelProduct->where("product_id='$getoneProductCode[product_id]'")->find();
            if(empty($getoneProduct)){
                $code=0;
            }else {
                if(!empty($getoneProduct['images'])) {
                    $_arr = explode('.', $getoneProduct['images']);
                    $getoneProduct['images'] = $_arr[0] . config('upload_config.thumb_mobile_name') . '.' . $_arr[1];
                }
            }
        }

        if($code==1) {
            //查询产品内容信息
            $listProductContent = $ModelProductContent->where("product_id='$getoneProductCode[product_id]' AND data_status=1")
                ->order('data_sort ASC,create_time ASC')
                ->select();
        }

        //查询网站配置信息
        $getoneWebConfig=$ModelWebConfig->where("data_status='1'")
            ->order("id DESC")
            ->find();
        $this->assign('getoneWebConfig',$getoneWebConfig);

        //echo json_encode($param);exit;
        $this->assign('param',$param);
        $this->assign('code',$code);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('listProductContent',$listProductContent);
        $this->assign('getoneProductCode',$getoneProductCode);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        $this->assign('sn',my_returnUUID());
        return $this->fetch();
    }

    /*======================西红柿模版 begin=======================*/
    //region description
    /**
     * @描述：生产流程
     */
    public function sclc(){
        return $this->fetch();
    }

    /**
     * @描述：成长日记
     */
    public function rili(){
        return $this->fetch();
    }

    /**
     * @描述：生长期图片
     */
    public function shengzhangqi(){
        return $this->fetch();
    }

    /**
     * @描述：检测信息
     */
    public function jiance(){
        return $this->fetch();
    }

    /**
     * @描述：肥料使用表
     */
    public function feiliao(){
        return $this->fetch();
    }

    /**
     * @描述：农药使用表
     */
    public function nongyao(){
        return $this->fetch();
    }

    /**
     * @描述：仿伪查询
     */
    public function fwsearch(){

        $param = $this->request->param();
        $code_id=isset($param['code_id']) ? htmlentities(trim($param['code_id'])) : '';
        $fw_code=isset($param['fw_code']) ? htmlentities(trim($param['fw_code'])) : '';
        if(empty($code_id) or empty($fw_code)){
            echo "数据错误！";
            exit;
        }
        $ModelProductCodeInfo=Db::name('product_code_info');
        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_id='$code_id' AND code_cipher='$fw_code'")->find();

        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        return $this->fetch();
    }
    //endregion
    /*======================西红柿模版 end=======================*/

    /*======================啤酒模版 begin=======================*/
    //region description
    /**
     * @描述：真伪
     */
    public function beer_fangwei(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}
        $gettime=time();

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');
        $ModelProductCodeInfoQueryRecord=Db::name('product_code_info_query_record');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();
        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //增加查询信息
        $dataProductCodeInfoQueryRecord=array('product_code_info_id'=>$getoneProductCodeInfo['product_code_info_id'],
            'product_code_id'=>$getoneProductCodeInfo['product_code_id'],
            'product_id'=>$getoneProductCodeInfo['product_id'],
            'code_cipher'=>$getoneProductCodeInfo['code_cipher'],
            'query_address'=>'',
            'query_client'=>my_getClentType(),
            'query_weburl'=>$_SERVER['REMOTE_ADDR'],
            'query_system'=>my_GetOs(),
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );
        $ModelProductCodeInfoQueryRecord->insert($dataProductCodeInfoQueryRecord);
        //查询是否是首次查询
        $countProductCodeInfoQueryRecord=$ModelProductCodeInfoQueryRecord->where("product_code_info_id='$product_code_info_id'")->count();
        if($countProductCodeInfoQueryRecord < 2){
            //更新sy_product_code_info 产品码详细表，首次查询信息
            $dataProductCodeInfo=array('code_cipher_query_time'=>$gettime,
                'update_time'=>$gettime,);
            $ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id'")->update($dataProductCodeInfo);
        }
        //更新sy_product_code_info 产品码详细表，总的查询次数
        $ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id'")->setInc('code_cipher_query_total',1);
        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();
        //取得首次查询信息
        $getoneProductCodeInfoQueryRecord=$ModelProductCodeInfoQueryRecord->where("product_code_info_id='$product_code_info_id'")
            ->order("create_time ASC")
            ->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        $this->assign('getoneProductCodeInfoQueryRecord',$getoneProductCodeInfoQueryRecord);
        return $this->fetch('fanwgei');
    }

    /**
     * @描述：溯源
     */
    public function beer_suyuan(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}
        $gettime=time();

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');
        $ModelProductCodeInfoQueryRecord=Db::name('product_code_info_query_record');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();
        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        return $this->fetch('suyuan');
    }

    /**
     * @描述：售后
     */
    public function beer_shouhou(){
        return $this->fetch('shouhou');
    }
    //endregion
    /*======================啤酒模版 end=======================*/

    /*======================稻花香大米 begin=======================*/
    //region description
    /**
     * @描述：三方检测
     */
    public function rice_jiance(){
        return $this->fetch('jiance');
    }

    /**
     * @描述：公司简介
     */
    public function rice_jianjie(){
        return $this->fetch('jianjie');
    }

    /**
     * @描述：产品信息
     */
    public function rice_product(){
        return $this->fetch('product');
    }

    /**
     * @描述：全程溯源
     */
    public function rice_zhuisu(){
        return $this->fetch('zhuisu');
    }
    //endregion
    /*======================稻花香大米 end=======================*/

    /*======================蛋糕 begin=======================*/
    //region description
    /**
     * @描述：防伪
     */
    public function cake_fangwei(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}
        $gettime=time();

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');
        $ModelProductCodeInfoQueryRecord=Db::name('product_code_info_query_record');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();
        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //增加查询信息
        $dataProductCodeInfoQueryRecord=array('product_code_info_id'=>$getoneProductCodeInfo['product_code_info_id'],
            'product_code_id'=>$getoneProductCodeInfo['product_code_id'],
            'product_id'=>$getoneProductCodeInfo['product_id'],
            'code_cipher'=>$getoneProductCodeInfo['code_cipher'],
            'query_address'=>'',
            'query_client'=>my_getClentType(),
            'query_weburl'=>$_SERVER['REMOTE_ADDR'],
            'query_system'=>my_GetOs(),
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );
        $ModelProductCodeInfoQueryRecord->insert($dataProductCodeInfoQueryRecord);
        //查询是否是首次查询
        $countProductCodeInfoQueryRecord=$ModelProductCodeInfoQueryRecord->where("product_code_info_id='$product_code_info_id'")->count();
        if($countProductCodeInfoQueryRecord < 2){
            //更新sy_product_code_info 产品码详细表，首次查询信息
            $dataProductCodeInfo=array('code_cipher_query_time'=>$gettime,
                'update_time'=>$gettime,);
            $ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id'")->update($dataProductCodeInfo);
        }
        //更新sy_product_code_info 产品码详细表，总的查询次数
        $ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id'")->setInc('code_cipher_query_total',1);
        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();
        //取得首次查询信息
        $getoneProductCodeInfoQueryRecord=$ModelProductCodeInfoQueryRecord->where("product_code_info_id='$product_code_info_id'")
            ->order("create_time ASC")
            ->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        $this->assign('getoneProductCodeInfoQueryRecord',$getoneProductCodeInfoQueryRecord);
        return $this->fetch('fangwei');
    }

    /**
     * @描述：全程溯源
     */
    public function cake_suyuan(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}
        $gettime=time();

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');
        $ModelProductCodeInfoQueryRecord=Db::name('product_code_info_query_record');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();
        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        return $this->fetch('suyuan');
    }
    //endregion
    /*======================蛋糕 end=======================*/

    /*======================海南贵妃芒 begin=======================*/
    //region description
    /**
     * @描述：防伪
     */
    public function mango_fertil(){
        return $this->fetch('fertil');
    }

    /**
     * @描述：防伪
     */
    public function mango_grow(){
        return $this->fetch('grow');
    }

    /**
     * @描述：防伪
     */
    public function mango_soil(){
        return $this->fetch('soil');
    }
    //endregion
    /*======================海南贵妃芒 end=======================*/

    /*======================碱地番茄 begin=======================*/
    //region description
    //endregion
    /*======================碱地番茄 end=======================*/

    /*======================百香果 begin=======================*/
    //region description
    /**
     * @描述：在线订购
     */
    public function passionfruit_buy(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();

        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        return $this->fetch('buy');
    }

    /**
     * @描述：温馨提示
     */
    public function passionfruit_notice(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();

        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        return $this->fetch('notice');
    }

    /**
     * @描述：全程溯源
     */
    public function passionfruit_orgin(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();

        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        return $this->fetch('orgin');
    }

    /**
     * @描述：产品信息
     */
    public function passionfruit_product(){
        $param = $this->request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(empty($product_code_info_id)){echo 'paramer error!'; exit;}

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelWebConfig=Db::name('web_config');

        $getoneProductCodeInfo=$getoneProductCode=$getoneProduct=$listProductContent=array();

        $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_info_id='$product_code_info_id' AND data_status=1 ")
            ->find();
        //查询产品信息
        $getoneProduct=$ModelProduct->where("product_id='$getoneProductCodeInfo[product_id]'")->find();

        $this->assign('param',$param);
        $this->assign('getoneProduct',$getoneProduct);
        $this->assign('getoneProductCodeInfo',$getoneProductCodeInfo);
        return $this->fetch('product');
    }
    //endregion
    /*======================百香果 end=======================*/

    /*======================橙子 begin=======================*/
    /*======================橙子 end=======================*/

    /*======================除草剂 begin=======================*/
    /**
     * @描述：产品信息
     */
    public function herbicide_produce(){
        return $this->fetch('produce');
    }
    /**
     * @描述：公司介绍
     */
    public function herbicide_about(){
        return $this->fetch('about');
    }
    /**
     * @描述：联系我们
     */
    public function herbicide_us(){
        return $this->fetch('us');
    }
    /**
     * @描述：溯源信息
     */
    public function herbicide_xinxi(){
        return $this->fetch('xinxi');
    }
    /*======================除草剂 end=======================*/
}