<?php
# vim: set sw=4 expandtab smarttab:
require_once('../index.php');
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
        if($this->_param["rssid"] === -1 || $this->_param["aid"] === -1){
            $info = array();
        }
        else {
            $info = $this->atl->getAritcleInfo(array( "rssid" => $this->_param["rssid"], "aid" => $this->_param["aid"])) ;
            $info = $info[0] ;
            $this->atl->markStatus($this->_param["rssid"], $this->_param["aid"] , 1);
            $this->rss->autoUpdateUnreadCount( $info['rssid'] );
        }

        $this->_smarty->assign("a", $info);
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

