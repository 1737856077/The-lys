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
        return $this->fetch();
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
        $data_type = htmlspecialchars(trim($param['data_type'])?$param['data_type']:'');
        if (!$title){
            echo '参数错误';
            exit();
        }
        $data = [
            'title'=>$title,
            'level'=>$level,
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
}