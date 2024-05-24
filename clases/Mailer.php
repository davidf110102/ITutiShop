<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    function enviarEmail($email, $asunto, $cuerpo)
    {
        require_once '/xampp/htdocs/ITUTISHOP/config/config.php';
        require '/xampp/htdocs/ITUTISHOP/phpmailer/src/Exception.php';
        require '/xampp/htdocs/ITUTISHOP/phpmailer/src/PHPMailer.php';
        require '/xampp/htdocs/ITUTISHOP/phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'vichicelakevin@gmail.com';
            $mail->Password   = 'vyoa ixzf njgc qrsf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            
            // Configuración del correo electrónico
            $mail->setFrom('vichicelakevin@gmail.com');
            //Correo receptor y nombre
            $mail->addAddress($email);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $asunto;

            $mail->Body = utf8_decode($cuerpo);

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error de correo electrónico: " . $e->getCode() . " - " . $e->getMessage();
            return false;
        }
    }
}
