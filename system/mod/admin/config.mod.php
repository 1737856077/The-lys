<?php

class mod_config extends mod {
	public function basic(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
            unset($_POST['file']);
			$config=$_POST;
			$this->db->update('w_config', $config,array('id'=>1));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
		$config	= $this->db->query('select * from w_config where id=1',2);
		$levels	= $this->db->query('select * from w_level order by id limit 0,'.$config['w_level'],3);
		$this->display('config.basic',array('user'=>$user,'config'=>$config,'levels'=>$levels));			 
	}
	public function switchlevel(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
			$fields 	= $_POST;
			$this->db->update('w_config', $fields,array('id'=>1));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
	}
	public function about(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$id 	=intval($_GET['id']);
		if ($this->post) {
			$config=array(
				'n_content'	=>$_POST['n_content']
			);
			$this->db->update('w_about', $config,array('id'=>$id));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
		$about	=$this->db->query('select * from w_about where id='.$id,2);
		$this->display('config.about',array('user'=>$user,'about'=>$about));		
	}

	public function save_credit(){
        $user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if ($this->post) {
            $type = $_POST['type'];
            if($type == 1){
                $this->db->update('w_users',array('m_score'=>$this->config['w_xinyu1']) ,array('m_del'=>0));
                echo json_encode(array('status'=>1,'msg'=>'更新成功'));exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'更新失败'));exit();
            }

        }
    }
	public function sms(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
			$sms=array(
				'w_user_name'	=>$_POST['w_user_name'],
				'w_user_pass'	=>$_POST['w_user_pass'],
				'w_user_reg'	=>$_POST['w_user_reg'],
				'w_user_reg_sms'=>$_POST['w_user_reg_sms'],
				'w_user_rep'	=>$_POST['w_user_rep'],
				'w_user_rep_sms'=>$_POST['w_user_rep_sms'],
				'w_user_dnt'	=>$_POST['w_user_dnt'],
				'w_user_dnt_sms'=>$_POST['w_user_dnt_sms'],
				'w_user_snt'	=>$_POST['w_user_snt'],
                'w_user_snt_sms'=>$_POST['w_user_snt_sms'],
				'w_user_pay'	=>$_POST['w_user_pay'],
				'w_user_pay_sms'=>$_POST['w_user_pay_sms'],
				'w_user_sm'     =>$_POST['w_user_sm'],
				'w_user_sm_sms' =>$_POST['w_user_sm_sms'],
				'w_user_upzw'   =>$_POST['w_user_upzw'],
				'w_user_upzw_sms'=>$_POST['w_user_upzw_sms'],
				'w_user_qrsk'   =>$_POST['w_user_qrsk'],
				'w_user_qrsk_sms'=>$_POST['w_user_qrsk_sms'],
			);
			$this->db->update('w_sms', $sms,array('id'=>1));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
		$sms	=$this->db->query('select * from w_sms where id=1',2);
		$this->display('config.sms',array('user'=>$user,'sms'=>$sms));			 
	}
	public function upload(){
		if($_FILES["file"]["error"]){
			echo json_encode(array('code'=>1,'msg'=>'发生错误'));exit();
		}else{
			if(($_FILES["file"]["type"]=="image/png"||$_FILES["file"]["type"]=="image/jpeg")&&$_FILES["file"]["size"]<1024000){
					$filename =substr(strrchr($_FILES["file"]["name"], '.'), 1);
					$filename ="./static/upload/".date('Ymd',time()).$this->getMillisecond().'.'.$filename;
					if(file_exists($filename)){
						echo json_encode(array('code'=>1,'msg'=>'刷新后重试'));exit();
					}else{  
						move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
						echo json_encode(array('code'=>0,'msg'=>$filename));exit();    
					}        
			}else {
				echo json_encode(array('code'=>1,'msg'=>'类型不允许'));exit();
			}
		}
	}
	public function level(){
		$user	=$this->checkadmin();
		$levels	=$this->db->query('select * from w_level order by id limit 0,'.$this->config['w_level'],3);
		$this->display('config.level',array('user'=>$user,'levels'=>$levels));		 
	}

	// 点击保存 ---- 更新数据样式
	public function style(){
		$user	=$this->checkadmin();
		if ($this->post) {
			$s_id		=		$_POST['s_id'];
			$style	=array(
				's_name'	=>$_POST['s_name'],
				's_url'		=>$_POST['s_url'],
				's_icon'	=>$_POST['s_icon'],
				's_sort'	=>$_POST['s_sort']
			);
			$this->db->update('w_style',$style,array('s_id'=>$s_id));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
		$styles	=$this->db->query('select * from w_style where s_display=1 order by s_sort asc',3);
		if($styles){
			foreach($styles as &$st){
				if($this->config['w_temp']==4){
					$st['icon_img']=str_replace('/icons/','/iconss/',$st['s_icon']);
				}else{
					$st['icon_img']=$st['s_icon'];
				}
			}
		}
		$this->display('config.style',array('user'=>$user,'styles'=>$styles));		 
	}
	
	public function add_menu(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
			$s_id		=		$_POST['s_id'];
			$this->db->update('w_style',array('s_display'=>1),array('s_id'=>$s_id));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
		$styles	=$this->db->query('select * from w_style where s_display=0 order by s_sort asc',3);
		$this->display('config.add_menu',array('user'=>$user,'styles'=>$styles));		 
	}
	
	public function removestyle(){
		$user	=$this->checkadmin();
		if ($this->post) {
			$s_id		=		$_POST['s_id'];
			$this->db->update('w_style',array('s_display'=>0),array('s_id'=>$s_id));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
	}
	public function save_level(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$id		=intval($_POST['id']);
		if ($this->post) {
			$level=array(
				'l_name'	=>$_POST['l_name'],
				'l_nick'	=>$_POST['l_nick'],
				'l_user1'	=>$_POST['l_user1'],
				'l_level1'	=>$_POST['l_level1'],
				'l_price1'	=>$_POST['l_price1'],
				'l_user2'	=>$_POST['l_user2'],
				'l_level2'	=>$_POST['l_level2'],
				'l_price2'	=>$_POST['l_price2'],
				'l_tnum'	=>$_POST['l_tnum'],
				'l_tlevel'	=>$_POST['l_tlevel'],
				'l_znum'	=>$_POST['l_znum'],
				'l_zlevel'	=>$_POST['l_zlevel']
			);
			$this->db->update('w_level', $level,array('id'=>$id));
			echo json_encode(array('status'=>1,'msg'=>'设置成功'));exit();
		}
	}


    public function banner(){
        $user	 	 = $this->checkadmin();
		$cates		=$this->banner_cate;
        $this->display('banner.index',array('cates'=>$cates,'user'=>$user));
    }
    public function banner_list(){
        $user		=$this->checkadmin();
 		$cates		=$this->banner_cate;
        $sql		="SELECT * FROM `w_banner` ORDER BY b_pos,b_index asc ";
        $banner		=$this->db->query($sql,3);
        foreach($banner as &$row){
            $row['b_time']		=date('Y-m-d H:i:s',$row['b_time']);
            $row['b_pos']		=$cates[$row['b_pos']];
            $row['b_img']		=$row['b_img']==''?'':'<img src="'.$row['b_img'].'" height="80">';
        }
        echo json_encode(array('code'=>0,'msg'=>'','count'=>count($banner),'data'=>$banner));
        exit();
    }
    public function banner_add(){
		$user		= $this->checkadmin();
		$cates		=$this->banner_cate;
        $user   =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if($this->post){
			der('Content-type:text/json');
            $_POST['b_time'] = time();
            unset($_POST['file']);
            $is_ins = $this->db->insert('w_banner',$_POST);
            if($is_ins){
                echo json_encode(array('status'=>1,'msg'=>'添加成功'),JSON_UNESCAPED_UNICODE);exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'添加失败'));
                exit();
            }
        }
        $this->display('banner.add',array('cates'=>$cates,'b_id'=>0));
    }
    public function banner_del(){
        $user   =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
        if($this->post){
            $banner_id = $_POST['id'];
            $sql = "DELETE FROM w_banner WHERE id = $banner_id";
            $is_del = $this->db->query($sql,0);
            if($is_del != false){
                echo json_encode(array('code'=>1,'msg'=>'删除成功'));
                exit();
            }else{
                echo json_encode(array('code'=>0,'msg'=>'删除失败'));
                exit();
            }
        }
    }
    public function banner_edit(){
        $user   =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$cates		=$this->banner_cate;
        $banner_id = $_GET['id'];
        $sql = "SELECT * FROM `w_banner`WHERE id = $banner_id";
        $banner = $this->db->query($sql,2);
        if($this->post){
 			header('Content-type:text/json');
            unset($_POST['file']);
            $_POST['b_time'] = time();
            $is_set 	= $this->db->update('w_banner',$_POST,array('id'=>$banner_id));
            if($is_set != false){
                echo json_encode(array('status'=>1,'msg'=>'修改成功'));
                exit();
            }else{
                echo json_encode(array('status'=>0,'msg'=>'修改失败'));
                exit();
            }
        }
        $this->display('banner.add',array('banner'=>$banner,'b_id'=>$banner_id,'cates'=>$cates));
    }
	public function notice(){
		$user	=$this->checkadmin();
		$this->display('notice.index',array('user'=>$user));	
	}
	public function notice_list(){
		$user		=$this->checkadmin();
		$page       =(isset($_GET['page']) && $_GET['page']!='')?intval($_GET['page']):1;
		$limit      =(isset($_GET['limit']) && $_GET['limit']!='')?intval($_GET['limit']):20;
		$query1  	="select * from w_notice order by id desc limit ".$limit*($page-1).",".$limit;		
		$query2  	="select count(id) as total from `w_notice`";
		$notice	 	=$this->db->query($query1, 3);
		$data2 		=$this->db->query($query2, 2);
		foreach($notice as &$rows){
			$rows['n_img']	=$rows['n_img']==''?'':'<img src="'.$rows['n_img'].'" height="60">';
			$rows['n_time']	=date('Y-m-d H:i:s',$rows['n_time']);
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>count($data2),'data'=>$notice));
		exit();
	}
	public function notice_add(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['n_title']==''){echo json_encode(array('status'=>0,'msg'=>'标题不能为空'));exit();}
			if($fields['n_index']==''){echo json_encode(array('status'=>0,'msg'=>'排序不能为空'));exit();}
            if($fields['n_desc']=='') {echo json_encode(array('status'=>0,'msg'=>'描述不能为空'));exit();}
			if($fields['n_img']=='')  {echo json_encode(array('status'=>0,'msg'=>'缩略图不能为空'));exit();}
 			$notice	=array(
				'n_title'		=> $fields['n_title'],
				'n_time'		=> time(),
				'n_img'			=> $fields['n_img'],
				'n_desc'		=> $fields['n_desc'],
				'n_index'		=> $fields['n_index'],
				'n_read'		=> 0
			);
			$noticeid=$this->db->insert('w_notice', $notice);
			if($noticeid){		
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
			}
		}else{
			$this->display('notice.add',array('user'=>$user,'n_id'=>0));
		}
	}
	public function notice_edit(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$n_id		=intval($_GET['id']);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['n_title']==''){echo json_encode(array('status'=>0,'msg'=>'标题不能为空'));exit();}
			if($fields['n_index']==''){echo json_encode(array('status'=>0,'msg'=>'排序不能为空'));exit();}
			if($fields['n_desc']=='') {echo json_encode(array('status'=>0,'msg'=>'描述不能为空'));exit();}
			if($fields['n_img']=='')  {echo json_encode(array('status'=>0,'msg'=>'缩略图不能为空'));exit();}
 			$notice	=array(
				'n_title'		=> $fields['n_title'],
                'n_time'		=> time(),
				'n_img'			=> $fields['n_img'],
				'n_desc'		=> $fields['n_desc'],
				'n_index'		=> $fields['n_index'],
				'n_read'		=> 0
			);
			$this->db->update('w_notice', $notice,array('id'=>$n_id));
			echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();	
		}else{
			$notice=$this->db->query('select * from w_notice where id='.$n_id,2);
			$this->display('notice.add',array('user'=>$user,'n_id'=>$n_id,'n'=>$notice));
		}
	}
	public function notice_del(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$cateid		=intval($_POST['id']);
		$this->db->query('delete from w_notice where id='.$cateid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}
	
	
	
}

?>