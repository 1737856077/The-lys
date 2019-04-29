<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/28
 * Time: 15:34
 */

namespace app\news\controller;


use app\common\controller\CommonBase;
use think\Db;
use think\Session;

class News extends CommonBase
{
    /**
     * 新闻首页渲染
     */
    public function index()
    {
        $admin_id = Session::get('adminid');
        if (!$admin_id){
            echo '参数错误';
            exit();
        }
        $admin_data = Db::name('admin')->where('admin_id',$admin_id)->find();
        if ($admin_data['oskey']==1){
            //所有分类
            $news_class_data = Db::name('news')->select();
            //添加所属分类
            $news_class_datas = [];
            foreach ($news_class_data as $k=>$v){
                $v['father']=Db::name('news_class')->where('class_id',$v['class_id'])->field('title')->find()['title'];
                $news_class_datas[] = $v;
            }
            $this->assign('data',$news_class_datas);
            return $this->fetch();
        }else{
            echo '权限不足';
            exit();
        }
    }
    /**
     * 新闻页面添加
     */
    public function add()
    {
        $admin_id = Session::get('adminid');
        if (!$admin_id){
            echo '参数错误';
            exit();
        }
        $admin_data = Db::name('admin')->where('admin_id',$admin_id)->find();
        if ($admin_data['oskey']==1){
            $news_class_data = Db::name('news_class')->select();
            $this->assign('data',$news_class_data);
            return $this->fetch();
        }else{
            echo '权限不足';
            exit();
        }
    }
    /**
     * 保存新闻内容
     */
    public function saveadd()
    {
        $param = $this->request->param();
       $title = htmlspecialchars(trim($param['title'])?$param['title']:'');
        $class_id = htmlspecialchars(trim($param['class_id'])?$param['class_id']:'');
        $admin_id = htmlspecialchars(trim($param['admin_id'])?$param['admin_id']:'');
        $index_show = htmlspecialchars(trim($param['index_show'])?$param['index_show']:'');
        $keywords = htmlspecialchars(trim($param['keywords'])?$param['keywords']:'');
        $description = htmlspecialchars(trim($param['description'])?$param['description']:'');
        $send_author = htmlspecialchars(trim($param['send_author'])?$param['send_author']:'');
        $contents = htmlspecialchars(trim($param['contents'])?$param['contents']:'');
        if(empty($title) or empty($class_id)){
            echo '参数错误';
            exit();
        }
        $data = [
            'title'=>$title,
            'class_id'=>$class_id,
            'admin_id'=>$admin_id,
            'index_show'=>$index_show,
            'keywords'=>$keywords,
            'description'=>$description,
            'send_author'=>$send_author,
            'contents'=>$contents,
            'create_date'=>time()
        ];
        $res  = Db::name('news')->insertGetId($data);
        if ($res){
            return $this->success('发布成功');
        }{
            return $this->error('发布失败请检查');
    }
    }
    /**
     * 更改状态
     */
    public function staticsave()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:0));
        $class_id = htmlspecialchars(trim(isset($param['class_id'])?$param['class_id']:''));
        if (!$class_id){
            echo "参数错误";
            exit();
        }
        if ($id==1){
            $res = Db::name('news')->where('id',$class_id)->update(['data_status'=>0]);
            if ($res){
                return json(1);
            }else{
                return json(0);
            }
        }else{
            $res = Db::name('news')->where('id',$class_id)->update(['data_status'=>1]);
            if ($res){
                return json(1);
            }else{
                return json(0);
            }
        }
    }
    /**
     * 首页推荐
     */
    public function recommend()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:0));
        $class_id = htmlspecialchars(trim(isset($param['class_id'])?$param['class_id']:''));
        if (!$class_id){
            echo "参数错误";
            exit();
        }
        if ($id==1){
            $res = Db::name('news')->where('id',$class_id)->update(['index_show'=>0]);
            if ($res){
                return json(1);
            }else{
                return json(0);
            }
        }else{
            $res = Db::name('news')->where('id',$class_id)->update(['index_show'=>1]);
            if ($res){
                return json(1);
            }else{
                return json(0);
            }
        }
    }
}