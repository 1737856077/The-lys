<?php
namespace app\product\controller;
/**
 * @[溯源系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:产品类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Template.php 2018-07-06 09:58:00 $
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Paginator;
use think\File;
use think\Image;
use \app\common\controller\CommonBase;
class Product extends CommonBase
{
    public function _initialize(){
        parent::_initialize();
        //查询产品模块信息
        $list_product_template=Db::name('product_template')->where("data_status=1")
            ->order("product_template_id ASC")
            ->select();
        $this->assign("list_product_template",$list_product_template);
    }
    /**
     * @描述：信息列表页面
     */
    public function  index(){
        $param = $this->request->param();
        //查询
        $SearchTitle = isset($param['SearchTitle']) ? trim(htmlspecialchars(urldecode($param['SearchTitle']))) : '' ;
        $SearchStatus = isset($param['SearchStatus']) ? htmlspecialchars(urldecode($param['SearchStatus'])) : '';
        $paramUrl='';
        $paramUrl.='SearchTitle='.$SearchTitle;
        $paramUrl.='&SearchStatus='.$SearchStatus;
        $this->assign("SearchTitle",$SearchTitle);
        $this->assign("SearchStatus",$SearchStatus);

        $ModelProduct=Db::name('product');
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
        if(!empty($SearchTitle)){ $_where.=" AND title LIKE '%".urldecode($SearchTitle)."%'"; }
        if($SearchStatus!=''){ $_where.=" AND data_status='$SearchStatus'"; }

        if($_where=='1'){$_where='';}
        $count = $ModelProduct->where($_where)
            ->where($_whereIn)
            ->count();

        $resultArr=array();
        $List=$ModelProduct->where($_where)
            ->where($_whereIn)
            ->order('create_time DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

        foreach($List as $key=>$value){
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
     * @描述：添加信息
     */
    public function add(){
        return $this->fetch();
    }

    /**
     * @描述：添加提交
     */
    public function insert(){
        $param = $this->request->post();
        $ModelProduct=Db::name('product');
        $ModelAdmin=Db::name('admin');

        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $IMAGES='';
        $data_status=htmlspecialchars(isset($param['data_status']) ? intval($param['data_status']) : 0);
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $product_template_id=htmlspecialchars(isset($param['product_template_id']) ? intval($param['product_template_id']) : 0);
        $gettime=time();
        $admin_id=Session::get('adminid') ;

        if(empty($title)
        ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }

        //查看是否存在相同小区名称
        $count=$ModelProduct->where("title='$title'")->count();
        if($count){
            echo '<script language="javascript">alert("名称已存在！");history.go(-1);</script>';
            exit;
        }
        //===============================图片==================================
        $file=request()->file('IMAGES');
        if($file){//上传	图片
            $info = $file->validate(['size'=>config('upload_config.max_size'),'ext'=>config('upload_config.file_ext')])
                ->rule(config('upload_config.savename_rule'))
                ->move( config('upload_config.upload_root').'product/');
            if($info){
                // 成功上传后 获取上传信息
                $IMAGES=str_replace('\\','/',$info->getSaveName());

                $image = Image::open(config('upload_config.upload_root').'product/'.$IMAGES);
                $_IMAGESArr=explode('.',$IMAGES);
                //上传后缩略图-手机端尺寸
                $image->thumb(config('upload_config.thumb_mobile_width'), config('upload_config.thumb_mobile_height'))
                    ->save(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_mobile_name').'.'.$_IMAGESArr[1]);

                //上传后缩略图-列表图片显示尺寸a
                $image->thumb(config('upload_config.thumb_smaill_width'), config('upload_config.thumb_smaill_height'))
                    ->save(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_smaill_name').'.'.$_IMAGESArr[1]);
            }else{
                // 上传失败获取错误信息
                //echo $file->getError();
                echo '<script language="javascript">alert("'.$file->getError().'");history.go(-1);</script>';
            }

        }

        $data=array(
            'product_id'=>my_returnUUID(),
            'title'=>$title,
            'images'=>$IMAGES,
            'product_template_id'=>$product_template_id,
            'admin_id'=>$admin_id,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'create_time'=>$gettime,
            'update_time'=>$gettime,
        );
        $ReturnID=$ModelProduct->insertGetId($data);
        if($ReturnID){
            $this->success("操作成功",url("product/index"),3);
        }else{
            $this->error("操作失败",url("product/index"),3);
        }
        exit;
    }

    /**
     * @描述：编辑
     */
    public function edit(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}
        $ModelProduct=Db::name('product');
        $ModelAdmin=Db::name('admin');
        $getone=$ModelProduct->where("product_id='$id'")->find();

        $this->assign("getone",$getone);
        return $this->fetch();
    }

    /**
     * @描述：编辑提交
     */
    public function update(){
        $param = $this->request->post();
        $ModelProduct=Db::name('product');
        $ModelAdmin=Db::name('admin');

        $product_id=htmlspecialchars(isset($param['product_id']) ? trim($param['product_id']) : '');
        $title=htmlspecialchars(isset($param['title']) ? trim($param['title']) : '');
        $IMAGES=htmlspecialchars(isset($param['oldIMAGES']) ? trim($param['oldIMAGES']) : '');
        $data_status=htmlspecialchars(isset($param['data_status']) ? intval($param['data_status']) : 0);
        $data_desc=htmlspecialchars(isset($param['data_desc']) ? trim($param['data_desc']) : '');
        $product_template_id=htmlspecialchars(isset($param['product_template_id']) ? intval($param['product_template_id']) : 0);
        $gettime=time();
        $admin_id=Session::get('adminid') ;

        if(empty($title) or empty($product_id)
        ){
            echo '<script language="javascript">alert("必填项不能为空！");history.go(-1);</script>';
            exit;
        }

        //查看是否存在相同小区名称
        $count=$ModelProduct->where("title='$title' AND product_id!='$product_id'")->count();
        if($count){
            echo '<script language="javascript">alert("名称已存在！");history.go(-1);</script>';
            exit;
        }

        //===============================图片==================================
        $file=request()->file('IMAGES');
        if($file){//上传	图片
            if($IMAGES!=""){
                $new=@unlink(config('upload_config.upload_root').'product/'.$IMAGES);

                $_IMAGESArr=explode('.',$IMAGES);
                @unlink(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_mobile_name').'.'.$_IMAGESArr[1]);
                @unlink(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_smaill_name').'.'.$_IMAGESArr[1]);
            }

            $info = $file->validate(['size'=>config('upload_config.max_size'),'ext'=>config('upload_config.file_ext')])
                ->rule(config('upload_config.savename_rule'))
                ->move( config('upload_config.upload_root').'product/');
            if($info){
                // 成功上传后 获取上传信息
                $IMAGES=str_replace('\\','/',$info->getSaveName());

                $image = Image::open(config('upload_config.upload_root').'product/'.$IMAGES);
                $_IMAGESArr=explode('.',$IMAGES);
                //上传后缩略图-手机端尺寸
                $image->thumb(config('upload_config.thumb_mobile_width'), config('upload_config.thumb_mobile_height'))
                    ->save(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_mobile_name').'.'.$_IMAGESArr[1]);

                //上传后缩略图-列表图片显示尺寸a
                $image->thumb(config('upload_config.thumb_smaill_width'), config('upload_config.thumb_smaill_height'))
                    ->save(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_smaill_name').'.'.$_IMAGESArr[1]);
            }else{
                // 上传失败获取错误信息
                //echo $file->getError();
                echo '<script language="javascript">alert("'.$file->getError().'");history.go(-1);</script>';
            }

        }

        $data=array(
            'title'=>$title,
            'images'=>$IMAGES,
            'product_template_id'=>$product_template_id,
            'data_desc'=>$data_desc,
            'data_status'=>$data_status,
            'update_time'=>$gettime,
        );
        $ReturnID=$ModelProduct->where("product_id='$product_id'")->update($data);
        if($ReturnID){
            $this->success("操作成功",url("product/index"),3);
        }else{
            $this->error("操作失败",url("product/index"),3);
        }
        exit;
    }

    /**
     * @描述：操作处理
     */
    public function editinfo(){
        $param = $this->request->param();
        $ModelProduct=Db::name('product');
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if($param["action"]=="checkStatus"){//设置状态
            $Status=isset($param['Status']) ? intval($param['Status']) : 0 ;
            $ModelProduct->where("product_id='$id'")->setField('data_status',$Status);
        }

        $this->success("操作成功",url("product/index"),3);
        exit;
    }

    /**
     * @描述：删除图片
     */
    public function delimg(){
        $param = $this->request->param();
        $id=isset($param['id']) ? htmlspecialchars($param['id']) : '' ;
        if(empty($id)){echo 'paramer error!';exit;}

        $ModelProduct=Db::name('product');
        $getone=$ModelProduct->where("product_id='$id'")->find();
        if($getone['images']!=""){
            @unlink(config('upload_config.upload_root').'product/'.$getone['images']);

            $_IMAGESArr=explode('.',$getone['images']);
            @unlink(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_mobile_name').'.'.$_IMAGESArr[1]);
            @unlink(config('upload_config.upload_root').'product/'.$_IMAGESArr[0].config('upload_config.thumb_smaill_name').'.'.$_IMAGESArr[1]);
        }
        $ModelProduct->where("product_id='$id'")->setField('images',"");
        $this->success("操作成功",url("product/edit",array('id'=>$id)),3);
        exit;
    }

}