<?php
namespace app\common\controller;
/**
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:CommonBase.php 2018-03-26 14:18:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use think\Image;
use think\Session;
use app\common\controller\CommonBaseHome;
class CommonBase extends CommonBaseHome
{

    public function __construct(Request $request){
        parent::__construct($request);
    }

    /**
     * @描述：初始化函数
     */
    public function  _initialize(){
        $MemberModel = Db::name('member');
        $MemberData = $MemberModel->where('member_id',Session::get('memberid'))->find();
        $this->assign('MemberData',  $MemberData );
        parent::_initialize();
        if(!Session::has('username') ){
            echo "<script language=\"javascript\">window.open('/index.php/member/register/login','_top');</script>";
            exit;
        }
    }

}