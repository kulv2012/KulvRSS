<?php

/**
 * swift mailer
 **/
class Swift_Sendmail
{
    
    public function __construct()
    {
       
    }

    /**
     * send html email
     *
     * @return int
     * @author renwenyue@baidu.com
     **/
    public function sendhtml($from, $to, $subject, $htmlbody)
    {
        // Use connect() method to load Swiftmailer and connect using the parameters set in the email config file
		$swift = email::connect();
		 
		// From, subject and HTML message
		
		$message = $htmlbody;
		 
		// Build recipient lists
		$recipients = new Swift_RecipientList;
		if (!is_array($to))//以逗号分隔的邮件列表
		{
			$to = explode(",", $to);
		}
		foreach ($to as $mail)
		{
			$recipients->addTo($mail);
		}
		 
		// Build the HTML message
		$message = new Swift_Message($subject, $message, "text/html");
		 
		if ($swift->send($message, $recipients, $from))
		{
		  // Success
		  return true;
		}
		else
		{
		  // Failure
		  return false;
		}
		 
		// Disconnect
    }
}
?>
