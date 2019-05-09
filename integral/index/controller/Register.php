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
    /**检测验证码是否正确
     * @param $phone int [手机号]
     * @param $cod  int [验证码]
     */

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
        $code = htmlspecialchars($param['code']);
        if (empty($username)) {
            return  return_msg(400, '请输入用户名!');
        }
        if (empty($moblie)) {
            return  return_msg(400, '请输入手机号!');
        }
        /*********** 检测是否超时  ***********/
        $last_time = session($moblie . '_last_send_time');
        if (!$code){
            return_msg(400, '请输入验证码');
        }
        if (time() - $last_time > 60) {
            return_msg(400, '验证超时,请在一分钟内验证!');
        }
        /*********** 检测验证码是否正确  ***********/
        $md5_code = md5($moblie . '_' . md5($code));
        if (session($moblie . "_code") !== $md5_code) {
            return_msg(400, '验证码不正确!');
        }
        /*********** 不管正确与否,每个验证码只验证一次  ***********/
        session($moblie . '_code', null);

        $MemberModel = Db::name('member');
        $moblieRes = $MemberModel->where('moblie', $moblie)->find();
        if (!empty($moblieRes)) {
            return  return_msg(400, '手机号已经存在!');
        }
        $data = array(
            'moblie' => $moblie,
            'username' => $username,
            'pwd' => $pwd,
            'admin_id'=>Session::get('admin_id'),
            'uid'=> my_returnUUID(),
            'data_status' => 1,
            'create_time' => time()
        );
        $res = $MemberModel->insertGetId($data);
        if (!$res) {
            return  return_msg(400, '服务器忙，请稍后再试!');
        }
        Session::delete('memberid');
        Session::delete('username');
        Session::set('memberid', $res);
        Session::set('username', $username);
        return  return_msg(200, '注册成功');
    }

    /**
     * @验证手机是否重复
     */
    public function rep()
    {
        $param = $this->request->param();
        $Mobile = htmlspecialchars(isset($param['moblie']) ? $param['moblie'] : '');
        $res = Db::name('member')->where('moblie', $Mobile)->find();
        if (!$res) {
          return return_msg(200,'ok');
        } else {
          return return_msg(400,'手机号已经存在');
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
        $getone1=$modelMember->where("moblie='$username' AND pwd='$pwd'")->find();

        if(empty($getone) and empty($getone1)){
            return json(array('msg' => '用户名或密码错误', 'code' => 2));
        }

        if ($getone){
            Session::delete('username');
            Session::delete('memberid');
            Session::set('username', $getone["username"]);
            Session::set('memberid', $getone["id"]);
        }
        if ($getone1){
            Session::delete('username');
            Session::delete('memberid');
            Session::set('username', $getone1["username"]);
            Session::set('memberid', $getone1["id"]);
        }
       return json(array('msg' => '登录成功', 'code' => 0));
        }
}