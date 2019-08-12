<?php
define('WEBDESC', '管理系统');
define('DB_HOST', '127.0.0.1');     // 数据库主机
define('DB_PORT', '3306');              // 数据库端口号
define('DB_NAME', 'youqianhuan');     // 数据库名称
define('DB_USER', 'root');              // 数据库账户
define('DB_PASS', 'root');              // 数据库密码
define('DB_PREFIX', 'w_');              // 数据库表前缀
define('MEMBER_SESSIONTIME', 15 * 60);  // 用户登录有效时长
define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
define('TIMESTAMP', time());
define('LYS','liyusheng');
