<?php
namespace app\wechat\controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/12 0012
 * Time: 下午 5:53
 */

use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use \app\wechat\controller\HomeCommonAction;
use \app\wechat\controller\HomeGetWinXinInfoAction;
use \app\wechat\controller\HomeReplyWechatWatchAction;
class Wech extends Controller
{
    //微信公众号列表
    public function index()
    {
        $id = Session::get('bus_adminid');
        $list = Db::name('wechat_api_config')->where('admin_id',$id)->paginate(5);
        $count = count($list);
        $this->assign('list',$list);
        $this->assign('count',$count);
        return $this->fetch();
    }
    //添加公众号
    public function add()
    {
        return $this->fetch();
    }
    public function add1()
    {
        if(Request::instance()->isPost()){
            //添加逻辑

        }else{
            return $this->fetch();
        }
    }

}