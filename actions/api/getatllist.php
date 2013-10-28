<?php
# vim: set sw=4 expandtab smarttab:
require_once('../../index.php');
require_once('Myrss/Action/Abstract.php');
require_once("Myrss/Fetch/Article.php");


//程序入口
class MyrssAction extends Myrss_Action_Abstract {

    public function __construct()
    {
        $param = array(
            'rssid' => array('type' => 'int', 'default' => -1),
            'lastupdtime' => array('type' => 'string', 'default' => "0000-00-00 00:00:00"),
            'szKeyword' => array('type' => 'string', 'default' => ""),
            'nocontent' => array('type' => 'string', 'default' => "1"),
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
            $lastupdtime = $this->_param["lastupdtime"] ;
            if($this->_param["rssid"] === -1){
                $atllst = $this->atl->getUnreadArticle($lastupdtime);
            }
            else {
                $atllst = $this->atl->getAritcleInfoByRssid($this->_param["rssid"], $lastupdtime) ;
            }
        }
        else {
            $atllst = $this->atl->SearchArticle($this->_param["szKeyword"], $this->_param["rssid"]) ;
        }

        $atllst = array_slice( $atllst , 0, 200) ;
        if( $this->_param["nocontent"] === "1"){
            foreach($atllst as $id => $a ){
                unset($atllst[$id]["description"]) ;
                unset($atllst[$id]["content"]) ;
            }
        }
        echo json_encode($atllst) ;
        die();
        //$this->_smarty->assign("atllst", $atllst);
        //$this->_smarty->assign("atllstContent", json_encode($atllst));
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

