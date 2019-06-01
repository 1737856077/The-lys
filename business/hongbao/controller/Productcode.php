<?php
namespace app\hongbao\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品码类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Productcode.php 2018-07-07 00:16:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\common\controller\CommonBase;
class Productcode extends CommonBase
{
    /**
     * @描述：信息列表页面
     */
    public function  index(){
        $id = Session::get('adminid');
        $param = $this->request->param();
        //查询
        $SearchTitle = isset($param['SearchTitle']) ? trim(htmlspecialchars(urldecode($param['SearchTitle']))) : '' ;
        $paramUrl='';
        $paramUrl.='SearchTitle='.$SearchTitle;
        $this->assign("SearchTitle",$SearchTitle);

        $ModelProduct=Db::name('product');
        $ModelProductCode=Db::name('product_code');
        $ModelAdmin=Db::name('admin');

        //加入权限 begin
        $_whereIn=[];
        //商家管理员
        if(Session::get('admin_data_type')=='2') {
            $_whereIn['admin_id']=['in', $this->CommBusinesIDs];
        }
        //业务员
        if(Session::get('admin_data_type')=='1' and Session::get('admin_role_id')=='2'){
            $_whereIn['admin_id']=['in', $this->CommBusinesIDs];
        }
        //加入权限 end
        $_where="1";
        if(!empty($SearchTitle)){
            $listProduct=$ModelProduct->where(" title LIKE '%".urldecode($SearchTitle)."%'")->select();
            $ProductIDS=array();
            foreach ($listProduct as $k=>$v){
                $ProductIDS[]=$v['product_id'];
            }
            if(count($ProductIDS)){
                $_where .= " AND product_id IN('".implode("','",$ProductIDS)."') ";
            }else {
                $_where .= " AND 0 ";
            }
        }

        if($_where=='1'){$_where='';}
        $count = $ModelProduct->where($_where)
            ->where($_whereIn)
            ->count();

        $resultArr=array();
        $List=$ModelProductCode->where($_where)
            ->where($_whereIn)
            ->where('admin_id',$id)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

        foreach($List as $key=>$value){
            //模版名称
            $getoneProduct=$ModelProduct->where("product_id='$value[product_id]'")->find();
            $value["product_title"]=$getoneProduct['title'];

            //公司名称
            $getoneAdmin=$ModelAdmin->where("admin_id='$value[admin_id]'")->find();
            $value["admin_name"]=$getoneAdmin['name'];

            $resultArr[]=$value;
        }

        $this->assign("count",$count);
        $this->assign("List",$resultArr);
        $this->assign("page",$show);
        $this->assign('paramUrl',$paramUrl);
        return $this->fetch();
    }

    /**
     * @desc: 批量开启二维码
     */
    public function openqrcode(){
        $param = $this->request->param();
        $product_code_id = isset($param['product_code_id']) ? trim(htmlspecialchars(urldecode($param['product_code_id']))) : '' ;
        if(empty($product_code_id)){echo 'param error!';exit;}
        $gettime=time();

        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');

        $_data=array('data_status'=>'1',
            "qr_open_time"=>$gettime,
            "update_time"=>$gettime
        );
        // 开启事务
        Db::startTrans();
        $ModelProductCodeInfo->where("product_code_id='$product_code_id'")->update($_data);
        $ModelProductCode->where("product_code_id='$product_code_id'")->update(array('is_batch_open'=>'1','update_time'=>$gettime));
        Db::commit();//提交事务

        $this->success("操作成功", url("productcode/index"), 3);
    }

    /**
     * @描述：编辑
     */
    public function  edit(){
        $param = $this->request->param();
        $product_code_id = isset($param['product_code_id']) ? trim(htmlspecialchars(urldecode($param['product_code_id']))) : '' ;
        if(empty($product_code_id)){echo 'param error!';exit;}
        $gettime=time();

        $ModelProduct=Db::name('product');
        $ModelProductCode=Db::name('product_code');

        $getone=$ModelProductCode->where("product_code_id='$product_code_id'")->find();
        if(empty($getone) or $getone['is_batch_open']!='0'){
            echo 'param error!';exit;
        }
        $getoneProduct=$ModelProduct->where("product_id='$getone[product_id]'")->find();

        $this->assign("getone",$getone);
        $this->assign("getoneProduct",$getoneProduct);
        return $this->fetch();
    }

    /**
     * @desc : update
     */
    public function update(){
        $param = $this->request->post();
        $ModelProduct=Db::name('product');
        $ModelProductCode=Db::name('product_code');
        $ModelProductCodeInfo=Db::name('product_code_info');
        $ModelAdmin=Db::name('admin');

        $product_code_id=htmlspecialchars(isset($param['product_code_id']) ? trim($param['product_code_id']) : '');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $production_batch=htmlspecialchars(isset($param['production_batch']) ? trim($param['production_batch']) : '');
        $manufacture_date=isset($param['manufacture_date']) ? strtotime($param['manufacture_date']) : '0';
        $market_time=isset($param['market_time']) ? trim($param['market_time']) : date('Y-m-d');
        $business_enterprise=htmlspecialchars(isset($param['business_enterprise']) ? trim($param['business_enterprise']) : '');
        $contacts=htmlspecialchars(isset($param['contacts']) ? trim($param['contacts']) : '');
        $tel=htmlspecialchars(isset($param['tel']) ? trim($param['tel']) : '');
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $gettime=time();
        $market_time=strtotime($market_time);

        $getone=$ModelProductCode->where("product_code_id='$product_code_id'")->find();
        if(empty($title) or empty($getone) or $getone['is_batch_open']!='0'){
            echo 'param error!';exit;
        }

        $data=array(
            'title'=>$title,
            'production_batch'=>$production_batch,
            'manufacture_date'=>$manufacture_date,
            'market_time'=>$market_time,
            'business_enterprise'=>$business_enterprise,
            'contacts'=>$contacts,
            'tel'=>$tel,
            'data_desc'=>$data_desc,
            'update_time'=>$gettime
        );
        $ModelProductCode->where("product_code_id='$product_code_id'")->update($data);

        $this->success("操作成功", url("productcode/index"), 3);
    }
}