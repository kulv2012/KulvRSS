<?php
# vim: set sw=4 expandtab smarttab:
require_once('../../index.php');
require_once('Myrss/Action/Abstract.php');
require_once("Myrss/Fetch/Rss.php");
//程序入口
class MyrssAction extends Myrss_Action_Abstract {

    public function __construct()
    {
        $param = array(
                );
        parent::__construct($param);
        $this->rss = new Myrss_Fetch_Rss();
        
    }
    public function init() {
        return TRUE;
    }

    public function Exec(){
        global $config ;

        $rsses = array(array("id"=>1, "name"=>"abc"),
                        array("id"=>2, "name"=>"kulv2012"),);

        $rss = new Myrss_Fetch_Rss();
        $rsses = $rss->getAllRssInfo();
        echo json_encode($rsses);
        die();
        //$this->_smarty->assign("rsses", $rsses);
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

