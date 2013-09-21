<?php
# vim: set sw=4 expandtab smarttab:
require_once('../index.php');
require_once('Myrss/Action/Abstract.php');
require_once("Myrss/Fetch/Article.php");


//程序入口
class MyrssAction extends Myrss_Action_Abstract {

    public function __construct()
    {
        $param = array(
            'rssid' => array('type' => 'int', 'default' => -1),
            'szKeyword' => array('type' => 'string', 'default' => ""),
                );
        parent::__construct($param);
        $this->atl = new Myrss_Fetch_Article();
    }
    public function init() {
        return TRUE;
    }

    public function Exec(){
        global $config ;

        if( $this->_param["szKeyword"] === ""){
            if($this->_param["rssid"] === -1){
                $atllst = $this->atl->getUnreadArticle();
            }
            else {
                $atllst = $this->atl->getAritcleInfoByRssid($this->_param["rssid"]) ;
            }
        }
        else {
            $atllst = $this->atl->SearchArticle($this->_param["szKeyword"], $this->_param["rssid"]) ;
        }

        $atllst = array_slice( $atllst , 0, 100) ;
        $this->_smarty->assign("atllst", $atllst);
        $this->_smarty->assign("atllstContent", json_encode($atllst));
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

