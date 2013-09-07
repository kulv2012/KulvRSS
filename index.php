<?php
# vim: set sw=4 smarttab expandtab:
require_once(dirname(__FILE__)."/conf/config.php");

function getElapsTime() {
    //首次调用返回当前时间，再次调用返回间隔时间
    static $beg = 0 ;
    list($usec, $sec) = explode(' ', microtime()); 
    $tmp = $beg ;
    $beg = ((float)$usec + (float)$sec) ; 
    return (int)(($beg-$tmp)*1000) ;
} 
getElapsTime();

define('MYRSS_ROOT_PATH', dirname(__FILE__));
set_include_path(get_include_path() . PATH_SEPARATOR . MYRSS_ROOT_PATH . '/libs');


$statics = "" ;


ob_start();


header('Content-Type: text/html; charset=utf-8');
