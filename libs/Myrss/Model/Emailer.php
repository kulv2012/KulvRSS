<?php
require_once 'Third/Swift-5.0.0/lib/swift_required.php';



class Myrss_Model_Emailer {
    
    public function __construct($smtp, $user, $pwd){
        $this->smtp = $smtp;
        $this->user = $user ;
        $this->pwd = $pwd ;
    }

    public function SendMail($to, $subject, $content, $file = null ){

        try{ 
            $transport = Swift_SmtpTransport::newInstance($this->smtp, 465, "ssl") ;
            $transport->setUsername($this->user) ;
            $transport->setPassword($this->pwd) ;

            $mailer = Swift_Mailer::newInstance($transport);

            $message = Swift_Message::newInstance();
            $message->setFrom(array( $this->user => 'KL'));
            $message->setTo( explode(",", $to) );
            $message->setSubject($subject ) ;
            $message->setBody($content, 'text/html') ;
            if( $file != null ){
                $message->attach(Swift_Attachment::fromPath( $file['path'], $file['type'] )->setFilename( $file['filename'] ));
            }
            $res = $mailer->send($message);
            return $res ;
        }catch (Swift_ConnectionException $e){ 
            return 'There was a problem communicating with SMTP: ' . $e->getMessage();
        }
    }

}


