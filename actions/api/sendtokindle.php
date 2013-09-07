<?php
# vim: set sw=4 expandtab smarttab:
require_once('../../index.php');
require_once('Myrss/Action/Abstract.php');
require_once("Myrss/Fetch/Article.php");
require_once("Myrss/Fetch/Rss.php");
require_once 'Third/Swift-5.0.0/lib/swift_required.php';


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
        $ret = "" ;
        if($this->_param["rssid"] === -1 || $this->_param["aid"] === -1){
            $ret = "failed";
        }
        else {
            $info = $this->atl->getAritcleInfo(array( "rssid" => $this->_param["rssid"], "aid" => $this->_param["aid"])) ;
            $info = $info[0];
            var_dump($info);
            $this->sendMail( $info['title'] , $info['content']) ;
            $ret = "ok";
        }
        echo $ret;
        die();
    }
    public function sendMail($title, $content){
        $transport = Swift_SmtpTransport::newInstance('smtp.163.com', 25);
        $transport->setUsername('hw_henry2008@163.com');
        $transport->setPassword('fenger');

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance();
        $message->setFrom(array('hw_henry2008@163.com' => 'kulvrss'));
            $message->setTo(array('hw_henry2008@126.com' => 'wuhaiwen','hw_henry2008@kindle.com' => 'wuhaiwen',));
        //$message->setTo(array('hw_henry2008@kindle.com' => 'wuhaiwen',));
        $message->setSubject($title );
        $message->setBody($content, 'text/html', 'utf-8');
        
        $tmpfile = dirname(__FILE__)."/tmp.html" ;
        file_put_contents($tmpfile, $content);
//        $message->attach(Swift_Attachment::fromPath($tmpfile, 'text/html')->setFilename("$content.html"));
    $message->attach(Swift_Attachment::fromPath(dirname(__FILE__).'/Applications.pdf', 'application/pdf')->setFilename('A Client Notification Service for Internet-Scale Applications.pdf'));
        try{
            $res = $mailer->send($message);
            var_dump($res);
        }
        catch (Swift_ConnectionException $e){
            echo 'There was a problem communicating with SMTP: ' . $e->getMessage();
        }
    }

}


$ac = new  MyrssAction();
$ac->execute();

