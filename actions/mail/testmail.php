<?php
require_once("../../index.php");


require_once 'Third/Swift-5.0.0/lib/swift_required.php';
function sendMail(){
    $transport = Swift_SmtpTransport::newInstance('smtp.163.com', 25);
    $transport->setUsername('hw_henry2008@163.com');
    $transport->setPassword('xxx');

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance();
    $message->setFrom(array('hw_henry2008@163.com' => 'name'));
//    $message->setTo(array('hw_henry2008@kindle.com' => 'wuhaiwen',));
    $message->setSubject("this the title");
    $message->setBody('Here is the message, iam kulv', 'text/html', 'utf-8');
//    $message->attach(Swift_Attachment::fromPath('A Client Notification Service for Internet-Scale Applications.pdf', 'application/pdf')->setFilename('A Client Notification Service for Internet-Scale Applications.pdf'));
    try{
        $res = $mailer->send($message);
        var_dump($res);
    }
    catch (Swift_ConnectionException $e){
        echo 'There was a problem communicating with SMTP: ' . $e->getMessage();
    }
}


sendMail() ;
