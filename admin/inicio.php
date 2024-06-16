<?php 

require 'config/database.php';
include 'config/config.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
    header('Location: index.php');
    exit;
}

$db = new Database();
$con = $db->conectar();

$hoy = date('Y-m-d');
$lunes = date($hoy, strtotime('monday this week'));
$domingo = date($hoy, strtotime('sunday this week'));

$fechaInicial = new DateTime($lunes);
$fechaFinal = new DateTime($domingo);

$diasVentas = [];

for($i = $fechaInicial; $i <= $fechaFinal; $i->modify('+1 day')){

}

function totalDia($con, $fecha){
  $sql = "SELECT IFNULL(SUM(total), 0) as total FROM compras WHERE DATE(fecha) = '$fecha' AND status LIKE 'COMPLETED'";
}

include 'header.php'; 
?>
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class ="row">
      <div class="col-6">
        <div cñass="card mb-4">
          <div class="card-header">
            Ventas de la semana
          </div>
          <div class="card-body">
            <canvas id="myChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-5">
        <div cñass="card mb-4">
          <div class="card-header">
            Productos mas vendidos del mes
          </div>
          <div class="card-body">
            <canvas id="Chart-productos"></canvas>
          </div>
        </div>
      </div>

    </div>


  </div>
</main>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  const ctxProductos = document.getElementById('Chart-productos');

   new Chart(ctxProductos, {
    type: 'pie',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<?php include 'footer.php'; ?>