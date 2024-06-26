<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - SB Admin</title>
  <link href="<?php echo ADMIN_URL; ?>css/styles.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <style>
    /* Estilo para ocultar las secciones del menú lateral cuando está colapsado */
    .sidebar-collapsed #layoutSidenav_nav {
      display: none;
    }

    /* Ajusta el contenido principal cuando el menú lateral está colapsado */
    .content-expanded {
      transition: margin-left 0.3s ease;
    }

    .content-collapsed {
      transition: margin-left 0.3s ease;
    }

    @media (min-width: 768px) {
      .content-expanded {
        margin-left: 250px; /* Ancho del menú lateral cuando está abierto */
      }

      .content-collapsed {
        margin-left: 75px; /* Ancho del menú lateral cuando está cerrado */
      }
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a id="navbar-brand" class="navbar-brand ps-3" href="../inicio.php">iTuTiShop</a>

    <!-- Sidebar Toggle Button -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" type="button">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
          aria-expanded="false"><i class="fas fa-user fa-fw"></i><?php echo $_SESSION['user_name']; ?></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>cambiar_password.php?id=<?php  echo $_SESSION['user_id']; ?>">Cambiar Contraseña</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a id="logout-link" class="dropdown-item" href="../logout.php">Cerrar Sesión</a></li>

        </ul>
      </li>
    </ul>
    
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>configuracion">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Configuracion
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>usuarios">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Usuarios
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>categorias">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Categorias
            </a>
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>productos">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Productos
            </a>


            <a class="nav-link" href="<?php echo ADMIN_URL; ?>compras">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Compras
            </a>

            

            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth"
                  aria-expanded="false" aria-controls="pagesCollapseAuth">
                  Authentication
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                  data-bs-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="login.html">Login</a>
                    <a class="nav-link" href="register.html">Register</a>
                    <a class="nav-link" href="password.html">Forgot Password</a>
                  </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError"
                  aria-expanded="false" aria-controls="pagesCollapseError">
                  Error
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

              </nav>
            </div>

          </div>
        </div>

      </nav>
    </div>
    <div id="layoutSidenav_content" class="content-expanded">
      
    
    <script>
      // Ajusta dinámicamente el enlace del Navbar Brand según la URL actual
      document.addEventListener("DOMContentLoaded", function () {
        var currentUrl = window.location.pathname;
        var navbarBrand = document.getElementById('navbar-brand');

        if (currentUrl.endsWith("admin/inicio.php")) {
          navbarBrand.href = "inicio.php";
        } else {
          navbarBrand.href = "../inicio.php";
        }
      });

      // Ajusta dinámicamente el enlace de Cerrar Sesión según la URL actual
      var currentUrl = window.location.pathname;
      var logoutLink = document.getElementById('logout-link');

      if (currentUrl.endsWith("admin/inicio.php")) {
        logoutLink.href = "logout.php";
      } else {
        logoutLink.href = "../logout.php";
      }

      // Maneja el evento de clic en el botón de alternar barra lateral
      document.getElementById('sidebarToggle').addEventListener('click', function () {
        var layoutSidenav = document.getElementById('layoutSidenav');
        var layoutSidenavContent = document.getElementById('layoutSidenav_content');

        layoutSidenav.classList.toggle('sidebar-collapsed');

        if (layoutSidenav.classList.contains('sidebar-collapsed')) {
          layoutSidenavContent.classList.remove('content-expanded');
          layoutSidenavContent.classList.add('content-collapsed');
        } else {
          layoutSidenavContent.classList.remove('content-collapsed');
          layoutSidenavContent.classList.add('content-expanded');
        }
      });
    </script>
      </body>
</html>