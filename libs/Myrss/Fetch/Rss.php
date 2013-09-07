<?php

require_once("Myrss/Model/Mysql.php");
require_once("Myrss/Fetch/Article.php");


class Myrss_Fetch_Rss {
    private $mysql = null ;
    public $tableName = "RssInfo";

    public function __construct( ){  

        $this->mysql = new Myrss_Model_Mysql( $this->tableName);

    }

    public function getAllRssInfo(){
        $res = $this->mysql->get();
        return $res ;
    }
    public function getAllRssInfoById( $id ){
        $res = $this->mysql->get(array("id" => $id ));
        return $res ;
    }

    public function addRss($ary){
        $res = $this->mysql->add($ary);
        if($res <= 0){
            return FALSE ;
        }
        return TRUE ;
    }

    public function updateUnReadcount($rssid, $count){
        $res = $this->mysql->updateself(array("id"=>$rssid), array("unreadcount" => $count ));
        if($res != 1){
            return FALSE ;
        }
        return TRUE ;

    }

    public function autoUpdateUnreadCount( $rssid){
        $this->atl = new Myrss_Fetch_Article();
        $count = $this->atl->getUnreadCount( $rssid );
        $res = $this->mysql->updateself(array("id"=>$rssid), array("unreadcount" => $count ));
        if($res != 1){
            return FALSE ;
        }

        return TRUE ;
    }


}




