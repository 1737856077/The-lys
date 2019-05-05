<?php
namespace app\wechat\controller;

/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:PublicMaterialAction.class.php 2015-08-07 10:33:00 $
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
use \app\wechat\controller\CommonBaseHome;
class Publicmaterial extends CommonBaseHome{
	
	/**
	 * @描述：查询除了音乐之外的所有素材
	 */
	public function AjaxMaterial(){
		$ListArray=array("count"=>0,
				"page"=>0,
				"last_page"=>0,
				"total_page"=>0,
				"list"=>array(),
		);
		
		$page = isset($_POST["page"]) ? intval(trim($_POST["page"])) : intval($_GET["page"]);
		$MsgType = isset($_POST['MsgType']) ? $_POST['MsgType'] : $_GET['MsgType'] ;
		$MsgType=htmlspecialchars(trim($MsgType));
		if(empty($MsgType)){ $MsgType="news";  }
		
		if($MsgType=="news"){
			$_where=" AND (data_type='$MsgType' OR data_type='atricles')";
		}else{
			$_where=" AND data_type='$MsgType'";
		}
		$ModelWechatMaterial=Db::name('WechatMaterial');
		$count=$ModelWechatMaterial->where("1 $_where ")->count();
		
		$page = $page ? $page : 1 ;//当前页
		$display_num=10;
		$total_page=ceil($count/$display_num);//总页数
		$page=$page>$total_page ? $total_page : $page;
		$numpage=($page-1)*$display_num;
		$last_page=$page+1;//下一页
		$last_page=$last_page>$total_page ? $total_page : $last_page;
		
		$List=$ModelWechatMaterial->where("1 $_where ")
								->order("create_time DESC")
								->limit("$numpage,$display_num")->select();
		//wirtefile($ModelWechatMaterial->getLastSql());
		$_list=array();
		foreach($List as $key=>$value){
			$_arr=array();
			$_arr["MediaId"]=$value["media_id"];
			$_arr["Title"]=$value["title"];
			$_arr["Url"]=$value["url"];
			$_arr["Description"]=$value["introduction"];
			$_arr["Type"]=$value["data_type"];
			$_arr["Time"]=date("Y-m-d",$value["create_time"]);
			$_list[]=$_arr;
		}
		
		$ListArray["count"]=$count;
		$ListArray["page"]=$page;
		$ListArray["last_page"]=$last_page;
		$ListArray["total_page"]=$total_page;
		$ListArray["list"]=$_list;
		
		echo json_encode($ListArray);
		exit;
	}
	
	/**
	 * @描述：查询音乐素材
	 */
	public function AjaxMaterialMusic(){
		$ListArray=array("count"=>0,
				"page"=>0,
				"last_page"=>0,
				"total_page"=>0,
				"list"=>array(),
		);
		
		$page = isset($_POST["page"]) ? intval(trim($_POST["page"])) : intval($_GET["page"]);
		$MsgType = isset($_POST['MsgType']) ? $_POST['MsgType'] : $_GET['MsgType'] ;
		$MsgType=htmlspecialchars(trim($MsgType));
		if(empty($MsgType)){ $MsgType="music";  }
		
		$_where=" AND data_type='$MsgType'";
		$ModelWechatMaterialMusic=Db::name('WechatMaterialMusic');
		$count=$ModelWechatMaterialMusic->where("1 $_where ")->count();
		
		$page = $page ? $page : 1 ;//当前页
		$display_num=10;
		$total_page=ceil($count/$display_num);//总页数
		$page=$page>$total_page ? $total_page : $page;
		$numpage=($page-1)*$display_num;
		$last_page=$page+1;//下一页
		$last_page=$last_page>$total_page ? $total_page : $last_page;
		
		$List=$ModelWechatMaterialMusic->where("1 $_where ")
									->order("id DESC")
									->limit("$numpage,$display_num")->select();
		
		$_list=array();
		foreach($List as $key=>$value){
			$_arr=array();
			$_arr["Title"]=$value["title"];
			$_arr["Description"]=$value["introduction"];
			$_arr["Url"]=$value["url"];
			$_arr["HdUrl"]=$value["hd_url"];
			$_arr["ThumbUrl"]=$value["thumb_url"];
			$_arr["ThumbMediaId"]=$value["thumb_media_id"];
			$_arr["Type"]=$value["data_type"];
			$_arr["Time"]=date("Y-m-d",$value["create_time"]);
			$_list[]=$_arr;
		}
		
		$ListArray["count"]=$count;
		$ListArray["page"]=$page;
		$ListArray["last_page"]=$last_page;
		$ListArray["total_page"]=$total_page;
		$ListArray["list"]=$_list;
		
		echo json_encode($ListArray);
		exit;
	}
	
}