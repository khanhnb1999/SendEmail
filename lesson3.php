<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->CharSet = 'utf8';
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'binhkhanh25031999@gmail.com';                     
    $mail->Password   = 'jbybfgckvwvawnwg';                             
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
    $mail->Port       = 465;                                 
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    //Recipients
    $mail->setFrom('binhkhanh25031999@gmail.com', 'Admin');
    $mail->addAddress('binhkhanh25031999@gmail.com', 'khanhnb');     
    $mail->addAddress('khanhnbph18914q@fpt.edu.vn');               
    $mail->addReplyTo('binhkhanh25031999@gmail.com', 'Information');
    

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Đơn hàng của bạn đã được tạo';
    $mail->Body    = 'Thông tin đơn hàng <b>của bạn!</b>';

    $mail->send();
    echo 'Gửi mail thành công';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}