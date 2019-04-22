<?php
/**
 * Created by PhpStorm.
 * User: 李玉生
 * Date: 2019/4/18
 * Time: 16:37
 * explain:用户注册 登录处理
 */

namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Session;

class Register extends Controller
{
    /**
     * @用户注册处理
     * return 1用户名密码输入 2手机号未输入 3 手机号已经存在 4注册失败服务器繁忙 0成功
     */
    public function register()
    {
        $param = $this->request->param();
        $username = htmlspecialchars(isset($param['username']) ? $param['username'] : '');
        $moblie = htmlspecialchars(isset($param['moblie']) ? $param['moblie'] : '');
        $pwd = md5(htmlspecialchars(isset($param['pwd']) ? $param['pwd'] : ''));
        if (empty($username) or empty($pwd)) {
            return json(array('msg' => '请输入用户名和密码', 'code' => 1));
        }
        if (empty($moblie)) {
            return json(array('msg' => '请输入手机号', 'code' => 2));
        }
        $MemberModel = Db::name('member');
        $moblieRes = $MemberModel->where('moblie', $moblie)->find();
        if (!empty($moblieRes)) {
            return json(array('msg' => '手机号已经存在', 'code' => 3));
        }
        $data = array(
            'moblie' => $moblie,
            'username' => $username,
            'pwd' => $pwd,
            'uid'=> my_returnUUID(),
            'data_status' => 1,
            'create_time' => time()
        );
        $res = $MemberModel->insertGetId($data);
        if (!$res) {
            return json(array('msg' => '服务器忙，请稍后再试！', 'code' => 4));
        }
        Session::delete('memberid');
        Session::delete('username');
        Session::set('memberid', $res);
        Session::set('username', $username);
        return json(array('msg' => '注册成功', 'code' => 0));
    }

    /**
     * @验证手机是否重复
     */
    public function rep()
    {
        $param = $this->request->param();
        $MemberModel = Db::name('member');
        $Mobile = htmlspecialchars(isset($param['moblie']) ? $param['moblie'] : '');
        $res = $MemberModel->where('moblie', $Mobile)->find();
        if ($res) {
            return json('手机号已存在');
        } else {
            return json('正确');
        }
    }
    /**
     * 登录验证处理
     * return 1 用户名密码未输入 2用户名密码错误 0登录成功
     */
    public function checklogin()
    {
        $param = $this->request->post();
        $username=htmlspecialchars(isset($param['username']) ? trim($param['username']) : '');
        $pwd=isset($param['pwd']) ? trim($param['pwd']) : '';

        if(empty($username) or empty($pwd) ){
            return json(array('msg' => '请输入用户名和密码', 'code' => 1));
        }

        $pwd=md5($pwd);
        $modelMember=Db::name('member');
        $getone=$modelMember->where("username='$username' AND pwd='$pwd'")->find();
        if(empty($getone)){
            return json(array('msg' => '用户名或密码错误', 'code' => 2));
        }
        Session::delete('username');
        Session::delete('memberid');
        Session::set('username', $getone["username"]);
        Session::set('memberid', $getone["id"]);
        //添加日志 begin
        //添加日志 end
       return json(array('msg' => '登录成功', 'code' => 0));
        }
}