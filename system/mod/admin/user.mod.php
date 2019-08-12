<?php
class mod_user extends mod {
	public function index(){
		$user	 	 =$this->checkadmin();
		if(isset($_GET['pid']) && $_GET['pid']!=''){$pid=intval($_GET['pid']);}else{$pid=0;}
		if(isset($_GET['tid']) && $_GET['tid']!=''){$tid=intval($_GET['tid']);}else{$tid=0;}
		$u_levels	 =$this->base_levels;
		$this->display('user.index',array('user'=>$user,'u_levels'=>$u_levels,'pid'=>$pid,'tid'=>$tid));
	}
	public function tree(){
		$user	 	 =$this->checkadmin();
		if(isset($_GET['id']) && $_GET['id']!=''){$id=intval($_GET['id']);}else{$id=0;}
		$xxx=json_encode($this->getDowns($id,0));
		$this->display('user.tree',array('user'=>$user,'xxx'=>$xxx));
	}
	public function login(){
		$user	 	 =$this->checkadmin();
		$userid		 =intval($_GET['id']);
		$_SESSION['uid'] 	= $userid;
		$url_login	 ='/index.php?m=index&c=index';
		header( 'Location: ' . $url_login );
		exit;
	}
	public function userlist(){
		$user   =$this->checkadmin();
		$pid    =isset($_GET['pid'])?intval($_GET['pid']):0;
		$tid    =isset($_GET['tid'])?intval($_GET['tid']):0;
		$page   =isset($_GET['page']) && $_GET['page']!=''?intval($_GET['page']):1;
		$limit  =isset($_GET['limit']) && $_GET['limit']!=''?intval($_GET['limit']):20;

		$condtion="m_del=0";
		if($pid){$condtion	 .=' and m_pid='.$pid;}
		if($tid){$condtion	 .=' and m_tid='.$tid;}
		if(isset($_GET['s_name']) && $_GET['s_name']!=''){
			$s_name=urldecode($_GET['s_name']);
			$condtion.=" and (m_name like '%".$s_name."%' or m_weixin like '%".$s_name."%' or m_phone like '%".$s_name."%')";
		}
		$s_level    =isset($_GET['s_level']) && $_GET['s_level']!=''?intval($_GET['s_level']):-1;
		if($s_level>=0){
			$condtion.=" and m_level=".$s_level;
		}
		if(isset($_GET['s_regt']) && $_GET['s_regt']!=''){
			$s_regt	  	=urldecode($_GET['s_regt']);
			$s_times  	=explode(' - ',$s_regt);
			$s_btime	=strtotime(trim($s_times[0]));
			$s_etime	=strtotime(trim($s_times[1]));
			$condtion.=" and m_regtime>=".$s_btime." and m_regtime<=".$s_etime;
		}
		$query1  	="select * from w_users where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;		
		$query2  	="select count(id) as total from `w_users` where ".$condtion;
		$data1 		=$this->db->query($query1, 3);
		$data2 		=$this->db->query($query2, 2);
		foreach($data1 as &$row){
			$row['m_avatar']	=$row['m_avatar']==''?'/static/image/tx.jpg':$row['m_avatar'];
			if($this->config['w_shiming'] == 0){
                $row['m_user']		='<img src="'.$row['m_avatar'].'" class="m_avatar" /><a href="?m=user&c=index&tid='.$row['id'].'"> 昵称：'.$row['m_name'].'<br/>手机号：'.$row['m_phone'].'</a>';
            }else{
                $row['m_user']		='<img src="'.$row['m_avatar'].'" class="m_avatar" /><a href="?m=user&c=index&tid='.$row['id'].'"> 昵称：'.$row['m_name'].'<br/>手机号：'.$row['m_phone'].'<br/>真实姓名：'.$row['m_zsxm'].'<br/>身份证号：'.$row['m_carid'].'</a>';
            }
			$row['m_levels']	=$this->user_levels[$row['m_level']];			
			$row['t_user']		=$row['m_tid']<1?'无':'<a href="?m=user&c=index&tid='.$row['m_tid'].'">'.$this->getUser($row['m_tid']).'</a>';
			$row['p_user']		=$row['m_pid']<1?'无':'<a href="?m=user&c=index&pid='.$row['m_pid'].'">'.$this->getUser($row['m_pid']).'</a>';
			$row['m_regtime']	=date('Y-m-d H:i:s',$row['m_regtime']);
			$row['m_qrcode']	=$row['m_qrcode']==''?'':'<img src="'.$row['m_qrcode'].'">';
			if($row['m_lock']){
				$row['lock']		='<a class="layui-btn layui-btn-danger layui-btn-xs" href="javascript:t_lock('.$row['id'].')" id="uid_'.$row['id'].'">锁定</a>';
			}else{
				$row['lock']		='<a class="layui-btn layui-btn-normal layui-btn-xs" href="javascript:t_lock('.$row['id'].')" id="uid_'.$row['id'].'">正常</a>';
			}
			$data = $this->get_cash($row['id']);
			$row['c_num']       = $data['c_num'];
			$row['c_ov_num']    = $data['c_ov_num'];
			$row['m_gender']	=$this->user_gender[$row['m_gender']];
            $m_carimg 	        = array('0'=>'#','1'=>'#');
            if($row['m_carimg'] != false){
                $m_carimg = explode(',',$row['m_carimg']);
                $row['m_car_img']  = '<a href="'.$m_carimg['0'].'" class="layui-btn layui-btn-normal layui-btn-xs" target="_blank">反面</a>
								 <br/><a href="'.$m_carimg['1'].'" class="layui-btn layui-btn-normal layui-btn-xs" target="_blank">正面</a>';
            }
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
	}

	public function user_status(){
        $user   =   $this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        header('Content-type:text/json');
        if ($this->post) {
            $user_id =intval($_POST['id']);
            $is_rz = $this->db->update('w_users',array('m_rz'=>'1'),array('id'=>$user_id));
            if($is_rz){
                $this->sendcode($user['m_phone'], 'sm');
                echo json_encode(array('status'=>1,'msg'=>'认证成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'认证失败,检查用户状态'));exit();
            }
        }
    }

    //导出
    public function export_list(){
        $user = $this->checkadmin();
        $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
        $tid = isset($_GET['tid']) ? intval($_GET['tid']) : 0;
        $condtion = "m_del=0";
        if ($pid) {
            $condtion .= ' and m_pid=' . $pid;
        }
        if ($tid) {
            $condtion .= ' and m_tid=' . $tid;
        }
        if (isset($_GET['s_name']) && $_GET['s_name'] != '') {
            $s_name = urldecode($_GET['s_name']);
            $condtion .= " and (m_name like '%" . $s_name . "%' or m_weixin like '%" . $s_name . "%' or m_phone like '%" . $s_name . "%')";
        }
        $s_level = isset($_GET['s_level']) && $_GET['s_level'] != '' ? intval($_GET['s_level']) : -1;
        if ($s_level >= 0) {
            $condtion .= " and m_level=" . $s_level;
        }
        if (isset($_GET['s_regt']) && $_GET['s_regt'] != '') {
            $s_regt = urldecode($_GET['s_regt']);
            $s_times = explode(' - ', $s_regt);
            $s_btime = strtotime(trim($s_times[0]));
            $s_etime = strtotime(trim($s_times[1]));
            $condtion .= " and m_regtime>=" . $s_btime . " and m_regtime<=" . $s_etime;
        }
        $query1 = "select * from w_users where ".$condtion ." order by id desc";
        $data1 = $this->db->query($query1, 3);
        $title_arr = explode(',', 'ID,昵称,手机号,阶段,推荐人,节点人,性别,注册时间');
        $datas_arr = array();
        foreach ($data1 as &$row) {
            $data_arr = array(
                $row['id'] = $row['id'],
                $row['m_name'] = $row['m_name'],
                $row['m_phone'] = $row['m_phone'],
                $row['m_levels'] = $this->user_levels[$row['m_level']],
                $row['t_user'] = $row['m_tid'] < 1 ? '无' :  $this->getUsers($row['m_tid']),
                $row['p_user'] = $row['m_pid'] < 1 ? '无' :  $this->getUsers($row['m_pid']),
                $row['m_gender'] = $this->user_gender[$row['m_gender']],
                $row['m_regtime'] = date('Y-m-d H:i:s', $row['m_regtime']),
            );
            array_push($datas_arr, $data_arr);
        }
        $file_name = '用户数据'.date('Y-m-d H:i:s',time()). '.xls';
        $this->exportToExcel($file_name, $title_arr, $datas_arr);
    }


    public function logs(){
        $user	 =$this->checkadmin();
        if(isset($_GET['id']) && $_GET['id']!=''){$user_id=intval($_GET['id']);}else{$user_id=0;}
        $this->display('user.logs',array('user'=>$user,'user_id'=>$user_id));
    }

    public function log_list(){
        $user     =$this->checkadmin();
        $l_uid    =isset($_GET['id'])?intval($_GET['id']):0;
        $page     =(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
        $limit    =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
        $condition="1";
        if($l_uid){$condition	 .=' and l_uid='.$l_uid;}
        if(isset($_GET['s_regt']) && $_GET['s_regt']!=''){
            $s_regt	  	=urldecode($_GET['s_regt']);
            $s_times  	=explode(' - ',$s_regt);
            $s_btime	=strtotime(trim($s_times[0]));
            $s_etime	=strtotime(trim($s_times[1]));
            $condition.=" and l_time>=".$s_btime." and l_time<=".$s_etime;
        }
        $query1  	="select * from w_logs where ".$condition." order by l_time desc limit ".$limit*($page-1).",".$limit;
        $query2  	="select count(id) as total from `w_logs` where ".$condition;
        $data1 		=$this->db->query($query1, 3);
        $data2 		=$this->db->query($query2, 2);
        foreach($data1 as &$row){
            $row['l_uid']		=$this->getUser($row['l_uid']);
            $row['l_type']		='余额';
            $row['l_time']		=date('Y-m-d H:i:s',$row['l_time']);
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
    }

    public function del_log(){
        $user   =$this->checkadmin();
        header('Content-type:text/json');
        if ($this->post) {
            $userid =intval($_POST['id']);
            $this->db->query('delete from w_logs where id='.$userid,0);
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
        }
    }


	public function t_lock(){
		$user   =$this->checkadmin();
		header('Content-type:text/json');
		if ($this->post) {
			$userid=intval($_POST['uid']);
			$users	=$this->db->query('select * from w_users where id='.$userid, 2);
			if($users){
				if($users['m_lock']){
					$this->db->update('w_users', array('m_lock'=>0),array('id'=>$userid));
					echo json_encode(array('code'=>0,'msg'=>'已解锁'));exit();				 
				}else{
					$this->db->update('w_users', array('m_lock'=>1),array('id'=>$userid));	
					echo json_encode(array('code'=>1,'msg'=>'已锁定'));exit();
				}
			}
			
		}	
	}
	public function del(){
		$user   =$this->checkadmin();
		header('Content-type:text/json');
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
			$userid =intval($_POST['id']);
			if($userid){
				$query		= "select * from w_users where id=".$userid;
				$member		= $this->db->query($query, 2);
				if($member){
					$this->db->update('w_users', array('m_del'=>1),array('id'=>$userid));
					if($member['m_pid']){
						$m_pid		= $member['m_pid'];
						$query		= "select * from w_users where id='".$m_pid."' and m_del=0";
						$member		= $this->db->query($query, 2);
						$m_num		= $member['m_num']-1;
						$this->db->update('w_users', array('m_num'=>$m_num),array('id'=>$m_pid));
					}
				}else{
					echo json_encode(array('code'=>0,'msg'=>'无效的用户'));exit();
				}
				echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
			}else{
				echo json_encode(array('code'=>0,'msg'=>'无效的用户'));exit();
			}
			//会员被标记为删除的，团队不上移，占位有效 匹配订单是匹配给默认账号 即删除会员所获得的订单，将直接分配给默认账号。
			//需要做的修改是，将上级节点人的m_num-1;
		}
	}
	public function add_user(){
		$user	 	 =$this->checkadmin();
		$u_levels	 =$this->base_levels;
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['m_name']==''){echo json_encode(array('status'=>0,'msg'=>'真实姓名不能为空'));exit();}
			if($fields['m_phone']==''){echo json_encode(array('status'=>0,'msg'=>'手机号码不能为空'));exit();}
			if($fields['m_pass']==''){echo json_encode(array('status'=>0,'msg'=>'登录密码不能为空'));exit();}
			$m_phone	=$fields['m_phone'];
			$query		="select * from w_users where m_phone='$m_phone' and m_del=0";
			$member		= $this->db->query($query, 2);
			if(!empty($member)){echo json_encode(array('status'=>0,'msg'=>'当前手机号码已经注册'));exit();}
			
			$m_tid		=$fields['m_tid']==''?0:intval($fields['m_tid']);
            $m_line		='0';
			if(isset($fields['m_pid'])){ //如果填写了PID 则按照填写PID走
				$m_pid   = $fields['m_pid']==''?0:intval($fields['m_pid']);
				if($m_pid>0){
					$t_user  = $this->db->query("select * from w_users where id='$m_pid' and m_del=0", 2);
					if(empty($t_user)){echo json_encode(array('status'=>0,'msg'=>'节点人不存在'));exit();}
				}
			}else{              //未填写 则按系统规则走
				$m_pid	 = $this->getPidbyTid($m_tid);
			}
			
			$query		= "select * from w_users where id='".$m_pid."' and m_del=0";
			$member		= $this->db->query($query, 2);
			if(!empty($member)){//如果节点人存在 则获取m_line信息
				$m_line		= $member['m_line'];
			}

			$member	=array(
				'm_tid'				=>$m_tid,
				'm_pid'				=>$m_pid,
				'm_name'			=>$fields['m_name'],
				'm_gender'			=>$fields['m_gender'],
				'm_phone'			=>$fields['m_phone'],
				'm_pass'			=>md5($fields['m_pass']),
				'm_level'			=>intval($fields['m_level']),
				'm_avatar'			=>$fields['m_avatar'],
				'm_infos'			=>strlen($fields['m_infos'])>180?substr($fields['m_infos'],0,180):$fields['m_infos'],
				'm_regtime'			=>time(),
				'm_yqm'			    =>$this->MakeKey(),
			);
            if($this->config['w_xinyu']){
                $member['m_score'] = $this->config['w_xinyu1'];
            }
			$memberid=$this->db->insert('w_users', $member);
			if($memberid){//更新会员节点序列及所在层次
				$this->db->update('w_users', array('m_line'=>$m_line.','.$memberid,'m_layer'=>count(explode(',',$m_line))),array('id'=>$memberid));
				if($m_pid){//更新节点人的一层人数
					$query		= "select * from w_users where id='".$m_pid."' and m_del=0";
					$member		= $this->db->query($query, 2);
					if($member){
						$m_num		= $member['m_num']+1;
						$this->db->update('w_users', array('m_num'=>$m_num),array('id'=>$m_pid));	
					}
				}
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
			}							
			
		}else{
			$this->display('user.add',array('user'=>$user,'u_levels'=>$u_levels,'userid'=>0));
		}
	}

    public function edit_user(){
        $user	 		=$this->checkadmin();
        $u_levels	 	=$this->base_levels;
        $userid	 		=intval($_GET['id']);
        $members			=$this->db->query('select * from w_users where id='.$userid, 2);

        if ($this->post) {
            header('Content-type:text/json');
            $fields 	= $_POST;
            if($fields['m_name']==''){echo json_encode(array('status'=>0,'msg'=>'真实姓名不能为空'));exit();}
            if($fields['m_phone']==''){echo json_encode(array('status'=>0,'msg'=>'手机号码不能为空'));exit();}
            $m_phone	= $fields['m_phone'];
            $query		= "select * from w_users where m_phone='$m_phone' and m_del=0 and id<>".$userid;
            $member		= $this->db->query($query, 2);
            if(!empty($member)){echo json_encode(array('status'=>0,'msg'=>'当前手机号码已经存在'));exit();}

            if($fields['m_tid']==''){echo json_encode(array('status'=>0,'msg'=>'推荐人ID不能为空'));exit();}
            if($fields['m_tid']== $userid){echo json_encode(array('status'=>0,'msg'=>'推荐人不能是自己'));exit();}
            $m_tid      = intval($fields['m_tid']);
            if($m_tid != 0){
                $t_user =  $this->db->query("select * from w_users where id='$m_tid' and m_del=0", 2);
                if(empty($t_user)){echo json_encode(array('status'=>0,'msg'=>'推荐人不存在'));exit();}
            }

            if($this->config['w_frame']==1 && $this->config['w_hualuo']==0){//无限直推 且未开启滑落  //节点人=推荐人 只显示和接收m_tid
                $m_pid   = $m_tid;
            }else{  //滑落状态 接点人和推荐人 可能不是同一个人

                $m_pid   = $fields['m_pid']==''?0:intval($fields['m_pid']);
                if($m_pid == $userid){ echo json_encode(array('status'=>0,'msg'=>'节点人不能是自己'));exit();}
                if($m_pid>0){
                    $t_user  = $this->db->query("select * from w_users where id='$m_pid' and m_del=0", 2);
                    if(empty($t_user)){echo json_encode(array('status'=>0,'msg'=>'节点人不存在'));exit();}
                }

            }
            if($m_pid != $members['m_pid']){       //如果修改了推荐人 则修改 节点人
                $this->changepid($userid,$m_pid);
            }
            $member	=array(
                'm_tid'             =>$m_tid,
                'm_name'			=>$fields['m_name'],
                'm_gender'			=>$fields['m_gender'],
                'm_phone'			=>$fields['m_phone'],
                'm_level'			=>intval($fields['m_level']),
                'm_avatar'			=>$fields['m_avatar'],
                'm_infos'			=>strlen($fields['m_infos'])>180?substr($fields['m_infos'],0,180):$fields['m_infos']
            );
            if($fields['m_pass']!=''){
                $member['m_pass']=md5($fields['m_pass']);
            }
            $this->db->update('w_users',$member,array('id'=>$userid));
            echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();
        }else{
            $this->display('user.add',array('user'=>$user,'u_levels'=>$u_levels,'userid'=>$userid,'member'=>$members));
        }
    }

    public function recharge(){
        $user   =$this->checkadmin();
        header('Content-type:text/json');
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if ($this->post) {
            $l_num  =intval($_POST['l_num']);
            $l_uid  =intval($_POST['l_uid']);
            $l_info	='管理员操作:'.$_POST['l_info'];
            $res    = $this->do_logs($l_uid,1,$l_num,$l_info);
            if($res){
                echo json_encode(array('code'=>1,'msg'=>'充值成功'));exit();
            }else{
                echo json_encode(array('code'=>0,'msg'=>'充值失败'));exit();
            }
        }
    }

    //回收站
    public function recover_user(){
        $user	 	 =$this->checkadmin();
        if(isset($_GET['pid']) && $_GET['pid']!=''){$pid=intval($_GET['pid']);}else{$pid=0;}
        if(isset($_GET['tid']) && $_GET['tid']!=''){$tid=intval($_GET['tid']);}else{$tid=0;}
        $u_levels	 =$this->base_levels;
        $this->display('recover.user',array('user'=>$user,'u_levels'=>$u_levels,'pid'=>$pid,'tid'=>$tid));
    }

    //回收站
    public function recover_data(){
        $user   =$this->checkadmin();
        $pid    =isset($_GET['pid'])?intval($_GET['pid']):0;
        $tid    =isset($_GET['tid'])?intval($_GET['tid']):0;
        $page   =isset($_GET['page']) && $_GET['page']!=''?intval($_GET['page']):1;
        $limit  =isset($_GET['limit']) && $_GET['limit']!=''?intval($_GET['limit']):10;

        $condtion="m_del=1";
        if($pid){$condtion	 .=' and m_pid='.$pid;}
        if($tid){$condtion	 .=' and m_tid='.$tid;}
        if(isset($_GET['s_name']) && $_GET['s_name']!=''){
            $s_name=urldecode($_GET['s_name']);
            $condtion.=" and (m_name like '%".$s_name."%' or m_weixin like '%".$s_name."%' or m_phone like '%".$s_name."%')";
        }
        $s_level    =isset($_GET['s_level']) && $_GET['s_level']!=''?intval($_GET['s_level']):-1;
        if($s_level>=0){
            $condtion.=" and m_level=".$s_level;
        }
        $query1  	="select * from w_users where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;
        $query2  	="select count(id) as total from `w_users` where ".$condtion;
        $data1 		=$this->db->query($query1, 3);
        $data2 		=$this->db->query($query2, 2);
        foreach($data1 as &$row){
            $row['m_avatar']	=$row['m_avatar']==''?'/static/image/tx.jpg':$row['m_avatar'];
            $row['m_user']		='<img src="'.$row['m_avatar'].'" class="m_avatar" /><a href="?m=user&c=index&tid='.$row['id'].'">'.$row['m_name'].'<br/>'.$row['m_phone'].'</a>';
            $row['m_levels']	=$this->user_levels[$row['m_level']];
            $row['t_user']		=$row['m_tid']<1?'无':'<a href="?m=user&c=index&tid='.$row['m_tid'].'">'.$this->getUser($row['m_tid']).'</a>';
            $row['p_user']		=$row['m_pid']<1?'无':'<a href="?m=user&c=index&pid='.$row['m_pid'].'">'.$this->getUser($row['m_pid']).'</a>';
            $row['m_regtime']	=date('Y-m-d H:i:s',$row['m_regtime']);
            $row['m_gender']	=$this->user_gender[$row['m_gender']];
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
    }

    //恢复用户
    public function user_reply(){
        $user   =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        header('Content-type:text/json');
        if ($this->post) {
            $userid =intval($_POST['id']);
            if($userid){
                $query		= "select * from w_users where id=".$userid;
                $member		= $this->db->query($query, 2);
                if($member){
                    $this->db->update('w_users', array('m_del'=>0),array('id'=>$userid));
                    if($member['m_pid']){
                        $m_pid		= $member['m_pid'];
                        $query		= "select * from w_users where id='".$m_pid."' and m_del=0";
                        $member		= $this->db->query($query, 2);
                        $m_num		= $member['m_num']+1;
                        $this->db->update('w_users', array('m_num'=>$m_num,'m_del'=>'0'),array('id'=>$m_pid));
                    }
                }else{
                    echo json_encode(array('code'=>0,'msg'=>'无效的用户'));exit();
                }
                echo json_encode(array('code'=>1,'msg'=>'恢复成功'));exit();
            }else{
                echo json_encode(array('code'=>0,'msg'=>'无效的用户'));exit();
            }
        }
    }

    //彻底删除用户
    public function user_del(){
        $user   =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        header('Content-type:text/json');
        if($this->post){
            $user_id =intval($_POST['id']);
            if($user_id){
                $query		= "select * from w_users where id=".$user_id;
                $member		= $this->db->query($query, 2);
                if($member['m_del'] == 1){
                    $this->db->query('delete from w_users where m_del=1 and id='.$user_id,0);
                    echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
                }else{
                    echo json_encode(array('code'=>0,'msg'=>'状态有误'));exit();
                }
            }
        }
    }


	public function wlogs(){
		$user	 	 =$this->checkadmin();
		if(isset($_GET['id']) && $_GET['id']!=''){$id=intval($_GET['id']);}else{$id=0;}
		$u_levels	 =$this->base_levels;
		$status_name =array('待审核','已审核');
		$this->display('user.wlogs',array('user'=>$user,'u_levels'=>$u_levels,'id'=>$id,'status_name'=>$status_name));
	}
	public function del_w(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$bankid		=intval($_POST['id']);
		$this->db->query('delete from w_wlog where id='.$bankid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}
	public function done_w(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$logid		=intval($_POST['id']);
		$logs		=$this->db->query('select * from w_wlog where id='.$logid,2);
		if($logs){
			if($logs['l_status']==0){
				$this->db->update('w_users', array('m_weixin'=>$logs['l_new']),array('id'=>$logs['l_uid']));
				$this->db->update('w_wlog', array('l_status'=>1),array('id'=>$logid));
				echo json_encode(array('code'=>1,'msg'=>'成功'));exit();	
			}else{
				echo json_encode(array('code'=>0,'msg'=>'已审核,请勿重复审核'));exit();	
			}
		}else{
			echo json_encode(array('code'=>0,'msg'=>'失败'));exit();
    }
	}
	public function w_list(){
		$user			=$this->checkadmin();
		$status_name 	=array('待审核','已审核');		
		$user_id	    =isset($_GET['user_id'])?intval($_GET['user_id']):0;
		$s_stat	    	=isset($_GET['stat'])?intval($_GET['stat']):-1;
		$page    		=(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
		$limit    		=(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
		$condtion		="1";
		if($user_id){	$condtion	 .=' and l_uid='.$user_id;}
		if($s_stat>=0){	$condtion	 .=' and l_status='.$s_stat;}
		
		if(isset($_GET['s_regt']) && $_GET['s_regt']!=''){
			$s_regt	  	=urldecode($_GET['s_regt']);
			$s_times  	=explode(' - ',$s_regt);
			$s_btime	=strtotime(trim($s_times[0]));
			$s_etime	=strtotime(trim($s_times[1]));
			$condtion.=" and l_time>=".$s_btime." and l_time<=".$s_etime;
		}
		
		$query1  	="select * from w_wlog where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;		
		$query2  	="select count(id) as total from `w_wlog` where ".$condtion;
		$data1 		=$this->db->query($query1, 3);
		$data2 		=$this->db->query($query2, 2);
		foreach($data1 as &$row){
			  $row['user_info'] ='<a href="?m=user&c=wlogs&id='.$row['l_uid'].'">'.$this->getUser($row['l_uid']).'</a>';
			  $row['l_time'] 	=date('Y-m-d H:i:s',$row['l_time']);
				if($row['l_status']==0){
					$row['status']='<a class="layui-btn layui-btn-danger layui-btn-xs">待审核</a>';
				}else{
					$row['status']='<a class="layui-btn layui-btn-normal layui-btn-xs">已审核</a>';
				}		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
		exit();
	
	}
	public function mlogs(){
		$user	 	 =$this->checkadmin();
        if(isset($_GET['id']) && $_GET['id']!=''){$id=intval($_GET['id']);}else{$id=0;}
        $u_levels	 =$this->base_levels;
        $status_name =array('待处理','已处理');
        $this->display('user.mlogs',array('user'=>$user,'u_levels'=>$u_levels,'id'=>$id,'status_name'=>$status_name));
	}
	public function m_list(){
		$user			=$this->checkadmin();
		$status_name 	=array('待处理','已处理');		
		$user_id	    =isset($_GET['user_id'])?intval($_GET['user_id']):0;
		$s_stat	    	=(isset($_GET['stat']) && $_GET['stat']!='')?intval($_GET['stat']):-1;
		$page    		=(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
		$limit    		=(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
		$condtion		="1";
		if($user_id){	$condtion	 .=' and m_uid='.$user_id;}
		if($s_stat>=0){	$condtion	 .=' and m_status='.$s_stat;}
		if(isset($_GET['s_regt']) && $_GET['s_regt']!=''){
			$s_regt	  	=urldecode($_GET['s_regt']);
			$s_times  	=explode(' - ',$s_regt);
			$s_btime	=strtotime(trim($s_times[0]));
			$s_etime	=strtotime(trim($s_times[1]));
			$condtion.=" and m_ctime>=".$s_btime." and m_ctime<=".$s_etime;
		}
		$query1  	="select * from w_message where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;		
		$query2  	="select count(id) as total from `w_message` where ".$condtion;
		$data1 		=$this->db->query($query1, 3);
		$data2 		=$this->db->query($query2, 2);
		foreach($data1 as &$row){
			$row['user_info'] 	='<a href="?m=user&c=mlogs&id='.$row['m_uid'].'">'.$this->getUser($row['m_uid']).'</a>';
			$row['m_ctime'] 	=date('Y-m-d H:i:s',$row['m_ctime']);
			$row['m_dtime'] 	=date('Y-m-d H:i:s',$row['m_dtime']);
			$row['suit_type'] 	=$this->suit_type[$row['m_type']];;
			if($row['m_status']==0){
				$row['status']	='<a class="layui-btn layui-btn-danger layui-btn-xs">待处理</a>';
			}else{
				$row['status']	='<a class="layui-btn layui-btn-normal layui-btn-xs">已处理</a>';
			}
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
		exit();
	}
	public function del_m(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$bankid		=intval($_POST['id']);
		$this->db->query('delete from w_message where id='.$bankid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}
	public function done_m(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$logid		=intval($_POST['id']);
		$logs		=$this->db->query('select * from w_message where id='.$logid,2);
		if($logs){
			if($logs['m_status']==0){
				$this->db->update('w_message', array('m_status'=>1,'m_dtime'=>time()),array('id'=>$logid));
				echo json_encode(array('code'=>1,'msg'=>'成功'));exit();	
			}else{
				echo json_encode(array('code'=>0,'msg'=>'已审核,请勿重复审核'));exit();	
			}
		}else{
			echo json_encode(array('code'=>0,'msg'=>'失败'));exit();
		}
	}
	
	public function uplist(){
		$user			=$this->checkadmin();
        $j_type	        =array('0'=>'其他','1'=>'信用卡','2'=>'房贷','3'=>'车贷','4'=>'其他');
		$nid   	=(isset($_GET['n_id'])&&$_GET['n_id']!='')?intval($_GET['n_id']):0;
		$status =(isset($_GET['status'])&&$_GET['status']!='')?intval($_GET['status']):-1;
		$level	=(isset($_GET['level'])&&$_GET['level']!='')?intval($_GET['level']):-1;
		$page  	=(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
		$limit  =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
		
		$condtion		="1";
		if($status>=0)	{$condtion	 .=' and status='.$status;}
		if($nid>0)		{$condtion	 .=' and uid='.$nid.' or sid='.$nid;}
		if($level>=0)	{$condtion	 .=' and level='.$level;}
		
		if(isset($_GET['c_time']) && $_GET['c_time']!=''){
			$s_regt	  	=urldecode($_GET['c_time']);
			$s_times  	=explode(' - ',$s_regt);
			$s_btime	=strtotime(trim($s_times[0]));
			$s_etime	=strtotime(trim($s_times[1]));
			$condtion.=" and c_time>=".$s_btime." and c_time<=".$s_etime;
		}
		
		if(isset($_GET['d_time']) && $_GET['d_time']!=''){
			$s_regt	  	=urldecode($_GET['d_time']);
			$s_times  	=explode(' - ',$s_regt);
			$s_btime	=strtotime(trim($s_times[0]));
			$s_etime	=strtotime(trim($s_times[1]));
			$condtion.=" and d_time>=".$s_btime." and d_time<=".$s_etime;
		}
		
		$query1  	="select * from w_uplevel where ".$condtion." order by id desc limit ".$limit*($page-1).",".$limit;		
		$query2  	="select count(id) as total from `w_uplevel` where ".$condtion;
		$data1 		=$this->db->query($query1, 3);
		$data2 		=$this->db->query($query2, 2);
		foreach($data1 as &$row){
				$row['u_user']	  =$this->getUser($row['uid']);
				$row['s_user']	  =$this->getUser($row['sid']);
				$row['c_time']	  =$row['c_time']==0?'暂无':date('Y-m-d H:i:s',$row['c_time']);
				$row['d_time']	  =$row['d_time']==0?'暂无':date('Y-m-d H:i:s',$row['d_time']);
				$row['level']	  ='第'.$row['level'].'阶段';
                $row['l_pay_img'] ='<img src="'.$row['l_pay_img'].'" class="l_pay_img" />';
				if($row['status']==0){
					$row['s_status']='<a class="layui-btn layui-btn-danger layui-btn-xs">待打款</a>';
				}elseif($row['status']==1){
					$row['s_status']='<a class="layui-btn layui-btn-normal layui-btn-xs">已打款</a>';
				}elseif($row['status']==2){
                    $row['s_status']='<a class="layui-btn layui-btn-normal layui-btn-xs">已确认</a>';
                }
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
		exit();
	}
	
	public function uplevel(){
		$user			=$this->checkadmin();
		$status_name	=array('待打款','已打款','已确认');
		$uid			=isset($_GET['uid'])?intval($_GET['uid']):0;
		$sid			=isset($_GET['sid'])?intval($_GET['sid']):0;
		$u_levels	 	=$this->base_levels;
		$this->display('user.uplevel',array('user'=>$user,'sid'=>$sid,'uid'=>$uid,'status'=>$status_name,'levels'=>$u_levels));	
	}

	public function del_up(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$bankid		=intval($_POST['id']);
		$this->db->query('delete from w_uplevel where id='.$bankid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}


	public function shen_up(){
		$user   =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		header('Content-type:text/json');
		if ($this->post) {
			$logid = intval($_POST['id']);
			$u_log = $this->db->query('select * from w_uplevel where id='.$logid, 2);
			if(!empty($u_log)){
				if($u_log['status'] == 2){
					echo json_encode(array('code'=>0,'msg'=>'已审核,请勿重复审核'));exit();				 
				}else{
					if($this->upgrade_do($logid)>0){
						echo json_encode(array('code'=>1,'msg'=>'审核成功'));exit();
					}else{
						echo json_encode(array('code'=>0,'msg'=>'发生未知错误'));exit();
					}					
				}
			}
		}	
	}
	public function jh_list(){
        $user			=$this->checkadmin();
        $j_type	        =array('0'=>'其他','1'=>'信用卡','2'=>'房贷','3'=>'车贷','4'=>'其他');
        $uid			=isset($_GET['uid'])?intval($_GET['uid']):0;
        $sid			=isset($_GET['sid'])?intval($_GET['sid']):0;
        $u_levels	 	=$this->base_levels;
        $this->display('user.jihua',array('user'=>$user,'sid'=>$sid,'uid'=>$uid,'status'=>$j_type,'levels'=>$u_levels));
    }

    public function jh_data(){
        $user			=$this->checkadmin();
        $j_type	        =array('0'=>'其他','1'=>'信用卡','2'=>'房贷','3'=>'车贷','4'=>'其他');
        $nid   	=(isset($_GET['n_id'])&&$_GET['n_id']!='')?intval($_GET['n_id']):0;
        $status =(isset($_GET['status'])&&$_GET['status']!='')?intval($_GET['status']):0;
        $page  	=(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
        $limit  =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
        $condition		="1";
        if($status>0) {$condition	 .=' and j_type='.$status;}
        if($nid>0)		{$condition	 .=' and j_uid='.$nid;}
        if(isset($_GET['c_time']) && $_GET['c_time']!=''){
            $s_regt	  	=urldecode($_GET['c_time']);
            $s_times  	=explode(' - ',$s_regt);
            $s_btime	=strtotime(trim($s_times[0]));
            $s_etime	=strtotime(trim($s_times[1]));
            $condition  .=" and j_ctime>=".$s_btime." and j_ctime<=".$s_etime;
        }

        if(isset($_GET['d_time']) && $_GET['d_time']!=''){
            $s_regt	  	=urldecode($_GET['d_time']);
            $s_times  	=explode(' - ',$s_regt);
            $s_btime	=strtotime(trim($s_times[0]));
            $s_etime	=strtotime(trim($s_times[1]));
            $condition .=" and j_dtime>=".$s_btime." and j_dtime<=".$s_etime;
        }
        $query1  	="select * from w_jihua where ".$condition." order by j_id desc limit ".$limit*($page-1).",".$limit;
        $query2  	="select count(j_id) as total from `w_jihua` where ".$condition;
        $data1 		=$this->db->query($query1,3);
        $data2 		=$this->db->query($query2,2);
        foreach($data1 as &$row){
            $row['u_user']	    =$this->getUser($row['j_uid']);
            $row['j_ctime']	    =$row['j_ctime']==0?'暂无':date('Y-m-d H:i:s',$row['j_ctime']);
            $row['j_dtime']	    =$row['j_dtime']==0?'暂无':date('Y-m-d H:i:s',$row['j_dtime']);
            $row['j_type_name'] =$j_type[$row['j_type']];
            if($row['j_status'] == 0){
                $row['j_sta_name']='<a class="layui-btn layui-btn-danger layui-btn-xs">发起借款</a>';
            }elseif($row['j_status'] == 1){
                $row['j_sta_name']='<a class="layui-btn layui-btn-normal layui-btn-xs">通过</a>';
            }elseif($row['j_status']==2){
                $row['j_sta_name']='<a class="layui-btn layui-btn-normal layui-btn-xs">拒绝</a>';
            }
            $row['j_bor_img']   ='<img src="'.$row['j_bor_img'].'" class="j_bor_img" />';
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>$data2['total'],'data'=>$data1));
        exit();
    }


    public function shen_jihua(){
        $user   =$this->checkadmin();
        header('Content-type:text/json');
        if ($this->post) {
            $j_id    = intval($_POST['j_id']);
            $u_jihua = $this->db->query('select * from w_jihua where j_id='.$j_id, 2);
            $cash = $this->db->query('select * from w_cash where `c_status`=1 c_uid='.$u_jihua['j_uid'], 2);
            if(!empty($cash)){ echo json_encode(array('code'=>0,'msg'=>'已有还款计划已激活'));exit();}
            if(!empty($u_jihua)){
                if($u_jihua['j_status']){
                    echo json_encode(array('code'=>0,'msg'=>'已审核,请勿重复审核'));exit();
                }else{
                    $is_res = $this->db->update('w_jihua',array('j_status'=>'1','j_dtime'=>time()),array('j_id'=>$j_id));
                    if($is_res){
                        $this->set_cash($u_jihua['j_uid'],$j_id);
                        $this->sendcode($user['m_phone'], 'upzw');
                        echo json_encode(array('code'=>1,'msg'=>'审核成功'));exit();
                    }else{
                        echo json_encode(array('code'=>0,'msg'=>'发生未知错误'));exit();
                    }
                }
            }
        }
    }
    public function del_jihua(){
        $user		= $this->checkadmin();
        $j_id		= intval($_POST['j_id']);
        $u_jihua    = $this->db->query('select * from w_jihua where j_status <> 1 and j_id='.$j_id, 2);
        if(!empty($u_jihua)){
            $this->db->query('delete from w_jihua where j_id='.$j_id,0);
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
        }else{
            echo json_encode(array('code'=>1,'msg'=>'订单状态有误'));exit();
        }
    }
	
}
