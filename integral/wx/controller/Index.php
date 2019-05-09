<?php
namespace app\wx\controller;

use think\Controller;
use think\Db;
use think\Session;
use Workerman\Protocols\Http;

class Index extends Controller
{
    public function getBaseInfo()
    {
        /**
         * 获取code
         */
        $appid = 'wxb8d7d0f77e16a9fe';
        $redirect_url = urlencode('http://tzs.sindns.com/integral.php/wx/index/getUserOpenId');
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_url&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('location:'.$url);
    }
    public function getUserOpenId()
    {
        /**
         * 使用code获取access_token
         */
        $param = $this->request->param();
        $appid = 'wxb8d7d0f77e16a9fe';
        $secret = 'e3aedffe336958d1e2ce8e6e4c28eaf3';
        $code = $param['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        $res =json_decode( curl_exec($ch),true);
        /**
         * 拉取用户详情信息 access_token openid
         */
        $access_token = $res['access_token'];
        $openid = $res['openid'];
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $cd = curl_init();
        /**
         * 执行url
         */
        curl_setopt($cd,CURLOPT_URL,$url);
        curl_setopt($cd,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($cd,CURLOPT_HEADER,0);
        /**
         * 获取url内容
         */
        $ress =json_decode( curl_exec($cd),true);
        /**
         * 获取用户内容
         */
        $name = $ress['nickname'];
        $uid = $ress['openid'];
        $img = $ress['headimgurl'];
        $id = Db::name('member')->where('uid',$uid)->find();
      if (empty($id)){
          $MemberModel = Db::name('member');
          $data = array(
              'username' => $name,
              'admin_id'=>Session::get('admin_id'),
              'uid'=> $uid,
              'img'=>$img,
              'data_status' => 1,
              'create_time' => time()
          );
          $res = $MemberModel->insertGetId($data);
          if (!$res) {
          }
          Session::delete('memberid');
          Session::delete('username');
          Session::set('memberid', $res);
          Session::set('username', $name);
          $this->redirect('index/index/integral');
      }{
        Session::delete('memberid');
        Session::delete('username');
        Session::set('memberid', $id['id']);
        Session::set('username', $id['username']);
        $this->redirect('index/index/integral');
    }


    }
}