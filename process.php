<?php

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$message = $_POST['message'];

// print_r(value: 'Name- '.$name.'<br/>');
// print_r(value: 'Email- '.$email.'<br/>');
// print_r(value: 'Mobile- '.$mobile.'<br/>');
// print_r(value: 'Message- '.$message.'<br/>');

require './include/PHPMailer.php';
require './include/SMTP.php';
require './include/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$error = '';

if (empty($name) || empty($email) || empty($mobile) || empty($message)) {
    $error = 'Empty found';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Invalid Email';
}

if (!empty($error)) {
    echo "Errors- " . $error;
    exit();
}

class EmailTemplate
{

    public static function formTemplate($name, $email, $mobile, $message)
    {
        return '
            <p> Name :- ' . $name . '</p> <br/>
            <p> Email :- ' . $email . '</p> <br/>
            <p> Mobile :- ' . $mobile . '</p> <br/>
            <p> Message :- ' . $message . '</p> <br/>
        ';
    }
}

$mail = new PHPMailer;
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'kalana.smtp@gmail.com';                     //SMTP username
$mail->Password   = 'zzvsfycfpardxfxh';                               //SMTP password
$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
$mail->Port       = 587;

$mail->setFrom('kalana.smtp@gmail.com', 'kalanaCoder');
$mail->addReplyTo('kalanadidulanga2005@gmail.com', 'Kalana Didulanga');
$mail->addAddress('kalanadidulanga2005@gmail.com', 'Kalana Didulanga');

//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = $name;
$mail->Body    = EmailTemplate::formTemplate($name, $email, $mobile, $message);

if ($mail->send()) {
    header("Location: index.html?mail_send_successfuly");
    exit();
} else {
    echo 'Error :- ' . $mail->ErrorInfo;
}

$mail->smtpClose();
