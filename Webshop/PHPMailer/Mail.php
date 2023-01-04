<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/Applications/XAMPP/xamppfiles/htdocs/Webshop/Webshop/PHPMailer/includes/Exception.php';
require '/Applications/XAMPP/xamppfiles/htdocs/Webshop/Webshop/PHPMailer/includes/PHPMailer.php';
require '/Applications/XAMPP/xamppfiles/htdocs/Webshop/Webshop/PHPMailer/includes/SMTP.php';

$mail = new PHPMailer();#
$mail->SMTPDebug  = 2;
$mail->isSMTP();
$mail->Host ="smtp.gmail.com";
$mail->SMTPAuth="true";
$mail->SMTPSecure="tls";
$mail->Port="587";
$mail->Username="taylorzhuangorz@gmail.com";
$mail->Password="nfmqwemachihgvcz";
$mail->Subject="Test";
$mail->SetFrom('noreply@mysg.com', 'Myshop');
$mail->Body="This is body";
$mail->addAddress("taylorzhuang@live.com");
if($mail->Send()){
    echo "sent";
}else{
    echo "error";
};
?>