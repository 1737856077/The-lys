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
        $param = $this->request->param();

        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:''));
        if (empty($id)){
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
        }else{
            $value = htmlspecialchars(isset($param['value'])?$param['value']:'');
            $where['title'] = array('like','%'.$value.'%');
            if ($value){
                $res = Db::name('news')->where($where)->select();
                $news_class_datas = [];
                foreach ($res as $k=>$v){
                    $v['father']=Db::name('news_class')->where('class_id',$v['class_id'])->field('title')->find()['title'];
                    $news_class_datas[] = $v;
                }
                $this->assign('data',$news_class_datas);
                return $this->fetch();
            }else{
                echo '请输入查询内容';
            }
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
            $news_class_data = Db::name('news_class')->where('data_status',1)->select();
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
            return $this->success('发布成功','/admin.php/news/news/index');
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
    /**
     * 删除栏目
     */
    public function delete()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:''));
        if (!$id){
            echo '参数错误';
        }
        $res =Db::name('news')->where('id',$id)->delete();
        if ($res){
            return json(1);
        }else{
            return json(0);
        }
    }
    /**
     * 修改界面渲染
     */
    public function alteradd()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:''));
        if (!$id){
            echo '参数错误';
        }
        $data = Db::name('news')->where('id',$id)->find();
        $data['contents']=html_entity_decode($data['contents']);
        $class_data = Db::name('news_class')->where('class_id',$data['class_id'])->find();
        $class = Db::name('news_class')->select();
        $this->assign('data',$data);
        $this->assign('class_data',$class_data);
        $this->assign('class',$class);
        return $this->fetch();
    }
    /**
     * 保存新闻内容
     */
    public function altersaveadd()
    {
        $param = $this->request->param();
        $title = htmlspecialchars(trim(isset($param['title'])?$param['title']:''));
        $class_id = htmlspecialchars(trim(isset($param['class_id'])?$param['class_id']:''));
        $admin_id = htmlspecialchars(trim(isset($param['admin_id'])?$param['admin_id']:''));
        $index_show = htmlspecialchars(trim(isset($param['index_show'])?$param['index_show']:''));
        $keywords = htmlspecialchars(trim(isset($param['keywords'])?$param['keywords']:''));
        $description = htmlspecialchars(trim(isset($param['description'])?$param['description']:''));
        $send_author = htmlspecialchars(trim(isset($param['send_author'])?$param['send_author']:''));
        $contents = htmlspecialchars(trim(isset($param['contents'])?$param['contents']:''));
        $id = htmlspecialchars(trim(isset($param['id'])?$param['id']:''));
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
        $res  = Db::name('news')->where('id',$id)->update($data);
        if ($res){
            return $this->success('更新成功','/admin.php/news/news/index');
        }{
        return $this->error('更新失败请检查');
    }
    }
}