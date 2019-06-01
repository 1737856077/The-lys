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
class Api extends HomeCommonAction
{
    private $GetUserOpenid="";

    public function index(){
        //$GetWinXinInfoAction=new HomeGetWinXinInfoAction();
        //$this->GetUserOpenid=$GetWinXinInfoAction->GetOpenid();
        //echo $this->GetUserOpenid;
        //exit;
        //推送欢迎信息 begin
        //$ReplyWechatWatchAction=new HomeReplyWechatWatchAction();
        //$_xml=$ReplyWechatWatchAction->AttentionReply('gh_02bd989123c0','oZRzLtxCWOKNCt89CVUtcDoem-C0');
        //wirtefile($_xml);
        //echo $_xml;
        //推送欢迎信息 end
    }
}