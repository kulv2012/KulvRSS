<?php
$to="hw_henry2008@126.com";
$fn="Fisrt Name";
$ln="Last Name";
$name=$fn.' '.$ln;
$from="hw_henry2008@126.com";
$subject = "Welcome to Website";
$message = "Dear $name, 


Your Welcome Message.


Thanks
www.website.com
";
include('smtpwork.php');

?>
