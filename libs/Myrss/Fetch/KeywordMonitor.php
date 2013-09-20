<?php

require_once("Myrss/Model/Mysql.php");



class Myrss_Fetch_KeywordMonitor {
    private $mysql = null ;
    public $tableName = "KeywordMonitor";
    public $orderary = array("id" => "desc",);

    public function __construct( ){  

        $this->mysql = new Myrss_Model_Mysql( $this->tableName);

    }

    public function AddMonitorItem($szKeyword, $nWeight, $szMail) {
        $ary = array("keyword"=> $szKeyword, "star" => $nWeight, "action" => $szMail ) ;
        $res = $this->mysql->add($ary);
        if($res <= 0){
            return FALSE ;
        }
        return TRUE ;
    }

    public function getAllKeywordInfo(){
        $res = $this->mysql->get(array(), $this->orderary);
        return $res ;
    }

    public function DeleteKeywordMonitor($id){
        $res = $this->mysql->del( array( "id" => $id, ));
        if($res <= 0){
            return FALSE ;
        }
        return TRUE ;
    }

    public function checkKeywordMonitor( $subject, $content ){
        $got = FALSE;
        $allkeys = $this->getAllKeywordInfo();
        foreach($allkeys as $key ){
            if(strpos($content, $key['keyword']) !== false
               || preg_match($key['keyword'], $content) == true  ) {
                $got = $key ;
                break;
            }
        }
        return $got ;
    }
}




