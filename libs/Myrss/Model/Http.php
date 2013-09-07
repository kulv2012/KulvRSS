<?php
# vim: set sw=4 smarttab expandtab:

require_once 'Third/Snoopy/Snoopy.class.php';

class Myrss_Model_Http {
    private $_snoopy;

    public function __construct()
    {
        $this->_snoopy = new Snoopy;
        $this->_snoopy->read_timeout = 10 ;
        $this->setRawHeaders("User-Agent", "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36");
//        $this->setRawHeaders("Accept", "*/*");
//        $this->setRawHeaders("Host", "blog.sunner.cn");
    }

    public function fetch($url)
    {
        $this->_snoopy->fetch($url);
        if($this->_snoopy->results === ""){
            var_dump($this->_snoopy->error);
            var_dump($this->_snoopy->headers);
        }
        return $this->_snoopy->results;
    }

    public function submit($url, $data, $cookie)
    {
        $this->_snoopy->cookies = array();
        foreach ($cookie as $key => $value)
            $this->_snoopy->cookies[$key] = $value;
        $this->_snoopy->submit($url, $data);
        return $this->_snoopy->results;
    }
    
    public function getHeader($headerKey, &$value){
        while(list($key,$val) = each($this->_snoopy->headers)){
            $arr = explode(":",$val);
            if (count($arr) < 2)
                continue;
            if (strcmp($arr[0],$headerKey) == 0){
                $value = $arr[1];
                return true;
            }
        }
        return false;
    }
    public function setRawHeaders($key , $value ) {
        $this->_snoopy->rawheaders[$key] = $value ;
        return true ;
    }
    public function setAgent($str ) {
        $this->_snoopy->agent = $str ;
        return true ;
    }
    public function setReferer($str) {
        $this->_snoopy->referer = $str;
        return true ;
    }
}
