<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:HomeCommonAction.php 2015-06-16 09:38:00 $
 */
define("TOKEN", 'lianyuwechat');
define("APP_ID", 'wxc18fa831272ac730');
define("APP_SECRET", '8eaa03d4dd154ddc50736d77085956c2');
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\Cookie;
use think\model;
use \app\wechat\controller\HomeReplyWechatWatchAction;
use think\Config;
class HomeCommonAction extends Controller{
	private $postObj=null;
	private $fromUsername="";
	private $toUsername="";
	private $msgType="";
	private $host="";

	public $CommonTOKEN="lianyuwechat";
    public $CommonAPP_ID="wxc18fa831272ac730";
    public $CommonAPP_SECRET="8eaa03d4dd154ddc50736d77085956c2";

	//public  $productCategory;
	//public  $areaList;
	/*自动运行的方法*/
    /*function _initialize() {
        include_once './admin/public/lib/functions.php';
    }*/
	function _initialize() {
        include_once './admin/public/lib/functions.php';
		header("Content-Type:text/html; charset=utf-8");
		//import('ORG.Util.Session');
		//import('ORG.Util.Cookie');
		//load("extend");
        //wirtefile('test');
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$postStr = $GLOBALS ['HTTP_RAW_POST_DATA'];
			//wirtefile($postStr);
			if (! empty ( $postStr )) {
				$this->postObj =$postObj= simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );				
				//$this->host = $_SERVER ['HTTP_HOST'];
				$gettime=time();		
			
				
				$ModelWechatWatch=Db::name("WechatWatch");
				$ModelMember=Db::name("Member");
				//wirtefile($postObj->MsgType);
				if($postObj->MsgType=="event"){//关注/取消关注事件
					$_fromUsername = $postObj->FromUserName;
					$_toUsername = $postObj->ToUserName;
					//wirtefile("[".$postObj->Event."]");
					if($postObj->Event=="subscribe"){//subscribe(订阅)			
						//wirtefile("ins_".$postObj->Event."|$_fromUsername]");
						$countWechatWatch=$ModelWechatWatch->where("wechat_openid='$_fromUsername'")->count();
						$GetUserInfoWechatArray=$this->GetUserInfoWechat($_fromUsername);
                        //wirtefile(json_encode($GetUserInfoWechatArray));
						if($countWechatWatch){//已存在
							if(empty($GetUserInfoWechatArray["nickname"])){//没拉取到信息
														
								$dataWechatWatch=array("data_status"=>"1",
										"update_time"=>$gettime,
								);
								$ModelWechatWatch->where("wechat_openid='".$_fromUsername."'")->update($dataWechatWatch);
							}else{
								$dataWechatWatch=array("nickname"=>"$GetUserInfoWechatArray[nickname]",
														"sex"=>"$GetUserInfoWechatArray[sex]",
														"province"=>"$GetUserInfoWechatArray[province]",
														"city"=>"$GetUserInfoWechatArray[city]",
														"country"=>"$GetUserInfoWechatArray[country]",
														"headimgurl"=>"$GetUserInfoWechatArray[headimgurl]",
														"privilege"=>isset($GetUserInfoWechatArray['privilege']) ? $GetUserInfoWechatArray['privilege'] : '',
														"wechat_groups_id"=>"$GetUserInfoWechatArray[groupid]",
														"data_status"=>"1",
														"update_time"=>$gettime,
								);
								$ModelWechatWatch->where("wechat_openid='".$_fromUsername."'")->update($dataWechatWatch);
								//$ModelMember->where("wechat_openid='".$_fromUsername."'")->setField("username",$GetUserInfoWechatArray["nickname"]);
							}
							

						}else{//不存在，重新添加
							$dataWechatWatch=array("wechat_openid"=>$postObj->FromUserName,
													"developer_account"=>$postObj->ToUserName,
													"nickname"=>$GetUserInfoWechatArray["nickname"],
													"sex"=>$GetUserInfoWechatArray["sex"],
													"province"=>$GetUserInfoWechatArray["province"],
													"city"=>$GetUserInfoWechatArray["city"],
													"country"=>$GetUserInfoWechatArray["country"],
													"headimgurl"=>$GetUserInfoWechatArray["headimgurl"],
													"privilege"=>isset($GetUserInfoWechatArray['privilege']) ? $GetUserInfoWechatArray['privilege'] : '',
													"wechat_groups_id"=>"$GetUserInfoWechatArray[groupid]",
													"data_status"=>"1",
													"create_time"=>$gettime,
													"update_time"=>$gettime,
							);
							
							$GetUserInfoWechatArray["nickname"]=!isset($GetUserInfoWechatArray["nickname"]) ? "游客" : $GetUserInfoWechatArray["nickname"];
							//$returnid=$ModelWechatWatch->insertGetId($dataWechatWatch);
							$ModelWechatWatch->query("INSERT INTO `sy_wechat_watch` (wechat_openid,
																									developer_account,
																									`nickname`,
																									`sex`,
																									`province`,
																									`city`,
																									`country`,
																									`headimgurl`,
																									`privilege`,
																									`wechat_groups_id`,
																									`data_status`,
																									`create_time`,
																									`update_time`)
									VALUES ('$_fromUsername',
									'$_toUsername',
									'$GetUserInfoWechatArray[nickname]',
									'$GetUserInfoWechatArray[sex]',
									'$GetUserInfoWechatArray[province]',
									'$GetUserInfoWechatArray[city]',
									'$GetUserInfoWechatArray[country]',
									'$GetUserInfoWechatArray[headimgurl]',
									'',
									'$GetUserInfoWechatArray[groupid]',
									1,
									$gettime,
									$gettime)");
							
							
						}
						
						//推送欢迎信息 begin
						$ReplyWechatWatchAction=new HomeReplyWechatWatchAction();
						$_xml=$ReplyWechatWatchAction->AttentionReply($postObj->FromUserName,$postObj->ToUserName);
						wirtefile($_xml);
						echo $_xml;
						//推送欢迎信息 end
					}else if($postObj->Event=="unsubscribe"){//unsubscribe(取消订阅) 
						$ModelWechatWatch->where("wechat_openid='".$postObj->FromUserName."'")->setField("data_status", 0);
					}else if($postObj->Event=="MASSSENDJOBFINISH"){//群发后的推送事件
						$msg_id=$postObj->MsgID;
						
						$ModelWechatMassLog=Db::name("WechatMassLog");
						$dataWechatMassLog=array("from_username"=>(string)$postObj->FromUserName,
												"send_status"=>(string)$postObj->Status,
												"total_count"=>(string)$postObj->TotalCount,
												"filter_count"=>(string)$postObj->FilterCount,
												"sent_count"=>(string)$postObj->SentCount,
												"error_count"=>(string)$postObj->ErrorCount,
												"send_time"=>(string)$postObj->CreateTime,
												"update_time"=>time(),
						);
						
						$ModelWechatMassLog->where("msg_id='$msg_id'")->update($dataWechatMassLog);
						//wirtefile(json_encode($postObj));
					}
					
				}else if($postObj->MsgType=="text"){//用户发送文本[关键词]信息
					//wirtefile($dataWechatMassLog);
					$msg_id=(string)$postObj->MsgId;
					$Content=(string)$postObj->Content;
					if(!empty($Content)){
						$info=array("MsgID"=>$msg_id,
									"Content"=>$Content,
									"CreateTime"=>(string)$postObj->CreateTime,
						);
						//回复关键字 begin
						$ReplyWechatWatchAction=new HomeReplyWechatWatchAction();
						$_xml=$ReplyWechatWatchAction->KeywordReply($info,$postObj->FromUserName,$postObj->ToUserName);
						//wirtefile($_xml);
						echo $_xml;
						//回复关键字 end
					}
					echo '';
				}
				
			} else {
				//exit ( 'FILE IS Failure' );
				echo '';
			}
		} else {//第一次接入时使用
			
			$this->valid ();
		}
	}	
    
    //获取用户openid
    public function GetUserOpenid($code){
    	if(config('WebConfig_Debug')){
    		return config('WebConfig_Debug_Openid');
    		exit;
    	}
		$file_content=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->CommonAPP_ID."&secret=".$this->CommonAPP_SECRET."&code=".$code."&grant_type=authorization_code");
    	$file_content=(Array)json_decode($file_content);
    
    	return $file_content["openid"];
    	exit;
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
    
    //获取用户基本信息
    public function GetUserInfoWechat($openid){
    	wirtefile("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->GetAccessToken()."&openid=".$openid."&lang=zh_CN");
    	$file_content=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->GetAccessToken()."&openid=".$openid."&lang=zh_CN");
    	//wirtefile($file_content);
    	if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
    	$file_content=(Array)json_decode($file_content);

    	return $file_content;
    }
    //获取用户基本信息
    public function GetUserInfoWechatUserInfo($openid){
    	//wirtefile("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->GetAccessToken()."&openid=".$openid."&lang=zh_CN");
    	$file_content=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$this->GetAccessTokenUserInfo()."&openid=".$openid."&lang=zh_CN");
    	//wirtefile($file_content);
    	if(stripos($file_content,"errcode")!==false){/*wirtefile($file_content);*/}
    	$file_content=(Array)json_decode($file_content);
    
    	return $file_content;
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
    
    //获取token
	public function GetAccessToken(){
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		$data = json_decode(file_get_contents("access_token_home.json"));
        $data = (Array)$data;
        if(count($data)){
            if ($data['expire_time'] > time()) {
                $access_token = $data['access_token'];
                return $access_token;
            }
        }
		//if ($data->expire_time < time()) {
			// 如果是企业号用以下URL获取access_token
			// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->CommonAPP_ID."&secret=".$this->CommonAPP_SECRET."";
			//wirtefile($url);
            $res = json_decode(file_get_contents($url));
			$access_token = $res->access_token;
			if ($access_token) {
                $data=array();
                $data['expire_time'] = time() + 7000;
                $data['access_token'] = $access_token;
				$fp = fopen("access_token_home.json", "w");
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		//} else {
			//$access_token = $data->access_token;
		//}
        //wirtefile($access_token);
		return $access_token;
	
	}    
	//获取token
	public function GetAccessTokenUserInfo(){
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		$data = json_decode(file_get_contents("access_token_snsapi_userinfo.json"));
        $data = (Array)$data;
        if(count($data)){
            if ($data['expire_time'] > time()) {
                $access_token = $data['access_token'];
                return $access_token;
            }
        }
		//if ($data->expire_time < time()) {
			// 如果是企业号用以下URL获取access_token
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->CommonAPP_ID."&secret=".$this->CommonAPP_SECRET."&code=CODE&grant_type=authorization_code";
			$res = json_decode(file_get_contents($url));
			$access_token = $res->access_token;
			if ($access_token) {
                $data=array();
                $data['expire_time'] = time() + 7000;
                $data['access_token'] = $access_token;
				$fp = fopen("access_token_snsapi_userinfo.json", "w");
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		//} else {
			//$access_token = $data->access_token;
		//}
		return $access_token;
	
	}   
	
	//第一次接入时使用
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    //第一次接入时使用
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	
}
?>