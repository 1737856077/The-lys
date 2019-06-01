<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:WechatWatchGroupsLocalAction.class.php 2015-08-11 17:18:00 $
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
class Excel extends UserCommon{
	//员工表，表头辅助数组
	private $bt1 = array('id'=>'序号','demand_id'=>'uuid','uid'=>'会员id','category_id'=>'分类id','category_title'=>'其他','origin_id'=>'地区','title'=>'商品名称','images'=>'图片','description'=>'商品描述','price'=>'价格上限','price_total'=>'订单总价','reward_gold_total'=>'总悬赏金','end_time'=>'有效期','data_click'=>'点击量','order_num'=>'订单量','index_show'=>'首页显示','sort_rank'=>'排序','data_status'=>'状态','del_status'=>'删除状态','create_time'=>'添加时间','update_time'=>'修改时间');


	public function index(){
		return $this->fetch();
	}

	public function member(){
		set_time_limit(0);
		$db_vip=Db::name("wechat_watch");
		$vip = $db_vip->select();
		$db_member=Db::name("member");
		foreach($vip as $a => $b){
			$data = $db_member ->where("wechat_openid = '".$b['wechat_openid']."'") -> find();
			//dump($data);
			if(!$data){
				//echo $b['nickname']."in</br>";
				$add_arr = array();
				$add_arr['uid'] = implode("",explode("-",substr(com_create_guid(),1,-1)));
				$mobile_head = array();
				$mobile_head[0] = 130;
				$mobile_head[1] = 131;
				$mobile_head[2] = 132;
				$mobile_head[3] = 133;
				$mobile_head[4] = 134;
				$mobile_head[5] = 135;
				$mobile_head[6] = 136;
				$mobile_head[7] = 137;
				$mobile_head[8] = 138;
				$mobile_head[9] = 139;
				$mobile_head[10] = 189;
				$mobile_head[11] = 159;
				$mobile_head[12] = 153;
				$mobile_head[13] = 156;
				$mobile_head[14] = 155;
				$mobile_head[15] = 157;
				$mobile_head[16] = 150;
				$mobile_head[17] = 158;
				$mobile_head[18] = 159;
				$mobile_head[19] = 151;
				$mobile_head[20] = 152;
				$mobile_head[21] = 188;
				$mobile_head[22] = 182;
				$add_arr['moblie'] = $mobile_head[mt_rand(0,22)].mt_rand(10000000,99999999);
				$add_arr['username'] = $b['nickname'];
				$add_arr['wechat_openid'] = $b['wechat_openid'];
				//$add_arr['money']
				//$add_arr['img_passport']
				//$add_arr['img_visa']
				//$add_arr['img_identity_face']
				//$add_arr['img_identity_side']
				$add_arr['data_authentication'] = 1;
				$add_arr['description'] = "";
				//$add_arr['data_type'] = 
				$add_arr['data_status'] = 1;
				$add_arr['create_time'] = strtotime("2015/09/30")+mt_rand(-604800,604800);
				$add_arr['update_time'] = $add_arr['create_time'];
				//dump($add_arr);
				
				$res = $db_member ->insertGetId($add_arr);
				if($res){
					echo "OK";
				}else{
					echo "FAIL";
				}
				ob_flush();
				flush();
				sleep(1);
			}/*else{
				echo $b['nickname']."out</br>";
			}*/
			
		}
		echo "FINISH</br>";
		echo "<a href='http://".$_SERVER['HTTP_HOST']."/business.php/wechat/excel/address'>点击进入下一步</a>";
	}

	public function address(){
		set_time_limit(0);
		$address = file("./address.txt");
		$address = explode(",",$address[0]);
		shuffle($address);
		
		$name = file("./name.txt");
		$name = explode(",",$name[0]);
		shuffle($name);

		$db_member=Db::name("member");
		$member = $db_member->order("rand()")->limit("151")->select();
		$db_address=Db::name("rceiving_address");
		foreach($member as $a => $b){
			$add_rceiving_address = array();
			$add_rceiving_address['rceiving_address_id'] = implode("",explode("-",substr(com_create_guid(),1,-1)));
			$add_rceiving_address['uid'] = $b['uid'];
			$add_rceiving_address['name'] = $name[$a];
			$add_rceiving_address['tel'] = $b['moblie'];

			$add_rceiving_address['area_country_id'] = 1;
			//$add_rceiving_address['province_id'] = mt_rand(2,35);
			//$add_rceiving_address['city_id'] =Db::name('city')->where("father_id = ".$add_rceiving_address['province_id'])->getfield("city_id");
			//$add_rceiving_address['county_id'] =Db::name('city')->where("father_id = ".$add_rceiving_address['city_id'])->getfield("city_id");

			$add_rceiving_address['province_id'] = 25;
			$add_rceiving_address['city_id'] = 321;
			$add_rceiving_address['address'] = $address[$a];
			$match = substr($add_rceiving_address['address'],6,9);
			switch($match){
				case "长宁区";
					$add_rceiving_address['county_id'] = 2703;
					break;
				case "闸北区";
					$add_rceiving_address['county_id'] = 2704;
					break;
				case "闵行区";
					$add_rceiving_address['county_id'] = 2705;
					break;
				case "徐汇区";
					$add_rceiving_address['county_id'] = 2706;
					break;
				case "浦东新";
					$add_rceiving_address['county_id'] = 2707;
					break;
				case "杨浦区";
					$add_rceiving_address['county_id'] = 2708;
					break;
				case "普陀区";
					$add_rceiving_address['county_id'] = 2709;
					break;
				case "静安区";
					$add_rceiving_address['county_id'] = 2710;
					break;
				case "卢湾区";
					$add_rceiving_address['county_id'] = 2711;
					break;
				case "虹口区";
					$add_rceiving_address['county_id'] = 2712;
					break;
				case "黄浦区";
					$add_rceiving_address['county_id'] = 2713;
					break;
				case "南汇区";
					$add_rceiving_address['county_id'] = 2714;
					break;
				case "松江区";
					$add_rceiving_address['county_id'] = 2715;
					break;
				case "嘉定区";
					$add_rceiving_address['county_id'] = 2716;
					break;
				case "宝山区";
					$add_rceiving_address['county_id'] = 2717;
					break;
				case "青浦区";
					$add_rceiving_address['county_id'] = 2718;
					break;
				case "金山区";
					$add_rceiving_address['county_id'] = 2719;
					break;
				case "奉贤区";
					$add_rceiving_address['county_id'] = 2720;
					break;
				case "崇明县";
					$add_rceiving_address['county_id'] = 2721;
					break;
			}
			$add_rceiving_address['code'] = "200000";
			$add_rceiving_address['data_type'] = 1;
			$add_rceiving_address['data_status'] = 1;
			$add_rceiving_address['create_time'] = $b['create_time']+mt_rand(30025,102400);
			$add_rceiving_address['update_time'] = $add_rceiving_address['create_time'];

			$res = $db_address->insertGetId($add_rceiving_address);
			if($res){
				echo "OK";
			}else{
				echo "FAIL";
			}
			//dump($add_rceiving_address);
			ob_flush();
			flush();
			sleep(1);
		}

		
			
		echo "FINISH</br>";
		echo "<a href='http://".$_SERVER['HTTP_HOST']."/business,php/wechat/excel/index'>点击进入下一步</a>";
	}


	public function excel_up(){
	    $param = $this->request->param();
		$act = $param['act'];
		//$this->show('上传处理', 'utf-8');exit();

		if($act == "upload"){//文件上传
			//if(!empty($_FILES['img']['tmp_name'])){
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize = 100971520 ;// 设置附件上传大小
			$upload->allowExts = array('xls','xlsx');// 设置附件上传类型
			$upload->savePath = './Public/Uploads/Excel/'.date("Y-m-d",time()).'/'; //设置附件上传目录
			//$upload->savePath = "./Public/Uploads/Excel/".date("Y-m-d",time())."/";
			if(!$upload->upload()) {
				$this->error("文件上传失败！错误信息：".$upload->getErrorMsg(),url("attentionreply/index"));
			}else{
				$info = $upload->getUploadFileInfo();
				//dump($info);
				//exit;
				//$info[0]['savepath'] = substr($info[0]['savepath'],1);
				$filedata = array();
				$filedata['address'] = './Public/Uploads/Excel/'.date("Y-m-d",time())."/".$info["0"]['savename'];
				//$filetemp = $info['name'];
				$filedata['filename'] = $info["0"]['name'];
				$filedata['ext'] = $info["0"]['extension'];
				//dump($filedata);exit();
				$this->filedata = $filedata;
				$_SESSION['filedata'] = $filedata;
			}
			//文件上传完成，文件信息存储在session中
			//开始数据导入
			$this->data_in();
		}
	}


	private function data_in(){
		set_time_limit(0); 
		$filedata = $_SESSION['filedata'];
		if($filedata == NULL){
			$this->show('非法操作！', 'utf-8');
		}else{//导入数据
			$dbobj =Db::name('haidai_demand');


			$filePath = $filedata['address'];
			$ext = $filedata['ext'];

			//解析excel，数据存入$data
			require_once($_SERVER['DOCUMENT_ROOT'].'/ThinkPHP/Extend/Library/ORG/PHPExcel/PHPExcel.php');
			require_once($_SERVER['DOCUMENT_ROOT'].'/ThinkPHP/Extend/Library/ORG/PHPExcel/PHPExcel/IOFactory.php');
			if($ext == "xls"){
				require_once($_SERVER['DOCUMENT_ROOT'].'/ThinkPHP/Extend/Library/ORG/PHPExcel/PHPExcel/Reader/Excel5.php');
				$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
			}elseif($ext == "xlsx"){
				require_once($_SERVER['DOCUMENT_ROOT'].'/ThinkPHP/Extend/Library/ORG/PHPExcel/PHPExcel/Reader/Excel2007.php');
				$objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2007 for 2007 format
			}
			
			$objPHPExcel = $objReader->load($filePath); 
		    $sheet = $objPHPExcel->getSheet(0);
		    $highestRow = $sheet->getHighestRow();           //取得总行数
	        $highestColumn = $sheet->getHighestColumn(); //取得总列数
			$data = array();
			//建立辅助数组
			$aras = array();
			for($i = 1;$i <= 26;$i++){
				$aras[chr(ord("A")+ $i - 1)] = $i;
				$aras[$i] = chr(ord("A")+ $i - 1);
			}
			for($i = 1;$i <= 26;$i++){
				$aras["A".chr(ord("A")+ $i - 1)] = $i + 26;
				$aras[$i+26] = "A".chr(ord("A")+ $i - 1);
			}
			$highestColumn = $aras[$highestColumn];
			//dump($highestRow.":".$highestColumn);exit();
			$mark = 0;//标记变量,mark=0上传失败，mark=1上传成功
			$db_member=Db::name("member");
			$db_demand=Db::name("demand");
			$db_order=Db::name("order");
			$db_trip =Db::name('take_trip');
			$db_address =Db::name('rceiving_address');
			$db_order_detail=Db::name("order_detail");
			//dump($db_order_detail);
			//exit;
	        for($j=2;$j<=$highestRow;$j++)                        //从第二行开始读取数据
			{
				$t_arr = array();
				$str = "";
				for($k=1;$k<=$highestColumn;$k++)            //从A列读取数据
				{
					$str .=($sheet->getCell("{$aras[$k]}{$j}")->getValue().'^*^');//读取单元格
				}
				
				$strs = explode("^*^",$str);

				//$bt1 = array('id'=>'序号','demand_id'=>'uuid','uid'=>'会员id','category_id'=>'分类id','category_title'=>'其他','origin_id'=>'地区','title'=>'商品名称','images'=>'图片','description'=>'商品描述','price'=>'价格上限','price_total'=>'订单总价','reward_gold_total'=>'总悬赏金','end_time'=>'有效期','data_click'=>'点击量','order_num'=>'订单量','index_show'=>'首页显示','sort_rank'=>'排序','data_status'=>'状态','del_status'=>'删除状态','create_time'=>'添加时间','update_time'=>'修改时间');
				
				//haidai_demand 商品表数据

				
				$data = $db_address ->order("rand()")->select();
				$add_demand = array();
				$add_demand['demand_id'] = implode("",explode("-",substr(com_create_guid(),1,-1)));
				$add_demand['uid'] = $data[0]['uid'];
				$add_demand['category_id'] = 2;
				$add_demand['category_title'] = "";
				$add_demand['origin_id'] = 8;
				$add_demand['title'] = $strs[1];
				$add_demand['images'] = $strs[0]."-1.jpg,".$strs[0]."-2.jpg,".$strs[0]."-3.jpg";
				//echo $add_demand['image'];
				//exit;
				$add_demand['description'] = $strs[2];
				$add_demand['price'] = round($strs[3]*1.2);
				//$add_arr['price_total'] = $strs[8];
				//$add_arr['reward_gold_total'] = $strs[9];
				$add_demand['create_time'] = $data[0]['create_time']+mt_rand(2000,102400);
				$add_demand['update_time'] = $add_demand['create_time'];
				$add_demand['end_time'] = $add_demand['create_time']+24*60*60*14;
				$add_demand['data_click'] = mt_rand(6,1000);
				$add_demand['order_num'] = $strs[6];
				$add_demand['index_show'] = 1;
				$add_demand['sort_rank'] = mt_rand(1,100);
				$add_demand['data_status'] = 1;
				$add_demand['del_status'] = 1;
				
				
				
				$id_demand = $db_demand->insertGetId($add_demand);
				
				if($id_demand){
					echo "demand--OK!";
				}else{
					echo "demand--FAIL!__序号:".$strs[0];
				}
				echo "</br>";
				

				//haidai_order 海带订单表

				$add_order = array();
				$add_order['order_no'] = $add_demand['create_time'].mt_rand(1000,9999);
				$add_order['demand_id'] = $add_demand['demand_id'];
				$add_order['uid'] = $add_demand['uid'];
				$add_order['price'] = round($strs[3]*1.2);
				$add_order['num'] = $strs[6];
				$add_order['reward_gold'] = $strs[4];
				$add_order['price_total'] = $add_order['price']*$add_order['num'];

				$add_order['pay_total'] = $add_order['price_total']+$add_order['reward_gold'];
				$add_order['pay_real'] = $add_order['pay_total'];
				//$add_order['pay_real_account'] = 0.00;
				$add_order['pay_real_online'] = $add_order['pay_total'];
				
				$add_order['accept_uid'] = $data[1]['uid'];

				$add_order['description'] = "";
				$add_order['mark_status'] = 0;

				//行程信息导入
				
				$add_trip['take_trip_id'] = implode("",explode("-",substr(com_create_guid(),1,-1)));
				$add_trip['uid'] = $data[1]['uid'];
				$add_trip['travel_country_id'] = 1;
				$add_trip['travel_city_id'] = mt_rand(2,5);
				$add_trip['travel_time_begin'] = $add_demand['create_time']+mt_rand(102400,104800);
				$add_trip['travel_time_end'] = $add_trip['travel_time_begin']+7*24*60*60;
				
				$add_trip['data_type'] = 0;
				$add_trip['data_status'] = 0;
				$add_trip['create_time'] = $add_demand['create_time']+mt_rand(102400,204800);
				$add_trip['update_time'] = $add_trip['create_time'];

				$id_trip = $db_trip->insertGetId($add_trip);
				if($id_trip){
					echo "trip--OK!";
				}else{
					echo "trip--FAIL!__序号:".$strs[0];
				}
				echo "</br>";

				//dump($add_trip);
				$add_order['take_trip_id'] = $id;     //待导入行程信息

				$add_order['pay_type'] = 0;
				$add_order['pay_method'] = 0;
				$add_order['notice_type'] = 0;
				$add_order['data_order'] = 4;
				$add_order['send_goods_time'] = $add_demand['create_time']+mt_rand(602400,804800);
				$add_order['data_pay'] = 1;
				
				$add_order['data_status'] = 1;
				$add_order['del_status'] = 1;
				$add_order['create_time'] = $add_demand['create_time'];
				$add_order['update_time'] = $add_order['send_goods_time'];

				//dump($add_order);
				
				$id_order = $db_order->insertGetId($add_order);
				if($id_order){
					echo "order--OK!";
				}else{
					echo "order--FAIL!__序号:".$strs[0];
				}
				echo "</br>";


				//haidai_order_detail 海带订单详情表

				$add_order_datail = array();
				$add_order_datail['order_no'] = $add_order['order_no'];
				
				$res = $db_address->where("uid = '".$data[0]['uid']."'")->find();
				//dump($res);

				$add_order_datail['consignee_contacts'] = $res['name'];
				$add_order_datail['consignee_tel'] = $res['tel'];
				$add_order_datail['consignee_province_id'] = $res['province_id'];
				$add_order_datail['consignee_city_id'] = $res['city_id'];
				$add_order_datail['consignee_county_id'] = $res['county_id'];
				$add_order_datail['consignee_address'] = $res['address'];
				$add_order_datail['consignee_code'] = "200000";

				//$add_order_datail['consignee_get_time'] = $res['create_time']+mt_rand(300,302400);
				$add_order_datail['delivery_ticket_img'] = "";
				$add_order_datail['delivery_currency_id'] = 6;
				$add_order_datail['delivery_price'] = round($strs[3]*18.8369);
				$add_order_datail['delivery_num'] = $add_order['num'];
				$add_order_datail['delivery_express_id'] = 10;
				//$add_order_datail['consignee_contacts'] = $add_demand['demand_id'];
				$add_order_datail['delivery_express_number'] = "021".mt_rand(100000000,999999999);
				$add_order_datail['mark_time'] = $add_demand['create_time']+mt_rand(302400,452400);
				$add_order_datail['delivery_send_time'] = $add_demand['create_time']+mt_rand(602400,804800);
				
				$a = mt_rand(0,3);
				$lbs = array();
				$lbs[0][0] = 35.6;
				$lbs[0][1] = 139.8;
				$lbs[1][0] = 34.3;
				$lbs[1][1] = 135.3;
				$lbs[2][0] = 34.4;
				$lbs[2][1] = 135.1;
				$lbs[3][0] = 32.4;
				$lbs[3][1] = 129.5;
				$add_order_datail['mark_lat'] = $lbs[$a]['0'].mt_rand(100,999);
				$add_order_datail['mark_long'] = $lbs[$a]['1'].mt_rand(100,999);
				
				//$add_order_datail['mark_time'] = ;
				$add_order_datail['data_status'] = 0;
				$add_order_datail['del_status'] = 1;
				$add_order_datail['create_time'] = $add_order['send_goods_time'];
				$add_order_datail['update_time'] = $add_order['send_goods_time'];

				//dump($add_order_datail);
				//exit;
				$id_order_detail = $db_order_detail->insertGetId($add_order_datail);
				//dump($db_order_detail);
				//dump($id_order_detail);
				if($id_order_detail){
					echo "order_detail--OK!";
				}else{
					echo "order_detail--FAIL!__序号:".$strs[0];
				}
				echo "</br>";
				
				

				ob_flush();
				flush();
				sleep(1);

			}
			echo '导入完成！';
		}
	}




}

?>