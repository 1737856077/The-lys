<?php
namespace app\wechat\controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-7-10
 * Time: 上午10:17
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
class HomePublicAction extends Controller{
    /**
     * 从微信接口获取文件
     * @param string $media_id 微信返回媒体_ID
     * @param string $filename 上传文件名（不带后缀名）
     * @param string $path 上传路径 （不填为默认路径）
     * @return string
     */
    public function saveWeiXinFileImage($media_id='',$filename='',$path='./Public/Uploads/',$width=600,$height=600){
    	$CommonAction=A("Common");
    	
    	$filepath=$path;
 	
        if(empty($media_id) || empty($filename)) return 0;
        $url="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$CommonAction->GetAccessToken()."&media_id=$media_id";
        $fileInfo=$this->GetSend($url);
        //判断http请求
        if($fileInfo['header']['http_code'] != '200') return 0;
        $type = $fileInfo['header']['content_type'];
        $extension = substr(strrchr($type, '/'), 1);
        $filename .= ".".$extension;
        $path .= "big_".$filename;
        $result = file_put_contents($path,$fileInfo['body']);
        if($result === FALSE ) return 0;
        
        import('ORG.Util.Image');
        $Image = new Image();
        $ret=$Image->thumb($filepath."big_".$filename, $filepath.$filename,"",$width,$height);
        if($ret==false){return 0;}
        $ret=$Image->thumb($filepath."big_".$filename, $filepath."thumb_".$filename,"",200,200);
        if($ret==false){return 0;}
        @unlink($filepath."big_".$filename);
        
        return $filename;
    }

    //模拟Get提交
    public function GetSend($url){
        $ch = curl_init ($url);
        curl_setopt ( $ch, CURLOPT_HEADER,0);
        curl_setopt ( $ch, CURLOPT_NOBODY,0);
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $package = curl_exec ( $ch );
        $httpinfo = curl_getinfo($ch);
        
        if(stripos($package,"errcode")!==false){wirtefile($package);}
        
        if (curl_errno ( $ch )) {
            return curl_error ( $ch );
        }
        $imageAll=array_merge(array('header'=>$httpinfo),array("body"=>$package));
        curl_close ( $ch );
        return $imageAll;
    }

	//保存访问路径
	public function SaveCurrentPath(){
		$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		session("SaveCurrentPath",$url);
	}
	
	//自动生成用户名
	public function SystemAutoMemberName($str){
		$getoneMember=M("Member")->where("moblie='$str'")->find();
		if(!empty($getoneMember)){//已存在相同
			$str=substr($str, 0,11);
			$str=$str.(randstr(2,"upper"));
			$this->SystemAutoMemberName($str);
		}
		return $str;
	}
}