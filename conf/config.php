<?php

$config = array();

$db = array( 
        'type'     => 'mysql',
        'user'     => 'myrss',
        'pass'     => 'develop',
        'host'     => 'localhost',
        'port'     => 8306,
        'socket'   => FALSE,
        'database' => 'Db_Myrss'

        );

$config['db'] = $db ;


$config['email'] = array(
        "smtp" => "smtp.126.com", 
        "user" => "kulvrss@126.com",
        "pwd" => "",
        ) ;
