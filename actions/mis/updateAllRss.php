<?php
# vim: set sw=4 expandtab smarttab:
require_once('../../index.php');
require_once('Myrss/Action/Abstract.php');
require_once("Myrss/Fetch/Rss.php");
require_once("Myrss/Fetch/Article.php");
require_once("Myrss/Model/Http.php");
require_once("Myrss/Model/UrlContenter.php");
require_once('Myrss/Fetch/KeywordMonitor.php');
require_once("Myrss/Model/Emailer.php");
require_once("Myrss/Model/HtmlToPdf.php");


//程序入口
class MyrssAction {

    public function __construct()
    {
        $this->rss = new Myrss_Fetch_Rss();
        $this->atl = new Myrss_Fetch_Article();
        
    }
    public function init() {
        return TRUE;
    }

    public function Run( $rssid ){
        global $config ;
        global $g_updcount ;

        $rsses = array();
        $all = $this->rss->getAllRssInfo();
        if( $rssid == -1){
            $rsses = array();
            var_dump($all);
        }
        else if($rssid === 0)
            $rsses = $all ;
        else {
            $rsses = $this->rss->getAllRssInfoById( $rssid );
            if(count($rsses) !== 1){
                echo $rssid." is not uniq!";return FALSE;
            }
        }
        foreach($rsses as $r ){
            ob_end_clean();  
            $url = $r['feedurl'] ;
            
            if($r['feedtype'] === 'rss')
                $res = $this->updateRssOne($r);
            else if( $r['feedtype'] === 'atom')
                $res = $this->updateAtomOne($r);
            
            if($res === FALSE){//标记为未读数目为-1
                $this->rss->updateUnReadcount($r['id'], -1);
            }
            else {
                $this->rss->autoUpdateUnreadCount( $r['id'] );
            }
            echo $res === TRUE ? "$url \t成功\n" : "$url \t失败\n" ;
            echo "新文章数：$g_updcount\n";
            flush();  
        }

        

        return TRUE ;
    }
    public function updateRssOne($rss){

        $url = $rss["feedurl"] ;
        $http = new Myrss_Model_Http();
        $data = $http->fetch( $url );
        if(strlen($data) < 256){
            var_dump($data);
            echo "download error.url=$url, rssid=".$rss['id']."\n";
            return FAlse ;
        }
        //file_put_contents(dirname(__FILE__)."/heiyeluren.xml" , $data);
        //$data = file_get_contents(dirname(__FILE__)."/heiyeluren.xml");

        /*$xml_array=simplexml_load_string($data, NULL, LIBXML_NOCDATA );
        if($xml_array === FALSE ){
            echo "simplexml_load_string failed.";return FALSE;
        }
        $jsonstr = json_encode($xml_array);
        if($jsonstr == FALSE ){
            echo "json_encode failed.";return FALSE;
        }
        $js = json_decode($jsonstr,true);
        if($js === NULL ){
            echo "json_decode failed.";return FALSE;
        }
        $lst = $js['channel']['item'] ;
        foreach($lst as $l){
            var_dump($l);die();
            $ary = array( "rssid" => $rss["id"], 
                        "title" => $l["title"], 
                        "link" => $l["link"], 
                        "isreaded" => 0, 
                        "pubdate" => $l["pubDate"], 
                        "description" => $l['content:encoded'],
                );
            $this->insertArticle($rss, $ary);

        }*/
        try {
            $xml = new SimpleXmlElement($data);
        }catch (Exception $e){
            var_dump($e); 
            return false;
        }
        $ns = $xml->getNamespaces(true);
        foreach ($xml->channel->item as $item) {
            $article = array();
            $article['rssid'] = $rss["id"];
            $article['title'] = (string)$item->title;
            $article['link'] = (string)$item->link ;
            $article['isreaded'] = 0 ;
            $article['pubdate'] = (string)$item->pubDate ;
            $article['description'] = (string)trim($item->description);

            $article['oricontent'] = "" ;
            if(isset($ns['content'])){
                $content = $item->children($ns['content']);
                $article['oricontent'] = trim($content->encoded);
            }
            //避免比如CSDN,月光博客等没有全文RSS的站点
            if( strlen($article['description']) > strlen($article['oricontent']))
                $article['oricontent'] = $article['description'] ;
            $article['content'] = Myrss_Model_UrlContenter::getContent( $article['link'], $article['oricontent'] ) ;
            
            $hp = new Myrss_Model_HtmlToPdf() ;
            $hp->ConvertToPdf( $article['content'] , "aa".rand().".pdf" ) ;

            if($this->isExistsArticle( $rss["id"], $article['link'] ) == TRUE){
                continue ;
            }

            $this->insertArticle($rss, $article);
        }
        return TRUE ;
    }
    public function updateAtomOne($rss){

        $url = $rss["feedurl"] ;
        $http = new Myrss_Model_Http();
        $data = $http->fetch( $url );
        if(strlen($data) < 100){
            echo "download error.url=$url, rssid=".$rss['id']."\n";
            return FAlse ;
        }
        $xml_array=simplexml_load_string($data, NULL, LIBXML_NOCDATA );
        if($xml_array === FALSE ){
            echo "simplexml_load_string failed.";return FALSE;
        }
        $jsonstr = json_encode($xml_array);
        if($jsonstr == FALSE ){
            echo "json_encode failed.";return FALSE;
        }
        $js = json_decode($jsonstr,true);
        if($js === NULL ){
            echo "json_decode failed.";return FALSE;
        }
        $lst = $js['entry'] ;
        foreach($lst as $l){
            if(count($l["link"]) > 1)
                $href = $l["link"][0]['@attributes']['href'];
            else $href = $l["link"]['@attributes']['href'] ;
            if($this->isExistsArticle( $rss["id"], $href ) == TRUE){
                continue ;
            }

            $readability = Myrss_Model_UrlContenter::getContent( $href, $l['content'] ) ;
            $ary = array( "rssid" => $rss["id"], 
                        "title" => $l["title"], 
                        "link" => $href, 
                        "isreaded" => 0, 
                        "pubdate" => $l["updated"], 
                        "description" => $l['content'],
                        "content" => $readability,
                );
            $this->insertArticle($rss, $ary);

        }
        return TRUE ;
    }

    public function isExistsArticle($rssid, $link ) {
        $tmp = $this->atl->getAritcleInfo(array( "rssid" => $rssid, "link" => $link,));
        if(count($tmp) !== 0){//已经存在这文章了
            echo "文章已经存在:".$link."\n" ;
            return TRUE ;
        }
        return FALSE ;
    }
    public function insertArticle($rss, $ary){
        global $config ;
        global $g_updcount ;

        $keym = new Myrss_Fetch_KeywordMonitor();
        $res = $keym->checkKeywordMonitor($ary['title'], $ary['content']) ;
        if($res !== FALSE){
            $ary['star'] = $res['star'] ;
            $email = $res['action'] ;
//            $email = "hw_henry2008@126.com" ;
            if( strpos($email, "@") !== false) {//发送邮件
                $tmpname = "./".time().".txt";
                file_put_contents($tmpname, $ary['content'] ) ;
                $file = array() ;
                $file['filename'] = $ary['title'].".txt" ;
                $file['type'] = 'text/plain' ;
                $file['path'] = $tmpname ;
                $file['path'] = "/home/wuhaiwen/webroot/KulvRSS/libs/Third/html2pdf-4.5.1/examples/about.pdf" ;
                var_dumP($file);
                var_duMP($email) ;
                $emailer = new Myrss_Model_Emailer($config['email']['smtp'], $config['email']['user'], $config['email']['pwd']) ;
                //$res = $emailer->SendMail( $email, "Kl:".$ary['title'], $ary['content'], $file ); 
                $res = $emailer->SendMail( $email, $ary['title'], $ary['content'], $file ); 
                echo "关键词检测成功，发送邮件给$email, 结果：$res\n" ;

     //           unlink($tmpname) ;
            }
        }
        else {
            $ary['star'] = 0 ;
        }
die();
        $res = $this->atl->addArticle($ary);
        if($res !== TRUE){
            echo "atl->addArticle 失败，Article:".$ary["link"]."\n" ;
        }
        $g_updcount  ++ ;
        echo "成功：".$ary["link"]."\n" ;
    }

}

if(isset($_GET["rssid"])){
    $rssid = (int)$_GET["rssid"] ;
}
else {
#/home/wuhaiwen/php/bin/php updateAllRss.php  -1
    $rssid = -1 ;
    $argc = $_SERVER["argc"] ;
    $argv = $_SERVER["argv"] ;

    if(isset($argv[1]))
        $rssid = (int) $argv[1] ;
}

$g_updcount = 0 ;
$ac = new  MyrssAction();
$ac->Run( $rssid );

