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
class Wechatwatchgroupslocal extends UserCommon{

	//显示用户分组主界面
	public function index(){
        $param = $this->request->param();
		$ModelWechatWatch=Db::name('WechatWatch');
		$ModelMemberGroups=Db::name('MemberGroups');

		$SearchName=isset($param["SearchName"]) ? htmlspecialchars(trim($param['SearchName'])) : '';
		$paramter="/SearchName/$SearchName/";

		$p=isset($param['p']) ? intval($param['p']) : 1;
		$num=20;

		$_where = '1';
		$_where.=" AND data_status=1";
		if(!empty($SearchName)){$_where.=" AND nickname LIKE '%".$SearchName."%'";}
        if($_where=='1'){$_where='';}
		$count = $ModelWechatWatch->where($_where)->count();
		//import("ORG.Util.Page");
		//$Page=new Page($count, $num,$paramter);
		//$Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
		//$show=$Page->show();

		//$List=$ModelWechatWatch->where(" 1 $_where ")->order("wechat_watch_id DESC")->page($p.','.$num)->select();


        $List=$ModelWechatWatch->where($_where)
            ->order('wechat_watch_id DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

		//取得分组
		$ListMemberGroups=$ModelMemberGroups->order("member_groups_id ASC")->select();
		$ArrayMemberGroups=array();
		foreach ($ListMemberGroups as $key=>$value){
			$ArrayMemberGroups[$value["member_groups_id"]]=$value["title"];
		}
		$_List=array();
		foreach($List as $key=>$value){
			$_MemberGroupsArr=explode(",", $value["member_groups_id"]);
			$_MemberGroupsStr="";
			foreach ($_MemberGroupsArr as $k=>$val){
				$_MemberGroupsArr[$k]=$ArrayMemberGroups[$val];
			}
			//print_r($_MemberGroupsArr);
			$_MemberGroupsStr=implode("，", $_MemberGroupsArr);
			$value["MemberGroups"]=$_MemberGroupsStr;
			$_List[]=$value;
		}

		$this->assign("count",$count);
		$this->assign("List",$_List);
		$this->assign("page",$show);
		$this->assign("ArrayMemberGroups",$ArrayMemberGroups);
		$this->assign("SearchName",$SearchName);
		$this->assign("ListMemberGroups",$ListMemberGroups);
		return $this->fetch();
	}

	//显示编辑分组界面
	public function edit(){
        $param = $this->request->param();
		$openid=isset($param["openid"]) ? htmlspecialchars(trim($param['openid'])) : htmlspecialchars($param['openid']);

		$ModelWechatWatch=Db::name('WechatWatch');
		$ModelMemberGroups=Db::name('MemberGroups');

		$getone = $ModelWechatWatch->where("wechat_openid='$openid' ")->find();
		if(empty($getone)){echo "paramer error!"; exit;}
		$getone["MemberGroupsArr"]=explode(",", $getone["member_groups_id"]);
		$ListMemberGroups=$ModelMemberGroups->order("member_groups_id ASC")->select();
		
		
		$this->assign("getone",$getone);
		$this->assign("ListMemberGroups",$ListMemberGroups);
		return $this->fetch();
	}

	//提交编辑分组表单
	public function update(){
        $param = $this->request->param();
		$openid=htmlspecialchars(trim($param['openid']));
		$groups_id=$param['groups_id'];
		$gettime=time();

		if(empty($openid)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}
		if(!count($groups_id)){
			echo "<script language=\"javascript\">alert(\"所属分组不能为空！\");history.go(-1);</script>";
			exit;
		}
		$ModelWechatWatch=Db::name('WechatWatch');
		$groups_id=implode(",", $groups_id);
		$data=array("member_groups_id"=>$groups_id,
					"update_time"=>$gettime,
		);
		$ModelWechatWatch->where("wechat_openid='$openid'")->update($data);

		$this->success("操作成功！",url("Wechatwatchgroupslocal/index"),3);
		exit;
	}

	//全选操作
	public function editinfo(){
        $param = $this->request->param();
		$openid_list=$param['sqt'];
		$groups_id=intval(trim($param['groups_id']));
		$checkclass=intval(trim($param['checkclass']));
		$gettime=time();

		if(!count($openid_list)){
			echo "<script language=\"javascript\">alert(\"未选择粉丝！\");history.go(-1);</script>";
			exit;
		}
		$ModelWechatWatch=Db::name('WechatWatch');
		
		if($checkclass==1){//将选中的粉丝从分组中移除
			foreach ($openid_list as $key=>$val){
				$getone = $ModelWechatWatch->where("wechat_openid='$val' ")->find();
				$getone["MemberGroupsArr"]=explode(",", $getone["member_groups_id"]);
				foreach ($getone["MemberGroupsArr"] as $k=>$v){
					if($v==$groups_id and $groups_id!=1){
						unset($getone["MemberGroupsArr"][$k]);
					}
				}
				$data=array("member_groups_id"=>implode(",", $getone["MemberGroupsArr"]),
						"update_time"=>$gettime,
				);
				$ModelWechatWatch->where("wechat_openid='$val'")->update($data);
			}
		}else if($checkclass==11){//将选中的粉丝移动到
			foreach ($openid_list as $key=>$val){
				$getone = $ModelWechatWatch->where("wechat_openid='$val' ")->find();
				$getone["MemberGroupsArr"]=explode(",", $getone["member_groups_id"]);
				if(!in_array($groups_id, $getone["MemberGroupsArr"])){
					array_push($getone["MemberGroupsArr"], $groups_id);
				}
				$data=array("member_groups_id"=>implode(",", $getone["MemberGroupsArr"]),
						"update_time"=>$gettime,
				);
				$ModelWechatWatch->where("wechat_openid='$val'")->update($data);
			}
		}

		$this->success("操作成功！",url("Wechatwatchgroupslocal/index"),3);
		exit;
	}


}