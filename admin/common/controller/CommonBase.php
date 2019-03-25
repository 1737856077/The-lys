<?php
//PHP程序代码修复由:找源码 http://Www.ZhaoYuanMa.Com 网站在线提供,QQ:7530782 
?>
<?php
namespace app\common\controller;
/**
 * @[?ym_arr_1?] zaixianpaiban system?Information?Technology?Co.,?Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $zym_var_1.php 2018-04-19 12:31:00 $
 */

use think\Controller;
use think\Db;
use think\db\Query;
use think\Request;
use think\Image;
use think\Session;
class CommonBase  extends Controller
{
    public $zymvar_1=array();//褰???涓??″??绠＄????-???ユ??????瀹跺??琛
    public $CommBusinesIDs=array();//褰???绠＄????-???ユ????灏???瀹剁??ID?扮?
    public function __construct(Request $request){

        parent::__construct($request);
    }

    /**
     * @??杩帮???濮??规?
     */
    public function _initialize(){
        header("Content-Type:text/html; charset=utf-8");
        $request= \think\Request::instance();
        $_module = $request->module();//妯″????
        $_controller = $request->controller();//?у?跺?ㄥ??
        $_action = $request->action();//?规???
        $_url_action=strtolower("$_module/$_controller/$_action");

        //?ョ?????︽????娉?????
        $_getServerHost=$_SERVER['SERVER_NAME'];
        $_authHost=array('zxpaiban.localhost',
			'yunpai.sindns.com',
			'yundayin.sindns.com',
            '127.0.0.1');
        if(!in_array($_getServerHost,$_authHost)){
            echo '??????????';
            exit;
        }

        include_once './admin/public/lib/functions.php';
        $request = Request::instance();
        $listRowPage=config('paginate.list_rows');
        if(!Session::has('adminname') ){
            echo "<script language=\"javascript\">window.open('/admin.php','_top');</script>";
            exit;
        }
        //楠?璇?????
        $admin_permissions=Session::get('admin_permissions');
        $admin_permissions=(Array)json_decode($admin_permissions);
        //??寰?涓???瑕?楠?璇???妯″??
        $data_not_in_auth_url=\think\Config::get('data.not_in_auth_url');
        $admin_permissions=array_merge($admin_permissions,$data_not_in_auth_url);
        if(Session::get('adminname')!='admin'){
            if(!in_array($_url_action,$admin_permissions)){echo $_url_action;
                echo '[4001]娌℃??????锛?';
                exit;
            }
        }

        //??瀹剁?????锛??诲?锛??宠???涓???瀹
        if(Session::get('admin_data_type')=='2'){
            //??寰??宠????瀹
            $this->listCommSalesmanBusines=Db::name('admin')->where('admin_id=\''.Session::get('adminid').'\'')
                ->select();
            foreach ($this->listCommSalesmanBusines as $key=>$val){
                $this->CommBusinesIDs[]=$val['admin_id'];
            }
            $this->assign("listCommSalesmanBusines",$this->listCommSalesmanBusines);
            $this->assign("CommBusinesIDs",$this->CommBusinesIDs);

            if(!count($this->listCommSalesmanBusines)){
                echo '[4002]娌℃??????锛?';exit;
            }
        }

        //涓??″??锛??诲?锛??宠???涓???瀹
        if(Session::get('admin_data_type')=='1'){
            $zymvar_2=Db::name('admin')->where('admin_id='.intval(Session::get('adminid')))->find();
            //涓??″??
            if($zymvar_2['role_id']==2){
                //??寰??宠??灏??
                $this->listCommSalesmanBusiness=Db::name('member')->where('from_user_id='.intval(Session::get('adminid')))
                    ->select();
                foreach ($this->listCommSalesmanVillage as $key=>$val){
                    $this->CommBusinesIDs[]=$val['member_id'];
                }
                $this->assign("listCommSalesmanBusiness",$this->listCommSalesmanBusiness);
                $this->assign("CommBusinesIDs",$this->CommBusinesIDs);

            }
        }

    }

    //??寰??????板??
    public function GetServerHostUrl(){
        if($_SERVER["SERVER_PORT"]!="80"){
            $url='http://'.$_SERVER['SERVER_NAME'].":".$_SERVER["SERVER_PORT"];

        }else{
            $url='http://'.$_SERVER['SERVER_NAME'];
        }
        return $url;
    }

    //??寰??????板??
    public function GetServerHost(){
        return $_SERVER['SERVER_NAME'];
    }

    //妯℃??POST??浜
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

    //楠?璇?????
    static function auth($node_url){
        //楠?璇?????
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