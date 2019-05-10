<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:WechatMenuAction.class.php 2015-07-30 17:08:00 $
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
use think\Config;
class Wechatmenu extends UserCommon{
	
	//显示主页面
	public function index(){
		$ModelWechatMenu=Db::name("WechatMenu");
		$ModelWechatMaterial=Db::name('WechatMaterial');
		
		$ListOne=$ModelWechatMenu->where("data_status=1 AND father_id=0")->order("data_sort ASC,id ASC")->select();
		$_list=array();
		foreach($ListOne as $key=>$value){
			$value["MaterialTitle"]="";
			if(($value["data_type"]=="media_id" or $value["data_type"]=="view_limited") and !empty($value["media_id"]) ){
				$getoneWechatMaterialOne=$ModelWechatMaterial->where("media_id='$value[media_id]'")->find();
				$value["MaterialTitle"]=$getoneWechatMaterialOne["title"];
			}
			$ListTwo=$ModelWechatMenu->where("data_status=1 AND father_id='$value[id]'")->order("data_sort ASC,id ASC")->select();
			$_ListTwo=array();
			foreach($ListTwo as $k=>$val){
				$val["MaterialTitle"]="";
				if(($val["data_type"]=="media_id" or $val["data_type"]=="view_limited") and !empty($val["media_id"]) ){
					$getoneWechatMaterialTwo=$ModelWechatMaterial->where("media_id='$val[media_id]'")->find();
					$val["MaterialTitle"]=$getoneWechatMaterialTwo["title"];
				}
				$_ListTwo[]=$val;
			}
			$value["ChildrenList"]=$_ListTwo;
			$_list[]=$value;
		}
		//print_r($_list);
		
		
		$this->assign("list",$_list);
		return $this->fetch();
	}
	
	//显示添加页面
	public function add(){
		$ModelWechatMenu=Db::name("WechatMenu");
		$ModelWechatMaterial=Db::name('WechatMaterial');
		
		$ListWechatMenu=$ModelWechatMenu->where("data_status=1 AND father_id=0")->order("data_sort ASC,id ASC")->select();
		
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
		
		$this->assign("ListWechatMenu",$ListWechatMenu);	
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		$this->assign("ListWechatMaterialVideo",$ListWechatMaterialVideo);
		$this->assign("ListWechatMaterialVoice",$ListWechatMaterialVoice);
		$this->assign("ListWechatMaterialArticles",$ListWechatMaterialArticles);
		$this->assign("ListWechatMaterialThumb",$ListWechatMaterialThumb);
		return $this->fetch();
	}
	
	//显示编辑页面
	public function edit(){
        $param = $this->request->param();
		$id = isset($param['id']) ? intval(trim($param['id'])) : intval($param['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }

		$ModelWechatMenu=Db::name("WechatMenu");
		$ModelWechatMaterial=Db::name('WechatMaterial');

		$getone=$ModelWechatMenu->where("id='$id'")->find();
		if(empty($getone)){ echo "paramer error!"; exit;  }
		$ListWechatMenu=$ModelWechatMenu->where("data_status=1 AND father_id=0")->order("data_sort ASC,id ASC")->select();

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

		$this->assign("ListWechatMenu",$ListWechatMenu);
		$this->assign("getone",$getone);
		$this->assign("ListWechatMaterialImages",$ListWechatMaterialImages);
		$this->assign("ListWechatMaterialVideo",$ListWechatMaterialVideo);
		$this->assign("ListWechatMaterialVoice",$ListWechatMaterialVoice);
		$this->assign("ListWechatMaterialArticles",$ListWechatMaterialArticles);
		$this->assign("ListWechatMaterialThumb",$ListWechatMaterialThumb);
		return $this->fetch();
	}

	//提交添加表单
	public function insert(){
        $param = $this->request->param();
		$father_id=intval(trim($param['father_id']));
		$data_type=htmlspecialchars(trim($param['data_type']));
		$title=htmlspecialchars(trim($param['title']));
		$url=htmlspecialchars(trim($param['url']));
		$btn_key=htmlspecialchars(trim($param['btn_key']));
		$media_id=htmlspecialchars(trim($param['media_id']));
		$data_sort=intval(trim($param['data_sort']));
		$description=htmlspecialchars(trim($param['description']));
		$gettime=time();

		if(empty($title)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		if($data_type=="click"){//点击推事件
			if(empty($btn_key)){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		if($data_type=="view"){//跳转URL
			if(empty($url)){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		if($data_type=="media_id" or $data_type=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
			if(empty($media_id)){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		$ModelWechatMenu=Db::name("WechatMenu");

		if($father_id==0){//查看一级菜单是否超过3个
			$count=$ModelWechatMenu->where("father_id=0")->count();
			if($count>=3){
				echo "<script language=\"javascript\">alert(\"添加失败，一级菜单最多只能添加3个！\");history.go(-1);</script>";
				exit;
			}
		}
		if($father_id!=0){//查看2级菜单是否超过5个
			$count=$ModelWechatMenu->where("father_id='$father_id'")->count();
			if($count>=5){
				echo "<script language=\"javascript\">alert(\"添加失败，二级菜单最多只能添加5个！\");history.go(-1);</script>";
				exit;
			}
		}

		$data=array();
		$data["father_id"]=$father_id;
		$data["title"]=$title;
		$data["description"]=$description;
		$data["url"]=$url;
		$data["btn_key"]=$btn_key;
		$data["media_id"]=$media_id;
		$data["data_sort"]=$data_sort;
		$data["data_type"]=$data_type;
		$data["data_status"]="1";
		$data["create_time"]=$gettime;
		$data["update_time"]=$gettime;


		$ModelWechatMenu->insertGetId($data);

		$this->success("操作成功！",url("wechatmenu/index"),3);
		exit;
	}

	//提交编辑表单
	public function update(){
        $param = $this->request->param();
		$id=intval(trim($param['id']));
		$father_id=intval(trim($param['father_id']));
		$data_type=htmlspecialchars(trim($param['data_type']));
		$title=htmlspecialchars(trim($param['title']));
		$url=htmlspecialchars(trim($param['url']));
		$btn_key=htmlspecialchars(trim($param['btn_key']));
		$media_id=htmlspecialchars(trim($param['media_id']));
		$data_sort=intval(trim($param['data_sort']));
		$description=htmlspecialchars(trim($param['description']));
		$gettime=time();

		if(empty($title)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		if($data_type=="click"){//点击推事件
			if(empty($btn_key)){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		if($data_type=="view"){//跳转URL
			if(empty($url)){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		if($data_type=="media_id" or $data_type=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
			if(empty($media_id)){
				echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
				exit;
			}
		}
		$ModelWechatMenu=Db::name("WechatMenu");

		if($father_id==0){//查看一级菜单是否超过3个
			$count=$ModelWechatMenu->where("father_id=0 AND id!='$id'")->count();
			if($count>=3){
				echo "<script language=\"javascript\">alert(\"编辑失败，一级菜单最多只能添加3个！\");history.go(-1);</script>";
				exit;
			}
		}
		if($father_id!=0){//查看2级菜单是否超过5个
			$count=$ModelWechatMenu->where("father_id='$father_id' AND id!='$id'")->count();
			if($count>=5){
				echo "<script language=\"javascript\">alert(\"编辑失败，二级菜单最多只能添加5个！\");history.go(-1);</script>";
				exit;
			}
		}

		$data=array();
		$data["father_id"]=$father_id;
		$data["title"]=$title;
		$data["description"]=$description;
		$data["url"]=$url;
		$data["btn_key"]=$btn_key;
		$data["media_id"]=$media_id;
		$data["data_sort"]=$data_sort;
		$data["data_type"]=$data_type;
		$data["update_time"]=$gettime;

		$ModelWechatMenu->where("id='$id'")->update($data);

		$this->success("操作成功！",url("wechatmenu/index"),3);
		exit;
	}

	//删除菜单
	public function del(){
        $param = $this->request->param();
		$id = isset($param['id']) ? intval(trim($param['id'])) : intval($param['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		$ModelWechatMenu=Db::name("WechatMenu");
		$ModelWechatMenu->where("id='$id'")->delete();
		
		$this->success("操作成功！",url("wechatmenu/index"),3);
		exit;
	}
	
	//同步微信菜单
	public function SyncWechatMenu($type=0){
		$ModelWechatMenu=Db::name("WechatMenu");
		$gettime=time();
		
		$info=$this->WechatMenuSync();
		$info=$info['menu'];
		$info=(Array)$info;
		$info=$info['button'];
		//print_r($info);exit;
		
		//添空老数据
		$ModelWechatMenu->query("TRUNCATE sy_wechat_menu");
		foreach ($info as $key=>$value){
			$value=(Array)$value;
			//insert
			
			$data=array();
			$data["father_id"]="0";
			$data["title"]=$value["name"];
			//点击推事件//扫码推事件
			//扫码推事件且弹出“消息接收中”提示框//弹出系统拍照发图
			//弹出拍照或者相册发图//弹出微信相册发图器
			//弹出地理位置选择器
            if(isset($value["type"])) {
                if ($value["type"] == "click" or $value["type"] == "scancode_push"
                    or $value["type"] == "scancode_waitmsg" or $value["type"] == "pic_sysphoto"
                    or $value["type"] == "pic_photo_or_album" or $value["type"] == "pic_weixin"
                    or $value["type"] == "location_select"
                ) {
                    $data["btn_key"] = $value["key"];
                } else if ($value["type"] == "view") {//跳转URL
                    $data["url"] = $value["url"];
                } else if ($value["type"] == "media_id" or $value["type"] == "view_limited") {//下发消息（除文本消息）//跳转图文消息URL
                    $data["media_id"] = $value["media_id"];
                }
            }
			$data["data_sort"]="50";
			$data["data_type"]=isset($value["type"]) ? $value["type"] : '';
			$data["data_status"]="1";
			$data["create_time"]=$gettime;
			$data["update_time"]=$gettime;
			$returnid=$ModelWechatMenu->insertGetId($data);
				
			//查看是否有子菜单	begin
			$sub_button=(Array)$value["sub_button"];
			if(count($sub_button)){	
				foreach ($sub_button as $k=>$val){
					$val=(Array)$val;
					//insert
						
					$data=array();
					$data["father_id"]=$returnid;
					$data["title"]=$val["name"];
					//点击推事件//扫码推事件
					//扫码推事件且弹出“消息接收中”提示框//弹出系统拍照发图
					//弹出拍照或者相册发图//弹出微信相册发图器
					//弹出地理位置选择器
					if($val["type"]=="click" or $val["type"]=="scancode_push"
						or $val["type"]=="scancode_waitmsg" or $val["type"]=="pic_sysphoto"
						or $val["type"]=="pic_photo_or_album" or $val["type"]=="pic_weixin"
						or $val["type"]=="location_select"
					){
						$data["btn_key"]=$val["key"];
					}else if($val["type"]=="view"){//跳转URL
						$data["url"]=$val["url"];
					}else if($val["type"]=="media_id" or $val["type"]=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
						$data["media_id"]=$val["media_id"];
					}
					$data["data_sort"]="50";
					$data["data_type"]=$val["type"];
					$data["data_status"]="1";
					$data["create_time"]=$gettime;
					$data["update_time"]=$gettime;
					$ModelWechatMenu->insertGetId($data);
					
				}
			}
			//查看是否有子菜单	end
		}		
		
		if($type==0){
			$this->success("同步成功！",url("wechatmenu/index"),3);
			exit;
		}
	}
	
	//生成微信菜单
	public function CreateWechatMenu(){
		$ModelWechatMenu=Db::name("WechatMenu");
			
		$ListOne=$ModelWechatMenu->where("data_status=1 AND father_id=0")->order("data_sort ASC,id ASC")->select();

		$json='{
							     "button":[';
		$json_ins='';
		foreach($ListOne as $key=>$value){			
			$ListTwo=$ModelWechatMenu->where("data_status=1 AND father_id='$value[id]'")->order("data_sort ASC,id ASC")->select();
			if(count($ListTwo)){//有子菜单
				$json_ins.=' {
				            "name": "'.$value["title"].'", 
				            "sub_button": [';
				
				$json_i_ins='';
				foreach($ListTwo as $k=>$val){
					//点击推事件//扫码推事件
					//扫码推事件且弹出“消息接收中”提示框//弹出系统拍照发图
					//弹出拍照或者相册发图//弹出微信相册发图器
					//弹出地理位置选择器
					if($val["data_type"]=="click" or $val["data_type"]=="scancode_push"
						or $val["data_type"]=="scancode_waitmsg" or $val["data_type"]=="pic_sysphoto"
						or $val["data_type"]=="pic_photo_or_album" or $val["data_type"]=="pic_weixin"
						or $val["data_type"]=="location_select"
					){
						$json_i_ins.='{
							          "type":"'.$val["data_type"].'",
							          "name":"'.$val["title"].'",
							          "key":"'.$val["btn_key"].'"
							},';
					}else if($val["data_type"]=="view"){//跳转URL
						$json_i_ins.='{
							          "type":"'.$val["data_type"].'",
							          "name":"'.$val["title"].'",
							          "url":"'.$val["url"].'"
							},';
					}else if($val["data_type"]=="media_id" or $val["data_type"]=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
						$json_i_ins.='{
							          "type":"'.$val["data_type"].'",
							          "name":"'.$val["title"].'",
							          "media_id":"'.$val["media_id"].'"
							},';
					}
				} 
				
				$json_ins.=substr($json_i_ins,0,-1);
				$json_ins.='   ]
				        }, ';
			}else{//没有子菜单
				//点击推事件//扫码推事件
				//扫码推事件且弹出“消息接收中”提示框//弹出系统拍照发图
				//弹出拍照或者相册发图//弹出微信相册发图器
				//弹出地理位置选择器
				if($value["data_type"]=="click" or $value["data_type"]=="scancode_push"
					or $value["data_type"]=="scancode_waitmsg" or $value["data_type"]=="pic_sysphoto"
					or $value["data_type"]=="pic_photo_or_album" or $value["data_type"]=="pic_weixin"
					or $value["data_type"]=="location_select" 
				){
					$json_ins.='{
							          "type":"'.$value["data_type"].'",
							          "name":"'.$value["title"].'",
							          "key":"'.$value["btn_key"].'"
							},';
				}else if($value["data_type"]=="view"){//跳转URL
					$json_ins.='{
							          "type":"'.$value["data_type"].'",
							          "name":"'.$value["title"].'",
							          "url":"'.$value["url"].'"
							},';
				}else if($value["data_type"]=="media_id" or $value["data_type"]=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
					$json_ins.='{
							          "type":"'.$value["data_type"].'",
							          "name":"'.$value["title"].'",
							          "media_id":"'.$value["media_id"].'"
							},';
				}
				
			}
			
			//$value["ChildrenList"]=$ListTwo;
			//$_list[]=$value;
		}
		$json.=substr($json_ins, 0,-1);
		$json.=']
				}';
		//wirtefile($file_content);
		//echo $json;exit;
		$info=$this->WechatMenuCreate($json);
		if($info["errcode"]=="0"){
			$this->success("微信菜单创建成功！",url("wechatmenu/index"),3);
			exit;
		}else{
			$this->error("微信菜单创建失败！原因：".json_encode($info),url("wechatmenu/index"),3);
			exit;
		}
	}
	
	//微信同步微信菜单接口
	public function WechatMenuSync(){
		//include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$Token;
		$file_content=$PublicAction->curlPost($url);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
		
		return $file_content;
	}
	
	//微信菜单创建接口
	public function WechatMenuCreate($data){
		//include_once './Public/Lib/functions.php';
		$PublicAction=new PublicAction();
		$Token=$PublicAction->accessToken();
		$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$Token;
		$file_content=$PublicAction->curlPost($url,$data);
		if(stripos($file_content,"errcode")!==false){wirtefile($file_content);}
		$file_content=(Array)json_decode($file_content);
		
		return $file_content;
	}
}
