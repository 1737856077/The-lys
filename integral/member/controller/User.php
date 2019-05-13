<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 9:07
 */

namespace app\member\controller;


use app\common\controller\CommonIntegra;
use think\Db;
use think\Session;

class User extends CommonIntegra
{
    /**
     * 渲染修改密码
     */
    public function alterpwd()
    {
        $param = $this->request->param();
        $id = htmlspecialchars(trim(isset($param['uid'])?$param['uid']:''));
        if (!$id){
            echo '参数错误';
        }
        $member_data = Db::name('member')->where('id',$id)->find();
        $this->assign('member_data',$member_data);
        return $this->fetch();
    }
    /**
     * 保存修改密码
     */
    public function SavePwd()
    {
        $param = $this->request->param();
        $member_id = Session::get('memberid');
        $pwd = htmlspecialchars(isset($param['pwd'])?$param['pwd']:'');
        $pwd1 = htmlspecialchars(isset($param['pwd1'])?$param['pwd1']:'');
        $pwd2 = htmlspecialchars(isset($param['pwd2'])?$param['pwd2']:'');
        $data = [
            'code'=>1,
            'msg'=>''
        ];
        if (!$pwd){
            $data=['code'=>0,'msg'=>'原密码不存在'];
            return json($data);
        }
        if (!$pwd2==$pwd1){
            $data=['code'=>-1,'msg'=>'两次输入的密码不一致'];
            return json($data);
        }
        $member_data = Db::name('member')->where('id',$member_id)->find();
        $pwd = md5($pwd);
        $password = md5($pwd2);
        if ($pwd==$member_data['pwd']){
            $res = Db::name('member')->where('id',$member_id)->update(['pwd'=>$password]);
            if ($res){
                $data=['code'=>1,'msg'=>'更新成功'];
                return json($data);
            }else{
                $data=['code'=>-5,'msg'=>'更新失败'];
                return json($data);
            }
        }else{
            $data=['code'=>-2,'msg'=>'密码错误'];
            return json($data);
        }

    }

}