<?php
class mod_class extends mod {
	public function cates(){
		$user	=$this->checkadmin();
		$this->display('class.cate',array('user'=>$user));	
	}

	public function catelist(){
		$user		=$this->checkadmin();
		$query  	="select * from `w_caten` order by c_index asc";
		$banks	 	=$this->db->query($query, 3);
		foreach($banks as &$rows){
			$rows['c_img']	=$rows['c_img']==''?'':'<img src="'.$rows['c_img'].'" height="30">';
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>count($banks),'data'=>$banks));
		exit();
	}

	public function addcate(){
		$user	=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['c_name']==''){echo json_encode(array('status'=>0,'msg'=>'分类名称不能为空'));exit();}
			if($fields['c_img']==''){echo json_encode(array('status'=>0,'msg'=>'分类图片不能为空'));exit();}
			if($fields['c_index']==''){echo json_encode(array('status'=>0,'msg'=>'分类排序不能为空'));exit();}
  			$cates	=array(
				'c_name'			=>$fields['c_name'],
				'c_title'			=>$fields['c_title'],
				'c_img'				=>$fields['c_img'],
				'c_index'			=>$fields['c_index']
			);
			$cateid=$this->db->insert('w_caten', $cates);
			if($cateid){		
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
			}
		}else{
			$this->display('class.addcate',array('user'=>$user,'cateid'=>0));
		}
	}

	public function editcate(){
		$user	 =$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$cateid	 =$_GET['id'];
		$sql	 ="select * from w_caten where id=".$cateid;
		$cates	 =$this->db->query($sql, 2);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['c_name']==''){echo json_encode(array('status'=>0,'msg'=>'分类名称不能为空'));exit();}
			if($fields['c_img']==''){echo json_encode(array('status'=>0,'msg'=>'分类图片不能为空'));exit();}
			if($fields['c_index']==''){echo json_encode(array('status'=>0,'msg'=>'分类排序不能为空'));exit();}
  			$cates	=array(
				'c_name'			=>$fields['c_name'],
				'c_title'			=>$fields['c_title'],
				'c_img'				=>$fields['c_img'],
				'c_index'			=>$fields['c_index']
			);
			$this->db->update('w_caten', $cates,array('id'=>$cateid));
			echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();	
		}else{
			$this->display('class.addcate',array('user'=>$user,'cateid'=>$cateid,'cates'=>$cates));
		}
	}

	public function delcate(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$cateid		=intval($_POST['id']);
		$this->db->query('delete from w_caten where id='.$cateid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}
	public function index(){
		$user		=$this->checkadmin();
		$query  	="select * from `w_caten` order by c_index asc";
		$cates	 	=$this->db->query($query, 3);
		$this->display('class.index',array('user'=>$user,'cates'=>$cates));	
	}
	public function class_list(){
		$user		=$this->checkadmin();
		$query  	="select * from `w_class` order by n_index asc";
		$notice	 	=$this->db->query($query, 3);
		foreach($notice as &$rows){
			$rows['n_img']	=$rows['n_img']==''?'':'<img src="'.$rows['n_img'].'" height="60">';
			$rows['n_time']	=date('Y-m-d H:i:s',$rows['n_time']);
		}
		echo json_encode(array('code'=>0,'msg'=>'','count'=>count($notice),'data'=>$notice));
		exit();
	}
	public function class_add(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$query  	="select * from `w_caten` order by c_index asc";
		$cates	 	=$this->db->query($query, 3);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['n_title']==''){echo json_encode(array('status'=>0,'msg'=>'标题不能为空'));exit();}
			if($fields['n_index']==''){echo json_encode(array('status'=>0,'msg'=>'排序不能为空'));exit();}
			if($fields['n_read']=='') {echo json_encode(array('status'=>0,'msg'=>'阅读不能为空'));exit();}
			if($fields['n_img']=='')  {echo json_encode(array('status'=>0,'msg'=>'缩略图不能为空'));exit();}
 			$notice	=array(
				'n_title'		=> $fields['n_title'],
				'n_time'		=> strtotime($fields['n_time']),
				'n_cate'		=> 0,
				'n_img'			=> $fields['n_img'],
				'n_content'		=> $fields['n_content'],
				'n_index'		=> $fields['n_index'],
				'n_read'		=> $fields['n_read']
			);
			$noticeid=$this->db->insert('w_class', $notice);
			if($noticeid){		
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));exit();	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'发生未知错误，请联系在线客服处理'));exit();
			}
		}else{
			$this->display('class.add',array('user'=>$user,'n_id'=>0,'cates'=>$cates));
		}
	}
	public function class_edit(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$query  	="select * from `w_caten` order by c_index asc";
		$cates	 	=$this->db->query($query, 3);
		$n_id		=intval($_GET['id']);
		if ($this->post) {
			header('Content-type:text/json');
			$fields 	= $_POST;
			if($fields['n_title']==''){echo json_encode(array('status'=>0,'msg'=>'标题不能为空'));exit();}
			if($fields['n_index']==''){echo json_encode(array('status'=>0,'msg'=>'排序不能为空'));exit();}
			if($fields['n_read']=='') {echo json_encode(array('status'=>0,'msg'=>'阅读不能为空'));exit();}
			if($fields['n_img']=='')  {echo json_encode(array('status'=>0,'msg'=>'缩略图不能为空'));exit();}
 			$notice	=array(
				'n_title'		=> $fields['n_title'],
				'n_time'		=> strtotime($fields['n_time']),
				'n_cate'		=> 0,
				'n_img'			=> $fields['n_img'],
				'n_content'		=> $fields['n_content'],
				'n_index'		=> $fields['n_index'],
				'n_read'		=> $fields['n_read']
			);
			$this->db->update('w_class', $notice,array('id'=>$n_id));
			echo json_encode(array('status'=>1,'msg'=>'修改成功'));exit();	
		}else{
			$notice=$this->db->query('select * from w_class where id='.$n_id,2);
			$this->display('class.add',array('user'=>$user,'n_id'=>$n_id,'n'=>$notice,'cates'=>$cates));
		}
	}
	public function class_del(){
		$user		=$this->checkadmin();
        if($user == 1){
            echo json_encode(array('role'=>'error'));exit();
        }
		$cateid		=intval($_POST['id']);
		$this->db->query('delete from w_class where id='.$cateid,0);
		echo json_encode(array('code'=>1,'msg'=>'删除成功'));exit();
	}
}
?>