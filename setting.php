<?php
ob_start(); //输出缓冲
require('config.php');
//dataBase
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if($db -> connect_errno){
   $status = "Fail to connect to MySQL: (" . $db -> connect_errno . ") " . $db -> connect_error;
   exit($status);
} 

//class_autoload_register
spl_autoload_register(function ($class_name) {
   require_once("./class/" . $class_name . '.php');
});

//set User;
$user = new User();
$user -> login_with_session(); //在任何页面都可以使用session登陆

/* set email(SMTP) */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once('vendor/autoload.php');

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
//Server settings
$mail->SMTPDebug = 2;                                 // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = MAIL_SMTP_SREVER;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = MAIL_USER_NAME;                 // SMTP username
$mail->Password = MAIL_PASSWORD;                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

//Recipients
$mail->setFrom(MAIL_USER_NAME, 'ChenXiaoyu');
//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//Attachments
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

//Content
$mail->isHTML(true);                                  // Set email format to HTML
//$mail->Subject = 'Here is the subject';
//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//$mail->send();
//echo 'Message has been sent';

?>
