<?php
header("Content-Type:text/html;charset=utf-8");
define('IA_ROOT', str_replace("\\", '/', dirname(__FILE__)));
define('ROOT', dirname(__FILE__));
define('MODULE', 'admin');
define('SYSTEM', ROOT . '/system');
define('CORE', ROOT . '/system/core');
require(SYSTEM . '/config.php');
require(CORE . '/core.core.php');
core::init();


