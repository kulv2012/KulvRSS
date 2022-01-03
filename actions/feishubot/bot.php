<?php

$data = file_get_contents("php://input") ;

file_put_contents("/tmp/bot_in.txt", $res, FILE_APPEND);
$data = json_decode($data, true);

$ary = array(
    'challenge' => $data['challenge'],
) ;

$res = json_encode($ary);
file_put_contents("/tmp/bot_out.txt", $res, FILE_APPEND);
echo $res;

