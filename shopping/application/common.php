<?php

function sendemail($toemail, $subject, $message)
{
   
   
    $mail = new \PHPMailer\PHPMailer\PHPMailer();
    //Server settings
    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->SMTPDebug = 0; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.qq.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = '541163714@qq.com'; // SMTP username
    $mail->Password = 'bqpwhbeaivbsbbgb'; // SMTP password
    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465; //端口 - likely to be 25, 465 or 587

    //Recipients
    $mail->setFrom('541163714@qq.com', '啦啦购物'); //发送方地址和昵称
    $mail->addAddress($toemail, 'Joe User'); // Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information'); //回复地址

    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $subject; //标题
    $mail->Body = $message; //内容
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if (!$mail->send()) {
        return array('status' => -1, 'msg' => '发送失败: ' . $mail->ErrorInfo);
    } else {
        return array('status' => 1, 'msg' => '发送成功');
    }

}
?>	