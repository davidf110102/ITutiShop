<?php
    require 'config/config.php';
    require 'clases/clienteFunciones.php';
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

        $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);

        if($id > 0){
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $token = generarToken();
            if(!registraUsuario([$usuario, $pass_hash, $token, $id], $con)){
                $errors[] = "Error al registrar usuario";
            }
        }else{
            $errors[] = "Error al registrar cliente";
        }

        if(count($errors) == 0){

        }else{
            print_r($errors);
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
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
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
                <a href="index.php" class="nav-link">Contacto</a>
            </li>
        </ul>
        
        <a href="checkout.php" class="btn btn-primary btn-sm me-2">
            <i class = "fas fa-shopping-cart"></i> Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>

    </div>
    </div>
</div>
</header>
<main class = "flex-shrink-0">
    <div class="container">
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
    
</body>
</html>