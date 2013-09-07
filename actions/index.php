<?php
# vim: set sw=4 expandtab smarttab:
require_once('../index.php');
require_once('Myrss/Action/Abstract.php');

//程序入口
class MyrssAction extends Myrss_Action_Abstract {

    public function __construct()
    {
        $param = array(
            'len' => array('type' => 'int', 'default' => 0),
            'ver' => array('type' => 'string', 'default' => "0000.0000.0000.0000"),
                );
        parent::__construct($param);
        
    }
    public function init() {
        return TRUE;
    }

    public function Exec(){
        global $config ;

        $rsses = array(array("id"=>1, "name"=>"abc"),
                        array("id"=>2, "name"=>"kulv2012"),);
        $this->_smarty->assign("rsses", $rsses);
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

