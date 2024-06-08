<?php
require '../config/database.php';
require '../config/config.php';
require '../header.php';

$db = new Database();
$con = $db->conectar();

$smtp = $_POST['smtp'];
$puerto = $_POST['puerto'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = $con->prepare("UPDATE configuracion SET valor=? Where nombre=?");
$sql->execute([$smtp, 'correo_smtp']);
$sql->execute([$puerto, 'correo_puerto']);
$sql->execute([$email, 'correo_email']);
$sql->execute([$password, 'correo_password']);
?>
<main>
  <div class="container-fluid px4">
    <h2 class="mt-4">Configuracion actualizada</h2>
    <a href="index.php" class="btn btn-secondary">Regresar</a>
    </ol>
  </div>
</main>



<?php include '../footer.php' ?>