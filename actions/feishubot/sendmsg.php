<?php


function sendauthmsg($openid, $appid, $data){
    $url = "https://open.feishu.cn/open-apis/im/v1/messages?receive_id_type=open_id";    
    $reqdata = array(
    "receive_id" => $openid,
        "content"=> "{\"text\":\"$data\"}",
        "msg_type"=> "text"
    );

    $apptoken = getApptoken();
    $h = array("Authorization: Bearer $apptoken");
    $res = httpPost($url, $h, http_build_query($reqdata));
    return $res;
}

function get_accesstoken($code){
    $url = "https://open.feishu.cn/open-apis/authen/v1/access_token";
    $apptoken = getApptoken();
    //$apptoken = "t-90d3c36580f780ccacbfb06f5976f9c31a3f124a";
    $h = array("Authorization: Bearer $apptoken",
        "Content-Type: application/json; charset=utf-8",
    );

    $reqdata = array("grant_type" => "authorization_code", "code" => $code);
    $res = httpPost($url, $h, json_encode($reqdata));
    $info = json_decode($res, true);
    return $info['data'] ;

}

function httpPost($url, $header, $data, $v = false)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $streamVerboseHandle = fopen('/tmp/httppost.vobse.txt', 'w+');
    if($v){
        curl_setopt($curlHandle, CURLOPT_VERBOSE, true);
        curl_setopt($curlHandle, CURLOPT_STDERR, $streamVerboseHandle);
    }

    $response = curl_exec($curl);
    if(curl_errno($curl)){
        printf("cUrl error (#%d): %s<br>\n",
            curl_errno($curl), htmlspecialchars(curl_error($curl)))
            ;
        die();
    }
    if($v){
        rewind($streamVerboseHandle);
        $verboseLog = stream_get_contents($streamVerboseHandle);
        echo "cUrl verbose information:\n", 
            "<pre>", htmlspecialchars($verboseLog), "</pre>\n";
    }
    $res = curl_close($curl);
    return $response;
}

function getApptoken(){
     $url = "https://open.feishu.cn/open-apis/auth/v3/tenant_access_token/internal";
     $data = array("app_id" => "cli_a1f5076146f9d00c", "app_secret" => "");
     $res = httpPost($url, array(), http_build_query($data));

     $apptoken = json_decode($res, true); 
     $apptoken = $apptoken['tenant_access_token'];
     return $apptoken;
}
