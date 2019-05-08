<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:MessagePushAction.class.php 2015-08-12 13:16:00 $
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
class Messagepush extends UserCommon{
	
	//显示消息推送主页面
	public function index(){
		$ModelMemberGroups=Db::name('MemberGroups');
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelCity=Db::name('City');
		
		$ListMemberGroups=$ModelMemberGroups->order("member_groups_id ASC")->select();
		
		$ListWechatMaterialImages=$ModelWechatMaterial->where("data_type='image' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialVideo=$ModelWechatMaterial->where("data_type='video' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialVoice=$ModelWechatMaterial->where("data_type='voice' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialArticles=$ModelWechatMaterial->where("data_type='news' OR data_type='atricles' ")->order("create_time DESC")
								->limit("0,10")->select();
		$ListWechatMaterialThumb=$ModelWechatMaterial->where("data_type='thumb' ")->order("create_time DESC")
								->limit("0,10")->select();
		
		$ListCity=$ModelCity->where("data_status=1 AND area_country_id=1 AND father_id=0")->order("sort_rank ASC,city_id ASC")->select();
		
		$this->assign("ListMemberGroups",$ListMemberGroups);
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		$this->assign("ListWechatMaterialVideo",$ListWechatMaterialVideo);
		$this->assign("ListWechatMaterialVoice",$ListWechatMaterialVoice);
		$this->assign("ListWechatMaterialArticles",$ListWechatMaterialArticles);
		$this->assign("ListWechatMaterialThumb",$ListWechatMaterialThumb);
		$this->assign("ListCity",$ListCity);
		return $this->fetch();
	}
	
	
	
	
	//提交推送信息表单
	public function insert(){
		$groups_id_all=intval(trim($_POST['groups_id_all']));
		$groups_id=$_POST['groups_id'];
		$province_id=intval(trim($_POST['province_id']));
		$city_id=intval(trim($_POST['city_id']));
		$push_address=$_POST['push_address'];
		$msgtype=isset($_POST['msgtype']) ? htmlspecialchars(trim($_POST['msgtype'])) : htmlspecialchars(trim($_GET['msgtype'])) ;
		$media_id=isset($_POST['media_id']) ? htmlspecialchars(trim($_POST['media_id'])) : htmlspecialchars(trim($_GET['media_id'])) ;
		$description=isset($_POST['description']) ? htmlspecialchars(trim($_POST['description'])) : htmlspecialchars(urldecode($_GET['description'])) ;
		$gettime=time();
		$is_to_all = $groups_id=="" ? "true" : "false" ;
		$is_to_all_data = $groups_id=="" ? 1 : 0 ;
		//dump($push_address);
		$paramter="";
		$paramter.="/groups_id/$groups_id";
		$paramter.="/province_id/$province_id";
		$paramter.="/city_id/$city_id";
		$paramter.="/msgtype/$msgtype";
		$paramter.="/media_id/$media_id";
		$paramter.="/description/".urlencode($description);
		
		if(empty($media_id) and empty($description)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		
		$ModelWechatMassLog=Db::name('WechatMassLog');
		$ModelWechatWatch=Db::name('WechatWatch');
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$ModelCity=Db::name('City');
		
		$openids=array();
		$video_title="";
		$video_description="";
		
		$_where="";
		if(!$groups_id_all){//没有选择所有粉丝
			if(count($groups_id) or count($push_address)){//有选择 
				$_where.=" AND ( 0 ";
				//查询粉丝
				if(count($groups_id)){
					foreach ($groups_id as $val){
						$_where.=" OR FIND_IN_SET('$val',member_groups_id)";
					}
				}
				if(count($push_address)){
					foreach ($push_address as $val){
						$getoneCity=$ModelCity->where("city_id='$val'")->find();
						$getoneCity["title"]=str_replace("区", "", $getoneCity["title"]);
						$_where.=" OR city LIKE '%$getoneCity[title]%'";
					}
				}
				$_where.=" ) ";
			}
			
		}
			
		$countWechatWatch=$ModelWechatWatch->where("data_status=1 $_where")->count();
		if($countWechatWatch<2){
			echo "<script language=\"javascript\">alert(\"群发信息推送粉丝总数量不能小于2位！\");history.go(-1);</script>";
			exit;
		}
		$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page = $page ? $page : 1 ;//当前页
		$display_num=1000;//每页显示记录数
		if($display_num>=10){
			if(($countWechatWatch%$display_num)==1){$display_num--;}
		}
		$total_page=ceil($countWechatWatch/$display_num);//总页数
		$page=$page>$total_page ? $total_page : $page;		
		$numpage=($page-1)*$display_num;
		$last_page=$page+1;//下一页
		$last_page=$last_page>$total_page ? $total_page : $last_page;
		
		$ListWechatWatch=$ModelWechatWatch->where("data_status=1 $_where")->order("create_time ASC")->limit($numpage.",".$display_num)->select();
		foreach($ListWechatWatch as $key=>$value){
			$openids[$key]=$value["wechat_openid"];
		}
		if(count($openids)<2){
			echo "<script language=\"javascript\">alert(\"群发信息推送粉丝数量不能小于2位！\");history.go(-1);</script>";
			exit;
		}
		//echo $ModelWechatWatch->getLastSql();
		//print_r($openids);exit;
		//取得视频的标题及描述
		if($msgtype=="video"){
			$getoneWechatMaterial=$ModelWechatMaterial->where("media_id='$media_id'")->find();
			$video_title=$getoneWechatMaterial["title"];
			$video_description=$getoneWechatMaterial["introduction"];
		}
		
		//$info=$this->WechatGroupsMass($msgtype,$media_id,$description,$groups_id,$is_to_all);//此接口暂不能使用
		$info=$this->WechatOpenidMass($msgtype,$media_id,$openids,$description,$video_title,$video_description);
		if($info["errcode"]=="0"){
			$data=array("is_to_all"=>$is_to_all_data,
					"group_id"=>$groups_id,
					"touser"=>implode(",", $openids),
					"media_id"=>$media_id,
					"msgtype"=>$msgtype,
					"description"=>$description,
					//"thumb_media_id"=>$gettime,
					"msg_id"=>$info["msg_id"],
					"msg_data_id"=>$info["msg_data_id"],
					//"send_type"=>$gettime,
					"del_status"=>1,
					"from_username"=>"",
					"data_type"=>"0",
					"create_time"=>$gettime,
					"update_time"=>$gettime,
			);
				
			$ModelWechatMassLog->insertGetId($data);
			//wirtefile($ModelWechatMassLog->getLastSql());
			
		}else{
			$this->error("发送失败！原因：".json_encode($info),url("Messagepush/index"),3);
			exit;
		}
		
		if($page==$total_page){//当前页等于总页面，发送完成
			$this->success("发送完成！$countWechatWatch/$countWechatWatch",url("Messagepush/index"),3);
			exit;
		}else{//发送进行中
			$this->success("发送进行中，已发送：".($page*$display_num)."/$countWechatWatch",url("Messagepush/insert")."/page/$last_page".$paramter,1);
			exit;
		}
		
	}
	
	//微信群发信息接口
	public function WechatGroupsMass($msgtype,$media_id,$text='',$group_id="",$is_to_all=false){	
		if(empty($msgtype)){ $msgtype="text";}
		
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$Token;
		$json='{
					   "filter":{
					      "is_to_all":'.$is_to_all.'
					      "group_id":"'.$group_id.'"
					   },
					   ';
				
		if($msgtype=="mpnews"){//图文消息
			$json.='"mpnews":{
					      "media_id":"'.$media_id.'"
					   },
					    "msgtype":"mpnews"
					';
		}else if($msgtype=="text"){//文本消息
			$json.='"text":{
					      "content":"'.$text.'"
					   },
					    "msgtype":"text"
					';
		}else if($msgtype=="voice"){//语音
			$json.='"voice":{
					      "media_id":"'.$media_id.'"
					   },
					    "msgtype":"voice"
					';
		}else if($msgtype=="image"){//图片
			$json.='"image":{
					      "media_id":"'.$media_id.'"
					   },
					    "msgtype":"image"
					';

		}else if($msgtype=="video"){//视频
			$json.='"mpvideo":{
					      "media_id":"'.$media_id.'",
					   },
					    "msgtype":"mpvideo"
					';
		}else if($msgtype=="wxcard"){//卡券
			$json.='"wxcard":{              
					           "card_id":"'.$media_id.'"         
					            },
					   "msgtype":"wxcard"
					';
		}
		$json.='}';
		wirtefile($json);
		$file_content=$PublicAction->curlPost($url,$json);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
		
	}
	
	//微信群发信息接口
	public function WechatOpenidMass($msgtype,$media_id,$openids,$text='',$title='',$description=''){
		if(empty($msgtype)){ $msgtype="text";}
	
		include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$Token;
		
		$json='{
					   "touser":[
					    "'.implode("\",\"", $openids).'"
					   ],
					   ';
		if($msgtype=="mpnews"){//图文消息
			$json.='"mpnews":{
					      "media_id":"'.$media_id.'"
					   },
					    "msgtype":"mpnews"
					';
		}else if($msgtype=="text"){//文本消息
			$json.='"msgtype": "text",
    				"text": { "content": "'.$text.'"}';
		}else if($msgtype=="voice"){//语音
			$json.='"voice":{
				      "media_id":"'.$media_id.'"
				   },
				    "msgtype":"voice"';
		}else if($msgtype=="image"){//图片
			$json.='"image":{
					      "media_id":"'.$media_id.'"
					   },
					    "msgtype":"image"';
		}else if($msgtype=="video"){//视频
			$json.='"mpvideo":{
					      "media_id":"'.$media_id.'",
					      "title":"'.$title.'",
					      "description":"'.$description.'"
					   },
					    "msgtype":"mpvideo"';
		}else if($msgtype=="wxcard"){//卡券
			$json.='"wxcard": {"card_id":"'.$media_id.'"}
        			"msgtype":"wxcard"';
		}
		$json.='}';
		//wirtefile($json);
		$file_content=$PublicAction->curlPost($url,$json);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
	
		return $file_content;
	}
	
	
}