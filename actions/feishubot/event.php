<?php
require_once("./sendmsg.php");


$data = file_get_contents("php://input") ;
//$data = json_encode($_REQUEST);
file_put_contents("/tmp/event_msg_in.txt", $data."\n", FILE_APPEND);
$data = json_decode($data, true);

if(isset($data['challenge'])){
    $ary = array(
        'challenge' => $data['challenge'],
    ) ;

    $res = json_encode($ary);
    file_put_contents("/tmp/event_msg_out.txt", $res."\n", FILE_APPEND);
    echo $res;
}

$appid = $data['header']['app_id'];
$openid = $data['event']['sender']['sender_id']['open_id'];
$url = "https://open.feishu.cn/open-apis/im/v1/messages?receive_id_type=open_id";    
$redirect_url = "http://kulvrss.chenzhenianqing.com/feishubot/redirect_url.php";
$url_redirect_url = urlencode($redirect_url);
$stat = $appid.":".$openid;
$authurl = "https://open.feishu.cn/open-apis/authen/v1/index?redirect_uri=$url_redirect_url&app_id=$appid&state=$stat";

sendauthmsg($openid, $appid, $authurl);


