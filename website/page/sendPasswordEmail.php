<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendPasswordEmail($email, $password) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'your-gmail-address@gmail.com';                 
        $mail->Password   = 'your-gmail-password';                           
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;                                    

        //Recipients
        $mail->setFrom('your-gmail-address@gmail.com', 'Mailer');
        $mail->addAddress($email);     

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Your New Password';
        $mail->Body    = 'Here is your new password: ' . $password;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>