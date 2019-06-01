<?php
date_default_timezone_set('PRC');

$config=require_once('../../database.php');
define("DB_HOST",$config["hostname"]);
define("DB_USERNAME",$config["username"]);
define("DB_PWD",$config["password"]);
define("DB_NAME",$config["database"]);
?>