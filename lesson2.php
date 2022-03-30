<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['btn_submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $title = $_POST['subject'];
    $content = $_POST['content'];

    //test username
    if(empty($username)) {
        $message['username'] = "Bạn phải nhập username";
    }

    //test email
    if(empty($email) || strlen($email) > 40) {
        $message['email'] = "Bạn phải nhập email độ dài không quá 40 kí tự";
    }
    
    //test title
    if(empty($title)) {
        $message['subject'] = "Bạn phải tiêu đề";
    }

    //test content
    if(empty($content)) {
        $message['content'] = "Bạn phải nhập nội dung";
    }
   
    //test fileToUpload
    //tạo thư mục chứa file
    $target_dir = 'images/';
    //lấy file
    $file = $_FILES['fileToUpload'];
    //lấy tên file
    $file_name = $file['name'];

    
    if (($file['size'] > 2000000) || (empty($file['size']))) {
        $message['file'] = "Dung lượng file vượt quá 2MB và file không được để trống";
    }
    //tạo mảng test file images khi upload
    $img = ['jpg', 'jpeg', 'png', 'gif','pdf','doc'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if (!in_array($ext, $img)) {
        $message['file'] = "File upload không phải là ảnh";
    }

    if(empty($message['file'])) {
        move_uploaded_file($file['tmp_name'], $target_dir.$file_name);
    }
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->CharSet = 'utf8';                                         
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'binhkhanh25031999@gmail.com';                 
    $mail->Password   = 'jbybfgckvwvawnwg';                            
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
    $mail->Port       = 465;
    $mail->addAttachment('images/'.$file_name);        
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->isHTML(true);                               
    $mail->setFrom('binhkhanh25031999@gmail.com', 'khanhnb1999');
    $mail->addAddress($_POST["email"], 'Joe User');
    $mail->Subject = $_POST['subject'];
    $mail->Body    = $_POST['content'];
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if($mail->send()){
        $message['file'] = 'Message has been sent';
    }else{
        $message['file'] = 'Message sent failed';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <style>
    .tab__login {
        margin: 80px auto;
        width: 700px;
        height: auto;
        background-color: #ffffff;
        padding: 32px 42px;
        border-radius: 5px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .tab__login--title h4 {
        color: red;
        padding: 12px;
        font-size: 35px;
    }

    .login {
        margin-top: 12px;
    }

    .login__label {
        font-size: 20px;
        padding-bottom: 7px;
    }

    .login__sign--up--in {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .login__sign--up p {
        padding-top: 12px;
        margin: 0;
    }

    .login__sign--up a {
        text-decoration: none;
    }

    .btn-danger {
        margin-top: 12px;
        width: 100%;
        height: 50px;
    }
    </style>
    <title>Registration</title>
</head>

<body>
    <div class="tab__login">
        <div class="tab__login--title text-center">
            <h4>Gửi email</h4>
        </div>
        <form action="lesson2.php" method="post" enctype="multipart/form-data">
            <div class="login login__form--username">
                <label for="" class="login__label"><b>Họ tên</b></label>
                <input type="text" name="username" class="form-control" placeholder="Username...">
                <span style="color:red">
                    <?= isset($message['username']) ? $message['username'] : "" ?>
                </span><br>
            </div>
            <div class="login login__form--email">
                <label for="" class="login__label"><b>Email</b></label>
                <input type="text" name="email" class="form-control" placeholder="Email...">
                <span style="color:red">
                    <?= isset($message['email']) ? $message['email'] : "" ?>
                </span><br>
            </div>
            <div class="login login__form--title">
                <label for="" class="login__label"><b>Tiêu đề</b></label>
                <input type="text" class="form-control" name="subject" placeholder="Tiêu đề" />
                <span style="color:red">
                    <?= isset($message['subject']) ? $message['subject'] : "" ?>
                </span><br>
            </div>

            <div class="mb-3 mt-3">
                <label for="comment">Comments:</label>
                <textarea class="form-control" rows="5" name="content"></textarea>
                <span style="color:red">
                    <?= isset($message['content']) ? $message['content'] : "" ?>
                </span><br>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Chọn ảnh trên file của bạn</label>
                <input class="form-control" type="file" id="formFile" name="fileToUpload">
                <span style="color:red">
                    <?= $message['file'] ?? '' ?>
                </span>
            </div>

            <div class="login__sign--up--in">
                <div class="login login__form--check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember"> Accept our Terms and
                        Conditions.
                    </label>
                </div>
                <div class="login__sign--up">
                    <p>Already have an account? <a href="/login_sign_in/index.html">Sign in</a></p>
                </div>
            </div>
            <div class="login login__form--submit">
                <button type="submit" class="btn btn-danger" name="btn_submit">Gửi email</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>