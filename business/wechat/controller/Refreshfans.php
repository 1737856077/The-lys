<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:RefreshFansAction.class.php 2015-08-13 16:17:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Paginator;
use think\File;
use think\Image;
use \app\wechat\controller\UserCommon;  
use \app\wechat\controller\PublicAction;
class Refreshfans extends UserCommon{
	
	//刷新粉丝
	public function index(){
        $param = $this->request->param();
		set_time_limit(0);//设置时间不超时
		$next_openid=htmlspecialchars(trim(isset($param['next_openid']) ? $param['next_openid'] : '')) ;
		$page=isset($param['page']) ? intval($param['page']) : 1;
		$page = $page ? $page : 1 ;//当前页
		$display_num=1000;//每页显示记录数
		
		$info=$this->WechatGetListOpenid($next_openid);
		if(!empty($info["errcode"])){
			$this->error("刷新粉丝失败！原因：".json_encode($info),url('Wechatwatchgroupslocal/index'),3);
			exit;
		}
		
		$total=$info['total'];//关注该公众账号的总用户数 
		$count=$info['count'];//拉取的OPENID个数，最大值为10000 
		$data=(Array)$info['data'];//列表数据，OPENID的列表 
		$next_openid=$info['next_openid'];//拉取列表的最后一个用户的OPENID 
		
		$ModelWechatWatch=Db::name('WechatWatch');
		$PublicAction=new PublicAction();
		$gettime=time();
		if(!$total){//没有粉丝，清空粉丝表
			$this->success("操作成功！",url('Wechatwatchgroupslocal/index'),3);
			exit;
		}
		
		
		$total_page=ceil($total/$display_num);//总页数
		$page=$page>$total_page ? $total_page : $page;
		$numpage=($page-1)*$display_num;
		$last_page=$page+1;//下一页
		$last_page=$last_page>$total_page ? $total_page : $last_page;
		
		$openids=(Array)$data["openid"];
		//存在session中 begin
		$_RefreshFansOpenids=session("RefreshFansOpenids");
		if(empty($_RefreshFansOpenids)){
			$Session_RefreshFansOpenids=$openids;
		}else{
			$Session_RefreshFansOpenids=(Array)unserialize($_RefreshFansOpenids);
		}
		//print_r($Session_RefreshFansOpenids);
		if(count($Session_RefreshFansOpenids)){
			array_merge($Session_RefreshFansOpenids,$openids);
		}else{
			$Session_RefreshFansOpenids=$openids;
		}
		//print_r($Session_RefreshFansOpenids);
		session("RefreshFansOpenids",serialize($Session_RefreshFansOpenids));//序列化后存入
		//print_r(unserialize(session("RefreshFansOpenids")));
		//存在session中 end
		foreach($openids as $val){
			$getone=$ModelWechatWatch->where("wechat_openid='$val'")->find();
			if(empty($getone)){//不存在，添加
				//取得粉丝资料
				$GetUserInfoWechatArray=$PublicAction->GetUserInfoWechat($val);
				if(!empty($GetUserInfoWechatArray["nickname"])){//没拉取到信息
					$dataWechatWatch=array("wechat_openid"=>$val,
							"developer_account"=>"none",
							"nickname"=>$GetUserInfoWechatArray["nickname"],
							"sex"=>$GetUserInfoWechatArray["sex"],
							"province"=>$GetUserInfoWechatArray["province"],
							"city"=>$GetUserInfoWechatArray["city"],
							"country"=>$GetUserInfoWechatArray["country"],
							"headimgurl"=>$GetUserInfoWechatArray["headimgurl"],
							"privilege"=>isset($GetUserInfoWechatArray["privilege"]) ? $GetUserInfoWechatArray["privilege"] : '',
							"wechat_groups_id"=>"$GetUserInfoWechatArray[groupid]",
							"data_status"=>"1",
							"create_time"=>$gettime,
							"update_time"=>$gettime,
					);
					$returnid=$ModelWechatWatch->insertGetId($dataWechatWatch);
				}
			}else if($getone["nickname"]=="游客"){//信息刷新
				//取得粉丝资料
				$GetUserInfoWechatArray=$PublicAction->GetUserInfoWechat($val);
				if(!empty($GetUserInfoWechatArray["nickname"])){//没拉取到信息
					$dataWechatWatch=array("nickname"=>$GetUserInfoWechatArray["nickname"],
							"sex"=>$GetUserInfoWechatArray["sex"],
							"province"=>$GetUserInfoWechatArray["province"],
							"city"=>$GetUserInfoWechatArray["city"],
							"country"=>$GetUserInfoWechatArray["country"],
							"headimgurl"=>$GetUserInfoWechatArray["headimgurl"],
							"privilege"=>$GetUserInfoWechatArray["privilege"],
							"wechat_groups_id"=>"$GetUserInfoWechatArray[groupid]",
							"data_status"=>"1",
							"update_time"=>$gettime,
					);
					$ModelWechatWatch->where("wechat_openid='$val'")->update($dataWechatWatch);
				}
			}else{
				if($getone["data_status"]!="1"){//设置状态
					$ModelWechatWatch->where("wechat_openid='$val'")->setField("data_status", "1");
				}
			}
		}
		
		if($page==$total_page){//当前页等于总页面，发送完成
			$Session_RefreshFansOpenids=(Array)unserialize(session("RefreshFansOpenids"));
			$ModelWechatWatch->where("wechat_openid NOT IN('".implode("','", $Session_RefreshFansOpenids)."')")->delete();//删除没关注的粉丝
			session("RefreshFansOpenids",null);//清空session
			//echo $ModelWechatWatch->getLastSql();exit;
			$this->success("刷新完成：$total/$total",url('Wechatwatchgroupslocal/index'),3);
			exit;
		}else{//发送进行中
			$this->success("刷新进行中，已刷新：".($page*$display_num)."/$total",url("Refreshfans/index")."/page/$last_page/next_openid/$next_openid",1);
			exit;
		}
		
	}
	
	//微信拉取用户接口-拉取用户列表
	public function WechatGetListOpenid($next_openid=null){
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$Token."&next_openid=".$next_openid;
		
		$file_content=file_get_contents($url);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
	}
	
}