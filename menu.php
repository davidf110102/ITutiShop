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
        <?php if(isset($_SESSION['user_id'])) { ?>
            <a href="#" class="btn btn-success"><i class="fa-solid fa-user"></i> <?php echo $_SESSION['user_name']; ?></a>
        <?php } else {?>
            <a href="login.php" class="btn btn-success"><i class="fa-solid fa-user"></i> Ingresar </a>   
        <?php } ?>
    </div>
    </div>
</div>
</header>