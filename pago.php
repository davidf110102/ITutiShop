<?php
require 'config/config.php';

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

//print_r($_SESSION);
$lista_carrito = array();
$num_cart = 0;

if ($productos != null) {
  foreach ($productos as $clave => $cantidad) {
    $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo = 1");
    $sql->execute([$clave]);
    $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
  }
} else {
  header("Location: index.php");
  exit;
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
  <link href="css/all.min.css" rel="stylesheet">
</head>

<body>
<header>
<div class="navbar navbar-expand-lg navbar-dark"  style="background-color: rgb(22, 13, 159); padding-left: 50px; padding-right: 50px;">
    <div class="container">
    <a href="index.php" class="navbar-brand" style="color: rgb(255, 241, 0);">
        <strong>ITuti Shop</strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class = "navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="index.php" class="nav-link active">Catalogo</a>
            </li>
            <li class="nav-item">
                <a href="https://tuti.com.ec" class="nav-link">Contacto</a>
            </li>
        </ul>
        
        <a href="checkout.php" class="btn btn-primary btn-sm me-2">
            <i class = "fas fa-shopping-cart"></i> Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
        <?php if(isset($_SESSION['user_id'])) { ?>

            <div class="dropdown">
            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" 
            id="btn_session" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: rgb(241, 228, 0); color: rgb(100, 100, 100);">
                    <i class="fa-solid fa-user"></i> &nbsp; <?php echo $_SESSION['user_name']; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="btn_session">
                    <li><a class="dropdown-item" href="compras.php">Mis Compras</a></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
            <?php } else {?>
            <a href="login.php" class="btn btn-success btn-sm" style="background-color: rgb(241, 228, 0); color: rgb(100, 100, 100);"><i class="fa-solid fa-user"></i> Ingresar </a>     
            <?php } ?>
    </div>
    </div>
</div>
</header>
  <main>
    <div class="container">

      <div class="row">
        <div class="col-6">
          <h4>Detalles de Pago</h4>
          <div id="paypal-button-container"></div>
        </div>
        <div class="col-6">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Productos</th>
                  <th>Subtotal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($lista_carrito == null) {
                  echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
                } else {
                  $total = 0;
                  foreach ($lista_carrito as $producto) {
                    $_id = $producto['id'];
                    $nombre = $producto['nombre'];
                    $precio = $producto['precio'];
                    $descuento = $producto['descuento'];
                    $cantidad = $producto['cantidad'];
                    $precio_desc = $precio - (($precio * $descuento) / 100);
                    $subtotal = $cantidad * $precio_desc;
                    $total += $subtotal;
                ?>
                <tr>
                  <td><?php echo $nombre; ?></td>

                  <td>
                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                      <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                  </td>
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="2">
                    <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2); ?></p>
                  </td>
                </tr>
              </tbody>
              <?php } ?>
            </table>
          </div>


        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>

  <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>">
  </script>

  <script>
  paypal.Buttons({
    style: {
      color: 'blue',
      shape: 'pill',
      label: 'pay'
    },
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: <?php echo $total; ?>
          }
        }],
        application_context: {
          shipping_preference: "NO_SHIPPING"
        }
      });
    },
    onApprove: function(data, actions) {
      let url = 'clases/captura.php';
      actions.order.capture().then(function(detalles) {

        console.log(detalles);

        let url = 'clases/captura.php';

        return fetch(url, {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            detalles: detalles
          })
        }).then(function(response) {
          window.location.href = "completado.php?key=" + detalles['id'];
        });
      });
    },
    onCancel: function(data) {
      alert("Pago cancelado");
      console.log(data)
    }

  }).render('#paypal-button-container');
  </script>

</body>

</html>