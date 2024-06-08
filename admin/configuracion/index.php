<?php
require  '../config/database.php';
require  '../config/config.php';
require  '../header.php';

$db = new Database();
$con = $db->conectar();

$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

$config = [];

foreach ($datos as $dato) {
  $config[$dato['nombre']] = $dato['valor'];
}

?>
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Configuracion</h1>

    <form action="guarda.php" method="post">
      <div class="row">
        <div class="col-6">
          <label for="smtp">SMTP</label>
          <input class="form-control" type="text" name="smtp" id="smtp" value="<?php echo $config['correo_smtp'] ?>">
        </div>

        <div class="col-6">
          <label for="puerto">Puerto</label>
          <input class="form-control" type="text" name="puerto" id="puerto"
            value="<?php echo $config['correo_puerto'] ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <label for="email">Correo electronico</label>
          <input class="form-control" type="text" name="email" id="email" value="<?php echo $config['correo_email'] ?>">
        </div>

        <div class="col-6">
          <label for="password">Contraseña</label>
          <input class="form-control" type="text" name="password" id="password"
            value="<?php echo $config['correo_password'] ?>">
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</main>


<?php require '../footer.php' ?>