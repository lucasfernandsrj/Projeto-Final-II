<?php

require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function enviar_email($destinatario_email, $assunto, $mensagem) {
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.yahoo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lucasfernandesrf@yahoo.com.br';
        $mail->Password = 'xmfudeyhlcccckrb';
        $mail->Port = 587;
        $mail->setFrom('lucasfernandesrf@yahoo.com.br');
        $mail->isHTML(true);
        $mail->addAddress($destinatario_email);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
        $mail->AltBody = 'Chegou o email teste do Canal TI';
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
        return false;
    }
}
