<?php
require_once("./sendmsg.php");


$code = $_GET['code'];
$state = explode(":", $_GET['state']);

$appid = $state[0];
$openid = $state[1];

$info = get_accesstoken($code);

$data = "code is :$code access_token: ".$info['access_token'];
var_dump($info);


sendauthmsg($openid, $appid, $data);

