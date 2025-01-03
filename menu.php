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