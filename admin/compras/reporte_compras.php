<?php
require '../config/database.php';
require '../config/config.php';
require('../fpdf/plantilla_reporte_compras.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
  header('Location: ../index.php');
  exit;
}

$db = new Database();
$con = $db->conectar();

$fechaIni = $_POST['fecha_ini'] ?? '01-01-2021';
$fechaFin = $_POST['fecha_fin'] ?? '01-01-2025';

$query = "SELECT DATE_FORMAT(c.fecha, '%d/%m/%Y %H:%i') AS fecha_hora, c.status, c.total, c.medio_pago, CONCAT(cli.nombres, ' ', cli.apellidos) AS cliente
FROM tienda_online.compras AS c
INNER JOIN tienda_online.clientes AS cli ON c.id_cliente = cli.id
WHERE DATE(c.fecha) BETWEEN ? AND ?
ORDER BY DATE(c.fecha) ASC";

$resultado = $con->prepare($query);
$resultado->execute([$fechaIni, $fechaFin]);

$datos = [
  'fechaIni' => $fechaIni,
  'fechaFin' => $fechaFin,
];


$pdf = new PDF('P', 'mm', 'Letter', $datos);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
  $pdf->Cell(30, 6, $row['fecha_hora'], 1, 0);
  $pdf->Cell(30, 6, $row['status'], 1, 0);
  $pdf->Cell(60, 6, $row['cliente'], 1, 0);
  $pdf->Cell(30, 6, $row['total'], 1, 0);
  $pdf->Cell(30, 6, $row['medio_pago'], 1, 1);
}
$pdf->Output();