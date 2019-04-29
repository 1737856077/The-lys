<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/4/28
 * Time: 13:47
 */
namespace app\news\controller;
use app\common\controller\CommonBase;
use think\Db;
use think\Session;

class Index extends CommonBase
{
    /**
     * 渲染分类首页
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
            $news_class_data = Db::name('news_class')->select();
            //添加所属分类
            $news_class_datas = [];
            foreach ($news_class_data as $k=>$v){
                $v['father']=Db::name('news_class')->where('class_id',$v['father_id'])->field('title')->find()['title'];
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
     * 渲染添加分类
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
     * 保存添加
     */
    public function saveadd()
    {
        $param = $this->request->param();
        $title = htmlspecialchars(trim($param['title'])?$param['title']:'');
        $level = htmlspecialchars(trim($param['level'])?$param['level']:0);
        $index_show = htmlspecialchars(trim($param['index_show'])?$param['index_show']:'');
        $father_id = htmlspecialchars(trim($param['father_id'])?$param['father_id']:'');
        $data_type = htmlspecialchars(trim($param['data_type'])?$param['data_type']:'');
        if (!$title){
            echo '参数错误';
            exit();
        }
        $data = [
            'title'=>$title,
            'level'=>$level,
            'father_id'=>$father_id,
            'index_show'=>$index_show,
            'data_type'=>$data_type,
            'create_date'=>time()
        ];
        $res = Db::name('news_class')->insertGetId($data);
        if ($res){
            return $this->success('创建成功');
        }else{
            return $title->error('创建失败');
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
            $res = Db::name('news_class')->where('class_id',$class_id)->update(['data_status'=>0]);
            if ($res){
                return json(1);
            }else{
                return json(0);
            }
        }else{
            $res = Db::name('news_class')->where('class_id',$class_id)->update(['data_status'=>1]);
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
            $res = Db::name('news_class')->where('class_id',$class_id)->update(['index_show'=>0]);
            if ($res){
                return json(1);
            }else{
                return json(0);
            }
        }else{
            $res = Db::name('news_class')->where('class_id',$class_id)->update(['index_show'=>1]);
            if ($res){
                return json(1);
            }else{
                return json(0);
            }
        }
    }
}