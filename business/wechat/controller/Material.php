<?php
namespace app\wechat\controller;
/**
 * Created by PhpStorm.
 * User: jiajun
 * Date: 15-7-24
 * Time: 下午4:16
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
use \app\wechat\controller\CommonBaseHome;
use \app\wechat\controller\PublicAction;
class Material extends CommonBaseHome{
    public function index($title='') {
        $title = trim($title);
        $Material =Db::name('Wechat_material');
        import('ORG.Util.Page');
        if(empty($title)) {
            $count = $Material->count();
            $Page = new Page($count, 25);
            $info = $Material->order('create_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        }else{
            $where['title'] = array('like',"%{$title}%");
            $count = $Material->where($where)->count();
            $Page = new Page($count, 25);
            $info = $Material->where($where)->order('create_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        }
        $Page->parameter .=  "title=".urlencode($title);
        $Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
        $show = $Page->show();
        //dump($info);
        $this->assign('page',$show);
        $this->assign('info',$info);
        return $this->fetch();
    }



    public function addMedia() {
        return $this->fetch();
    }

    /*新增永久多媒体素材*/
    public function insertMedia($title='',$data_type='',$introduction='') {
        $url = '';
        $data = array();
        $path='';
        //验证上传内容
        if ($_FILES["media"]["error"] > 0){
            $this->error('上传文件错误! 错误代码:'.$_FILES['media']['error'],'',3);
        }
        $dir = 'Public/Uploads/Multimedia/';
        $name = date('YmdHis').mt_rand(0000,9999);
        //$expand_arr = explode('/',$_FILES['media']['type']);
        //$expand = '.'.$expand_arr[1];
        $expand = '.'.pathinfo($_FILES['media']['name'],PATHINFO_EXTENSION);
        if(is_uploaded_file($_FILES["media"]["tmp_name"])){
            if(move_uploaded_file($_FILES["media"]["tmp_name"],$dir.$name.$expand)){
                $path = $_SERVER['DOCUMENT_ROOT'].'/'.$dir.$name.$expand;
            }else{
                $this->error('上传服务器临时错误','',3);
            }
        }else{
            $this->error('非法上传方法');
        }

        $Public = new Public();
        $token = $Public->accessToken();

        //判断样式
        if($data_type=='image' || $data_type=='voice' || $data_type=='thumb'){
            $url =  'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$token.'&type='.$data_type;
            $data = array('media' => "@{$path}" );
        }elseif($data_type=='video') {
            $url =  'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$token;
            $data = array('media' => "@{$path}" ,'description' => '{"title":"'.$title.'", "introduction":"'.$introduction.'"}');
        }else{
            $this->error('请选择正确的格式','',3);
        }

        $result_json = $Public->curlPost($url,$data);
        $result_arr = json_decode($result_json,true);
//        dump($path);
//        exit;
        if(empty($result_arr['media_id'])){
            $this->error("上传微信错误，错误代码：".$result_arr['errcode'].", 错误信息：".$result_arr['errmsg'],'',3);
        }

        $Material =Db::name('Wechat_material');
        $nowtime = time();
        $data['title'] = $title;
        $data['data_type'] = $data_type;
        $data['introduction'] = $introduction;
        $data['media_id'] =  $result_arr['media_id'];
        $data['url'] = $result_arr['url'];
        $data['local_path'] = $dir.$name.$expand;
        $data['create_time'] = $nowtime;
        $data['update_time'] = $nowtime;

        if($Material->add($data)){
            $this->success('添加微信多媒体素材成功！',U('Material/index'),3);
        }else{
            $this->error('数据库插入错误！','',3);
        }
    }

    /*删除永久素材*/
    public function delMedia($media_id = '') {
        $Public = new Public();
        $token = $Public->accessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token='.$token;
        $data = '{"media_id":"'.$media_id.'"}';
        $result_json = $Public->curlPost($url,$data);
        $result_arr = json_decode($result_json,true);
        if($result_arr['errcode'] != 0) $this->error("删除微信永久素材失败！错误代码：".$result_arr['errcode'].", 错误信息：".$result_arr['errmsg'],'',3);
        $Material =Db::name('Wechat_material');
        $where['media_id'] = $media_id;
        $res = $Material->where($where)->delete();
        if(!$res) $this->error('删除数据库数据错误','',3);
        $this->success('删除数据成功',U('Material/index'),3);
    }


    /*图文素材列表*/
    public function articles($title=''){
        $title = trim($title);
        $Atricles =Db::name('Wechat_atricles');
        import('ORG.Util.Page');


        if(empty($title)) {
            $count = $Atricles->count();
            $Page = new Page($count,25);
            $info = $Atricles->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        }else{
            $where['title'] = array('like',"%{$title}%");
            $count = $Atricles->where($where)->count();
            $Page = new Page($count,25);
            $info = $Atricles->where($where)->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        }
        $Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
        $show = $Page->show();
        //dump($info);
        $this->assign('page',$show);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function addArticle() {
        return $this->fetch();
    }


    /*添加图文到数据库*/
    public function insertArticleDb() {
        $nowtime = time();
        $Atricles =Db::name('Wechat_atricles');
        $Atricles->create();
        $Atricles->create_time = $nowtime;
        $Atricles->update_time = $nowtime;
        $Atricles->data_status = 0;
        if(!$Atricles->add()) $this->error("插入数据库错误",'',3);
        $this->success("保存数据成功",U('Material/articles'),3);
    }

    /*删除数据库图文*/
    public function delArticleDb($atr_id='') {
        $Atricles =Db::name('Wechat_atricles');
        $where['atr_id'] = $atr_id;
        $res = $Atricles->where($where)->delete();
        if(!$res) $this->error("删除数据错误",'',3);
        $this->success("删除数据成功！",U('Material/articles'),3);
    }

    /*编辑图文素材for数据库*/
    public function editArticle($atr_id='') {
        $Atricles =Db::name('Wechat_atricles');
        $where['atr_id'] = $atr_id;
        $info = $Atricles->where($where)->find();
        if(!$info) $this->error("抱歉您找的图文素材不存在！",'',3);
        //dump($info);
        $this->assign('info',$info);
        return $this->fetch();
    }

    /*更新图文素材FOR数据库*/
    public function updateArticleDb($atr_id='') {
        if(empty($atr_id)) $this->error('请选择正确的文章！','',3);
        $where['atr_id'] = $atr_id;
        $nowtime = time();
        $Atricles =Db::name('Wechat_atricles');
        $Atricles->create();
        $Atricles->update_time = $nowtime;
        $res = $Atricles->where($where)->save();
        //echo  $Atricles->_sql();exit;
        if(!$res) $this->error("更新数据库错误",'',3);
        $this->success("更新数据成功",U('Material/articles'),3);
    }


    /*新增永久图文素材*/
    public function insertArticles($atr_id=''){
        $data_arr = array();
        $nowtime = time();
        $atr_title = array();
        $atr_id=rtrim($atr_id,',');
        $atr_id_arr = explode(',',$atr_id);
        if(count($atr_id_arr) == 0 && count($atr_id_arr) <= 8) $this->error("请正确选择需要添加的图文素材",'',3);

        $Atricles =Db::name('Wechat_atricles');
        foreach($atr_id_arr as $key=>$val) {
            $where['atr_id'] = $val;
            $where['media_id'] = array('eq','');
            $info = $Atricles->where($where)->find();
            //dump($info);
            if(!$info) continue;
            $atr_title[] = $info['title'];

            $data_arr['articles'][$key] =
                 array(
                        "title" => urlencode($info['title']),
                        "thumb_media_id" => $info['thumb_media_id'],
                        "author" => urlencode($info['author']),
                        "digest" => urlencode($info['digest']),
                        "show_cover_pic" => $info['show_cover_pic'],
                        "content" =>urlencode($info['content']),
                        "content_source_url" => $info['content_source_url']
                );
        }
        if(empty($data_arr)) $this->error("此图文已经添加过",'',3);
        $Public = new Public();
        $token = $Public->accessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token='.$token;


        $data_json = urldecode(json_encode($data_arr));
        //echo $data_json;exit;

        $result = $Public->curlPost($url,$data_json);
        $result_arr = json_decode($result,true);
        //dump($result_arr);exit;
        if(empty($result_arr['media_id'])) $this->error("新增图文素材！错误代码：".$result_arr['errcode'].", 错误信息：".$result_arr['errmsg'],'',3);

        foreach($atr_id_arr as $key=>$val) {
            $where['atr_id'] = $val;
            $data['data_status'] = 1;
            $data['update_time'] = $nowtime;
            $res = $Atricles->where($where)->save($data);
            if(!$res) $this->error('更新数据库错误','',3);
        }

        $Material =Db::name('Wechat_material');
        $data_material['media_id'] = $result_arr['media_id'];
        $data_material['title'] = $atr_title[0];
        $data_material['atricles_id'] = $atr_id;
        if(count($atr_id_arr) == 1) {
            $data_material['data_type'] = 'articles';
        }else{
            $data_material['data_type'] = 'news';
        }
        $data_material['create_time']  = $nowtime;
        $data_material['update_time']  = $nowtime;
        $res = $Material->add($data_material);

        if(!$res) $this->error("添加数据库错误",'',3);
        $this->success("添加微信图文素材成功",U('Material/articles'),3);
    }


    /*同步多媒体微信素材管理*/
    public function SyncAllList() {
        $Material =Db::name('Wechat_material');
        $where['data_status'] = 1;
        $data['data_status'] = 0;
        $Material->where($where)->save($data);

        $this->Sync('image');
        $this->Sync('video');
        $this->Sync('voice');
        $this->Sync('news');
        $map['data_status'] = 0;
        $Material->where($map)->delete();
        $this->success("同步完成",U('Material/index'),3);

    }

   /* 递归取出所有列表*/
    public function Sync($type='image',$offset=0) {

        $Material =Db::name('Wechat_material');
        $image = $this->getMediaList($type,$offset);
        if(isset($image['errcode'])) $this->error("获去图文素材错误！错误代码：".$image['errcode'].", 错误信息：".$image['errmsg'],'',3);
        foreach($image['item'] as $val) {
            $where['media_id'] = $val['media_id'];
            $info = $Material->where($where)->find();

            $data = array(
                'media_id' => $val['media_id'],
                'update_time' => time(),
                'title' => $info['title'],
                'introduction' => $info['introduction'],
                'create_time' => $val['update_time'],
                'atricles_id' => $info['atricles_id'],
                'local_path' => $info['local_path'],
                'url'  => $val['url'],
                'data_type' => $type,
                'data_status' =>1,
            );
            if($type=='video') {
                $data['title'] = $val['name'];
                $data['introduction']= $val['introduction'];
            }

            if($type=='news'){
                $data['title'] =$val['content']['news_item'][0]['title'];
                if(count($val['content']['news_item']) == 1){
                    $data['data_type'] = 'atricles';
                }
            }

            $res = $Material->add($data,$options=array(),$replace=true);
            //echo $Material->_sql();exit;

        }

        $offset +=$image['item_count'];

        if($offset < $image['total_count']){
            $this->Sync($type,$offset);
        }

        return true;

    }

    /*获取永久素材列表*/
    public function getMediaList($type='news',$offset=0) {
        $Public = new Public();
        $token = $Public->accessToken();

        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$token;
        $data = '{"type":"'.$type.'","offset":"'.$offset.'","count":"20"}';
        $result_json = $Public->curlPost($url,$data);
        return (json_decode($result_json,true));
        //echo   $result_json;

    }

    /*获取素材总数*/
    public function getMediaCount() {
        $Public = new Public();
        $token = $Public->accessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token='.$token;
        echo file_get_contents($url);
    }

    public function test() {
        phpinfo();
    }
}