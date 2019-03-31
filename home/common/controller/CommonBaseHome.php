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
class CommonBaseHome extends Controller
{

    public function __construct(Request $request){
        parent::__construct($request);
    }

    /**
     * @描述：初始化函数
     */
    public function  _initialize(){
        //查询网站配置信息
        $ModelWebConfigComm=Db::name('web_config');
        $getoneWebConfigComm=$ModelWebConfigComm->where("data_status='1'")
            ->order("id DESC")
            ->find();
        $this->assign('getoneWebConfigComm',$getoneWebConfigComm);
    }

    /**
     * @desc:异步请求
     * @param string $url       --请求地址
     * @param array $data       --请求的数据
     * @param string $method    --请求的方式
     * @return mixed|string
     */
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
}