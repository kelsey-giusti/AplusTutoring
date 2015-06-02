<?php

  //echo $_POST['name'] . " " . $_POST['from'] . " " . $_POST['telp'] . " " . $_POST['message'];
  require '../PHPMailer/PHPMailerAutoload.php';
  
  $name = $_POST['contactname'];
  $emailfrom = $_POST['contactemail'];
  $telp = $_POST['contacttelp'];
  $message = $_POST['contactmessage'];

  $mail = new PHPMailer;

  //$mail->SMTPDebug = 3;                               // Enable verbose debug output

  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = 'aplustutorinfo@yahoo.com';                 // SMTP username
  $mail->Password = 'Qwerty1234';                           // SMTP password
  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 587;                                    // TCP port to connect to

  $mail->From = 'aplustutorinfo@yahoo.com';
  $mail->FromName = 'Aplus';
  //$mail->addAddress('aplustutorinfo@yahoo.com', 'info');     // Add a recipient
  $mail->addAddress('aplustutorinfo@yahoo.com');               // Name is optional

  
  $mail->addReplyTo($emailfrom, $name);
  /*
  $mail->addCC('cc@example.com');
  $mail->addBCC('bcc@example.com');
  */

  /*
  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  */

  $mail->isHTML(true);                                  // Set email format to HTML
  
  $mail->Subject = 'AplusTutor Contact Form from ' . $emailfrom;


  $mail->Body    = 'contactor email: <b>' . $emailfrom . '</b><br/>'.
                   'contactor name: <b>' . $name . '</b><br/>'.
                   'contactor telp: <b>' . $telp . '</b><br/>'.
                   'contactor message: <b>' . $message . '</b><br/>';
  $mail->AltBody = 'contactor email: ' . $emailfrom . '  '.   //for non-html mail client
                   'contactor name: ' . $name . '  '.
                   'contactor telp: ' . $telp . '  '.
                   'contactor message: ' . $message . '  ';

  if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
      #echo 'Message has been sent';
      header("Location: ../contactSubmitSuccess.php?");
  }

?>