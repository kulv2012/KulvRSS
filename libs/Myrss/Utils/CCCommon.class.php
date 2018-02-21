<?php

/*
 *  Baidu Public Comman Library
 * */

class CCCommon // used as a namespace
{
    public static function getLogID()
    {
        $arr = gettimeofday();
        return ((($arr['sec']*100000 + $arr['usec']/10) & 0x7FFFFFFF) |
                0x80000000);
    }

    public static function getClientIP()
    {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "0.0.0.0";
        }

        $pos = strpos($ip, ',');
        if ($pos > 0) $ip = substr($ip, 0, $pos);
        return trim($ip);
    }

    public static function getHostname()
    {
        return isset($_ENV['HOSTNAME'])?($_ENV['HOSTNAME']):'';
    }

    public static function numToIP($num)
    {
        $tmp = (double)$num;
        return sprintf('%u.%u.%u.%u', $tmp & 0xFF, (($tmp >> 8) & 0xFF),
                (($tmp >> 16) & 0xFF), (($tmp >> 24) & 0xFF));
    }

    public static function ipToNum($ip)
    {
        if (!preg_match('/^([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)$/is', $ip)) {
            return 0;
        }
        $n = ip2long($ip);
        /** convert to network order */
        $n =       (($n & 0xFF) << 24)
                | ((($n >> 8) & 0xFF) << 16)
                | ((($n >> 16) & 0xFF) << 8)
                | (($n >> 24) & 0xFF);
        return $n;
    }

    public static function padString($str, $len, $bolCut, $ch = "\0")
    {
        if (strlen($str) >= $len) {
            $str = $bolCut ? substr($str, 0, $len-1) . $ch : substr($str, 0, $len);
        } else {
            $str = str_pad($str, $len, $ch);
        }
        return $str;
    }
    public static function fixLastChar($strData, $intLimit = 0)
    {
        $intLength = strlen($strData);
        if ($intLimit <= 0 || $intLimit > $intLength) {
            $intLimit = $intLength;
        }       
        $bolNeedFix =   false;  
        $strRet     =   ''; 
        for ($i = 0; $i < $intLimit; $i++) { 
            $ch1 = ord($strData[$i]);
            if ($bolNeedFix && $ch1 >= 0x40 && $ch1<= 0xFE && $ch1 != 0x7F) { 
                $bolNeedFix = false;
            } else if ($ch1 >= 0x81 && $ch1 <= 0xFE) { 
                $bolNeedFix = true; 
            } else {
                $bolNeedFix = false;
            }       
        }       
        return ($bolNeedFix)
            ? substr($strData, 0, $intLimit - 1)
            : substr($strData, 0, $intLimit);
    }
    public static function StringToHex($strData)
    {
        $strData    =   strval($strData);
        $strHex =   '';
        for ($i=0, $cnt=strlen($strData); $i<$cnt; $i++) {
            $intVal =   ord($strData{$i});
            $low    =   $intVal % 16;
            $hi     =   ($intVal - $low) / 16;
            $strHex .=  chr($hi > 9 ? 55 + $hi : 48 + $hi)
                . chr($low > 9 ? 55 + $low : 48 + $low);
        }
        return $strHex;
    }
    public static function transHtmlSpecialChars($strData,$bolStripSlashes=false) {
        if($bolStripSlashes) 
            return htmlspecialchars(stripcslashes($strData),ENT_QUOTES) ;
        else 
            return htmlspecialchars($strData,ENT_QUOTES) ;    
    }
    public static function TransJsonSpecialChars(&$strData, $bolAddSlash = true) {
        if ($bolAddSlash){
            return addslashes($strData);
        }
        else {
            return $strData;    
        }
    }
    function get_device_type(){
        $ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : "" ;
        $agent = strtolower($ua);
        $mobile_type = 'other';
        if(strpos($agent, 'iphone') ){
            $mobile_type = 'iphone' ;
        }else if( strpos($agent, 'ipad')){
            $mobile_type = 'ipad';
        }else if( strpos($agent, 'android')){
            $mobile_type = "android" ;
        }else {
            $mobile_type = "web" ;
        }
        return $mobile_type;
    }

    public static function getExceptionTraceAsString($exception) {
        $rtn = "[" . $exception->getMessage() . "]<" ;
        $count = 0;
        foreach ($exception->getTrace() as $frame) {
            $args = "";
            if (isset($frame['args'])) {
                $args = array();
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        /*如果长度大于256，只获取前256字符和...提示*/
                        if (strlen($arg) >256) {
                            $args[] = "'" . substr($arg, 0, 256) . "...'";
                        } else {
                            $args[] = "'" . $arg . "'";
                        }
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }   
                }   
                $args = join(", ", $args);
            }
            $rtn .= sprintf( "#%s %s(%s): %s(%s),",
                $count,
                isset($frame['file']) ? $frame['file'] : 'unknown file',
                isset($frame['line']) ? $frame['line'] : 'unknown line',
                (isset($frame['class']))  ? $frame['class'].'->'.$frame['function'] : $frame['function'],
                $args );
            $count++;
        }
        return $rtn;
    } 

    public static function LogError($content, $filename ) {
        file_put_contents($filename, date("Y-m-d H:i:s")." $content\n", FILE_APPEND) ;
    }


}


define('HOSTNAME',      CCCommon::getHostname());

/* vim: set ts=4 et: */
?>
