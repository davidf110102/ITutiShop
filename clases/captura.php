<?php
require '../config/config.php';

session_start();

$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

print_r($datos);

if (is_array($datos)) {

  $idCliente = $_SESSION['user_cliente'];
  $sql = $con->prepare("SELECT email FROM clientes WHERE id=? AND estatus = 1");
  $sql->execute([$idCliente]);
  $row_cliente = $sql->fetch(PDO::FETCH_ASSOC);

  $id_transaccion = $datos['detalles']['id'];
  $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
  $status = $datos['detalles']['status'];
  $fecha = $datos['detalles']['update_time'];
  //$fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
  $fecha_nueva = date('Y-m-d H:i:s');
  //$email = $datos['detalles']['payer']['email_address'];
  $email = $row_cliente['email'];
  //$id_cliente = $datos['detalles']['payer']['payer_id'];
  
  $sql = $con->prepare("INSERT INTO compras (id_transaccion, fecha, status, email, id_cliente, total, medio_pago) VALUES (?,?,?,?,?,?,?)");
  $sql->execute([$id_transaccion, $fecha, $status, $email, $idCliente, $total, 'paypal']);
  $id = $con->lastInsertId();

  if ($id > 0) {
    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    if ($productos != null) {
      foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo = 1");
        $sql->execute([$clave]);
        $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

        $precio = $row_prod['precio'];
        $descuento = $row_prod['descuento'];
        $precio_desc = $precio - (($precio * $descuento) / 100);

        $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
        if($sql_insert->execute([$id, $row_prod['id'],  $row_prod['nombre'], $precio_desc, $cantidad])){
          restarStock($row_prod['id'], $cantidad, $con);
        }
      }
      require 'Mailer.php';

      $asunto = "Detalles de su compra";
      $cuerpo = '<h4>Gracias por preferirnos 🤑</h4>';
      $cuerpo .= '<h4>Folio de la compra: ' . $id_transaccion . '</h4>';
      $cuerpo .= '<h4>Fecha de la compra: ' . $fecha . '</h4>';
      $cuerpo .= '<h4>Total: ' . $total . '</h4>';
      $cuerpo .= '<h4>Puede ver los detalles de su pago en el siguiente enlace: <a href="http://localhost:8081/ProyectoEcommerce/ITutiShop/completado.php?key=' . $id_transaccion . '">Ver detalles del pago</a></h4>';


      $mailer = new Mailer();
      $mailer->enviarEmail($email, $asunto, $cuerpo);
    }
    unset($_SESSION['carrito']);
  }
}

function restarStock($id, $cantidad, $con){

  $sql = $con->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
  $sql->execute([$cantidad,$id]); 
}