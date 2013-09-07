<?php
# vim: set sw=4 smarttab expandtab:
require_once("Third/kohana/Database.php");



class Myrss_Utils_DB {
    public static function get( )
    {
        global $config;
        $db = NULL;
        
        $dbconf = $config["db"];
        $db = Myrss_Utils_DB::connectDB($dbconf ) ;
        if($db === NULL ){
            echo "连接所有数据库均失败";
            die();
        }
        return $db ; 
    }
    private static function connectDB($conf){
        global $config;

        $db = Database_Core::instance("default", $config['db']);






/*        $db = new Bd_DB();
        //注意mysqli的options函数如果传字符串时间，实际上是其assic码数字那么长！！！！不过我已经改了DB.php里面加入intVal
//        $db->setConnectTimeOut($conf['connecttimeout']) ;
//        $db->setReadTimeOut($conf['readtimeout']) ;
//        $db->setWriteTimeOut($conf['writetimeout'] );

//        $res = $db->connect($server, $conf['user'], $conf['pwd'], $conf['name'],$conf['port'] );
        //公司建议：不要用SET NAMES ，而要用set_charset。后者更安全。原因：http://www.laruence.com/2010/04/12/1396.html
        $res = $db->charset("UTF8");
        if($res == FALSE){
            $msg = "charset utf8 error ,errno:".$db->errno." , error:".$db->error;
            UB_LOG_WARNING("[errmsg:%s at %s]",$msg , __METHOD__);
        }
*/
        return $db;
    }
  }
