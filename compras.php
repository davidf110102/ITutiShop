<?php
    require 'config/config.php';
    require 'config/database.php';
    require 'clases/clienteFunciones.php';
    $db = new Database();
    $con = $db->conectar();

    $idCliente = $_SESSION['user_cliente'];

    $sql = $con->prepare("SELECT id_transaccion, fecha, status, total, medio_pago  FROM compras WHERE 
    id_cliente = ? ORDER BY DATE(fecha) DESC");
    $sql->execute([$idCliente]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITuti Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body>
<?php include 'menu.php'; ?>

<main class = "flex-shrink-0">
    <div class="container">
        <h4>Mis compras</h4>
        <hr>

        <?php while($row= $sql->fetch(PDO::FETCH_ASSOC)){?>
        <div class="card">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <?php }?>
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    
</body>
</html>