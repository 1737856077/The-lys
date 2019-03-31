<?php
date_default_timezone_set('PRC');

$config=require("../config.inc.php");
define("DB_HOST",$config["DB_HOST"]);
define("DB_USERNAME",$config["DB_USER"]);
define("DB_PWD",$config["DB_PWD"]);
define("DB_NAME",$config["DB_NAME"]);
?>