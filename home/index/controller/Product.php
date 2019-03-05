<?php
namespace app\index\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-产品信息类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Product.php 2018-07-22 19:32:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\model;
use think\Session;
use app\common\controller\CommonBaseHome;
class Product extends CommonBaseHome
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
            $getoneProductCodeInfo=$ModelProductCodeInfo->where("(product_code_info_id='$product_code_info_id' OR compress_code='$product_code_info_id') AND data_status=1 ")
                ->find();
            if(empty($getoneProductCodeInfo)){
                $code=0;
            }else{
                $product_code_info_id = isset($getoneProductCodeInfo['product_code_info_id']) ? $getoneProductCodeInfo['product_code_info_id'] : $product_code_info_id;
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
                //取得产品模版的code
                $getone_product_template=Db::name('product_template')->where("product_template_id='$getoneProduct[product_template_id]'")
                    ->find();
                //将产品模版信息存入SESSION
                Session::set('construct_tpl', $getone_product_template['tag_title']);
                //跳转进入中转处理
                $this->redirect('/index.php/product/product/index?code_info_id='.$product_code_info_id);
                if(!empty($getoneProduct['images'])) {
                    $_arr = explode('.', $getoneProduct['images']);
                    $getoneProduct['images'] = $_arr[0] . config('upload_config.thumb_mobile_name') . '.' . $_arr[1];
                }
            }
        }

        if($code==1) {
            //查询产品内容信息
            $listProductContent = $ModelProductContent->where("product_id='$getoneProductCode[product_id]'")
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
}