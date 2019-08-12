<?php

class mod_plan extends mod
{
    public function plan_index()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $this->checkuser($fields);
            $uid = $fields['uid'];
            $plan_1 = $this->db->query("select sum(j_price) as plan_1 from `w_jihua` where `j_uid`='$uid' AND `j_type`=1", 2);
            $plan_1 = empty($plan_1['plan_1']) ? 0 : intval($plan_1['plan_1']);
            $plan_2 = $this->db->query("select sum(j_price) as plan_2 from `w_jihua` where `j_uid`='$uid' AND `j_type`=2", 2);
            $plan_2 = empty($plan_2['plan_2']) ? 0 : intval($plan_2['plan_2']);
            $plan_3 = $this->db->query("select sum(j_price) as plan_3 from `w_jihua` where `j_uid`='$uid' AND `j_type`=3", 2);
            $plan_3 = empty($plan_3['plan_3']) ? 0 : intval($plan_3['plan_3']);
            $plan_4 = $this->db->query("select sum(j_price) as plan_4 from `w_jihua` where `j_uid`='$uid' AND `j_type`=4", 2);
            $plan_4 = empty($plan_4['plan_4']) ? 0 : intval($plan_4['plan_4']);
            $p_status_1 = $this->db->query("select * from `w_jihua` where `j_uid`='$uid' AND `j_type`=1 AND j_status=0", 2);
            $ps_1 = 1;
            if (empty($p_status_1)) {
                $ps_1 = 0;
            }
            $p_status_2 = $this->db->query("select * from `w_jihua` where `j_uid`='$uid' AND `j_type`=2 AND j_status=0", 2);
            $ps_2 = 1;
            if (empty($p_status_2)) {
                $ps_2 = 0;
            }
            $p_status_3 = $this->db->query("select * from `w_jihua` where `j_uid`='$uid' AND `j_type`=3 AND j_status=0", 2);
            $ps_3 = 1;
            if (empty($p_status_3)) {
                $ps_3 = 0;
            }
            $ps_4 = 1;
            $p_status_4 = $this->db->query("select * from `w_jihua` where `j_uid`='$uid' AND `j_type`=4 AND j_status=0", 2);
            if (empty($p_status_4)) {
                $ps_4 = 0;
            }
            $is_jh           = 0;
            $c_id            = 0;
            $cash_price      = 0;
            $cash            = $this->db->query('select * from w_cash where c_uid='.$uid, 2);
            $is_cash         = $this->db->query('select * from w_cash where `c_status`=1 AND c_uid='.$uid, 2);
            if(!empty($is_cash)){
                //$is_jh       = 1;
                $c_id        = $cash['c_id'];
                $cash_price  = $cash['c_num'];
            }
            if(!empty($cash)){
                $cash_price  = $cash['c_num'];
            }
            $up_level   = $this->db->query("select * from w_uplevel where uid=$uid AND `status`<2", 3);
            if(!empty($up_level)){
                $is_jh  = 2;
            }
            echo json_encode(
                array(
                    'code'       => 200,
                    'plan_1'     => $plan_1,
                    'ps_1'       => $ps_1,
                    'plan_2'     => $plan_2,
                    'ps_2'       => $ps_2,
                    'plan_3'     => $plan_3,
                    'ps_3'       => $ps_3,
                    'plan_4'     => $plan_4,
                    'ps_4'       => $ps_4,
                    'cash_price' => $cash_price,
                    'is_jh'      => $is_jh,
                    'c_id'      => $c_id,
                )
            );
            exit();
        }
    }

    public function plan_add()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $this->checkuser($fields);
            $uid = $fields['uid'];
            $cash = $this->db->query('select * from w_cash where `c_status`=1 AND c_uid='.$uid, 2);
            if (!empty($cash)) {
                echo json_encode(array('code' => 302, 'msg' => '众筹已激活,不能发起还款计划'));
                exit();
            }
            if ($fields['j_price'] == false) {
                echo json_encode(array('code' => 404, 'msg' => '债务金额无效'));
                exit();
            }
            if (isset($_FILES['j_bor_img'])) {
                $fields['j_bor_img'] = $this->uploads('j_bor_img');
            }
            if ($fields['j_bor_img'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '债务凭证不能为空'));
                exit();
            }
            $jh = array(
                'j_uid' => $uid,
                'j_price' => $fields['j_price'],
                'j_type' => $fields['j_type'],
                'j_bor_img' => $fields['j_bor_img'],
                'j_ctime' => time(),
                'j_status' => 0,
            );
            $is_res = $this->db->insert('w_jihua', $jh);
            if ($is_res) {
                echo json_encode(array('code' => 200, 'msg' => '添加成功'));
                exit();
            } else {
                echo json_encode(array('code' => 302, 'msg' => '添加失败'));
                exit();
            }
        }
    }

    //激活债务
    public function setup_debt()
    {
        if ($this->post) {
            $fields     = $this->SafeFilter($_POST);
            $user       = $this->checkuser($fields);
            $uid        = $fields['uid'];
            $c_id       = $fields['c_id'];
            $jihua      = $this->db->query("select * from `w_jihua` where `j_uid`='$uid' and `j_status`='0'", 2);
            if(!empty($jihua)){
                echo json_encode(array('code' => 302, 'msg' => '众筹计划审核中,无法激活'));
                exit();
            }
            $cash       = $this->db->query('select * from w_cash where c_uid='.$uid, 2);
            if(empty($cash)){
                echo json_encode(array('code' => 302, 'msg' => '请先添加还款计划'));
                exit();
            }
           /* $cash       = $this->db->query('select * from w_cash where `c_status`=1 AND c_uid=' . $uid . ' AND c_id=' . $c_id, 2);
            if (!empty($cash)) {
                echo json_encode(array('code' => 302, 'msg' => '众筹已激活,不能重复激活'));
                exit();
            }*/
            $up_level   = $this->db->query("select * from w_uplevel where uid=$uid AND `status`<2", 3);
            if(!empty($up_level)){
                echo json_encode(array('code' => 302, 'msg' => '众筹计划激活中'));
                exit();
            }
            $n_level = $user['m_level'];
            $u_level = $user['m_level'] + 1;
            $is_upgrade = 200;
            $level = $this->db->query('select * from w_level where id=' . $u_level, 2);
            if (empty($level)) {
                $is_upgrade = 303;
                $msg = '当前解锁阶段有误';
            }
            if ($level['l_tnum'] > 0) {
                $members    = $this->db->query('select id,m_tid,m_del from w_users where m_del=0 and `m_level` >= '.$level['l_tlevel'].' and m_tid='.$user['id'],3);
                //$members = $this->db->query('select id,m_tid,m_del from w_users where m_del=0 and m_tid=' . $user['id'], 3);
                if (count($members) < $level['l_tnum']) {
                    $is_upgrade = 302;
                    $msg = '当前直推人数未达标';
                }
            }
            if ($level['l_znum'] > 0) {
                $members    =$this->db->query("select id,m_line,m_del from w_users where m_del=0 and `m_level` >= ".$level['l_zlevel']." and m_line like '%,".$user['id'].",%'",3);
                //$members = $this->db->query("select id,m_line,m_del from w_users where m_del=0 and m_line like '%," . $user['id'] . ",%'", 3);
                if (count($members) < $level['l_znum']) {
                    $is_upgrade = 302;
                    $msg = '当前团队人数未达标';
                }
            }
            if ($u_level > $this->config['w_level']) {
                $is_upgrade = 400;
                $msg = '您当前已是最高级别';
            }
            $lines = $user['m_line'];            //当前所有上级
            $layer = $user['m_layer'];           //当前所在层级
            $one_index = $level['l_user1'];          //一单匹配位置
            $one_level = $level['l_level1'];         //一单匹配等级
            $two_index = $level['l_user2'];          //二单匹配位置
            $two_level = $level['l_level2'];         //二单匹配等级

            $w_pattern = $this->config['w_pattern']; //匹配模式
            if ($w_pattern == 1) {
                ##### 基础模式 ######  //1推荐2节点
                if($one_index > 0){
                    $one_id = $this->getUpID($lines, $one_level, $one_index, $layer);
                } else {
                    $one_id = 0;
                }
                if($u_level == 1 && $user['m_pid'] != $user['m_tid']) {              //即使不要求2单的匹配，也要给推荐人和节点人各一单
                    $two_id = $user['m_tid'];
                }elseif($two_index > 0){
                    $two_id = $this->getUpID($lines, $two_level, $two_index, $layer);
                }else{
                    $two_id = 0;
                }
                #########END########
            }elseif($w_pattern == 2){
                ##### 加强模式 ######   //1推荐2正常
                if ($u_level == 1 && $user['m_pid'] != $user['m_tid']) {              //第一单匹配给推荐人,
                    $one_id = $user['m_tid'];
                } elseif ($one_index > 0) {
                    $one_id = $this->getUpID($lines, $one_level, $one_index, $layer);
                } else {
                    $one_id = 0;
                }
                if ($two_index > 0) {
                    $two_id = $this->getUpID($lines, $two_level, $two_index, $layer);
                } else {
                    $two_id = 0;
                }
                #########END########
            }elseif($w_pattern == 3){
                ##### 无敌模式 ######   //1正常2正常
                if ($one_index > 0) {
                    $one_id = $this->getUpID($lines, $one_level, $one_index, $layer);
                } else {
                    $one_id = 0;
                }
                if ($two_index > 0) {
                    $two_id = $this->getUpID($lines, $two_level, $two_index, $layer);
                } else {
                    $two_id = 0;
                }
                #########END########
            }
            if ($one_id == 0 && $level['l_user1'] > 0){      //如果系统要求匹配而没有找到
                $one_id = $this->config['w_user'];

            }
            if ($two_id == 0 && $level['l_user2'] > 0){      //如果系统要求匹配而没有找到
                $two_id = $this->config['w_user2'];
            }
            if ($is_upgrade != 200){
                echo json_encode(array('code' => 0, 'msg' => $msg));
                exit();
            }
            if ($one_id) {
                $up_level = array(
                    'uid' => $uid,
                    'sid' => $one_id,
                    'level' => $u_level,
                    'status' => 0,
                    'c_time' => time(),
                    'd_time' => 0,
                    'price' => $this->config['w_price_num'],
                    'l_type' => 1
                );
                $this->db->insert('w_uplevel', $up_level);
            }
            if ($two_id) {
                $up_level = array(
                    'uid' => $user['id'],
                    'sid' => $two_id,
                    'level' => $u_level,
                    'status' => 0,
                    'c_time' => time(),
                    'd_time' => 0,
                    'price' => $this->config['w_price_num'],
                    'l_type' => 2
                );
                $this->db->insert('w_uplevel', $up_level);
            }
            echo json_encode(array('code' => 200, 'msg' => '激活申请成功'));
            exit();
        }
    }

    public function is_activation(){
        if($this->post){
            $fields = $this->SafeFilter($_POST);
            $user   = $this->checkuser($fields);
            $uid    = $fields['uid'];
            $c_id   = $fields['c_id'];
            $is_jh  = 0;
            $cash       = $this->db->query('select * from w_cash where `c_status`=1 AND c_uid=' . $uid . ' AND c_id=' . $c_id, 2);
            if (!empty($cash)){
               $is_jh = 1;
            }
            $up_level   = $this->db->query("select * from w_uplevel where uid=$uid AND `status`<2", 3);
            if(!empty($up_level)){
               $is_jh = 2;
            }
            echo json_encode(
                array(
                    'code'  => 200,
                    'is_jh' => $is_jh,

                )
            );
            exit();
        }
    }

    //众筹计划
    public function crowd_funding()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $user = $this->checkuser($fields);
            $uid = $fields['uid'];
            $jihua = $this->db->query("select * from `w_jihua` where `j_uid`='$uid'", 2);
            $cash = $this->db->query('select * from w_cash where c_uid=' . $uid, 2);
            if (!empty($jihua)){
                $up_level = $this->db->query("select SUM(price) as already_price from w_uplevel where sid=$uid AND `status`=2", 2);
                $alr_price = empty($up_level['already_price']) ? 0 : intval($up_level['already_price']);
                $c_num = $cash['c_num'];
                $data  = $this->set_stage($c_num, $alr_price);
                echo json_encode(
                    array(
                        'code' => 200,
                        'stage_arr' => $data['stage_arr'],
                        'alr_arr' => $data['alr_arr'],
                        'cash' => $cash,
                        'status' => $cash['c_status'],
                    )
                );
                exit();
            }else{
                echo json_encode(array('code' => 404, 'msg' => '暂无执行中还款计划'));
                exit();
            }
        }
    }

    public function user_order(){
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $user = $this->checkuser($fields);
            $uid = $fields['uid'];
            $up_level = $this->db->query("select * from w_uplevel where uid=$uid", 3);
            foreach ($up_level as &$row) {
                $row['m_name'] = $this->getMember($row['sid'], 'm_name');
                $row['m_phone'] = $this->getMember($row['sid'], 'm_phone');
                $carid = $this->getMember($row['sid'], 'm_carid');
                $m_rz  = $this->getMember($row['sid'], 'm_r');
                if($m_rz == 1 and $carid != false){
                    $row['m_name']  = $this->getMember($row['sid'], 'm_zsxm');
                    $row['m_carid'] = substr_replace($this->getMember($row['sid'], 'm_carid'),'******',5,6);
                }
                $row['m_avatar'] = $this->setup_img($this->getMember($row['sid'], 'm_avatar'));
                if ($row['status'] == 0) {
                    $row['s_desc'] = '待付款';
                } elseif ($row['status'] == 1) {
                    $row['s_desc'] = '已打款';
                } elseif ($row['status'] == 2) {
                    $row['s_desc'] = '已完成';
                }
            }
            echo json_encode(
                array(
                    'code' => 200,
                    'order' => $up_level,
                )
            );
            exit();
        }
    }

    public function user_order_info()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $user = $this->checkuser($fields);
            $uid = $fields['uid'];
            $up_id = $fields['up_id'];
            $up_level = $this->db->query("select * from `w_uplevel` where `id`='$up_id' AND `uid`='$uid'", 2);
            if (empty($up_level)) {
                echo json_encode(array('code' => 404, 'msg' => '订单状态有误'));
                exit();
            }
            $u_sid = $up_level['sid'];
            $w_pay = $this->db->query("select * from w_pay where p_uid='$u_sid' ORDER BY p_status desc", 2);
            if (empty($w_pay)) {
                echo json_encode(array('code' => 404, 'msg' => '众筹用户未添加收款码,请联系会员进行添加'));
                exit();
            }
            $w_pay['p_img'] = $this->setup_img($w_pay['p_img']);
            if ($up_level['status']) {
                $up_level['l_pay_img'] = $this->setup_img($up_level['l_pay_img']);
            }
            $s_user['m_name'] = $this->getMember($up_level['sid'], 'm_name');
            $s_user['m_phone'] = $this->getMember($up_level['sid'], 'm_phone');
            echo json_encode(
                array(
                    'code' => 200,
                    'order_desc' => $up_level,
                    'w_pay' => $w_pay,
                    's_user' => $s_user,
                )
            );
            exit();
        }
    }

    public function up_pay()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $user = $this->checkuser($fields);
            $uid = $fields['uid'];
            $up_id = $fields['up_id'];
            $up_level = $this->db->query("select * from `w_uplevel` where `id`='$up_id' AND `uid`='$uid' and `status`<2", 2);
            if (empty($up_level)) {
                echo json_encode(array('code' => 404, 'msg' => '订单状态有误'));
                exit();
            }
            if (isset($_FILES['l_pay_img'])) {
                $fields['l_pay_img'] = $this->uploads('l_pay_img');
            }
            if ($fields['l_pay_img'] == '') {
                echo json_encode(array('code' => 404, 'msg' => '请上传付款凭证'));
                exit();
            }
            $pay_data = array(
                'l_pay_img' => $fields['l_pay_img'],
                'l_pay_time'=> time(),
                'status'    => 1,
            );
            $this->db->update('w_uplevel', $pay_data, array('id' => $up_id));
            if ($this->smsset['w_user_dnt']) {
                $v_phone = $this->getMember($up_level['sid'], 'm_phone');
                $this->sendcode($v_phone, 'dnt');
            }
            echo json_encode(
                array(
                    'code' => 200,
                    'msg'  => '支付凭证,上传成功',
                )
            );
            exit();
        }
    }

    public function suser_order()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $user = $this->checkuser($fields);
            $uid = $fields['uid'];
            $up_level = $this->db->query("select * from w_uplevel where sid=$uid", 3);
            foreach ($up_level as &$row) {
                $row['m_name'] = $this->getMember($row['uid'], 'm_name');
                $row['m_phone'] = $this->getMember($row['uid'], 'm_phone');
                $carid = $this->getMember($row['uid'], 'm_carid');
                $m_rz = $this->getMember($row['uid'], 'm_rz');
                if($m_rz == 1 and $carid != false){
                    $row['m_name']  = $this->getMember($row['uid'], 'm_zsxm');
                    $row['m_carid'] = substr_replace($this->getMember($row['sid'], 'm_carid'),'******',5,6);
                }
                $row['m_avatar'] = $this->setup_img($this->getMember($row['uid'], 'm_avatar'));
                if ($row['status'] == 0) {
                    $row['s_desc'] = '待付款';
                } elseif ($row['status'] == 1) {
                    $row['s_desc'] = '已打款';
                } elseif ($row['status'] == 2) {
                    $row['s_desc'] = '已完成';
                }
            }
            echo json_encode(
                array(
                    'code' => 200,
                    'order' => $up_level,
                )
            );
            exit();
        }
    }

    public function suser_order_info()
    {
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $user = $this->checkuser($fields);
            $uid = $fields['uid'];
            $up_id = $fields['up_id'];
            $up_level = $this->db->query("select * from `w_uplevel` where `id`='$up_id' AND `sid`='$uid'", 2);
            if (empty($up_level)) {
                echo json_encode(array('code' => 404, 'msg' => '订单状态有误'));
                exit();
            }
            $w_pay = $this->db->query("select * from w_pay where p_uid='$uid' ORDER BY p_status desc", 2);
            if (empty($w_pay)) {
                echo json_encode(array('code' => 404, 'msg' => '众筹用户未添加收款码,请联系会员进行添加'));
                exit();
            }
            $w_pay['p_img'] = $this->setup_img($w_pay['p_img']);
            if($up_level['status']){
                $up_level['l_pay_img'] = $this->setup_img($up_level['l_pay_img']);
            }
            $s_user['m_name'] = $this->getMember($uid, 'm_name');
            $s_user['m_phone'] = $this->getMember($uid, 'm_phone');
            echo json_encode(
                array(
                    'code'       => 200,
                    'order_desc' => $up_level,
                    'w_pay'      => $w_pay,
                    's_user'     => $s_user,
                )
            );
            exit();
        }
    }
    public function query_over(){
        if ($this->post) {
            $fields = $this->SafeFilter($_POST);
            $user = $this->checkuser($fields);
            $uid = $fields['uid'];
            $up_id = $fields['up_id'];
            $is_cash = $this->db->query('select * from w_cash where `c_status`=0 AND c_uid='.$uid, 2);
            if(!empty($is_cash)){  echo json_encode(array('code' => 404, 'msg' => '未激活状态无法确认')); exit();}
            $up_level = $this->db->query("select * from `w_uplevel` where `id`='$up_id' AND `sid`='$uid' and status=1", 2);
            if (empty($up_level)) {
                echo json_encode(array('code' => 404, 'msg' => '订单状态有误'));
                exit();
            }
            if($up_level['level'] > $user['m_level']){
                echo json_encode(array('code'=>303,'msg'=>'您的级别过低,请升级后重试'));exit();
            }
            if($this->upgrade_do($up_id)>0){
                $this->sendcode($user['m_phone'], 'qrsk');
                echo json_encode(
                    array(
                        'code' => 200,
                        'msg'  => '确认成功,订单完成',
                    )
                );
                exit();
            }else{
                echo json_encode(
                    array(
                        'code' => 302,
                        'msg'  => '发生未知错误',
                    )
                );
                exit();
            }

        }
    }

    public function config_info(){
        if ($this->post){
            $data = $this->db->query('select * from w_config where id = 1', 2);
            $data['w_logo'] = $this->setup_img($data['w_logo']);
            echo json_encode(array('code' => 200, 'data' => $data,));exit();
        }
    }


}