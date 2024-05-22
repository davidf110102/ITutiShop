<?php
    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $errors=[];

    if(!empty($_POST)){

        $nombres = trim($_POST['nombres']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['telefono']);
        $dni = trim($_POST['dni']);
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);
        $repassword = trim($_POST['repassword']);
    }

    $idCategoria = $_GET['cat'] ?? '';
    $orden = $_GET['orden'] ?? '';
    $buscar = $_GET['q'] ?? '';
    $filtro = '';

    $orders = [
        
        'asc' => 'nombre ASC',
        'desc' => 'nombre DESC',
        'precio_alto' => 'precio DESC',
        'precio_bajo' => 'precio ASC'
    ];

    $order = $orders[$orden] ?? '';

    if(!empty($order)){
        $order = " ORDER BY $order";
    }

    //$params = [];

    //$query = "SELECT id, nombre, precio FROM productos WHERE activo = 1 $order";

    if($buscar != ''){
        /*$query .= " AND nombre LIKE ?"; 
        $params[] = "%$buscar%";*/
        $filtro = "AND (nombre LIKE '%$buscar%' || descripcion LIKE '%$buscar%')";
    }
    /*if($idCategoria != ''){
        $query .= " AND id_Categoria=?";
        $params[] = $idCategoria;
    }
    $query = $con->prepare($query);
    $query -> execute($params);*/
    
    
    if(!empty($idCategoria)){
        $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1 $filtro AND id_Categoria=?
        $order");
        $sql->execute([$idCategoria]);
    } else {
        $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1 $filtro $order");
        $sql->execute();
    }
    
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sqlCategorias = $con->prepare("SELECT id, nombre FROM categorias WHERE activo = 1");
    $sqlCategorias->execute();
    $categorias = $sqlCategorias->fetchAll(PDO::FETCH_ASSOC);

    //session_destroy();

    //print_r($_SESSION);
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
<header>
<div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a href="index.php" class="navbar-brand">
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
                <a href="index.php" class="nav-link">Contacto</a>
            </li>
        </ul>
        <form action="index.php" method="get" autocomplete="off">
            <div class = "input-group pe-3">
                <input type = "text" name = "q" id = "q" class="form-control form-control-sm" 
                placeholder="Buscar..." aria-describedby = "icon-buscar">
                <button type = "submit" id="icon-buscar" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <a href="checkout.php" class="btn btn-primary btn-sm me-2">
            <i class = "fas fa-shopping-cart"></i> Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>

    </div>
    </div>
</div>
</header>
<main class = "flex-shrink-0">
    <div class="container">
        <h2>Datos del cliente</h2>

        <form class= "row g-3" action="registro.php" method="post" autocomplete>
            <div class="col-md-6">
                <label for="nombres"><span class="text-danger">*</span>Nombres</label>
                <input type="text" name="nombres" id="nombres" class="form-control"required>
            </div>
            <div class="col-md-6">
                <label for="apellidos"><span class="text-danger">*</span>Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control"required>
            </div>
            <div class="col-md-6">
                <label for="email"><span class="text-danger">*</span>Correo Electronico</label>
                <input type="email" name="email" id="email" class="form-control"required>
            </div>
            <div class="col-md-6">
                <label for="telefono"><span class="text-danger">*</span>Telefono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control"required>
            </div>
            <div class="col-md-6">
                <label for="dni"><span class="text-danger">*</span>Cedula</label>
                <input type="text" name="dni" id="dni" class="form-control"required>
            </div>
            <div class="col-md-6">
                <label for="usuario"><span class="text-danger">*</span>Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control"required>
            </div>
            <div class="col-md-6">
                <label for="password"><span class="text-danger">*</span>Contraseña</label>
                <input type="password" name="password" id="password" class="form-control"required>
            </div>
            <div class="col-md-6">
                <label for="repassword"><span class="text-danger">*</span>Repetir Contraseña</label>
                <input type="password" name="repassword" id="repassword" class="form-control"required>
            </div>

            <i><b>Nota:</b> Los campos con asterisco son obligatorios</i>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    
</body>
</html>