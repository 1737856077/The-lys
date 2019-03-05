<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20 0020
 * Time: 下午 10:58
 */

namespace app\sinterface\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\model;
use app\common\controller\CommonBaseHome;
class Product extends CommonBaseHome
{
    /**
     * @描述：产品信息接口
     */
    public function index(){
        $param = $this->request->param();
        $user_id=isset($param['user_id']) ? intval(trim($param['user_id'])) : 0;
        $product_code_id=isset($param['product_code_id']) ? htmlentities(trim($param['product_code_id'])) : '';
        $product_code_no=isset($param['product_code_no']) ? intval(trim($param['product_code_no'])) : 0;
        $gettime=time();

        $code=1;
        if(empty($product_code_id)  or !$product_code_no
        ){
            //echo "数据错误！";
            $code=0;
        }

        $ModelProduct=Db::name('product');
        $ModelProductContent=Db::name('product_content');
        $ModelProductCode=Db::name('product_code');
        $ModelWebConfig=Db::name('web_config');
        $ModelProductCodeInfo=Db::name('product_code_info');

        $getoneProduct=$listProductContent=array();

        $getoneProductCode=array();
        //查询产品二维码是否开启
        if($code==1) {
            $getoneProductCodeInfo=$ModelProductCodeInfo->where("product_code_id='$product_code_id' AND code_plain='$product_code_no' AND data_status=1 ")
                ->find();
            if(empty($getoneProductCodeInfo)){
                $code=0;
            }
        }
        if($code==1){
            //查询产品码是否真的
            $getoneProductCode=$ModelProductCode->where("product_code_id='$product_code_id' AND ($product_code_no BETWEEN product_code_begin AND product_code_end)")
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
        return $this->fetch();
    }
}