<?php

require_once("Myrss/Model/Mysql.php");



class Myrss_Fetch_Article {
    private $mysql = null ;
    public $tableName = "ArticleInfo";
    public $orderary = array("isreaded" => "asc", "star" => "desc" ,"aid" => "desc",);

    public function __construct( ){  

        $this->mysql = new Myrss_Model_Mysql( $this->tableName);

    }

    public function getAllArticleInfo(){
        $res = $this->mysql->get(array(), $this->orderary);
        return $res ;
    }
    public function getAritcleInfo($ary){
        $res = $this->mysql->get($ary,  $this->orderary);
        return $res ;
    }
    public function getAritcleInfoByRssid($rssid){
        return $this->getAritcleInfo(array("rssid" => $rssid)) ;
    }
    public function getUnreadArticle(){
        return $this->getAritcleInfo(array("isreaded" =>0)) ;
    }

    public function addArticle($ary){

        $res = $this->mysql->add($ary);
        if($res <= 0){
            return FALSE ;
        }
        return TRUE ;
    }
    public function deleteArticle($ary){
        $res = $this->mysql->del($ary);
        if($res <= 0){
            return FALSE ;
        }
        return TRUE ;
    }

    public function markStatus($rssid , $aid, $status ){
        $cond['rssid'] = $rssid ;
        if( $aid !== -1 )
            $cond['aid'] = $aid ;
        $res = $this->mysql->updateself(
                $cond ,
                array("isreaded" => $status )
                );
        if($res != 1){
            return FALSE ; 
        }
    }
    public function getUnreadCount( $rssid) {
        return $this->mysql->count(
                array("rssid" => $rssid, "isreaded" => 0 )
                ) ;
    }

    public function SearchArticle($keyword, $rssid){
        $cond = array();
        if( $rssid != -1){
            $cond["rssid"] = $rssid ;
        }
        return $this->mysql->search($cond, "content", "%$keyword%" ) ;
    }

}




