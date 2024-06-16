<?php
require '../config/config.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
  header('Location: ../index.php');
  exit;
}

require  '../header.php';
?>

<!--Contenido-->
<main class="flex-shrink-0">
  <div class="container mt-3">
    <h4>Reporte de compras</h4>

    <form action="reporte_compras.php" method="post" autocomplete="off">
      <div class="row mb-2">
        <div class="col-12 col-md-4">
          <label for="fecha_ini" class="form-label">Fecha inicial:</label>
          <input type="date" class="form-control" name="fecha_ini" id="fecha_ini" require autofocus>
        </div>

        <div class="col-12 col-md-4">
          <label for="fecha_fin" class="form-label">Fecha final:</label>
          <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" require>
        </div>


      </div>

      <button type="submit" class="btn btn-primary">Generar</button>
    </form>


  </div>
</main>


<?php include '../footer.php'; ?>