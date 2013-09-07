<?php
# vim: set sw=4 expandtab smarttab:
require_once('../index.php');
require_once('Myrss/Action/Abstract.php');

//程序入口
class MyrssAction extends Myrss_Action_Abstract {

    public function __construct()
    {
        $param = array(
                );
        parent::__construct($param);
        
    }
    public function init() {
        return TRUE;
    }

    public function Exec(){
        global $config ;
            
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

