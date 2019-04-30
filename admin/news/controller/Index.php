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
    public function _initialize(){
        parent::_initialize();
        $admin = Session::get('adminid');
        $admin_data = Db::name('admin')->where('admin_id',$admin)->find();
        if (!$admin_data['oskey']==1){
            echo '权限不足';exit();
        }
    }

    /**
     * 渲染分类首页
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
        }else{
            $value = htmlspecialchars(isset($param['value'])?$param['value']:'');
            $data_type = htmlspecialchars(trim(isset($param['data_type'])?$param['data_type']:''));
            $where['title'] = ['like', '%' . $value . '%'];
            if ($value){
                $res = Db::name('news_class')->where($where)->where('data_type',$data_type)->select();
                $news_class_datas = [];
                foreach ($res as $k=>$v){
                    $v['father']=Db::name('news_class')->where('class_id',$v['father_id'])->field('title')->find()['title'];
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
     * 修改保存
     */
    public function save()
    {
        $param = $this->request->param();
        $title = htmlspecialchars(trim($param['title'])?$param['title']:'');
        $level = htmlspecialchars(trim($param['level'])?$param['level']:0);
        $index_show = htmlspecialchars(trim($param['index_show'])?$param['index_show']:'');
        $father_id = htmlspecialchars(trim($param['father_id'])?$param['father_id']:'');
        $data_type = htmlspecialchars(trim($param['data_type'])?$param['data_type']:'');
        $class_id = htmlspecialchars(trim(isset($param['class_id'])?$param['class_id']:''));
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
        $res = Db::name('news_class')->where('class_id',$class_id)->update($data);
        if ($res){
            return $this->success('更新成功','/admin.php/news/index/index');
        }else{
            return $title->error('更新失败');
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
            return $this->success('创建成功','/admin.php/news/index/index');
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
        $res =Db::name('news_class')->where('class_id',$id)->delete();
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
        $res =Db::name('news_class')->where('class_id',$id)->find();
        $datas = Db::name('news_class')->where('class_id',$res['father_id'])->find();
        $data = Db::name('news_class')->where('data_status',1)->select();
        $this->assign('datas',$datas);
        $this->assign('class',$data);
        $this->assign('data',$res);
       return $this->fetch();
    }
}