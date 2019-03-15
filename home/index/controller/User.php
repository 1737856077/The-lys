<?php
/**
 * Created by PhpStorm.
 * User: lys
 * Date: 2019/3/15
 * Time: 12:40
 */

namespace app\index\controller;
use think\Config;
use think\Controller;
use think\Validate;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBaseHome;

class User extends CommonBaseHome
{
    //注册页面
    public function register()
    {
        $this->assign('title', '用户注册');
        return $this->fetch();
    }
    //注册功能页面
    public function insert()
    {
        if (Request::instance()->isGet()) {
            $request = Request::instance();
            $data = $request->get();
            $rule = ([
                'username|姓名' => 'require|length:2,20|chsAlphaNum|unique:member',
                'email|邮箱' => 'require|email|unique:member',
                'pwd|密码' => 'require|length:6,20|alphaNum'
            ]);
            $data = [
                'username' => $data['username'],
                'email' => $data['email'],
                'pwd' => $data['pwd'],
            ];
            $validate = new Validate($rule);
            $result = $validate->check($data);
            if (true !== $result) {
                return $validate->getError();
                exit();
            } else {
                $data['username'] = htmlspecialchars(trim($data['username']));
                $data['email'] = htmlspecialchars(trim($data['email']));
                $data['pwd'] = htmlspecialchars(md5(trim($data['pwd'])));
                $data['create_time'] = time();
                $data['last_login_time'] = time();
                $data['data_status'] = 0;
                if (db('member')->insert($data)) {
                    $data['id'] = Db::name('member')->where('email', '=', $data['email'])->field('member_id id')->find();
                    Session::delete('username');
                    Session::delete('email');
                    Session::delete('id');
                    Session::set('username', $data['username']);
                    Session::set('email', $data["email"]);
                    Session::set('id', $data["id"]['id']);
                    $this->return_msg('200', '注册成功', $data);
//                    $this->success("注册成功",url("index"));
                    //echo "<script language=\"javascript\">window.open('" . url('index/index') . "','_top');</script>";
                } else {
                    $this->return_msg('400', '注册失败');
                    // echo "<script language=\"javascript\">window.open('" . url('index/index') . "','_top');</script>";
                }
            }
        } else {
            $this->error("请求错误");
        }
    }
    //登陆功能页面
    public function logins()
    {
        if (Request::instance()->isGet()) {
            $request = Request::instance();
            $data = $request->get();
            $rule = ([
                'username|姓名' => 'require|length:2,20|chsAlphaNum',
//                'email|邮箱'=> 'require|email|unique:member',
                'pwd|密码' => 'require|length:6,20|alphaNum'
            ]);
            $data = [
                'username' => $data['username'],
//                'email' =>$data['email'],
                'pwd' => $data['pwd'],
            ];
            $validate = new Validate($rule);
            $result = $validate->check($data);
            if (true !== $result) {
                return $validate->getError();
            } else {
                $data = Db::name('member')->where('username', $data['username'])
                    ->where('pwd', md5($data['pwd']))->find();
            }
            if (null == $data) {
                $this->return_msg('400', '用户名或密码错误');
                //echo "<script language=\"javascript\">window.open('" . url('index/index') . "','_top');</script>";
            } else {
                //将用户的数据写入到session中
                Session::set('username', $data['username']);
                Session::set('member_id', $data['member_id']);
                $this->return_msg('200', '登陆成功');
                // echo "<script language=\"javascript\">window.open('" . url('index/index') . "','_top');</script>";
            }

        }
    }
    //登陆页面
    public function login()
    {
        $this->assign('title', '用户登陆');
        return $this->fetch();
    }
    //修改密码页面
    public function modify()
    {
        $this->assign('title', '修改密码');
       return $this->fetch();
    }
    //修改密码功能
    public function modifys()
    {
        if (!isset($this->request->param()['pwd']) || !isset($this->request->param()['pwds']) || !isset($this->request->param()['member_id'])) {
            return '缺少字段';
        }
        if (Request::instance()->isGet()) {
            $data = $this->request->param();
            $rule = ([
                'pwd|密码' => 'require|length:6,20|alphaNum',
                'pwds|密码' => 'require|length:6,20|alphaNum',
            ]);
            $data = [
                'pwd' => $data['pwd'],
                'pwds' => $data['pwds'],
                'member_id' => $data['member_id'],
            ];
            $validate = new Validate($rule);
            $result = $validate->check($data);
            if (true !== $result) {
                return $validate->getError();
            }
            $mamberid = $data['member_id'];
            $pwd = htmlspecialchars(md5($data['pwd']));
            $pwds = htmlspecialchars(md5($data['pwds']));

            $result = Db::name('member ')->where('pwd', $pwd)->where('member_id', $mamberid)->select();
            if ($result == null) {
                $this->error("请输入正确的原密码");
            }
            $data = array(
                'pwd' => $pwds,
                'update_time' => time()
            );
            $results = Db::name('member')->where('member_id', $mamberid)->update($data);
            dump($results);
            if ($results) {
                return '修改成功';
            }
        } else {
            return '修改失败';
        }
        //return $this->fetch();

    }
    //上传头像
    public function img()
    {
        $data = $this->request->param();
        $id = $data['id'];//获取要换头像的id
        $request = Request::instance();
        $file = $request->file('img');
        if ($file) {

            $info = $file->validate([
                'size' => 5000000000,
                'ext' => 'jpeg,jpg,png,gif'
            ])->move('home/uploads/');
            if ($info) {
                $data['img'] = $info->getSaveName();
                //存入头像
                $sta = Db::name('member ')->where('member_id',$id)->update($data);
                if ($sta){
                    return '修改成功';
                }
            } else {
                $this->error($file->getError());
            }
        } else {

        }


    }
    //保存手机号
    public function phone()
    {
    }
    //模板管理 会员表id
    public function template()
    {
        if ($this->request->param('id')){
            $id = $this->request->param('id');
        }else{
            return '无内容';
        }
        $tp = Db::name('template')->where('member_id',$id)->select();
    }
    //

}
