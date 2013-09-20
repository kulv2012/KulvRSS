<?php
# vim: set sw=4 expandtab smarttab:
require_once('../../index.php');
require_once('Myrss/Action/Abstract.php');
require_once('Myrss/Fetch/KeywordMonitor.php');
//程序入口
class MyrssAction extends Myrss_Action_Abstract {

    public function __construct()
    {
        $param = array(
            'op' => array('type' => 'string', 'default' => "query"),
            'szKeyword' => array('type' => 'string', 'default' => ""),
            'nWeight' => array('type' => 'int', 'default' => 0),
            'szMail' => array('type' => 'string', 'default' => "xxx@126.com"),

            //delete
            'id' => array('type' => 'int', 'default' => 0),

                );
        parent::__construct($param);
        
    }
    public function init() {
        return TRUE;
    }

    public function Exec(){
        global $config ;
        $error = "" ;
        $keym = new Myrss_Fetch_KeywordMonitor();
        if( $this->_param["op"] === "add"){//add ome
            if($this->_param["szKeyword"] === "" ){
                $error = "监控关键字错误";
            }
            $res = $keym->AddMonitorItem($this->_param["szKeyword"], $this->_param["nWeight"], $this->_param["szMail"]) ;
            if( $res == FALSE) {
                echo "插入失败";die();
            }
            header("location:/mis/subscribe.php");
            die();
        }
        else if( $this->_param["op"] === "delete"){
            $res = $keym->DeleteKeywordMonitor( $this->_param["id"] ) ;
            if( $res == FALSE) {
                echo  "删除失败" ;
            }
            else {
                echo "ok" ;
            }
            die();
        }
        $allkeys = $keym->getAllKeywordInfo();
        $this->_smarty->assign("error", $error);
        $this->_smarty->assign("allkeys", $allkeys);
        return TRUE ;
    }

}


$ac = new  MyrssAction();
$ac->execute();

