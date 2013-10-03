<?php
# vim: set sw=4 expandtab smarttab:
require_once('../../index.php');
require_once('Myrss/Action/Abstract.php');
require_once("Myrss/Fetch/Article.php");
require_once("Myrss/Fetch/Rss.php");


//程序入口
class MyrssAction extends Myrss_Action_Abstract {

    public function __construct()
    {
        $param = array(
            'op' => array('type' => 'string', 'default' => ""),
            'rssid' => array('type' => 'int', 'default' => -1),
                );
        parent::__construct($param);
        $this->atl = new Myrss_Fetch_Article();        
        $this->rss = new Myrss_Fetch_Rss();
    }
    public function init() {
        return TRUE;
    }

    public function Exec(){
        global $config ;
        $ret = "" ;
        if($this->_param["rssid"] === -1 ){
            $ret = "failed";
        }
        else if( $this->_param["op"] === "delete") {
            $this->rss->deleteRssById( $this->_param["rssid"] ) ;
            $this->atl->deleteArticle( array("rssid" => $this->_param["rssid"])  ) ;
            $ret = "ok";
        }
        echo $ret;
        die();
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

