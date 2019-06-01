<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @描述：会员注册
 * @author:liuqingyan[Leaya] liuqingyan0308@gmail.com
 * $Id:UserCityAction.class.php 2015-06-17 16:20:00 $
 */
use think\Controller;
use think\View;
use think\Request;
use think\Db;
use think\Session;
use think\model;
use think\Paginator;
class Usercity extends Controller{
	
	/**
	 * @描述：根据上级城市ID选择下级城市 - city表
	 */
	public function AjaxGetCity(){
		$id=intval($_GET["id"]) ? intval($_GET["id"]) : 0 ;
		//四个直峡市
		if($id=="2" or $id=="25" or $id=="27" or $id=="32"){
			$getoneCityTwo=Db::name("City")->where("father_id='$id'")->find();
			$List=Db::name("City")->where("data_status=1  AND area_country_id=1 AND father_id='$getoneCityTwo[city_id]'")
							->order("sort_rank ASC,city_id ASC")
							->select();
		}else{
			$List=Db::name("City")->where("data_status=1  AND area_country_id=1 AND father_id='$id'")
							->order("sort_rank ASC,city_id ASC")
							->select();
		}		
		
		$ListArray=array();
		foreach($List as $key=>$val){
			$_arr=array();
				
			$_arr["ID"]=$val["city_id"];
			$_arr["TITLE"]=$val["title"];
				
			$ListArray[]=$_arr;
		}
		echo json_encode($ListArray);
		exit;
	}
}