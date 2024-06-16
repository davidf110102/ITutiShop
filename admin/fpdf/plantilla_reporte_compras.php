<?php

require 'fpdf.php';

class PDF extends FPDF
{
  private $fechaIni;
  private $fechaFin;

  public function __construct($orientacion, $medidas, $tamanio, $datos)
  {
    parent::__construct($orientacion, $medidas, $tamanio);
    $this->fechaIni = $datos['fechaIni'];
    $this->fechaFin = $datos['fechaFin'];
  }

  public function Header()
  {
    $this->Image('../images/logo.png', 10, 5, 20);
    $this->SetFont('Arial', 'B', 11);

    $this->Cell(30);
    $y = $this->GetY();
    $this->MultiCell(130, 10, 'Reporte de compras', 0, 'C');

    $this->SetXY(160, $y);
    $this->SetFont('Arial', '', 11);
    $this->Cell(40, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'L');

    $this->Ln(8);
  }
}