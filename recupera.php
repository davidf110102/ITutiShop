<?php
require_once 'config/config.php';
require_once 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {
  $email = trim($_POST['email']);

  if (esNulo([$email])) {
    $errors[] = "Debe llenar todos los campos";
  }

  if (!esEmail($email)) {
    $errors[] = "La dirección de correo no es válida";
  }

  if (count($errors) == 0) {
    if (emailExiste($email, $con)) {
      $sql = $con->prepare("SELECT usuarios.id, clientes.nombres FROM usuarios
                                            INNER JOIN clientes ON usuarios.id_cliente = clientes.id
                                            WHERE clientes.email LIKE ? LIMIT 1");
      $sql->execute([$email]);
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $user_id = $row['id'];
      $nombre = $row['nombres'];

      $token = solicitaPassword($user_id, $con);

      if ($token !== null) {
        require 'clases/Mailer.php';
        $mailer = new Mailer();

        $url = SITE_URL . '/reset_password.php?id=' . $user_id . '&token=' . $token;

        $asunto = "Recuperar password - Tienda online";
        $cuerpo = "Estimado $nombre: <br> Si haz solicitado el cambio de tu contraseña haz clic en el 
                siguiente link <a href='$url'>$url</a>";
        $cuerpo .= "<br>Si no hiciste esta solicitud puedes ignorar este correo";

        if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
          echo "<p><b>Correo enviado</b></p>";
          echo "<p>Hemos enviado un correo electrónico a la dirección $email para restablecer la contraseña</p>";

          exit;
        }
      }
    } else {
      $errors[] = "No existe una cuenta asociada a esta dirección de correo";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ITuti Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
  <header>
  <div class="navbar navbar-expand-lg navbar-dark"  style="background-color: rgb(22, 13, 159); padding-left: 50px; padding-right: 50px;">
    <div class="container">
    <a href="index.php" class="navbar-brand" style="color: rgb(255, 241, 0);">
          <strong>ITuti Shop</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
          aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarHeader">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a href="index.php" class="nav-link active">Catalogo</a>
            </li>
            <li class="nav-item">
              <a href="index.php" class="nav-link">Contacto</a>
            </li>
          </ul>

          <a href="checkout.php" class="btn btn-primary btn-sm me-2">
            <i class="fas fa-shopping-cart"></i> Carrito <span id="num_cart"
              class="badge bg-secondary"><?php echo $num_cart; ?></span>
          </a>

        </div>
      </div>
    </div>
  </header>
  <main class="form-login m-auto pt-4">
    <h3>Recuperar contraseña</h3>

    <?php mostrarMensajes($errors); ?>

    <form action="recupera.php" method="post" class="row g-3" autocomplete="off">
      <div class="form-floating">
        <input class="form-control" type="email" name="email" id="email" placeholder="Correo electrónico" required>
        <label for="email">Correo electrónico</label>
      </div>
      <div class="d-grid gap-3 col-12">
        <button type="submit" class="btn btn-primary">Continuar</button>
      </div>
      <div class="col-12">
        ¿No tienes cuenta? <a href="registro.php">Registrate aquí</a>
      </div>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>

</body>

</html>