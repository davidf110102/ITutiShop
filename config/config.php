<?php

$path = dirname(__FILE__);

require_once  $path . '/database.php';
require_once $path . '/../admin/clases/cifrado.php';

$db = new Database();
$con = $db->conectar();

$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datosConfig = $resultado->fetchAll(PDO::FETCH_ASSOC);

$config = [];

foreach ($datosConfig as $datoConfig) {
  $config[$datoConfig['nombre']] = $datoConfig['valor'];
}

//configuracion del sistema
define("SITE_URL", "http://localhost/ITutiShop");
define("KEY_TOKEN", "APR.wqc-354*");
define("MONEDA", "$");

//configuracion para paypal
define("CLIENT_ID", "Ad7IMXOaBDm9Rti8M3nHRqSW3gsrwo_4NmWbdzH7QKBtP6czf5PN6wUEEVlKMpHpWP80sfTtMr_CSlXj");
define("CURRENCY", "MXN");

//Configuración para Mercado Pago
define("TOKEN_MP", "TEST-3032682665147199-062222");
define("PUBLIC_KEY_MP", "TEST-f8d3d553-b99f");
define("LOCALE_MP", "es-MX");

//Datos para envio de correo electronico 
define("MAIL_HOST", $config['correo_smtp']);
define("MAIL_USER", $config['correo_email']);
define("MAIL_PASS", descifrar($config['correo_password']));
define("MAIL_PORT", $config['correo_puerto']);


session_start();

$num_cart = 0;
if (isset($_SESSION['carrito']['productos'])) {
  $num_cart = count($_SESSION['carrito']['productos']);
}