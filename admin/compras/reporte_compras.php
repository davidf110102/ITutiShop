<?php
require '../config/database.php';
require '../config/config.php';
require('../fpdf/fpdf.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
  header('Location: ../index.php');
  exit;
}

$db = new Database();
$con = $db->conectar();

$fechaIni = $_POST['fecha_ini'];
$fechaFin = $_POST['fecha_fin'];

$query = "SELECT date_format(c.fecha, '$d/$m/$Y %H:%i') AS fecahhora, c.status, c.total, c.medio_pago, CONCAT(cli.nombres, ' ', cli.apellidos) AS cliente
    FROM compras AS c
    INNER JOIN clientes AS cli ON c.id_cliente = cli.id
    WHERE DATE(c.fecha) BETWEEN ? AND ? 
    ORDER BY DATE(fecha) ASC";
$resultado = $con->prepare($query);
$resultado->execute([$fechaIni, $fechaFin]);

$pdf = new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

while ($row = $resultado->fetchAll($PDO::FETCH_ASSOC)) {
  $pdf->Cell(30, 6, $row['fechaHora'], 1, 0);
}
$pdf->Output();
