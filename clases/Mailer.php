<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
  function enviarEmail($email, $asunto, $cuerpo)
  {
    require_once __DIR__ . '/../config/config.php';
    require __DIR__ . '/../phpmailer/src/Exception.php';
    require __DIR__ . '/../phpmailer/src/PHPMailer.php';
    require __DIR__ . '/../phpmailer/src/SMTP.php';
    //require_once __DIR__.'/xampp/htdocs/ITUTISHOP/config/config.php';
    //require __DIR__.'/xampp/htdocs/ITUTISHOP/phpmailer/src/Exception.php';
    //require __DIR__.'/xampp/htdocs/ITUTISHOP/phpmailer/src/PHPMailer.php';
    //require __DIR__.'/xampp/htdocs/ITUTISHOP/phpmailer/src/SMTP.php';

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
      $mail->addAddress('dayanagualpa385@gmail.com');
      //Correo receptor y nombre
      $mail->addAddress($email);

      // Contenido del correo
      $mail->isHTML(true);
      $mail->Subject = $asunto;

      $mail->Body = mb_convert_encoding($cuerpo, 'ISO-8859-1', 'UTF-8');

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
