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
            'rssid' => array('type' => 'int', 'default' => -1),
            'aid' => array('type' => 'int', 'default' => -1),
            'isreaded' => array('type' => 'int', 'default' => 0),
            'list' => array('type' => 'string', 'default' => ""),
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
        if($this->_param["rssid"] === -1 && $this->_param['list'] != "" ){
            $list = json_decode($this->_param['list'], true) ;
            foreach($list as $l){
                list($rssid, $aid, $isreaded) = explode("_", $l) ;
                $isreaded = $isreaded == 1 ? 1 : 0 ;
                $this->atl->markStatus($rssid, $aid , $isreaded);
                $this->rss->autoUpdateUnreadCount( $rssid) ;
            }
            $ret = "ok" ;
        }
        else {
            $isreaded = $this->_param["isreaded"] ;

            $isreaded = $isreaded == 1 ? 1 : 0 ;
            $this->atl->markStatus($this->_param["rssid"], $this->_param["aid"] , $isreaded);
            $this->rss->autoUpdateUnreadCount( $this->_param['rssid'] );
            $ret = "ok";
        }
        echo $ret;
        die();
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

