<?php

class mod_index extends mod
{

    public function index()
    {
        $banner = $this->db->query('select * from w_banner where b_pos=1 order by b_index asc', 3);
        foreach ($banner as &$row){
            $row['b_img'] = $this->setup_img($row['b_img']);
        }
        $notice = $this->db->query("select id,n_title,n_img,n_time,n_read,n_desc,n_index from w_notice order by n_index,id desc", 3);
        foreach($notice as &$row){
            $row['n_time'] = date('Y-m-d H:i:s', $row['n_time']);
            $row['n_img'] = $this->setup_img($row['n_img']);
        }
        $news = $this->db->query('select * from w_class order by n_index desc', 3);
        foreach ($news as &$row){
            $row['n_time'] = date('Y-m-d H:i:s', $row['n_time']);
            $row['n_img'] = $this->setup_img($row['n_img']);
        }
        $arr 	  = array('20000','10000','60000','25000','10000','30000','4000','60000','20000');
        $phone 	  = array('152','139','188','151','136','147','181','185','182','135');
        $price_data = array(
            'm_phone' => $phone[rand('0','8')].'****'.rand('1000','9999'),
            'm_price' => $arr[rand('0','8')],
        );

        $config = $this->db->query('select * from w_config where `id`= 1', 2);
        $this->display('index',array(
            'code' => 200,
            'banner' => $banner,
            'g_notice' => $config['w_notice'],
            'notice' => $notice,
            'news' => $news,
            'price_data' => $price_data,
        ));
//        echo json_encode(array(
//                'code' => 200,
//                'banner' => $banner,
//                'g_notice' => $config['w_notice'],
//                'notice' => $notice,
//                'news' => $news,
//                'price_data' => $price_data,
//            )
//        );
        exit();
    }


    public function news_info(){
        if($this->post){
            $n_id = $_POST['n_id'];
            $news = $this->db->query('select * from w_class WHERE id='.$n_id, 2);
            if(!empty($news)){
                $news['n_img'] = $this->setup_img($news['n_img']);
                $news['n_time'] = date('Y-m-d H:i',$news['n_time']);
                echo json_encode(array(
                        'news'=>$news,
                        'code'=>200,
                ));
                exit();
            }else{
                echo json_encode(array('code' => 404, 'msg' => '文章信息不存在'));
                exit();
            }
        }
    }

    //登录
    public function login()
    {
        if ($this->post) {
            header('Content-type:text/json');
            $fields = $this->SafeFilter($_POST);
            if ($fields['m_phone'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '登录手机号不能为空'));
                exit();
            }
                if ($fields['m_password'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '登录密码不能为空'));
                exit();
            }
            $m_phone = $fields['m_phone'];
            $m_password = md5($fields['m_password']);
            $user = $this->db->query("select * from w_users where m_phone='$m_phone' and m_pass='$m_password' and m_del=0", 2);
            if (!empty($user)) {
                if ($user['m_lock'] == 1) {
                    echo json_encode(array('code' => 403, 'msg' => '账号已锁定,请联系客服处理'));
                    exit();
                }

                $token = $this->api_key($user['id']);
//                $this->display('index',array('uid'=>$user['id'],));
                $_SESSION['uid']=$user['id'];
                $_SESSION['token']=$token;
                echo json_encode(array('code' => 200, 'msg' => '登录成功', 'uid' => $user['id'], 'token' => $token));
                exit();
            } else {
                echo json_encode(array('code' => 302, 'msg' => '账号密码有误，请检查后重试'));
                exit();
            }
        }else{
           $this->display('login');
        }
    }
    //注册
    public function register()
    {
        $data = $this->db->query('select * from w_config where id = 1', 2);
        $data['w_logo'] = $this->setup_img($data['w_logo']);
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            if ($fields['invite_code'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '邀请码不能为空'));
                exit();
            }
            $invite_code = $fields['invite_code'];
            $invite_user = $this->db->query("select id,m_phone,m_del,m_level from w_users where m_yqm='$invite_code' and m_del=0", 2);
            if (empty($invite_user)) {
                echo json_encode(array('code' => 302, 'msg' => '邀请码有误'));
                exit();
            }
            if($invite_user['m_level'] < 1){
                echo json_encode(array('code' => 302, 'msg' => '邀请人等级不足'));
                exit();
            }
            $m_tid = $invite_user['id'];
            if ($fields['m_phone'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '注册手机号不能为空'));
                exit();
            }
            $m_phone = $fields['m_phone'];
            $reg_code = $fields['reg_code'];
            $path = './cache/'.md5($m_phone);
            $verycode = $this->cache_get($m_phone);
            if ($reg_code != $verycode) {
                echo json_encode(array('code' => 303, 'msg' => '短信验证码有误'));
                exit();
            }
            $user = $this->db->query("select id,m_phone,m_del from w_users where m_phone='$m_phone' and m_del=0", 2);
            if (!empty($user)) {
                echo json_encode(array('code' => 301, 'msg' => '该手机号已经注册'));
                exit();
            }
            if ($fields['m_password'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '登录密码不能为空'));
                exit();
            }
            $m_pid = $this->getPidbyTid($m_tid);
            $m_line = '0';
            if ($m_pid) {                                                           //找出 m_line 信息
                $member = $this->db->query("select * from w_users where id='" . $m_pid . "' and m_del=0", 2);
                if (empty($member)) {
                    echo json_encode(array('code' => 404, 'msg' => '节点人不存在'));
                    exit();
                }
                $m_line = $member['m_line'];
            }
            $yqm = $this->MakeKey();
            $member = array(
                'm_tid'     => $m_tid,
                'm_pid'     => $m_pid,
                'm_name'    => $data['w_name'].'-' . date('dhi') . rand(1, 999),
                'm_phone'   => $fields['m_phone'],
                'm_pass'    => md5($fields['m_password']),
                'm_level'   => 0,
                'm_regtime' => time(),
                'm_yqm'     => $yqm,
            );
            if ($this->config['w_xinyu']) {
                $member['m_score'] = $this->config['w_xinyu1'];
            }
            $member_id = $this->db->insert('w_users', $member);
            if ($m_pid) {                                               //更新节点人的一层人数

                $query = "select * from w_users where id='" . $m_pid . "' and m_del=0";
                $member = $this->db->query($query, 2);
                $m_num = $member['m_num'] + 1;
                $this->db->update('w_users', array('m_num' => $m_num), array('id' => $m_pid));
            }
            if ($member_id) {                                           //更新会员节点序列及所在层次
                $this->db->update('w_users', array('m_line' => $m_line . ',' . $member_id, 'm_layer' => count(explode(',', $m_line))), array('id' => $member_id));
                if(!file_exists($path)){
                    unlink($path);
                }
                echo json_encode(array('code' => 200, 'msg' => '注册成功'));
                exit();
            } else {
                echo json_encode(array('code' => 500, 'msg' => '发生未知错误，请联系在线客服处理'));
                exit();
            }
        }
        $get_type =(isset($_GET['get_type'])&&$_GET['get_type']!='')?intval($_GET['get_type']):0;
        if($get_type == 0){
            $this->display('register',array('w_name'=>$data['w_name'],'w_logo'=>$data['w_logo'],'w_down1'=>$data['w_down1']));
        }else{
            $this->display('register2',array('w_name'=>$data['w_name'],'w_logo'=>$data['w_logo'],'w_down1'=>$data['w_down1']));
        }

    }

    public function forget_pwd()
    {
        if ($this->post) {
            $fields = $_POST;
            if ($fields['m_phone'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '手机号不能为空'));
                exit();
            }
            $path = './cache/'.md5($fields['m_phone']);
            if(!file_exists($path)) {
                echo json_encode(array('code' => 302, 'msg' => '手机号不一致'));
                exit();
            }
            if (empty($fields['forget_code'])) {
                echo json_encode(array('code' => 404, 'msg' => '短信验证码不能为空'));
                exit();
            }
            $verycode = $this->cache_get($fields['m_phone']);
            if ($verycode != $fields['forget_code']) {
                echo json_encode(array('code' => 303, 'msg' => '短信验证码不正确'));
                exit();
            }
            if (empty($fields['new_pass1'])) {
                echo json_encode(array('code' => 404, 'msg' => '新密码不能为空'));
                exit();
            }
            if (empty($fields['new_pass2'])) {
                echo json_encode(array('code' => 404, 'msg' => '确认密码不能为空'));
                exit();
            }
            if ($fields['new_pass1'] != $fields['new_pass2']) {
                echo json_encode(array('code' => 302, 'msg' => '两次输入密码不一致'));
                exit();
            }
            $is_res = $this->db->update('w_users', array('m_pass'=>md5($fields['new_pass1'])), array('m_phone' => $fields['m_phone']));
            if($is_res){
                if(!file_exists($path)){
                    unlink($path);
                }
                echo json_encode(array('code' => 200, 'msg' => '密码重置成功'));
                exit();
            }else{
                echo json_encode(array('code' => 200, 'msg' => '密码重置失败'));
                exit();
            }
        }
    }

    //注册验证
    public function reg_smscode()
    {
        if ($this->post){
            $fields = $this->SafeFilter($_POST);
            $v_phone = $fields['m_phone'];
            if ($v_phone == '') {
                echo json_encode(array('code' => 404, 'msg' => '手机号不能为空'));
                exit();
            }
            $user = $this->db->query("select id,m_phone,m_del from w_users where m_phone='$v_phone' and m_del=0", 2);
            if (empty($user)) {
                $this->sendcode($v_phone, 'reg');
                echo json_encode(array('code' => 200, 'msg' => '验证码已发送至您的手机'));
                exit();
            } else {
                echo json_encode(array('code' => 305, 'msg' => '您输入的手机号已注册'));
                exit();
            }
        }
    }

    //忘记密码验证
    public function forget_smscode()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $v_phone = $fields['m_phone'];
            $user = $this->db->query("select id,m_phone,m_del from w_users where m_phone='$v_phone' and m_del=0", 2);
            if (!empty($user)){
                $this->sendcode($v_phone, 'rep');
                echo json_encode(array('code' => 200, 'msg' => '验证码已发送至您的手机'));
                exit();
            } else {
                echo json_encode(array('code' => 305, 'msg' => '您输入的手机号未注册'));
                exit();
            }
        }
    }
    //忘记密码页面渲染
    public function forgot()
    {
        $this->display('forgot');
    }
    //设置收款码验证
    public function setpay_smscode()
    {
        if ($this->post){
            $fields = $this->SafeFilter($_POST);
            $v_phone = $fields['m_phone'];
            $user = $this->db->query("select id,m_phone,m_del from w_users where m_phone='$v_phone' and m_del=0", 2);
            if (!empty($user)) {
                $this->sendcode($v_phone, 'pay');
                echo json_encode(array('code' => 200, 'msg' => '验证码已发送至您的手机'));
                exit();
            } else {
                echo json_encode(array('code' => 305, 'msg' => '您输入的手机号未注册'));
                exit();
            }
        }
    }

    //用户信息不存在
    public function get_info(){
        if ($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);

            if(!empty($user)){
                $user['m_name']     = $user['m_zsxm'];
                $user['m_avatar']   = $this->setup_img($this->config['w_logo']);
                echo json_encode(array('code'=>200,'user'=>$user));
                exit();
            }else{
                echo json_encode(array('code'=>302,'用户信息不存在'));
                exit();
            }
        }
    }
    public function get_servers(){
        $w_kefu     = $this->config['w_kefu'];
        $w_tel      = $this->config['w_tel'];
        $w_linecode = $this->setup_img($this->config['w_linecode']);
        echo json_encode(array(
            'code'          =>200,
            'w_kefu'        =>$w_kefu,
            'w_tel'         =>$w_tel,
            'w_linecode'    =>$w_linecode,
            )
        );
        exit();
    }
    public function config_info(){
        if ($this->post){
            $data = $this->db->query('select * from w_config where id = 1', 2);
            $data['w_logo'] = $this->setup_img($data['w_logo']);
            $data['w_uphb'] = $this->setup_img($data['w_uphb']);
            if($data['w_notice'] == false){
                $data['w_notice'] = array(
                    '0' => '1、每推荐一个用户注册可获得50元保证金，可提现',
                    '1' => '2、好友每次还款可获得5%-10%手续费提成',
                    '2' => '3、好友每次众筹可获得3%-8%收益分成',
                );
            }else{
                $data['w_notice'] = explode('|',$data['w_notice']);
            }
            echo json_encode(array('code' => 200, 'data' => $data,));exit();
        }
    }


}

?>