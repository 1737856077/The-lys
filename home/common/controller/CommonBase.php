<?php
namespace app\common\controller;
/**
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:CommonBase.php 2018-03-26 14:18:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use think\Image;
use think\Session;
class CommonBase extends Controller
{

    public function __construct(Request $request){
        config('template.view_path',APP_PATH. $request->module().DS. 'view'.DS);
        //判断是否需要动态加载模版
        $param = $request->param();
        $product_code_info_id=isset($param['code_info_id']) ? htmlentities(trim($param['code_info_id'])) : '';
        if(!empty($product_code_info_id)){
            $getoneProductCodeInfo=Db::name('product_code_info')->where("(product_code_info_id='$product_code_info_id' OR compress_code='$product_code_info_id') AND data_status=1 ")
                ->find();
            if(!empty($getoneProductCodeInfo)){
                //查询产品信息
                $getoneProduct=Db::name('product')->where("product_id='$getoneProductCodeInfo[product_id]'")->find();
                if(!empty($getoneProductCodeInfo)){
                    //取得产品模版的code
                    $getone_product_template=Db::name('product_template')->where("product_template_id='$getoneProduct[product_template_id]'")
                        ->find();
                    if(!empty($getoneProductCodeInfo)){
                        config('template.view_path',APP_PATH. $request->module().DS. $getone_product_template['tag_title'].DS);
                    }
                }
            }
        }
        //echo '['.APP_PATH.']';
//        if(Session::has('construct_tpl') and !empty(Session::get('construct_tpl'))){
//            //config('template.view_path',APP_PATH. DS .$request->module().DS. 'mobile'.DS);
//            config('template.view_path',APP_PATH. $request->module().DS. trim(Session::get('construct_tpl')).DS);
//        }else{
//            //config('template.view_path',APP_PATH. DS .$request->module().DS. 'mobile'.DS);
//            config('template.view_path',APP_PATH. $request->module().DS. 'view'.DS);
//        }
        parent::__construct($request);
    }

    /**
     * @描述：初始化函数
     */
    public function  _initialize(){
        //查询网站配置信息
        $ModelWebConfigComm=Db::name('web_config');
        $getoneWebConfigComm=$ModelWebConfigComm->where("data_status='1'")
            ->order("id DESC")
            ->find();
        $this->assign('getoneWebConfigComm',$getoneWebConfigComm);
    }

    public function returnStrC($str){
        $ConfigDataCInterface=\think\Config::get('data.c_interface');
        return $ConfigDataCInterface['begin_str'].$str.$ConfigDataCInterface['end_str'];
    }
}