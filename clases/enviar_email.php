<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/xampp/htdocs/EcommerceiTutiShop/phpmailer/src/Exception.php';
require '/xampp/htdocs/EcommerceiTutiShop/phpmailer/src/PHPMailer.php';
require '/xampp/htdocs/EcommerceiTutiShop/phpmailer/src/SMTP.php';

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

  // Contenido del correo
  $mail->isHTML(true);
  $mail->Subject = 'Detalles de su compra';
  $cuerpo = '<h4>Gracias por preferirnos 🤑</h4>';
  $cuerpo .= '<h4>Folio de la compra: ' . $id_transaccion . '</h4>';
  $cuerpo .= '<h4>Fecha de la compra: ' . $fecha . '</h4>';
  $cuerpo .= '<h4>Total: ' . $total . '</h4>';
  $cuerpo .= '<h4>Puede ver los detalles de su pago en el siguiente enlace: <a href="http://localhost/EcommerceiTutiShop/completado.php?key=' . $id_transaccion . '">Ver detalles del pago</a></h4>';



  $mail->Body .= $cuerpo;

  $mail->send();
} catch (Exception $e) {
  echo "Error de correo electrónico: " . $e->getCode() . " - " . $e->getMessage();
}
