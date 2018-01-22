<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require_once "functionmain.php";
  require_once "classes/Exception.php";
  require_once "classes/PHPMailer.php";
  require_once "classes/SMTP.php";

  function SendEmail($To, $Subject, $Body, $BodyHTML, $From = 'craig@peepz.co.za', $Attachment = '')
  {
      $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  //try {
      //Server settings
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'AKIAIFCAXMNXXLDGNW5Q';                 // SMTP username
      $mail->Password = 'AjbEjg0R1x3wmrDi48fI6Te51WEKE/f1VqaHu9pFjzPh';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom($From, 'Peepz');        // Name is optional
      $mail->addReplyTo($From, 'Peepz');

      $mail->addAddress($To);
      //Attachments
      //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $Subject;
      $arrBody = GetTemplate(1, $BodyHTML, $Body);

      $mail->Body    = $arrBody['BodyHTML'];
      $mail->AltBody = $arrBody['Body'];

      //$mail->send();
      //echo 'Message has been sent';
      if(!$mail->send()) {
          echo "Email not sent. " , $mail->ErrorInfo , PHP_EOL;
      } else {
          echo "Email sent!" , PHP_EOL;
      }
    }

    function GetTemplate($TemplateID, $BodyHTML, $Body)
    {
        $Template = [];
        if($TemplateID == 1)
        {
          $Template['BodyHTML'] = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                    <html xmlns='http://www.w3.org/1999/xhtml'>
                    <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                        <!--[if !mso]><!-->
                            <meta http-equiv='X-UA-Compatible' content='IE=edge' />
                        <!--<![endif]-->
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <!--[if (gte mso 9)|(IE)]>
                        <style type='text/css'>
                            table {border-collapse: collapse;}
                        </style>
                        <![endif]-->

                    </head>
                    <body style='margin: 0 !important; padding: 0; background-color: #a13191;'>
                        <center style='width: 100%; table-layout: fixed; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;'>
                            <div style='max-width: 600px; margin: 0 auto;'>
                                <!--[if (gte mso 9)|(IE)]>
                    <table width='600' align='center'>
                    <tr>
                    <td>
                    <![endif]-->
                    <table style='Margin: 0 auto; width: 100%; max-width: 600px;' align='center'>
                        <tr>
                            <td style='width: 100%; max-width: 600px; height: auto;'>
                                <img src='http://www.peepz.online/images/peepz_bg_logo.jpg' width='600' alt='' />
                            </td>
                        </tr>
                      <tr>
                    <td style='text-align: left;'>
                            <table width='100%' style='border-spacing: 0; font-family: sans-serif; color: #333333;'>
                                <tr>
                                    <td style='padding: 10px;'>
                                        $BodyHTML
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                      <tr>
                        <td style='padding: 20px 30px 15px 30px;'>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                <tr>
                                    <td align='center' style='padding: 20px 0 0 0;'>
                                        <table border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td width='37' style='text-align: center; padding: 0 10px 0 10px;'>
                                                    <a href='http://www.facebook.com/peepzonline'>
                                                        <img src='images/facebook.png' width='37' height='37' alt='Facebook' border='0' />
                                                    </a>
                                                </td>
                                                <td width='37' style='text-align: center; padding: 0 10px 0 10px;'>
                                                    <a href='http://www.twitter.com/peepzonline'>
                                                        <img src='images/twitter.png' width='37' height='37' alt='Twitter' border='0' />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                            </div>
                        </center>
                    </body>
                    </html>";
          $Template['Body'] = "$Body
                               Regards, Peepz";
        }

        return $Template;
    }
?>
