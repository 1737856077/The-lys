<?php

class mod
{
    protected $db_prefix;
    protected $version;
    protected $db;
    protected $post;
    protected $ispage;
    protected $time;
    protected $request_time_from;
    protected $request_time_to;
    protected $clients = array('web', 'mobile');
    protected $client_type = 'mobile';
    protected $user_levels;
    protected $base_levels;
    protected $user_nick;
    protected $agent_levels;
    protected $user_prices = array();
    protected $logs_type = array(0 => '后台充值', 1 => '后台减扣', 2 => '用户充值', 3 => '用户消费');
    protected $admin_type = array(0 => '系统禁用', 1 => '正常使用');
    protected $logs_status = array(0 => '待付款', 1 => '已完成');
    protected $user_gender = array(0 => '未知', 1 => '男', 2 => '女');
    protected $banner_cate = array(0 => '', 1 => '首页', 2 => '课堂');
    protected $suit_type = array(0 => '联系不到对方', 1 => '恶意抬高定价', 2 => '销售伪劣产品', 3 => '交易存在欺诈', 4 => '其他违规行为');
    protected $user_check = true;                 //登录检查
    protected $user_session = 'CLIENTUSER';
    protected $admin_session = 'CLIENTADMIN';
    protected $user;
    protected $config;
    protected $smsset;
    protected $viprice;
    public $pagesize = 20;

    public function __construct()
    {
        $this->db_prefix = DB_PREFIX;
        $this->db = core::lib('db');
        $this->post = strtolower($_SERVER['REQUEST_METHOD']) === 'post' ? true : false;
        $this->ispage = (array_key_exists('ispage', $_POST) && $_POST['ispage'] === 'true') ? true : false;
        $this->time = time();
        $this->config = $this->db->query('select * from w_config where id=1', 2);
        $this->smsset = $this->db->query('select * from w_sms where id=1', 2);
        define('WEBNAME', $this->config['w_name']);
        $levels = $this->db->query('select * from w_level order by id asc', 3);
        $user_level = array(0 => 'v0');
        $base_level = array(0 => 'v0');
        $user_nick = array(0 => '暂无');
        foreach ($levels as $l) {
            $user_level[$l['id']] = $l['l_name'];
            $user_nick[$l['id']] = $l['l_nick'];
            if ($l['id'] <= $this->config['w_level']) {
                $base_level[$l['id']] = $l['l_name'];
            }
        }
        $this->user_levels = $user_level;
        $this->base_levels = $base_level;
        $this->user_nick = $user_nick;
        $agent = $this->db->query('select * from w_agent order by a_level asc', 3);
        $agent_level = array(0 => '普通用户');
        foreach ($agent as $k => $v) {
            $agent_level[$v['a_level']] = $v['a_name'];
        }
        $this->agent_levels = $agent_level;
        $this->webname = WEBNAME;
        if ($this->config['w_hour'] > 0) {
            $this->autofinish();
        }

    }

    public function changepid($uid, $pid)
    { //修改接点人关系
        $cur_user = $this->db->query('select * from w_users where id=' . $uid, 2);
        $old_pid = $cur_user['m_pid'];
        $old_line = $cur_user['m_line'];

        //更新老节点人的首层人数
        $old_user = $this->db->query('select * from w_users where id=' . $old_pid, 2);
        if (!empty($old_user)) {
            $old_num = intval($old_user['m_num'] > 1) ? intval($old_user['m_num'] - 1) : 0;
            $this->db->update('w_users', array('m_num' => $old_num), array('id' => $old_pid));
        }

        //更新新节点人的首层人数
        $new_user = $this->db->query('select * from w_users where id=' . $pid, 2);
        if (!empty($new_user)) {
            $new_num = intval($new_user['m_num'] + 1);
            $new_line = $new_user['m_line'] . ',' . $uid;//新的节点
            $this->db->update('w_users', array('m_num' => $new_num), array('id' => $pid));
        } else {
            $new_line = '0,' . $uid;//新的节点
        }
        $new_layer = count(explode(',', $new_line)) - 1;
        //更新当前会员的 m_line m_layer m_pid 信息
        $this->db->update('w_users', array('m_line' => $new_line, 'm_layer' => $new_layer, 'm_pid' => $pid), array('id' => $uid));
        //查找所有uid的下级 循环更新 m_line和m_layer信息
        $all_down = $this->db->query("select * from w_users where m_line like '%," . $uid . ",%'", 3);
        foreach ($all_down as & $down) {
            $down_line = str_replace($old_line, $new_line, $down['m_line']);
            $down_layer = count(explode(',', $down_line)) - 1;
            $this->db->update('w_users', array('m_line' => $down_line, 'm_layer' => $down_layer), array('id' => $down['id']));
        }
        return 1;
    }

    public function autofinish()
    {
        $mintime = 3600 * $this->config['w_hour'];
        $startime = time() - $mintime;
        $users = $this->db->query('select * from w_users where m_del=0 and m_level=0 and m_regtime<=' . $startime, 3);
        if (count($users) > 0) {
            foreach ($users as $u) {
                $userid = $u['id'];
                $this->db->update('w_users', array('m_del' => 1, 'm_level' => 0), array('id' => $userid));
                if ($u['m_pid']) {//到期自动删除会员 并更新节点人的一层人数
                    $m_pid = $u['m_pid'];
                    $query = "select * from w_users where id='" . $m_pid . "' and m_del=0";
                    $member = $this->db->query($query, 2);
                    $m_num = $member['m_num'] - 1;
                    if ($m_num < 0) {
                        $m_num = 0;
                    }
                    $this->db->update('w_users', array('m_num' => $m_num), array('id' => $m_pid));
                }
                //删除会员的订单记录
                $this->db->query('delete from w_uplevel where uid=' . $userid . ' or sid=' . $userid, 0);
            }
        }
    }

    public function getUpID($lines, $level, $index, $layer)
    {
        $ret_id = 0;
        $m_layer = $layer - $index;
        if ($m_layer > 0){
            if ($level > 0){       //level = index
                $t_user = $this->db->query('select id,m_del,m_layer from w_users where m_lock=0 and m_del=0 and id in (' . $lines . ') and m_layer<=' . $m_layer . ' and m_level>=' . $level . ' order by m_layer desc', 2);
            }else{
                $t_user = $this->db->query('select id,m_del,m_layer from w_users where m_lock=0 and m_del=0 and id in (' . $lines . ') and m_layer=' . $m_layer . ' order by m_layer desc', 2);
            }
            if (!empty($t_user)) {
                //$cash   = $this->db->query('select * from w_cash where `c_status`=1 AND c_uid='.$t_user['id'], 2);
                //if(!empty($cash)){
                $ret_id = $t_user['id'];
                //}
            }
        }
        return $ret_id;
    }


    public function getDowns($id, $t)
    {
        $user = $this->db->query('select id,m_level,m_name,m_del,m_phone,m_lock from w_users where id=' . $id, 2);
        $ret_array = array(
            'name' => '<a href="?m=user&c=tree&id=' . $user['id'] . '">' . $user['m_name'] . '(' . $user['id'] . ')</a>',
        );

        $m_title = $user['m_phone'] . '<br/>' . $this->user_levels[$user['m_level']] . '<br/><span style="color: #00c1ff">状态：运营中</span>';
        if ($user['m_lock'] > 0) {
            $m_title = $user['m_phone'] . '<br/>' . $this->user_levels[$user['m_level']] . '<br/><span style="color:#ffb11d">状态：已锁定</span>';
        }
        if ($user['m_del'] > 0) {
            $m_title = $user['m_phone'] . '<br/>' . $this->user_levels[$user['m_level']] . '<br/><span style="color:red">状态：已删除</span>';
        }
        $ret_array['title'] = $m_title;
        $childs = array();
        if ($t < 3) {
            $t = $t + 1;
            $users = $this->db->query('select id,m_level,m_name,m_del,m_phone from w_users where m_pid=' . $id . ' order by id asc', 3);
            if ($users) {
                foreach ($users as $u) {
                    $d_user = $this->getDowns($u['id'], $t);
                    array_push($childs, $d_user);
                }
            }
        }
        $ret_array['children'] = $childs;
        return $ret_array;
    }


    public function do_score($uid, $ping)
    {
        $user = $this->db->query('select * from w_users where id=' . $uid, 2);
        if ($user) {
            $ping_str = 'w_ping' . $ping;
            $score = $user['m_score'] + $this->config[$ping_str];
            $this->db->update('w_users', array('m_score' => $score), array('id' => $uid));
        }
        return 1;
    }

    public function do_logs($uid, $type, $num, $minfo)
    {
        $user = $this->db->query('select * from w_users where id=' . $uid, 2);
        $field = 'm_money';
        if ($user) {
            $money = $user[$field] + $num;
            $this->db->update('w_users', array($field => $money), array('id' => $uid));
            $logs = array(
                'l_uid' => $uid,
                'l_type' => $type,
                'l_num' => $num,
                'l_info' => $minfo,
                'l_time' => time()
            );
            $this->db->insert('w_logs', $logs);
            return 1;
        } else {
            return 0;
        }
    }


    //生成订单号
    public function getNum()
    {
        $str = '1234597890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str), 0, 5) . time() . rand(100, 999);
    }


    public function getPidbyTid($tid)
    {
        $max_num = $this->config['w_frame'];
        $w_huanum = $this->config['w_huanum'];              //接收滑落的数量
        if ($max_num == 1) {
            if ($this->config['w_hualuo'] == 0) {
                return $tid;
            } else {
                //判断推荐人是否满足直推人数的条件
                $s_user = $this->db->query("select id,m_level,m_tid,m_pid from w_users where `m_del`='0' and `m_tid` = '$tid'", 3);
                $s_count = count($s_user);
                if ($s_count < $w_huanum) {
                    return $tid;
                } else {
                    return $this->GetSlipingPidByTid($tid);
                }
            }
        } else {
            $p_user = $this->db->query('select count(id) as p_count from w_users where m_del=0 and m_pid=' . $tid, 2);
            $p_count = empty($p_user['p_count']) ? 0 : intval($p_user['p_count']);
            if ($p_count < $max_num) {                    //如果自己下面没有满员，则放到自己下面
                return $tid;
            } else {                                      //找出当前会员下所有一星会员及以上会员 且第一层会员数量小于架构数量的会员
                $w_hlevel = $this->config['w_hlevel'];
                $query = "select * from `w_users` where m_line like '%," . $tid . ",%' and m_del=0 and m_lock=0 and m_level>=" . $w_hlevel . " and m_num<" . $max_num . " order by id asc limit 0,1";
                $puser = $this->db->query($query, 2);
                if (!empty($puser)) {
                    return $puser['id'];
                } else {
                    return $tid;
                }
            }
        }
    }

    //会员滑落机制
    public function GetSlipingPidByTid($tid)
    {
        $w_hlevel = $this->config['w_hlevel'];        //接收滑落的级别
        $w_huanum = $this->config['w_huanum'];        //接收滑落的数量
        $s_user = $this->db->query("select id,m_level,m_tid,m_pid from w_users where `m_del`='0' and `m_tid` = '$tid' and `m_level`>='$w_hlevel' and `m_lock` = '0' order by m_regtime asc", 3);
        if (!empty($s_user)) {
            $data = array();
            foreach ($s_user as $row) {
                $row_id = $row['id'];
                $z_user = $this->db->query("select count(id) as z_count from w_users where `m_del`='0' and `m_pid` = '$row_id' and `m_tid` = '$row_id' order by m_regtime desc", 2);
                $z_count = empty($z_user['z_count']) ? 0 : intval($z_user['z_count']);      //直推人数
                $n_user = $this->db->query("select count(id) as n_count from w_users where `m_del`='0' and `m_pid` = '$row_id' and `m_tid` <> '$row_id' order by m_regtime desc", 2);
                $n_count = empty($n_user['n_count']) ? 0 : intval($n_user['n_count']);      //已滑落的人数
                $data[] = array(
                    'uid' => $row_id,
                    'z_num' => $z_count,
                    'n_num' => $n_count,
                );
            }
            $arr = $this->arraySort($data, 'z_num', 'desc');
            foreach ($arr as $row2) {
                if ($row2['z_num'] != 0 and $row2['n_num'] < $w_huanum and $row2['n_num'] < $row2['z_num']) {
                    return $row2['uid'];
                }
            }
        }
        return $tid;
    }

    public function arraySort($arr, $keys, $type = 'asc')
    {
        $keys_value = $new_array = array();
        foreach ($arr as $k => $v) {
            $keys_value[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($keys_value);
        } else {
            arsort($keys_value);
        }
        reset($keys_value);
        foreach ($keys_value as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }



    public function upgrade_do($logid)
    {
        $u_log = $this->db->query('select * from w_uplevel where id=' . $logid, 2);
        if (!empty($u_log)) {
            if ($u_log['status'] == 1) {
                $this->db->update('w_uplevel', array('status' => 2, 'd_time' => time()), array('id' => $logid));
                $uid = $u_log['uid'];
                $sid = $u_log['sid'];
                $logs = $this->db->query('select * from w_uplevel where status<2 and uid=' . $uid, 3);
                $s_cash  = $this->db->query('select * from w_cash where c_uid='.$sid, 2);
                $m_cash  = $this->db->query('select * from w_cash where c_uid='.$uid, 2);
                if(!empty($s_cash)){
                    $set_cash = array(
                        'c_sp_num' => $s_cash['c_sp_num'] - $u_log['price'],
                        'c_ov_num' => $s_cash['c_ov_num'] + $u_log['price'],
                    );
                    $this->db->update('w_cash',$set_cash, array('c_id' => $s_cash['c_id']));
                }
                if (count($logs) <= 0){                                                 //没有未审核的记录
                    $level     = $u_log['level'];
                    $my_logs   = $this->db->query('select sum(price) as my_price from w_uplevel where status=2 and uid=' . $sid, 2);
                    $my_price  = empty($my_logs['my_price']) ? 0 : intval($my_logs['my_price']);
                    if(!empty($s_cash)){
                        $data      = $this->set_stage($s_cash['c_num'], $my_price);
                        $alr_arr   = $data['alr_arr'];
                        $key       = count($alr_arr)-1;
                        $stage_arr = $data['stage_arr'];
                        $s_arr     = $stage_arr[$key];
                        $a_arr     = $alr_arr[$key];
                        if ($s_arr == $a_arr){
                            $this->db->update('w_cash', array('c_status'=>0), array('c_id' => $s_cash['c_id']));
                        }
                    }
                    $this->db->update('w_cash',array('c_status' =>1), array('c_id' => $m_cash['c_id']));
                    $this->db->update('w_users',array('m_level' => $level), array('id' => $uid));
                    if($this->smsset['w_user_snt']){
                        $v_phone = $this->getMember($uid, 'm_phone');
                        $this->sendcode($v_phone, 'snt');
                    }
                    return 2;
                }else{
                    return 1;
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function creatNo()
    {
        return date('YmdHis', time()) . $this->generate_code(6);
    }

    public function creatSeed()
    {
        return date('ymd', time()) . $this->generate_code(5);
    }

    function getMillisecond()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }

    protected function getMember($uid, $keys)
    {
        $sql = 'select id,' . $keys . ' from w_users where id=' . $uid;
        $members = $this->db->query($sql, 2);
        if (empty($members)) {
            return '暂无';
        }
        return $members[$keys];
    }

    protected function getHang($cid, $key)
    {
        $sql = 'select id,' . $key . '  from w_cates where id=' . $cid;
        $cate = $this->db->query($sql, 2);
        if (empty($cate)) {
            return '无';
        }
        return $cate[$key];
    }

    protected function getUser($uid)
    {
        $sql = 'select id,m_name,m_phone from w_users where id=' . $uid;
        $members = $this->db->query($sql, 2);
        if (empty($members)) {
            return '未知';
        }
        return $members['m_name'] . '(' . $members['id'] . ')<br/>' . $members['m_phone'];
    }

    protected function getUsers($uid)
    {
        $sql = 'select id,m_name,m_phone from w_users where id=' . $uid;
        $members = $this->db->query($sql, 2);
        if (empty($members)) {
            return '未知';
        }
        return '昵称：' . $members['m_name'] . ' 手机号：' . $members['m_phone'];
    }

    protected function unlogin()
    {
        unset($_SESSION['uid']);
        unset($_SESSION['token']);
        unset($_SESSION['m_phone']);
        if (!$_SESSION["uid"]){
            header('Location:index.php?m=index&c=login');
        }
    }
    protected function checkUserVi()
    {
        $url_login = 'index.php?m=index&c=login';
        if (isset($_SESSION['uid']) && $_SESSION['uid'] != ''){
            $userUid = intval($_SESSION['uid']);
            $sql = "select * from w_users where id=".$userUid;
            $user = $this->db->query($sql,2);
            if ($user){
                return true;
            }else{
                header('Location: ' . $url_login);
                exit;
            }
        }else{
            header('Location: ' . $url_login);
            exit;
        }
    }
    protected function checkadmin()
    {
        $url_login = 'admin.php?m=index&c=login';
        if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != '') {
            $admin_id = intval($_SESSION['admin_id']);
            $sql = "select * from w_admin where id=" . $admin_id;
            $user = $this->db->query($sql, 2);
            if (!empty($user)) {
                $index_url = 'admin.php?m=index&c=index';
                $m = isset($_GET['m']) ? $_GET['m'] : 'index';
                $c = isset($_GET['c']) ? $_GET['c'] : 'index';
                $auth = $this->db->query("select * from w_auth where `a_ctl`='$m' and `a_fun` = '$c'", 2);
                if (!empty($auth)) {
                    $auth_id = ',' . $auth['id'] . ',';
                    $role = $this->db->query("select * from w_role where r_auth_ids like '%$auth_id%' and id = " . $user['w_role'], 2);
//                    $_SESSION[$this->admin_session] = serialize($user);
//                    return $user;
                    if (!empty($role) and $role['id'] == $user['w_role']) {
                        $_SESSION[$this->admin_session] = serialize($user);
                        return $user;
                    } else {
                        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
                            return 1;
                        } else {
                            header('Content-Type:text/html;charset=utf-8');
                            echo "<script type='text/javascript'>";
                            echo "alert('您当前没有访问权限！');";
                            echo "top.location.href='?m=index&c=index';";
                            echo "</script>";
                            exit;
                        }
                    }
                } else {
                    if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
                        return 1;
                    } else {
                        // 正常请求的处理方式
                        header('Content-Type:text/html;charset=utf-8');
                        echo "<script type='text/javascript'>";
                        echo "alert('暂无该权限,请前往添加');";
                        echo "top.location.href = 'admin.php?m=index&c=auth_index';";
                        echo "</script>";
                        exit;
                    }
                }

            } else {
                header('Location: ' . $url_login);
                exit;
            }
        } else {
            header('Location: ' . $url_login);
            exit;
        }
    }

    public function exportToExcel($filename, $tileArray = [], $dataArray = [])
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=" . $filename);
        $fp = fopen('php://output', 'w');
        fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($fp, $tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            if ($index == 1000) {
                $index = 0;
                ob_flush();
                flush();
            }
            $index++;
            fputcsv($fp, $item);
        }
        ob_flush();
        flush();
        ob_end_clean();
    }

    public function captcha()
    {
        $_vc = core::lib('captcha');
        $_vc->doimg();
        $_SESSION['captcha'] = $_vc->getCode();
    }

    public function sendsms($pnum, $psms)
    {
        $sendurl = 'http://api.smsbao.com/sms?u=' . $this->smsset['w_user_name'] . '&p=' . md5($this->smsset['w_user_pass']) . '&m=' . $pnum . '&c=' . urlencode($psms);
        return file_get_contents($sendurl);
    }

    public function sendcode($phonenum, $type)
    {
        $sms_key = 'w_user_' . $type . '_sms';
        $sms_sty = 'w_user_' . $type;
        $sms_txt = $this->smsset[$sms_key];
        $sms_name = '用户';
        $member = $this->db->query("select id,m_phone,m_name from w_users where m_phone='$phonenum'", 2);
        if(!empty($member)){
            $sms_name = $member['m_name'];
        }
        if($this->smsset[$sms_sty]){
            $verifycode = $this->generate_code(6);
            $sms_txt = str_replace("{NAME}", $sms_name, $sms_txt);
            $sms_txt = str_replace("{CODE}", $verifycode, $sms_txt);
            $_SESSION['verycode'] = $verifycode;
            $this->cache_set($phonenum, $verifycode);
            return $this->sendsms($phonenum, $sms_txt);
        }else{
            $verifycode= '123456';
            $_SESSION['verycode'] = $verifycode;
            $this->cache_set($phonenum, $verifycode);
            return 1;
        }
    }

    public function setup_img($img)
    {
        if ($img != '' and $img != false) {
            $arr_img = explode(',', $img);
            $str_img = '';
            if (count($arr_img) > 1) {
                foreach ($arr_img as &$row) {
                    $row = 'http://' . $_SERVER['HTTP_HOST'] . ltrim($row, '.');
                }
                $str_img = implode(',', $arr_img);
            } else {
                $str_img = 'http://' . $_SERVER['HTTP_HOST'] . ltrim($arr_img[0], '.');
            }
            return $str_img;
        } else {
            return '';
        }
    }

    public function verifycode()
    {
        $sendcode = $_GET['verifycode'];
        if ($_SESSION['verycode'] == $sendcode) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function generate_code($length)
    {
        return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
    }


    protected function display($tpl_name, $args = array())
    {
        define('TPL', SYSTEM . '/tpl/' . MODULE . '/' . $this->client_type);
        extract($args);
        $path = TPL . '/' . $tpl_name . '.php';
        if (file_exists($path)) {
            require($path);
        } else {
            echo " <script>
                window.location.href = '?m=index&c=index'
</script>";
        }
    }

    private function randomkeys($length)
    {
        $key = "";
        $pattern = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $pattern1 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pattern2 = '0123456789';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{
            mt_rand(0, 35)
            };
        }
        return $key;
    }


    public function SafeFilter($arr)
    {
        $ra = Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '/script/', '/javascript/', '/vbscript/', '/expression/', '/applet/', '/meta/', '/xml/', '/blink/', '/link/', '/style/', '/embed/', '/object/', '/frame/', '/layer/', '/title/', '/bgsound/', '/base/', '/onload/', '/onunload/', '/onchange/', '/onsubmit/', '/onreset/', '/onselect/', '/onblur/', '/onfocus/', '/onabort/', '/onkeydown/', '/onkeypress/', '/onkeyup/', '/onclick/', '/ondblclick/', '/onmousedown/', '/onmousemove/', '/onmouseout/', '/onmouseover/', '/onmouseup/', '/onunload/');
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                if (!is_array($value)) {
                    if (!get_magic_quotes_gpc()) {
                        $value = addslashes($value);                              //给单引号（'）、双引号（"）、反斜线（\）与NUL（NULL字符）加上反斜线转义
                    }
                    $value = preg_replace($ra, '', $value);      //删除非打印字符，粗暴式过滤xss可疑字符串
                    $arr[$key] = $value;                                       //去除 HTML 和 PHP 标记并转换为HTML实体
                } else {
                    $this->SafeFilter($arr[$key]);
                }
            }
        }
        return $arr;
    }

    public function set_cash($uid, $jid)
    {
        $m_cash = $this->db->query('select * from w_cash where c_uid=' . $uid, 2);
        $u_jh = $this->db->query('select * from w_jihua where j_id=' . $jid, 2);
        $cash_arr = array(
            'c_time' => time(),
            'c_ov_num' => 0,
            'c_status' => 0,
            'c_uid' => $uid,
        );
        if (empty($m_cash)) {
            $cash_arr['c_num'] = $u_jh['j_price'];
            $cash_arr['c_sp_num'] = $u_jh['j_price'];
            $is_res = $this->db->insert('w_cash', $cash_arr);
        } else {
            $cash_arr['c_num'] = $m_cash['c_num'] + $u_jh['j_price'];
            $cash_arr['c_sp_num'] = $m_cash['c_sp_num'] + $u_jh['j_price'];
            $is_res = $this->db->update('w_cash', $cash_arr, array('c_id' => $m_cash['c_id']));
        }
        return $is_res;
    }

    //key加密
    public function api_key($uid)
    {
        $time = time();
        $rand = rand('00000', '99999');
        $str = md5('YY' . $uid) . md5($rand . $time);
        $key = md5($str);
        $api_key = substr($key, '0', '16');
        $end_time = strtotime('+5 day');
        $arr = array(
            'token' => $api_key,
            'uid' => $uid,
            'expire_time' => $end_time,
            'update_time' => $time
        );
        $token = $this->db->query("select * from w_token where uid=" . $uid, 2);
        if (empty($token)) {
            $is_token = $this->db->insert('w_token', $arr);
        } else {
            $is_token = $this->db->update('w_token', $arr, array('uid' => $uid));
        }
        if ($is_token) {
            return $api_key;
        } else {
            return 404;
        }
    }

    public function cache_get($verb)
    {
        $cache = core::lib('cache');
        $cache->Cache('600', './cache/');
        $very_code = $cache->get($verb);
        return $very_code;
    }

    public function cache_set($verb, $code)
    {
        $cache = core::lib('cache');
        $cache->Cache('600', './cache/');
        $cache->put($verb, $code);
    }


    public function checkuser($fields)
    {
        $time = time();
        if (!array_key_exists('uid', $fields)) {
            echo json_encode(array('code' => 600,  'msg' => '用户ID不存在'));
            exit();
        }
        if (!array_key_exists('token', $fields)) {
            echo json_encode(array('code' => 600,  'msg' => '未检查到Token信息'));
            exit();
        }
        $this->db->query("delete from w_token where expire_time<'$time'", 0);
        $token = $fields['token'];
        $m_token = $this->db->query("select * from w_token where token='$token'", 2);
        if (empty($m_token)) {
            echo json_encode(array('code' => 600,  'msg' => 'Token信息不存在'));
            exit();
        }
        if ($m_token['expire_time'] >= $time) {
            $expTime = strtotime("+5 day");
            $save_token = array(
                'expire_time' => $expTime,
                'update_time' => time()
            );
            $this->db->update('w_token', $save_token, array('token' => $token));
        } else {
            echo json_encode(array('code' => 600,  'msg' => 'Token过期,请获取'));
            exit();
        }
        $uid = intval($fields['uid']);
        $user = $this->db->query("select * from w_users where id=" . $uid, 2);
        if (!empty($user)) {
            return $user;
        } else {
            echo json_encode(array('code' => 600,  'msg' => '会员已过期,请重新登录'));
            exit();
        }
    }


    //上传
    public function uploads($name)
    {
        if ($_FILES[$name]["error"] != 0) {
            echo json_encode(array('code' => 403, 'msg' => '发生错误'));
            exit();
        } else {
            if (($_FILES[$name]["type"] == "image/png" || $_FILES[$name]["type"] == "image/jpeg" || $_FILES[$name]["type"] == "image/gif" || $_FILES[$name]["type"] == "image/jpg")) {
                $filename = substr(strrchr($_FILES[$name]["name"], '.'), 1);
                $filename = "./static/upload/" . date('Ymd', time()) . $this->randomkeys('12') . '.' . $filename;
                if (file_exists($filename)) {
                    echo json_encode(array('code' => 403, 'msg' => '文件已经存在'));
                    exit();
                } else {
                    move_uploaded_file($_FILES[$name]["tmp_name"], $filename);
                    return $filename;
                }
            } else {
                echo json_encode(array('code' => 403, 'msg' => '图片格式有误'));
                exit();
            }
        }
    }

    public function set_stage($a_num, $b_num)
    {
        $w_price_num = $this->config['w_price_num'];
        $level = $this->db->query('select * from w_level order by id limit 0,' . $this->config['w_level'], 3);
        $x = 1;
        $sum_price = 0;
        $stage_arr = array();
        foreach ($level as $row) {
            $price = $w_price_num * pow(3, $x);
            if ($sum_price + $price > $a_num) {
                $stage_arr[$x-1] = $a_num - $sum_price;
                break;
            } else {
                $stage_arr[$x-1] = $price;
                $sum_price = $sum_price + $price;
            }
            $x++;
        }
        $xx = 1;
        $odd_price = 0;
        $alr_arr = array();
        foreach ($level as $row) {
            $price = $w_price_num * pow(3, $xx);
            if ($odd_price+$price > $b_num) {
                if($b_num - $odd_price !=0 ){
                    $alr_arr[$xx-1] = $b_num - $odd_price;
                }
                break;
            }else{
                $alr_arr[$xx-1] = $price;
                $odd_price = $odd_price + $price;
            }
            $xx++;
        }
        return array(
            'stage_arr' => $stage_arr,
            'alr_arr' => $alr_arr,
        );
    }



    public function get_cash($uid){
        $data = array(
            'c_num'     => 0,
            'c_ov_num'  =>0,
        );
        $cash = $this->db->query('select * from w_cash where c_uid='.$uid, 2);
        if(!empty($cash)){
                $data['c_num']    = $cash['c_num'];
                $data['c_ov_num'] = $cash['c_ov_num'];
        }
        return $data;
    }

    public function MakeKey(){
        $str = '1ABCDEFGHIJKL23MNO490PQRS58TU97VWXYZ';
        $key = rand(0, 9).substr(str_shuffle($str), 0, 4).rand(0, 9);
        $member = $this->db->query("select * from w_users where `m_yqm`='".$key."'", 2);
        if(!empty($member)){
            $this->MakeKey();
        }
        return $key;
    }

    public function SetupUser($uid,$m_name){
        $this->db->update('w_users', array('m_name' => $m_name), array('id' => $uid));
    }


}