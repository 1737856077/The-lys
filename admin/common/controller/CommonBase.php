<?php
namespace app\common\controller;
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:CommonBase.php 2018-04-19 12:31:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use think\Image;
use think\Session;
class CommonBase  extends Controller
{
    public $listCommSalesmanBusines=array();//当前业务员管理员-所拥有的商家列表
    public $CommBusinesIDs=array();//当前管理员-所拥有的小商家的ID数组
    public function __construct(Request $request){

        parent::__construct($request);
    }

    /**
     * @描述：初始方法
     */
    public function _initialize(){
        header("Content-Type:text/html; charset=utf-8");
        $request= \think\Request::instance();
        $_module = $request->module();//模块名
        $_controller = $request->controller();//控制器名
        $_action = $request->action();//方法名
        $_url_action=strtolower("$_module/$_controller/$_action");

        //查看是否是合法域名
        $_getServerHost=$this->GetServerHost();
        $_authHost=array('suyuan.localhost',
            '127.0.0.1');
        if(!in_array($_getServerHost,$_authHost)){
            echo '未授权域名';
            exit;
        }

        include_once './admin/public/lib/functions.php';
        $request = Request::instance();
        $listRowPage=config('paginate.list_rows');
        if(!Session::has('adminname') ){
            echo "<script language=\"javascript\">window.open('/admin.php','_top');</script>";
            exit;
        }
        //验证权限
        $admin_permissions=Session::get('admin_permissions');
        $admin_permissions=(Array)json_decode($admin_permissions);
        //取得不需要验证的模块
        $data_not_in_auth_url=\think\Config::get('data.not_in_auth_url');
        $admin_permissions=array_merge($admin_permissions,$data_not_in_auth_url);
        if(Session::get('adminname')!='admin'){
            if(!in_array($_url_action,$admin_permissions)){echo $_url_action;
                echo '[4001]没有权限！';
                exit;
            }
        }

        //商家管理员，登录，关连旗下商家
        if(Session::get('admin_data_type')=='2'){
            //取得关联商家
            $this->listCommSalesmanBusines=Db::name('admin')->where('admin_id=\''.Session::get('adminid').'\'')
                ->select();
            foreach ($this->listCommSalesmanBusines as $key=>$val){
                $this->CommBusinesIDs[]=$val['admin_id'];
            }
            $this->assign("listCommSalesmanBusines",$this->listCommSalesmanBusines);
            $this->assign("CommBusinesIDs",$this->CommBusinesIDs);

            if(!count($this->listCommSalesmanBusines)){
                echo '[4002]没有权限！';exit;
            }
        }

        //业务员，登录，关连旗下商家
        if(Session::get('admin_data_type')=='1'){
            $getoneAdminCommonBase=Db::name('admin')->where('admin_id='.intval(Session::get('adminid')))->find();
            //业务员
            if($getoneAdminCommonBase['role_id']==2){
//取得关联小区
                $this->listCommSalesmanBusiness=Db::name('salesman_business')->where('salesman_id='.intval(Session::get('adminid')))
                    ->select();
                foreach ($this->listCommSalesmanVillage as $key=>$val){
                    $this->CommBusinesIDs[]=$val['business_id'];
                }
                $this->assign("listCommSalesmanBusiness",$this->listCommSalesmanBusiness);
                $this->assign("CommBusinesIDs",$this->CommBusinesIDs);

            }
        }

    }

    //取得或名地址
    public function GetServerHostUrl(){
        if($_SERVER["SERVER_PORT"]!="80"){
            $url='http://'.$_SERVER['SERVER_NAME'].":".$_SERVER["SERVER_PORT"];

        }else{
            $url='http://'.$_SERVER['SERVER_NAME'];
        }
        return $url;
    }

    //取得或名地址
    public function GetServerHost(){
        return $_SERVER['SERVER_NAME'];
    }

    //模拟POST提交
    public function PostSend($url,$data,$method="POST"){
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, $method );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $tmpInfo = curl_exec ( $ch );
        if (curl_errno ( $ch )) {
            return curl_error ( $ch );
        }
        curl_close ( $ch );
        return $tmpInfo;
    }

    //验证权限
    static function auth($node_url){
        //验证权限
        $admin_permissions=Session::get('admin_permissions');
        $admin_permissions=json_decode($admin_permissions);
        if(Session::get('adminname')=='admin'){
            return true;
        }else{
            if(in_array($node_url,$admin_permissions)){
                return true;
            }
        }
        return false;
    }
}