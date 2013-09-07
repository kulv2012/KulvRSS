<?php

//CURL错误码对应见：http://curl.haxx.se/libcurl/c/libcurl-errors.html
class Myrss_Model_RawHttp{

	public function __construct($url){
		$this->_url = $url ;
		$this->_curl = curl_init(); 
		$this->_headerstr = "" ;
		$this->_body = "" ;
		curl_setopt($this->_curl, CURLOPT_URL, $this->_url);
	}
	public function __destruct() {
		curl_close($this->_curl);
	}

	public  function raw_post( $rawpost , $headerary = array(), $timeout = 5){
		curl_setopt($this->_curl, CURLOPT_POST, TRUE  );
		curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $rawpost);
		curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->_curl, CURLOPT_USERAGENT,"Mozilla/4.0");
		curl_setopt($this->_curl, CURLOPT_TIMEOUT, $timeout);//5秒超时，避免压垮我们自己
		curl_setopt($this->_curl, CURLOPT_HEADER, TRUE);
        $this->setHeaders($headerary);

        return $this->Execute() ;
    }
    public function PostForm( $formary = array(), $headerary, $timeout= 5){
	    curl_setopt($this->_curl, CURLOPT_POST, TRUE  );
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_curl, CURLOPT_USERAGENT,"Mozilla/4.0");
        curl_setopt($this->_curl, CURLOPT_TIMEOUT, $timeout);//默认5秒超时，避免压垮我们自己
        curl_setopt($this->_curl, CURLOPT_HEADER, TRUE);
        $this->setHeaders($headerary);//必须先设置header，再设置form，否则411 Length Required 错误
        $this->setPostFields($formary);

        return $this->Execute() ;
    }
    public function FetchGet( $timeout= 5){
        //GET 请求
        curl_setopt($this->_curl, CURLOPT_USERAGENT,"Mozilla/4.0");
        curl_setopt($this->_curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($this->_curl, CURLOPT_HEADER, TRUE);
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 1);
        return $this->Execute() ;
    }
    public function Execute() {
		$result = curl_exec($this->_curl);
		$ret['errmsg'] = FALSE ;
        $ret['data'] = FALSE;
		if($result === FALSE ){
			$ret['errmsg'] = "fetching res failed ";
			UB_LOG_WARNING("[errmsg:fetching (%s) res failed , errno:%d,error:%s in %s]",
                    $this->_url,curl_errno($this->_curl),curl_error($this->_curl),__METHOD__) ;
        }
        else {
            $hsize = curl_getinfo($this->_curl,CURLINFO_HEADER_SIZE ) ;
            $this->_headerstr = substr($result , 0 , $hsize) ;
            if(strlen($result) > $hsize ){//如果HTTP体大小不为0
                $this->_body = substr($result , $hsize);
                $ret['data'] = $this->_body ;
                UB_LOG_DEBUG("fetching (%s) result:head_size:%d,curl_exec returned len:%d, in %s.",$this->_url,$hsize,strlen($result),__METHOD__);
            }
            else {
                $ret['data'] = "" ;
                UB_LOG_WARNING("fetching (%s) result:head_size:%d,curl_exec returned len:%d, in %s.",$this->_url,$hsize,strlen($result),__METHOD__);
            }
        }
		return $ret;
	}
    public function setHeaders($hds){
		if(count($hds) > 0 ){
            if(FALSE === curl_setopt($this->_curl,CURLOPT_HTTPHEADER,$hds) ){
                UB_LOG_WARNING("curl_setopt failed to set CURLOPT_HTTPHEADER, headers:%s at %s", json_encode($hds), __METHOD__);
                return FALSE ;
            }
        }
        return TRUE ;
    }
    public function setPostFields($formary){
		if(count($formary) > 0 ){
            if(FALSE === curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $formary) ){
                UB_LOG_WARNING("curl_setopt failed to set CURLOPT_POSTFIELDS, formary:%s at %s", json_encode($formary), __METHOD__);
                return FALSE ;
            }
        }
        return TRUE ;
    }

	public function getHeaders($name = NULL){
		$kv = array() ;
		$sts = explode("\r\n",$this->_headerstr) ;
		foreach($sts as $value){
			if($value !== "" && strpos($value , ":") > 0 ){
				$tmp = split(":", $value,2);
				$kv[trim($tmp[0])] = trim($tmp[1]) ;
			}
		}
		if(isset($name))
			return $kv[$name] ;
		return $kv ;
	}
	public function getInfo(){
		$res = curl_getinfo($this->_curl);
		return $res ;
	}


}



?>
