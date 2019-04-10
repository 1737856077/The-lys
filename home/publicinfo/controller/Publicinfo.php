<?php
/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:网站前台-公用信息类
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:Publicinfo.php 2018-07-22 19:31:00 $
 */

namespace app\publicinfo\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use app\common\controller\CommonBase;
class Publicinfo extends Controller
{
    /**
     * @描述：公用头部
     */
    public function header(){
        return $this->fetch();
    }

    /**
     * @描述：公用底部
     */
    public function footer(){
        return $this->fetch();
    }

    /**
     * @描述：公用头部搜索
     */
    public function search(){
        return $this->fetch();
    }

    /**
     * @描述：公用头部-用户信息
     */
    public function headeruser(){
        return $this->fetch();
    }
}