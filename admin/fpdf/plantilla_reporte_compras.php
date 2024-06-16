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

    $this->MultiCell(130, 10, 'Reporte de compras', 1, 'C');
  }
}