<?php
namespace app\hongbao\controller;
use think\Controller;
use think\Db;
use think\Session;

class Option extends Controller
{

    public function getBaseInfo()
    {
        /**
         * 查询是否在合理的地区范围
         */
        $param = $this->request->param();
        $code = htmlspecialchars(isset($param['code'])?$param['code']:'');
        $code_info_id = htmlspecialchars(isset($param['code_info_id'])?$param['code_info_id']:'');
        if (!$code){
//            return_msg(400,'领取失败请同意获取地址');
        return $this->error('领取失败请同意获取地址');
        }

        //查询产品码
        $product_code_id = Db::name('product_code_info')->where('compress_code',$code_info_id)->find()['product_code_id'];
        //查询字段产品详情
        $product_code_data = Db::name('product_code')->where('product_code_id',$product_code_id)->find();
        if (!empty($product_code_data['listing_district'])){
            $data = Db::name('region')->where('area_parent_id',$product_code_data['listing_district'])->field('area_code')->select();
            $arr = [];
            foreach ($data as $k=>$v){
                $arr[] = $v['area_code'];
            }
            if (!in_array($code,$arr)){
//                return_msg(400,'不在规定地段领取');
                return $this->error('不在规定地段领取');
            }
        }elseif (!empty($product_code_data['listing_city'])){
            $data = Db::name('region')->where('area_parent_id',$product_code_data['listing_city'])->field('area_code')->select();
            $arr = [];
            foreach ($data as $k=>$v){
                $arr[] = $v['area_code'];
            }
            if (!in_array($code,$arr)){
              //  return_msg(400,'不在规定地段领取');
                return $this->error('不在规定地段领取');
            }

        }elseif (!empty($product_code_data['listing_province'])){
            $data = Db::name('region')->where('area_parent_id',$product_code_data['listing_province'])->field('area_code')->select();
            $arr = [];
            foreach ($data as $k=>$v){
                $arr[] = $v['area_code'];
            }
            if (!in_array($code,$arr)){
                return $this->error('不在规定地段领取');
                // return_msg(400,'不在规定地段领取');
            }
        }else{

        }
        /**
         * 获取code
         */
        $appid = 'wxb8d7d0f77e16a9fe';
        $redirect_url = urlencode('http://tzs.sindns.com/business.php/hongbao/option/openid');
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_url&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('location:'.$url);

    }

    public function openid()
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
        $uid = $ress['openid'];
        $data = [
          'openid'=> $uid,
        ];
        //获取微信用户的openid 存入数据库
        Db::name('openid')->insert($data);
        /**
         * 获取红包码区域
         */
        //判断用户只能领取一次
        $list = Db::name('openid')->where('openid',$uid)->field('openid')->select();
        $num = count($list);
        if($num >1){
            return $this->error('抱歉亲，一个账号只能领取一次哦');
            die;
        }else{
            $money = Session::get('money');
            $this->assign('openid',$uid);
            $this->assign('money',$money);
            return $this->fetch();
        }
    }
}

