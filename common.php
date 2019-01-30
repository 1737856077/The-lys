<?php
/**
 * @[在线排版系统] zaixianpaiban system Information Technology Co., Ltd.
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:common.php 2018-04-05 13:50:00 $
 */

// 应用公共文件

/**
 * @function chkstr()
 * @description: 验证字符串
 * @param $str 字符串
 * @param $reg 正则别名
 * @return boolean
*/
function my_chkstr($str, $type = 'int'){
     $regex = array(
        'license' => '/^[\x{4e00}-\x{9fa5}]{1}[A-Z]{1}[A-Z0-9]{5}$/u',   //车牌
        'code' => '/^[1-9a-zA-z]+$/',   //验证码
        'seccode' => '/^[0-9]+$/',   //手机验证码
        'hash' => '/^[a-zA-Z0-9]+$/', //校验码
        'date' => '/^[1-2]{1}\d{3}-(([0]{1}[1-9]{1})|([1]{1}[0-2]{1}))-(([0]{1}[1-9]{1})|([1-2]{1}[0-9]{1}|[3]{1}[0-1]{1}))$/', //日期
        'int'=>'/^[1-9]{1}[0-9]+$/', //不可以0开头的数字
        'num'=>'/^[0-9]+$/', //可以0开头
        'tel'=>'/^(\d{3})-(\d{8})|(\d{4})-(\d{7})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})$/', //座机
        'mobile' => '/^[1]{1}(3[0-9]|5[^4,\D]|8[^4,\D]|47|7[0-9])\d{8}$/', //手机
        'h:m' =>'/^[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/', //时:分
        'email' =>'/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', //邮箱
        'username' =>'/^[a-zA-Z]{1}{a-zA-Z0-9_\.}{5,15}$/', //用户名;
     );
     if(!isset($regex[$type])) return false;
     if(!preg_match($regex[$type], $str)) return false;
     return true;
}

/**
 * @description: 随机生成指定长度、指定类型的字符串
 * @int $len 返回随机字符串的长度
 * @string $type 要生成的字符串的类型
 *                1,为空则返回数字加大小写字母混合的字符串
 *                2,为int 则返回不可以0为开始随机数字
 *                3,为num 则返回可以0开头的随机数字
 *                4,为str 则返回大小写混合的字符串(去除o,i,l,0,1等容易混淆字符)
 *                5,为lower 则返回小写字母组成的字符串
 *                6,为upper 则返回大写字母组成的字符串
 * @return string
*/
function my_randstr($len, $type = ''){
    $int = '123456789';
    $num = '0123456789';
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $upper = strtoupper($lower);
    $str = $lower.$upper;
    $code = 'abcdefghkmnprstuvwyABCDEFGHJKMNPRSTUVWY23456789';
    $hash = $str.$num;
    $types = array('int','str','lower','upper','code','num','hash');
    $string = in_array($type,$types) ? $$type : ($num.$str);
    $return = '';
    for($i = 0; $i < $len; $i++){
        if($i > 0 && $type == 'int') $string = $num;
        $return .= substr($string,rand(0,strlen($string)-1),1);
    }
    return (string)$return;
}

/**
 * 遮挡处理程序
 */
function my_license($license, $replace = "*", $start = 4, $length=3){
    $str = '';
    for($i = 0;$i < $length; $i++){
        $str .= $replace;
    }
    return str_replace(substr($license,$start,$length),$str,$license);
}

/**
 * 价格格式化
 */
function my_price($money,$num=2){
    //$formatted = sprintf("%01.2f", $money);
	$formatted = number_format($money,$num,".",",");
    return $formatted;
}

/**
 * 访问客户端类型判断
 */
function my_ismobile(){
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])){
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])){
        $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian', 'ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])){
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
            return true;
        }
    }
    return false;
}

/**
* 转化 \或/ 为 系统分隔符
*
* @param    string  $path   路径
* @return   string  路径
*/
function my_dirpath($path) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
    if(substr($path, -1) != DIRECTORY_SEPARATOR) $path = $path.DIRECTORY_SEPARATOR;
    return $path;
}
/**
* 创建目录
* @param    string  $path   路径
* @param    string  $mode   属性
* @return   string  如果已经存在则返回true，否则为flase
*/
function my_dircreate($path, $mode = 0777) {
    if(is_dir($path)) return TRUE;
    $ftp_enable = 0;
    $path = dirpath($path);
    $temp = explode(DIRECTORY_SEPARATOR, $path);
    $cur_dir = '';
    $max = count($temp) - 1;
    for($i=0; $i<$max; $i++) {
        $cur_dir .= $temp[$i].DIRECTORY_SEPARATOR;
        if (@is_dir($cur_dir)) continue;
        @mkdir($cur_dir, 0777,true);
        @chmod($cur_dir, 0777);
    }
    return is_dir($path);
}
/**
* 拷贝目录及下面所有文件
* @param    string  $fromdir    原路径
* @param    string  $todir      目标路径
* @return   string  如果目标路径不存在则返回false，否则为true
*/
function my_dircopy($fromdir, $todir) {
    $fromdir = dirpath($fromdir);
    $todir = dirpath($todir);
    if (!is_dir($fromdir)) return FALSE;
    if (!is_dir($todir)) dircreate($todir);
    $list = glob($fromdir.'*');
    if (!empty($list)) {
        foreach($list as $v) {
            $path = $todir.basename($v);
            if(is_dir($v)) {
                dircopy($v, $path);
            } else {
                copy($v, $path);
                @chmod($path, 0777);
            }
        }
    }
    return TRUE;
}
/**
* 转换目录下面的所有文件编码格式
* @param    string  $in_charset     原字符集
* @param    string  $out_charset    目标字符集
* @param    string  $dir            目录地址
* @param    string  $fileexts       转换的文件格式
* @return   string  如果原字符集和目标字符集相同则返回false，否则为true
*/
function my_diriconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
    if($in_charset == $out_charset) return false;
    $list = dirlist($dir);
    foreach($list as $v) {
        if (pathinfo($v, PATHINFO_EXTENSION) == $fileexts && is_file($v)){
            file_put_contents($v, iconv($in_charset, $out_charset, file_get_contents($v)));
        }
    }
    return true;
}
/**
* 列出目录下所有文件
* @param    string  $path       路径
* @param    string  $exts       扩展名
* @param    array   $list       增加的文件列表
* @return   array   所有满足条件的文件
*/
function my_dirlist($path, $exts = '', $list= array()) {
    $path = dirpath($path);
    $files = glob($path.'*');
    foreach($files as $v) {
        if (!$exts || pathinfo($v, PATHINFO_EXTENSION) == $exts) {
            $list[] = $v;
            if (is_dir($v)) {
                $list = dirlist($v, $exts, $list);
            }
        }
    }
    return $list;
}
/**
* 设置目录下面的所有文件的访问和修改时间
* @param    string  $path       路径
* @param    int     $mtime      修改时间
* @param    int     $atime      访问时间
* @return   array   不是目录时返回false，否则返回 true
*/
function my_dirtouch($path, $mtime = TIME, $atime = TIME) {
    if (!is_dir($path)) return false;
    $path = dirpath($path);
    if (!is_dir($path)) touch($path, $mtime, $atime);
    $files = glob($path.'*');
    foreach($files as $v) {
        is_dir($v) ? dirtouch($v, $mtime, $atime) : touch($v, $mtime, $atime);
    }
    return true;
}
/**
* 目录列表
* @param    string  $dir        路径
* @param    int     $parentid   父id
* @param    array   $dirs       传入的目录
* @return   array   返回目录列表
*/
function my_dirtree($dir, $parentid = 0, $dirs = array()) {
    global $id;
    if ($parentid == 0) $id = 0;
    $list = glob($dir.'*');
    foreach($list as $v) {
        if (is_dir($v)) {
            $id++;
            $dirs[$id] = array('id'=>$id,'parentid'=>$parentid, 'name'=>basename($v), 'dir'=>$v.'/');
            $dirs = dirtree($v.DIRECTORY_SEPARATOR, $id, $dirs);
        }
    }
    return $dirs;
}

/**
* 删除目录及目录下面的所有文件
* @param    string  $dir        路径
* @return   bool    如果成功则返回 TRUE，失败则返回 FALSE
*/
function my_dirdelete($dir) {
    $dir = dirpath($dir);
    if (!is_dir($dir)) return FALSE;
    $list = glob($dir.'*');
    foreach($list as $v) {
        is_dir($v) ? dirdelete($v) : @unlink($v);
    }
    return @rmdir($dir);
}

/**
 * @描述：判断星期几
 * @param	string		$n		--数字，1-7，7为周日
 * @param	int			$type	--类型（0：星期；1：上午/上午）
 * @return	string		$str	--返回格式化后的周期
 */
function my_returnWeekStr($n,$type=0){
	
	$arr=array("1"=>"周一",
			"2"=>"周二",
			"3"=>"周三",
			"4"=>"周四",
			"5"=>"周五",
			"6"=>"周六",
			"7"=>"周日",
	);
	$arrpm=array("AM"=>"上午",
				 "PM"=>"下午",
	);
	if($type==0){
		return strlen($arr[$n])>0 ? $arr[$n] : "未知" ;
	}else{
		$n=strtoupper($n);
		return strlen($arrpm[$n])>0 ? $arrpm[$n] : "未知" ;
	}
}

//返回UUID,去掉杠后的UUID
function my_returnUUID(){
	return  str_replace("-", "", md5(uniqid(mt_rand(), true)));
}

function my_wirtefile($contnet){
	$file = fopen('Log/'.date("Ymd").".txt", 'a+');
	fwrite($file,date("Y-m-d H:i:s：").$contnet."\n");
	fclose($file);
	unset($file);
}

/**
 * @描述：返回日期字符串
 * @param 	int		$time		--需要计算的时间截
 * @param 	int		$type		--格式：
 * @return 	string				--日期描述
 */
function my_ReturnDateString($time,$type=0)
{
	//获取今天凌晨的时间戳
	$day = strtotime(date('Y-m-d',time()));
	//获取昨天凌晨的时间戳
	$pday = strtotime(date('Y-m-d',strtotime('-1 day')));
	//获取现在的时间戳
	$nowtime = time();

	if($type==1){
		if($time<$pday){
			$str = date('Y-m-d H:i',$time);
		}elseif($time<$day && $time>$pday){
			$str = "昨天 ".date('H:i',$time);
		}else{
			//$str = "今天";
			$str = date('H:i',$time);
		}	
	}else{				
		if($time<$pday){
			$str = date('y/m/d',$time);
		}elseif($time<$day && $time>$pday){
			$str = "昨天";
		}else{
			//$str = "今天";
			$str = date('H:i',$time);
		}
	}
	return $str;
}


function PublicLogWrite($file_name,$word='') {
    $fp = fopen($file_name,"a");
    flock($fp, LOCK_EX) ;
    fwrite($fp,date('Y-m-d H:i:s').'：'.$word."\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}

//获得访客浏览器类型
function my_GetBrowser(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        $br = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i',$br)) {
            $br = 'MSIE';
        }elseif (preg_match('/Firefox/i',$br)) {
            $br = 'Firefox';
        }elseif (preg_match('/Chrome/i',$br)) {
            $br = 'Chrome';
        }elseif (preg_match('/Safari/i',$br)) {
            $br = 'Safari';
        }elseif (preg_match('/Opera/i',$br)) {
            $br = 'Opera';
        }else {
            $br = 'Other';
        }
        return $br;
    }else{return "获取浏览器信息失败！";}
}

//获得访客浏览器语言
function my_GetLang(){
    if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
        $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $lang = substr($lang,0,5);
        if(preg_match("/zh-cn/i",$lang)){
            $lang = "简体中文";
        }elseif(preg_match("/zh/i",$lang)){
            $lang = "繁体中文";
        }else{
            $lang = "English";
        }
        return $lang;

    }else{return "获取浏览器语言失败！";}
}

//获取访客操作系统
function my_GetOs(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        $OS = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/win/i',$OS)) {
            $OS = 'Windows';
        }elseif (preg_match('/mac/i',$OS)) {
            $OS = 'MAC';
        }elseif (preg_match('/linux/i',$OS)) {
            $OS = 'Linux';
        }elseif (preg_match('/unix/i',$OS)) {
            $OS = 'Unix';
        }elseif (preg_match('/bsd/i',$OS)) {
            $OS = 'BSD';
        }else {
            $OS = 'Other';
        }
        return $OS;
    }else{return "获取访客操作系统信息失败！";}
}

//获得访客真实ip
function my_Getip(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ //获取代理ip
        $ips = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
    }
    if(!empty($ip)){
        $ips = array_unshift($ips,$ip);
    }
    if(!isset($ips)){
        return $_SERVER['REMOTE_ADDR'];
    }
    $count = count($ips);
    for($i=0;$i<$count;$i++){
        if(!preg_match("/^(10|172\.16|192\.168)\./i",$ips[$i])){//排除局域网ip
            $ip = $ips[$i];
            break;
        }
    }
    $tip = empty($_SERVER['REMOTE_ADDR']) ? $ip : $_SERVER['REMOTE_ADDR'];
    if($tip=="127.0.0.1"){ //获得本地真实IP
        return my_get_onlineip();
    }else{
        return $tip;
    }
}

//获得本地真实IP
function my_get_onlineip() {
    $mip = file_get_contents("http://city.ip138.com/city0.asp");
    if($mip){
        preg_match("/\[.*\]/",$mip,$sip);
        $p = array("/\[/","/\]/");
        return preg_replace($p,"",$sip[0]);
    }else{return "获取本地IP失败！";}
}

//根据ip获得访客所在地地名
function my_Getaddress($ip=''){
    if(empty($ip)){
        $ip = my_Getip();
    }
    $ipadd = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?ip=".$ip);//根据新浪api接口获取
    if($ipadd){
        $charset = iconv("gbk","utf-8",$ipadd);
        preg_match_all("/[\x{4e00}-\x{9fa5}]+/u",$charset,$ipadds);

        return $ipadds;   //返回一个二维数组
    }else{return "addree is none";}
}

//取得客户端类型
function my_getClentType(){
    //判断是不是微信
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return "WeiXin";
    }
    //判断是不是支付宝
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
        return "Alipay";
    }
    //其它
    return "other";
}