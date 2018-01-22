<?php

  require_once "functions/sendmail.php";

  $Body = 'This is the HTML message body <b>in bold!</b>';
  $BodyHTML = 'This is the body in plain text for non-HTML mail clients';
  SendEmail('craig@goglobalit.com', 'News for Peepz', $Body, $BodyHTML);

  /*use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require_once "functions/functionmain.php";
  require_once "functions/classes/Exception.php";
  require_once "functions/classes/PHPMailer.php";
  require_once "functions/classes/SMTP.php";

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
//try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'AKIAIFCAXMNXXLDGNW5Q';                 // SMTP username
    $mail->Password = 'AjbEjg0R1x3wmrDi48fI6Te51WEKE/f1VqaHu9pFjzPh';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('craig@peepz.co.za', 'Peepz');
    $mail->addAddress('craig@goglobalit.com');            // Name is optional
    $mail->addReplyTo('craig@peepz.co.za', 'Peepz');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //$mail->send();
    //echo 'Message has been sent';
    if(!$mail->send()) {
        echo "Email not sent. " , $mail->ErrorInfo , PHP_EOL;
    } else {
        echo "Email sent!" , PHP_EOL;
    }*/
?>
