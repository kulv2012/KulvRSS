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
            'szurl' => array('type' => 'string', 'default' => ""),
            'szname' => array('type' => 'string', 'default' => ""),
            'szfeedtype' => array('type' => 'string', 'default' => ""),
            'szOpml' => array('type' => 'string', 'default' => ""),
                );
        parent::__construct($param);
        $this->rss = new Myrss_Fetch_Rss();
        
    }
    public function init() {
        return TRUE;
    }

    public function Exec(){
        global $config ;

        $rsses = $this->rss->getAllRssInfo();

        if( $_SERVER["REQUEST_METHOD"] === "POST"){
            $res = $this->addPML($rsses);
            die($res);
        }


        /*for($i = 0 ; $i< count($rsses) ; $i ++ ){
            $idx = $i +1 ;
            $rsses[$i]['feedurl'] = "feed$idx=".$rsses[$i]['feedurl'] ;
        }*/
        $this->_smarty->assign("rsses", $rsses);
        return TRUE ;
    }
    public function addPML($rsses){
        if($this->_param["szurl"] !== "" && $this->_param["szname"] !== ""){
            $lst = array();
            $lst[0]['@attributes']['xmlUrl'] = $this->_param["szurl"];
            $lst[0]['@attributes']['text'] = $this->_param["szname"];
            $lst[0]['@attributes']['szfeedtype'] = $this->_param["szfeedtype"];
        }
        else if( $this->_param["szOpml"] !== "" ){
            $opml = $this->_param["szOpml"] ;
            $xml_array=simplexml_load_string($opml);
            if($xml_array === FALSE ){
                echo "simplexml_load_string failed.";die();
            }
            $jsonstr = json_encode($xml_array);
            if($jsonstr == FALSE ){
                echo "json_encode failed.";die();
            }
            $js = json_decode($jsonstr,true);
            if($js === NULL ){
                echo "json_decode failed.";die();
            }
            $lst = $js['body']['outline'] ;
        }
        else {
            echo "输入数据非法";
            $lst = array();
        }
        $hashurl = array();
        foreach($rsses as $r)  $hashurl[$r['feedurl']] = TRUE ;
        foreach( $lst as $l){
            $l = $l['@attributes'];
            if( isset($hashurl[$l['xmlUrl']] ) ){
                var_dump($l);
                echo "以上RSS已存在";
                continue ;
            }
            //增加一条记录
            $ary = array( "name" => $l["text"], "unreadcount" => 0, "feedurl" => $l['xmlUrl']);
            if( isset($l['szfeedtype']) ){
                $ary["feedtype"] = $l['szfeedtype'] ;
            }
            $res = $this->rss->addRss($ary);
            if($res !== TRUE){
                echo "mysql->add 失败，RSS:".var_export($ary,true)."<hr/>";
                continue ;
            }
            echo "成功：".var_export($ary,true)."<hr/>" ;
        }
    }

}


$ac = new  MyrssAction();
$ac->execute();

