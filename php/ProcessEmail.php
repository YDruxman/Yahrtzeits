<?php
require 'PHPMailer-master/PHPMailerAutoload.php';


$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->SMTPDebug=0;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->Username = 'dontlikeads@gmail.com';
$mail->Password = 'gvfeelogsxtwaibe';
try {
    $mail->setFrom('dontlikeads@gmail.com');
} catch (phpmailerException $e) {
    echo $e-> errorMessage();
    //header("Location: ContactUs.php?error=mailNotSent");
}
$mail->addAddress('dontlikeads@gmail.com');
$mail->Subject = 'Contact Us Email';

function invalidEmail($email): bool
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    return $result;
}


if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $message = htmlentities($_POST['message']);

    if (empty($email) || empty($name) || empty($message)) {
        header("Location: ContactUsPage.php?error=emptyFields");
        exit();
    } else if (invalidEmail($email)) {
        header("Location: ContactUs.php?error=invalidEmail");
        exit();
    }

    $emailBody = "Name: " . $name . "\nEmail address: " . $email . "\nMessage: "  . $message;
    $mail->Body = $emailBody;

    try {
        if (!$mail->send()) {
            echo "ERROR: " . $mail->ErrorInfo;
            //header("Location: ContactUs.php?error=mailNotSent");
        } else {
            //echo "SUCCESS";
            header("Location: ContactUs.php?error=mailSent");
        }
    } catch (phpmailerException $e) {
        echo $e-> errorMessage();
    }
    exit();

}


