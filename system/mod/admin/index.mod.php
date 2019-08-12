<?php

class mod_index extends mod {
	public function index(){
		$user	=$this->checkadmin();
		$this->display('index.center',array('user'=>$user));			 
	}

    public function main(){
        $user	=$this->checkadmin();
        $val_1	=strtotime(date('Y-m-d',time()));
        $arr_1	=$this->db->query('select count(id) as tnum from w_users where m_del=0 and m_regtime>'.$val_1,2);
        $num_1	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//
        $val_2	=strtotime(date("Y-m-d",strtotime("-1 day")));
        $arr_1	=$this->db->query('select count(id) as tnum from w_users where m_del=0 and m_regtime>'.$val_2.' and m_regtime<'.$val_1,2);
        $num_2	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//
        $arr_1	=$this->db->query('select count(id) as tnum from w_users where m_del=0 and m_level>0',2);
        $num_3	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//
        $arr_1	=$this->db->query('select count(id) as tnum from w_users where m_del=0',2);
        $num_4	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//会员总数

        //w_uplevel
        $arr_1	=$this->db->query('select count(id) as tnum from w_uplevel where c_time>'.$val_1,2);
        $num_5	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//今日新增订单

        $arr_1	=$this->db->query('select count(id) as tnum from w_uplevel where c_time>'.$val_2.' and c_time<'.$val_1,2);
        $num_6	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//昨日新增订单

        $arr_1	=$this->db->query('select count(id) as tnum from w_uplevel where status=0',2);
        $num_7	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//等待审核

        $arr_1	=$this->db->query('select count(id) as tnum from w_uplevel',2);
        $num_8	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//累计订单

        $val_1	=strtotime("+7 day");
        $arr_1	=$this->db->query('select count(id) as tnum from w_shops where `s_status`=0',2);
        $num_9	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//入驻申请

        $arr_1	=$this->db->query('select count(id) as tnum from w_shops where `s_status`=1 AND `s_dtime`>'.time().' and `s_dtime`<'.$val_1,2);
        $num_10	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//7日内到期

        $arr_1	=$this->db->query('select count(id) as tnum from w_shops where `s_status`=1 AND `s_hot`=1 and `s_dtime`>'.time(),2);
        $num_11	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//推荐中店铺

        $arr_1	=$this->db->query('select count(id) as tnum from w_shops where `s_status`=1 AND `s_dtime`>'.time(),2);
        $num_12	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//累计订单
        $arr_1=$this->db->query("select count(*) as tnum from w_jihua where j_status=0 ",2);
        $num_13	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//入驻申请
        $arr_1=$this->db->query("select count(*) as tnum from w_jihua where j_status=1 ",2);
        $num_14	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//入驻申请

        $arr_1	=$this->db->query('select count(id) as tnum from w_users where m_rz=0',2);
        $num_15	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//入驻申请
        $arr_1	=$this->db->query('select count(id) as tnum from w_users where m_rz=1',2);
        $num_16	=empty($arr_1['tnum'])?0:intval($arr_1['tnum']);//入驻申请

        $this->display('index.main',array('user'=>$user,'num_1'=>$num_1,'num_2'=>$num_2,'num_3'=>$num_3,'num_4'=>$num_4,'num_5'=>$num_5,'num_6'=>$num_6,'num_7'=>$num_7,'num_8'=>$num_8,'num_9'=>$num_9,'num_10'=>$num_10,'num_11'=>$num_11,'num_12'=>$num_12,'num_13'=>$num_13,'num_14'=>$num_14,'num_15'=>$num_15,'num_16'=>$num_16));
    }
	public function logout(){
		session_destroy();
		$url_index = '?m=index&c=login';
		header('Location: '.$url_index);
		exit();
	}
	public function changepwd(){
		$user	=$this->checkadmin();
		header('Content-type:text/json');
		if ($this->post) {
			$oldPassword=md5($_POST['oldPassword']);
			if($oldPassword!=$user['w_pass']){echo json_encode(array('code'=>0,'msg'=>'原密码输入错误'));exit();}
			$password		=$_POST['password'];
			$repassword		=$_POST['repassword'];
			if($password=='' || $password!=$repassword){echo json_encode(array('code'=>0,'msg'=>'新密码输入错误'));exit();}
			$repass=md5($password);
			$this->db->update('w_admin', array('w_pass'=>$repass),array('id'=>$user['id']));
			echo json_encode(array('code'=>1,'msg'=>'修改成功'));exit();
		}
	}

	public function admin(){

		$user	=$this->checkadmin();
		$this->display('index.admin',array('user'=>$user));
	}

	public function admin_list(){
		$user		=$this->checkadmin();
		$query  	="select * from `w_admin` order by id asc";
		$admin	 	=$this->db->query($query, 3);
		foreach($admin as &$rows){
			$rows['w_ctime']	=date('Y-m-d H:i:s',$rows['w_ctime']);
			$rows['w_ltime']	=$rows['w_ltime'] == false ? '暂未登录':date('Y-m-d H:i:s',$rows['w_ltime']);
			$rows['w_typename'] =$this->admin_type[$rows['w_type']];
            $role_set	 =$this->db->query("select * from w_role where id=".$rows['w_role'], 2);
			$rows['w_role'] =$role_set['r_name'];
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>count($admin),'data'=>$admin));
		exit();
	}

	public function addadmin(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['mobile']==''){echo json_encode(array('status'=>0,'msg'=>'手机号码格式错误'));exit();}
			if($fields['passwd']==''){echo json_encode(array('status'=>0,'msg'=>'密码不能为空'));exit();}
			if($fields['nickname']==''){echo json_encode(array('status'=>0,'msg'=>'真实姓名不能为空'));exit();}
			if($fields['w_role']==''){echo json_encode(array('status'=>0,'msg'=>'角色组不能为空'));exit();}
			$mobile	=$fields['mobile'];
			$sql	="select * from w_admin where w_name='$mobile'";
			$admin	=$this->db->query($sql, 2);
			if(!empty($admin)){echo json_encode(array('status'=>0,'msg'=>'当前手机号码已经注册'));exit();}
  			$member	=array(
				'w_name'			=>$mobile,
				'w_pass'			=>md5($fields['passwd']),
				'w_nick'			=>$fields['nickname'],
				'w_type'			=>1,
				'w_ctime'			=>time(),
				'w_ltime'			=>0,
				'w_role'			=>$fields['w_role']
			);
			$memberid=$this->db->insert('w_admin', $member);
			if($memberid){		
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
			}
		}else{
            $role	 	=$this->db->query("select * from `w_role` order by id asc", 3);
			$this->display('index.addadmin',array('user'=>$user,'userid'=>0,'role'=>$role));
		}
	}

	public function editadmin(){
		$user	 =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$admin_id=$_GET['id'];
		$sql	 ="select * from w_admin where id=".$admin_id;
		$admin	 =$this->db->query($sql, 2);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['mobile']==''){echo json_encode(array('status'=>0,'msg'=>'手机号码格式错误'));exit();}
			if($fields['nickname']==''){echo json_encode(array('status'=>0,'msg'=>'真实姓名不能为空'));exit();}
			$mobile		=$fields['mobile'];
  			$member	=array(
				'w_name'			=>$mobile,
				'w_nick'			=>$fields['nickname'],
                'w_role'			=>$fields['w_role']
			);
			if($fields['passwd']!=''){
				$member['w_pass']=md5($fields['passwd']);
			}
			$this->db->update('w_admin', $member,array('id'=>$admin_id));
			echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();	
		}else{
            $role	 	=$this->db->query("select * from `w_role` order by id asc", 3);
			$this->display('index.addadmin',array('user'=>$user,'userid'=>$admin_id,'admin'=>$admin,'role'=>$role));
		}
	}

	public function shen(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$admin_id	=intval($_POST['id']);
		$admin		=$this->db->query('select * from w_admin where id='.$admin_id,2);
		if($admin['w_type']){
			$this->db->update('w_admin', array('w_type'=>0),array('id'=>$admin_id));
		}else{
			$this->db->update('w_admin', array('w_type'=>1),array('id'=>$admin_id));
		}
		echo json_encode(array('code'=>1,'msg'=>'修改成功'));exit();
	}
	
	public function del(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$admin_id	=intval($_POST['id']);
		$admin		=$this->db->query('select * from w_admin where id='.$admin_id,2);
		$this->db->query('delete from w_admin where id='.$admin_id,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}

	public function login(){
		if ($this->post) {
			header('Content-type:text/json');
			$fields = $_POST;			
			if($_SESSION['captcha']!=$fields['vercode'] || $fields['vercode']==''){echo json_encode(array('status'=>0,'msg'=>'验证码错误'));exit();}
			if($fields['username']==''){echo json_encode(array('status'=>0,'msg'=>'手机号码不能为空'));exit();}
			if($fields['password']==''){echo json_encode(array('status'=>0,'msg'=>'登录密码不能为空'));exit();}	
			$mobile		=$fields['username'];
			$passwd		=md5($fields['password']);
			$sql		="select * from w_admin where w_name='$mobile' and w_pass='$passwd'";
			$user		= $this->db->query($sql, 2);
			if(!empty($user)){
				if($user['w_type']>0){
					$_SESSION['admin_id'] 	= $user['id'];
					$_SESSION['captcha']	='';
					$this->db->update('w_admin', array('w_ltime'=>time()),array('id'=>$user['id']));					
					echo json_encode(array('status'=>1,'msg'=>'登录成功'));exit();
				}else{
					echo json_encode(array('status'=>0,'msg'=>'您的账户未审核，请联系客服审核'));exit();
				}					
			}else{
				echo json_encode(array('status'=>0,'msg'=>'您的账号或密码错误，请检查后重试'));exit();
			}			
		}else{
			$this->display('index.login');	
		}	
	}

	//角色列表
	public function role_index(){
        $user		=$this->checkadmin();
        $this->display('role.index',array('user'=>$user));
    }

    public function role_data(){
        $user		=$this->checkadmin();
        $query  	="select * from `w_role` order by id asc";
        $role	 	=$this->db->query($query, 3);
        $role_count	=$this->db->query('select count(id) as total from `w_role`', 2);
        foreach($role as &$rows){
            $rows['r_addtime']	=date('Y-m-d H:i:s',$rows['r_addtime']);
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>$role_count['total'],'data'=>$role));
        exit();
    }

    //角色添加
    public function role_add(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if($this->post){
            header('Content-type:text/json');
            $fields = $_POST;
            if(empty($fields['ids'])){echo json_encode(array('status'=>0,'msg'=>'请选择对应权限'));exit();}
            $ids=$fields['ids'];
            $arr=[];
            foreach($ids as $k=>$v){
                $sql="select * from w_auth where id='".$v."'";
                $au=$this->db->query($sql,2);
                if($au['a_pid']==0){
                    $arr[]=$v;
                }else{
                    $sql="select * from w_auth where id='".$au['a_pid']."'";
                    $aus=$this->db->query($sql,2);
                    //var_dump($aus);
                    $arr[]=$v;
                    if(!in_array($aus['id'],$arr)){
                        $arr[]=$aus['id'];
                    }
                }
            }
            if($fields['r_name']==''){echo json_encode(array('status'=>0,'msg'=>'角色名称不能为空'));exit();}

            $r_auth_ids = implode(',',$arr);
            $r_auth_ids = '0,'.$r_auth_ids.',0';
            $role_up    = array(
                'r_name'=>$fields['r_name'],
                'r_auth_ids'=>$r_auth_ids,
                'r_addtime'=>time(),
            );
            $r_id = $this->db->insert('w_role', $role_up);
            if($r_id){
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'添加失败'));exit();
            }
        }
        $auth	    =$this->db->query("select * from `w_auth` where a_pid=0 order by id asc", 3);
        foreach($auth as $k=>&$v){
            $v['child']	    =$this->db->query("select * from `w_auth` where a_pid='".$v['id']."' order by id asc", 3);
        }
        $auth=json_encode($auth);
        $this->display('role.add',array('user'=>$user,'role_id'=>0,'auth'=>$auth));
    }

    //角色编辑
    public function role_edit(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $role_id=$_GET['id'];
        if($this->post){
            header('Content-type:text/json');
            $fields = $_POST;
            if(isset($_POST['ids'])){
                $ids=$fields['ids'];
            }else{
                $ids=[];
            }

          //  if(empty($fields['ids'])){echo json_encode(array('status'=>0,'msg'=>'请选择对应权限'));exit();}
            $arr=[];
            foreach($ids as $k=>$v){
                $sql="select * from w_auth where id='".$v."'";
                $au=$this->db->query($sql,2);
                if($au['a_pid']==0){
                    $arr[]=$v;
                }else{
                    $sql="select * from w_auth where id='".$au['a_pid']."'";
                    $aus=$this->db->query($sql,2);
                    //var_dump($aus);
                    $arr[]=$v;
                    if(!in_array($aus['id'],$arr)){
                        $arr[]=$aus['id'];
                    }
                }
            }
            if($fields['r_name']==''){echo json_encode(array('status'=>0,'msg'=>'角色名称不能为空'));exit();}
            $r_auth_ids = implode(',',$arr);
            $r_auth_ids = '0,'.$r_auth_ids.',0';
            $role_up    = array(
                'r_name'=>$fields['r_name'],
                'r_auth_ids'=>$r_auth_ids,
                'r_addtime'=>time(),
            );
            $r_id = $this->db->update('w_role', $role_up,array('id'=>$role_id));
            if($r_id){
                echo json_encode(array('status'=>1,'msg'=>'编辑成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'编辑失败'));exit();
            }
        }
        $role	=$this->db->query("select * from `w_role` WHERE id='$role_id'", 2);
        $l_role = ltrim($role['r_auth_ids'], "0,");
        $r_role = rtrim($l_role, ",0");
        $m_auth = explode(',',$r_role);
       /* $auth	    =$this->db->query("select * from `w_auth` order by a_level asc", 3);
        foreach ($auth as $k => &$v){
          if(in_array($v['id'],$m_auth)){
              $v['is_checked'] = 1;
          }else{
              $v['is_checked'] = 0;
          }
        }*/
        $auth	    =$this->db->query("select * from `w_auth` where a_pid=0 order by id asc", 3);
        foreach($auth as $k=>&$v){
            $j=0;
            if(in_array($v['id'],$m_auth)){
                $v['is_checked'] = 1;
            }else{
                $v['is_checked'] = 0;
            }
            $child =$this->db->query("select * from `w_auth` where a_pid='".$v['id']."' order by id asc", 3);
            $v['count']=count($child);

            foreach($child as $k1=>&$v1){
                if(in_array($v1['id'],$m_auth)){
                    $j++;
                    $v1['is_checked'] = 1;
                }else{
                    $v1['is_checked'] = 0;
                }
            }
            $v['select']=$j;
            $v['child']=$child;
        }
/*var_dump($auth);
        exit;*/
        $auth=json_encode($auth);
        $this->display('role.add',array('user'=>$user,'role_id'=>$role_id,'role'=>$role,'auth'=>$auth));
    }
    //删除角色列表
    public function role_del(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
	    $id=$_POST['id'];
        $res=$this->db->query('delete from w_role where id='.$id,0);
        if($res){
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
        }else{
            echo json_encode(array('code'=>0,'msg'=>'删除失败'));exit();
        }

    }
    //权限列表
    public function auth_index(){
        $user		=$this->checkadmin();
        $this->display('auth.index',array('user'=>$user));
    }

    //权限数据
    public function auth_data(){
        $user		=$this->checkadmin();
        $auth	 	=$this->db->query("select * from `w_auth` order by a_addtime desc", 3);
        foreach($auth as &$rows){
            $rows['a_addtime']	=date('Y-m-d H:i:s',$rows['a_addtime']);
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>count($auth),'data'=>$auth));
        exit();
    }

    //权限添加
    public function auth_add(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if($this->post){
            header('Content-type:text/json');
            $fields = $this->SafeFilter($_POST);
            if($fields['a_name']==''){echo json_encode(array('status'=>0,'msg'=>'权限名称不能为空'));exit();}
            if($fields['a_ctl']==''){echo json_encode(array('status'=>0,'msg'=>'控制器名称不能为空'));exit();}
            if($fields['a_fun']==''){echo json_encode(array('status'=>0,'msg'=>'方法名称不能为空'));exit();}
            $auth	 =  $this->db->query("select * from `w_auth` WHERE `a_ctl` = '".$fields['a_ctl']."' and `a_fun` = '".$fields['a_fun']."'", 2);
            if(!empty($auth)){echo json_encode(array('status'=>0,'msg'=>'当前权限已存在'));exit();}
            $fields['a_addtime'] = time();
            $a_id = $this->db->insert('w_auth', $fields);
            if($a_id){
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'添加失败'));exit();
            }
        }else{
            $sql="select * from `w_auth` where `a_pid`='0'";
            $auth 	= $this->db->query($sql, 3);
            $this->display('auth.add',array('user'=>$user,'auth_id'=>0,'auth'=>$auth));
        }

    }

    //权限编辑
    public function auth_edit(){
        $user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        $a_id = $_GET['id'];
        if($this->post){
            header('Content-type:text/json');
            $fields = $this->SafeFilter($_POST);
            if($fields['a_name']==''){echo json_encode(array('status'=>0,'msg'=>'权限名称不能为空'));exit();}
            if($fields['a_ctl']==''){echo json_encode(array('status'=>0,'msg'=>'控制器名称不能为空'));exit();}
            if($fields['a_fun']==''){echo json_encode(array('status'=>0,'msg'=>'方法名称不能为空'));exit();}
            $auth	 =  $this->db->query("select * from `w_auth` WHERE `id`<> and '$a_id'`a_ctl` = '".$fields['a_ctl']."' and `a_fun` = '".$fields['a_fun']."'", 2);
            if(!empty($auth)){echo json_encode(array('status'=>0,'msg'=>'当前权限已存在'));exit();}
            $fields['a_addtime'] = time();
            $this->db->update('w_admin', $fields,array('id'=>$a_id));
            echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();
        }
        $auth = $this->db->query("select * from `w_auth` WHERE id='$a_id'", 2);
        $this->display('auth.add',array('user'=>$user,'auth_id'=>$a_id,'auth'=>$auth));
    }
}

?>