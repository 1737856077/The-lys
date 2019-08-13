<?php

class mod_user extends mod
{
    //实名认证
    public function user()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('center');
        }else{
            header('Location:index.php?m=index&c=login ');
        }
    }
    public function real_name(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $uid    = $fields['uid'];
            if($fields['m_zsxm'] == ''){echo json_encode(array('code' => 404, 'msg' => '真实姓名不能为空'));exit();}
            if($fields['m_carid'] == ''){echo json_encode(array('code' => 404, 'msg' => '身份证号不能为空'));exit();}
            if(isset($_FILES['m_carimg1'])){
                $fields['m_carimg1'] = $this->uploads('m_carimg1');
            }
            if($fields['m_carimg1'] == ''){echo json_encode(array('code' => 404, 'msg' => '请上传身份照片'));exit();}
            if(isset($_FILES['m_carimg2'])){
                $fields['m_carimg2'] = $this->uploads('m_carimg2');
            }
            if($fields['m_carimg2'] == ''){echo json_encode(array('code' => 404, 'msg' => '请上传身份照片'));exit();}
            $set_sm = array(
                'm_zsxm'   => $fields['m_zsxm'],
                'm_carid'  => $fields['m_carid'],
                'm_carimg' => $fields['m_carimg1'].','.$fields['m_carimg2'],
            );
            $is_res = $this->db->update('w_users',$set_sm,array('id'=>$uid));
            if($is_res){
                $this->SetupUser($uid,$fields['m_zsxm']);
                echo json_encode(array('code' => 200, 'msg' => '上传成功,等待审核'));exit();
            }else{
                echo json_encode(array('code' => 302, 'msg' => '上传失败'));exit();
            }
        }
    }
    public function daili()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('daili');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function daili_con()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('daili_con');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function real_info(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $smrz = array(
                'm_zsxm'    => $user['m_zsxm'],
                'm_carid'   => $user['m_carid'],
                'm_rz'      => $user['m_rz'],
            );
            if($user['m_carimg'] != false){
                $car_img           = explode(',',$user['m_carimg']);
                $smrz['m_carimg1'] = $this->setup_img($car_img['0']);
                $smrz['m_carimg2'] = $this->setup_img($car_img['1']);
            }else{
                $smrz['m_carimg1'] = '';
                $smrz['m_carimg2'] = '';
            }
            echo json_encode(array(
                    'code' => 200,
                    'data' => $smrz
                )
            );
            exit();
        }
    }
    public function shiming()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('shiming');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function ulogin()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->unlogin();
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function skfs()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('skfs');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function yqm()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('yqm');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function team()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('team');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function tuandui()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('tuandui');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function contact()
    {
        $data = $this->checkUserVi();
        if ($data==true){
            $this->display('contact');
        }else{
            header('Location:index.php?m=index&c=login ');
        }

    }
    public function pay_list(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $uid    = $fields['uid'];
            $w_pay  = $this->db->query("select * from w_pay where p_uid='$uid' ORDER BY p_addtime DESC", 3);
            if(!empty($w_pay)){
                foreach ($w_pay as &$row){
                    $row['p_img'] = $this->setup_img($row['p_img']);
                }
            }
            echo json_encode(array(
                    'code' => 200,
                    'data' => $w_pay
                )
            );
            exit();
        }
    }
    public function pay_info(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $uid    = $fields['uid'];
            $w_pay  = $this->db->query("select * from w_pay where p_uid='$uid' AND `p_status`=1 ORDER BY p_addtime DESC", 2);
            if(!empty($w_pay)){
                $w_pay['p_img'] = $this->setup_img($w_pay['p_img']);
            }else{
                $w_pay = array();
            }
            echo json_encode(array(
                    'code' => 200,
                    'data' => $w_pay
                )
            );
            exit();
        }
    }

    public function pay_add(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $uid    = $fields['uid'];
            if($fields['p_num'] == ''){echo json_encode(array('code' => 404, 'msg' => '收款账号不能为空'));exit();}
            $w_pay = $this->db->query("select * from w_pay where p_num='".$fields['p_num']."' and p_type='".$fields['p_type']."'", 2);
            if(!empty($w_pay)){echo json_encode(array('code' => 404, 'msg' => '收款账号已存在'));exit();}
            if(isset($_FILES['p_img'])){
                $fields['p_img'] = $this->uploads('p_img');
            }
            $pay = array(
                'p_num'     =>$fields['p_num'],
                'p_img'     =>$fields['p_img'],
                'p_addtime' =>time(),
                'p_uid'     =>$uid,
                'p_type'    =>$fields['p_type'],
                'p_status'  =>$fields['p_status'],
            );
            $w_pay = $this->db->query("select * from w_pay where p_uid='$uid' ORDER BY p_addtime DESC", 3);
            if(!empty($w_pay) and $fields['p_status'] == 1){
                $this->db->update('w_pay', array('p_status'=>0), array('p_uid' => $uid));
            }
            $is_res = $this->db->insert('w_pay', $pay);
            if($is_res){
                echo json_encode(array('code' => 200, 'msg' => '添加成功'));exit();
            }else{
                echo json_encode(array('code' => 302, 'msg' => '添加失败'));exit();
            }
        }
    }


    public function pay_edit(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $uid    = $fields['uid'];
            $p_id    = $fields['p_id'];
            $w_pay = $this->db->query("select * from w_pay where p_id ='$p_id'", 2);
            if(empty($w_pay)){echo json_encode(array('code' => 404, 'msg' => '收款信息不存在'));exit();}
            if($fields['p_num'] == ''){echo json_encode(array('code' => 404, 'msg' => '收款账号不能为空'));exit();}
            if(isset($_FILES['p_img'])){
                $fields['p_img'] = $this->uploads('p_img');
            }
            $w_pay = $this->db->query("select * from w_pay where p_id <>'$p_id' and p_num='".$fields['p_num']."' and p_type='".$fields['p_type']."'", 2);
            if(!empty($w_pay)){echo json_encode(array('code' => 404, 'msg' => '收款账号已存在'));exit();}
            $pay = array(
                'p_num'     =>$fields['p_num'],
                'p_img'     =>$fields['p_img'],
                'p_uid'     =>$uid,
                'p_addtime' =>time(),
                'p_type'    =>$fields['p_type'],
                'p_status'  =>$fields['p_status'],
            );
            $w_pay = $this->db->query("select * from w_pay where p_uid='$uid' ORDER BY p_addtime DESC", 3);
            if(!empty($w_pay) and $fields['p_status'] == 1){
                $this->db->update('w_pay', array('p_status'=>0), array('p_uid' => $uid));
            }
            $is_res = $this->db->update('w_pay',$pay,array('p_id'=>$p_id));
            if($is_res){
                $s_pay = $this->db->query("select * from w_pay where p_uid='$uid' and p_status=1 ORDER BY p_addtime DESC", 3);
                $m_pay = $this->db->query("select * from w_pay where p_uid='$uid' and p_status=0 ORDER BY p_id DESC",2);
                if(empty($s_pay) and !empty($m_pay)){
                    $this->db->update('w_pay',array('p_status'=>1),array('p_id'=>$m_pay['p_id']));
                }
                echo json_encode(array('code' => 200, 'msg' => '编辑成功'));exit();
            }else{
                echo json_encode(array('code' => 302, 'msg' => '编辑失败'));exit();
            }
        }
    }

    public function pay_save(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $uid    = $fields['uid'];
            $p_id   = $fields['p_id'];
            if (empty($fields['pay_code'])) {
                echo json_encode(array('code' => 404, 'msg' => '短信验证码不能为空'));
                exit();
            }
            $verycode = $this->cache_get($fields['p_phone']);
            if($verycode != $fields['pay_code']){
                echo json_encode(array('code' => 303, 'msg' => '短信验证码不正确'));
                exit();
            }
            if($fields['p_num'] == ''){echo json_encode(array('code' => 404, 'msg'=>'收款账号不能为空'));exit();}
            if(isset($_FILES['p_img'])){
                $fields['p_img'] = $this->uploads('p_img');
            }
            $pay = array(
                'p_num'     =>$fields['p_num'],
                'p_img'     =>$fields['p_img'],
                'p_addtime' =>time(),
                'p_uid'     =>$uid,
                'p_type'    =>$fields['p_type'],
                'p_status'  =>$fields['p_status'],
            );
            $w_pay = $this->db->query("select * from w_pay where p_uid='$uid' ORDER BY p_addtime DESC", 3);
            if(!empty($w_pay) and $fields['p_status'] == 1){
                $this->db->update('w_pay', array('p_status'=>0), array('p_uid' => $uid));
            }
            if($p_id == 0){
                $is_res = $this->db->insert('w_pay', $pay);
            }else{
                $is_res = $this->db->update('w_pay',$pay,array('p_id'=>$p_id));
            }
            if($is_res){
                echo json_encode(array('code' => 200, 'msg' => '设置成功'));exit();
            }else{
                echo json_encode(array('code' => 302, 'msg' => '设置失败'));exit();
            }
        }
    }


    public function pay_del(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $this->checkuser($fields);
            $uid    = $fields['uid'];
            $p_id   = $fields['p_id'];
            $w_pay = $this->db->query("select * from w_pay where p_id='$p_id'", 2);
            if(empty($w_pay)){ echo json_encode(array('code' => 404, 'msg' => '收款信息不存在'));exit(); }
            $is_res = $this->db->query('delete from w_pay where p_id='.$p_id, 0);
            if($is_res){
                if($w_pay['p_status'] == 1){
                    $s_pay = $this->db->query("select * from w_pay where p_uid='$uid' and p_status=1 ORDER BY p_addtime DESC", 3);
                    $m_pay = $this->db->query("select * from w_pay where p_uid='$uid' and p_status=0 ORDER BY p_id DESC",2);
                    if(empty($s_pay) and !empty($m_pay)){
                        $this->db->update('w_pay',array('p_status'=>1),array('p_id'=>$m_pay['p_id']));
                    }
                }
                echo json_encode(array('code' => 200, 'msg' => '删除成功'));exit();
            }else{
                echo json_encode(array('code' => 302, 'msg' => '删除失败'));exit();
            }
        }
    }

    public function is_setup(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $is_rz  = 0;
            if($user['m_rz'] == 0 and $user['m_carimg'] != false){
                $is_rz  = 2;
            }elseif ($user['m_rz'] == 1){
                $is_rz  = 1;
            }
            $is_yq  = 1;
            if($user['m_level'] == 0){
                $is_yq = 0;
            }
            $uid    = $fields['uid'];
            $is_pay = 0;
            $w_pay  = $this->db->query("select * from w_pay where p_uid='$uid' ORDER BY p_addtime DESC", 3);
            if(!empty($w_pay)){
                $is_pay = 1;
            }
            echo json_encode(array(
                    'code'  => 200,
                    'is_rz' => $is_rz,
                    'is_pay'=> $is_pay,
                    'is_yq' => $is_yq,
                )
            );
            exit;
        }
    }

    public function teams(){
        if($this->post){
            $fields      = $this->SafeFilter($_POST);
            $uid         = $fields['uid'];
            $user        = $this->checkuser($fields);
            $teams       = $this->db->query("select count(id) as t_num from w_users where m_line like '%,$uid,%' and m_del=0",2);
            $t_num       = empty($teams['t_num'])?0:intval($teams['t_num']);                                             //团队总人数
            $teams_info  = $this->db->query("select * from w_users where m_line like '%,$uid,%' and m_del=0",3);         //团队人
            foreach ($teams_info as &$row){
                $row['m_avatar']   = $this->setup_img($row['m_avatar']);
                $row['m_regtime']  = date('Y-m-d H:i:s',$row['m_regtime']);
            }
            echo json_encode(array(
                    'code'       => 200,
                    't_num'      => $t_num,
                    'teams_info' => $teams_info,
                )
            );
            exit;
        }
    }

    public function teams_ass(){
        if($this->post){
            $fields      = $this->SafeFilter($_POST);
            $uid         = $fields['uid'];
            $user        = $this->checkuser($fields);
            $teams       =$this->db->query("select count(id) as t_num from w_users where m_line like '%,".$uid.",%' and m_del=0",2);
            $t_num_one   =empty($teams['t_num'])?0:intval($teams['t_num']);         //团队总人数
            $teams       =$this->db->query("select count(id) as t_num from w_users where m_line like '%,".$uid.",%' and m_del=0 and m_level>0",2);
            $t_num_two   =empty($teams['t_num'])?0:intval($teams['t_num']);         //一星及以上人数
            $t_nums		 =array();
            $x = 0;
            foreach($this->base_levels as $k=>$v){
                if($k > 0){
                    $num             =pow(3, $x);
                    $layer           = $k+$user['m_layer'];
                    $teams           =$this->db->query("select count(id) as t_num from w_users where m_line like '%,".$uid.",%' and m_del=0 and m_layer=".$layer,2);
                    $t_num_three     =empty($teams['t_num'])?0:intval($teams['t_num']);
                    $up_level        =$this->db->query("select count(id) as l_num from w_uplevel where `sid`='$uid' and `status`>0 and `level`='$k'",2);
                    $up_level_num     =empty($up_level['l_num'])?0:intval($up_level['l_num']);
                    if($k < $user['m_level']){
                        $w_order = $num-$up_level_num;
                    }else{
                        $w_order = 0;
                    }
                    $t_nums[$k]	     =array('t_name'=>'第'.$k.'层','t_num'=>$t_num_three,'y_order'=>$up_level_num,'w_order'=>$w_order);
                }
                $x++;
            }
            echo json_encode(array(
                    'code'         => 200,
                    't_num_one'    => $t_num_one,
                    't_num_two'    => $t_num_two,
                    't_nums'       => $t_nums,
                )
            );
            exit;
        }
    }



    //我的好友
    public function teams_zt(){
        if($this->post){
            $fields      = $this->SafeFilter($_POST);
            $uid         = $fields['uid'];
            $user        = $this->checkuser($fields);
            $query  	 ="select * from `w_users` where m_tid=".$user['id']." and m_del=0 order by id desc";
            $teams	 	 =$this->db->query($query, 3);
            foreach ($teams as &$row){
                $row['m_avatar']   = $this->setup_img($row['m_avatar']);
                $row['m_regtime']  = date('Y-m-d H:i:s',$row['m_regtime']);
            }
            echo json_encode(array(
                    'code'     => 200,
                    'teams'    => $teams
                )
            );
            exit;
        }
    }


    //用户协议
    public function about(){
        $about	=$this->db->query('select * from w_about where id=2',2);
        echo json_encode(array(
                'code'     => 200,
                'about'    => $about,
            )
        );
        exit;
    }

    public function invite_user(){
        if($this->post){
            $fields   = $this->SafeFilter($_POST);
            $user     = $this->checkuser($fields);
            $m_yqm    = $user['m_yqm'];
            $get_type = $fields['get_type'];
            $url      = 'http://'.$_SERVER['HTTP_HOST'].'/?m=index&c=register&get_type='.$get_type.'&t='.$m_yqm;
            $path     = $this->SetQRcode($url,'./static/upload/'.$m_yqm.'.jpg');
            $qr_code  =  'http://'.$_SERVER['HTTP_HOST'].ltrim($path,'.');
            echo json_encode(
                array(
                    'code'      =>200,
                    'qr_code'   =>$qr_code,
                    'user'      =>$user,
                    'url'       =>$url,
                )
            );
            exit();
        }
    }

    public function SetQRcode($url,$path){
        require_once './system/lib/phpqrcode.php';
        $value = $url;
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 6;
        if(!file_exists($path)){
            QRcode::png($value,$path , $errorCorrectionLevel, $matrixPointSize, 2);
            $QR = $path;        //已经生成的原始二维码图片文件
            $QR = imagecreatefromstring(file_get_contents($QR));
            imagepng($QR, $path);
            imagedestroy($QR);
        }
        return $path;
    }

    public function make_img(){
        if($this->post){
            $fields    = $this->SafeFilter($_POST);
            $w_yqhb    = $this->config['w_yqhb'];
            if($w_yqhb == false){
                echo json_encode(array('code' => 404, 'msg' => '请联系客户上传海报'));exit();
            }
            $user      = $this->checkuser($fields);
            $m_yqm     = $user['m_yqm'];
            $weichat   = '邀请码：'.$m_yqm;
            $img_name  = md5($m_yqm);
            $path      = './static/upload/'.$img_name.'.jpg';
            $qrcode    = './static/upload/'.$m_yqm.'.jpg';
            $path ='http://'.$_SERVER['HTTP_HOST'].trim($path,'.');
            if(!file_exists($path)){
                $this->SetImg($qrcode,$img_name,$weichat);
            }
            echo json_encode(array('code' => 200, 'path' => $path));exit();
        }
    }

    public function SetImg($qrcode,$m_phone,$weichat){
        $w_yqhb   = $this->config['w_yqhb'];
        $img_url  = './static/upload/'.$m_phone.'.jpg';
        $bigImg   = imagecreatefromstring(file_get_contents($w_yqhb));
        $qCodeImg = imagecreatefromstring(file_get_contents($qrcode));
        list($qCodeWidth, $qCodeHight) = getimagesize($qrcode);
        imagecopymerge($bigImg, $qCodeImg, 270, 500, 0, 0, $qCodeWidth, $qCodeHight, 100);
        $img = imagejpeg($bigImg,$img_url);
        if($img){
            $str = $this->SetWz($img_url,$weichat);
            if($str){
                return $img_url;
            }else{
                return 0;
            }
        }
    }

    public function SetWz($img_url,$weichat){
        $size = 22;
        $setImg = getimagesize($img_url);
        $s_original = $this->imgCreateFrom($img_url, $setImg[2]);
        $posX = imagesx($s_original)/strlen($weichat)*$size/3.4;
        $posY = imagesy($s_original)/1.55;
        $color = imagecolorallocate($s_original,255,255,255);
        imagettftext($s_original, 22, 0, $posX, $posY, $color, './static/font/MSYH.TTC', $weichat);
        $img = imagejpeg($s_original, $img_url);
        return $img;
    }

    public function imgCreateFrom($img_src,$val){
        switch($val){
            case 1 : $img = imagecreatefromgif($img_src);
                break;
            case 2 : $img = imagecreatefromjpeg($img_src);
                break;
            case 3 : $img = imagecreatefrompng($img_src);
                break;
        }
        return $img;
    }
}