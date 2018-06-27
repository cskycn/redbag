<?php
$_HOST = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';#兼容后台命令行运行
define('IS_DEV',strpos($_HOST,'.local')!==false);
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_PATH','./App/');
define('RUNTIME_PATH','./Runtime/');
define("TMPL_PATH","./tpl/");
//define('BIND_MODULE','Platform');

define("OSS_URL","");
if (IS_DEV) { //本地
    define('APP_DEBUG',false);
} else { //服务器
    define('APP_DEBUG',false);
}

require  './vendor/autoload.php';
require './System/ThinkPHP.php';