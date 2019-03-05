<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20 0020
 * Time: 下午 10:28
 */

namespace app\sinterface\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\model;
use app\common\controller\CommonBaseHome;
class Producttemplate extends CommonBaseHome
{
    /**
     * @描述：模版列表接口
     */
    public function template_list(){
        $param = $this->request->post();
        $user_id=isset($param['user_id']) ? intval(trim($param['user_id'])) : 0;

        if(!$user_id){
            echo $this->returnStrC('Fail');
            exit;
        }

        $ModelTemplate=Db::name('product');
        $listTemplate=$ModelTemplate->where("admin_id='$user_id' AND data_status='1'")
            ->order("create_time ASC")
            ->select();
        $_listTemplate=array();
        foreach ($listTemplate as $key=>$value){
            $_str=$value['product_id'].'|'.$value['title'];
            $_listTemplate[]=$_str;
        }
        $_listTemplate=implode(',',$_listTemplate);

        //echo $this->returnStrC(iconv('utf8','gb2312',$_listTemplate));
        echo $this->returnStrC($_listTemplate);
        exit;
    }
}