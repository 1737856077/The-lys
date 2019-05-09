<?php
namespace app\wechat\controller;
/**
 * This is NOT a freeware,use is subject to license terms
 * @author:liuqingyan
 * $Id:MemberGroupsAction.class.php 2015-08-11 11:15:00 $
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
use think\Config;
class Membergroups extends UserCommon{

	public function index(){
		$ModelMemberGroups=Db::name('MemberGroups');
		$ModelWechatWatch=Db::name('WechatWatch');

		$p=isset($_GET['p']) ? intval($_GET['p']) : 1;
		$num=20;

		$_where="";
		$count = $ModelMemberGroups->where(" 1 $_where ")->count();
		//import("ORG.Util.Page");
		//$Page=new Page($count, $num);
		//$Page->setConfig('theme', "<span class='pre'>%upPage%</span><span class='page-one'>%linkPage% </span><span class='pre'>%downPage%</span> <span class='totle'>共 %totalRow% 条</span> ");
		//$show=$Page->show();

		//$List=$ModelMemberGroups->where(" 1 $_where ")->order("member_groups_id DESC")->page($p.','.$num)->select();
        $List=$ModelMemberGroups->where($_where)
            ->order('member_groups_id DESC')
            ->paginate(config('paginate.list_rows'),false,['query' => $this->request->get('', '', 'urlencode')]);
        $show=$List->render();

		$_List=array();
		foreach ($List as $key=>$value){
			$countWechatWatch=$ModelWechatWatch->where("FIND_IN_SET('$value[member_groups_id]',member_groups_id)")->count();
			$value["count_member"]=$countWechatWatch;
			$_List[]=$value;
		}
		
		$this->assign("count",$count);
		$this->assign("List",$_List);
		$this->assign("page",$show);
		return $this->fetch();
	}

	//显示添加页面
	public function add(){
		return $this->fetch();
	}

	//显示编辑页面
	public function edit(){
		$id = isset($_POST['id']) ? intval(trim($_POST['id'])) : intval($_GET['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }

		$ModelMemberGroups=Db::name('MemberGroups');
		$getone=$ModelMemberGroups->where("member_groups_id='$id'")->find();

		$this->assign("getone",$getone);
		return $this->fetch();
	}

	//提交添加表单
	public function insert(){
		$title=htmlspecialchars(trim($_POST['title']));
		$gettime=time();

		if(empty($title)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}

		$data=array();
		$data["title"]=$title;
		$data["create_time"]=$gettime;
		$data["update_time"]=$gettime;

		$ModelMemberGroups=Db::name('MemberGroups');
		$count=$ModelMemberGroups->where("title='$title'")->count();
		if($count){
			echo "<script language=\"javascript\">alert(\"分组名称已存在相同！\");history.go(-1);</script>";
			exit;
		}

		$ModelMemberGroups->insertGetId($data);
		$this->success("添加成功！",url("Membergroups/index"),3);
		exit;
	}

	//提交编辑表单
	public function update(){
		$id=htmlspecialchars(trim($_POST['id']));
		$title=htmlspecialchars(trim($_POST['title']));
		$gettime=time();

		if(empty($title)){
			echo "<script language=\"javascript\">alert(\"必填项不能为空！\");history.go(-1);</script>";
			exit;
		}

		$ModelMemberGroups=Db::name('MemberGroups');

		$count=$ModelMemberGroups->where("member_groups_id='$id'")->count();
		if(!$count){ echo "paramer error!"; exit; }
		$count=$ModelMemberGroups->where("title='$title' AND member_groups_id!='$id'")->count();
		if($count){
			echo "<script language=\"javascript\">alert(\"分组名称已存在相同！\");history.go(-1);</script>";
			exit;
		}
		
		$data=array();
		$data["title"]=$title;
		$data["update_time"]=$gettime;

		$ModelMemberGroups->where("member_groups_id='$id'")->update($data);
		$this->success("编辑成功！",url("Membergroups/index"),3);
		exit;
	}

	//删除分组：还需调试，post删除未返回值
	public function delete(){
		$id = isset($_POST['id']) ? intval(trim($_POST['id'])) : intval($_GET['id']) ;
		if(!$id){ echo "paramer error!"; exit;  }
		if($id==1){echo "默认分组不能删除!"; exit;}

		$ModelMemberGroups=Db::name('MemberGroups');
		$getone=$ModelMemberGroups->where("member_groups_id='$id'")->find();
		if(empty($getone)){ echo "Data does not exist!"; exit;  }

		$ModelMemberGroups->where("member_groups_id='$id'")->delete();

		$this->success("操作成功！",url("Membergroups/index"),3);
		exit;		
	}



}