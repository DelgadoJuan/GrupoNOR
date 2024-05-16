<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tienda</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Select2 -->
  <link rel="stylesheet" href="../Util/Css/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Util/Css/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Util/Css/adminlte.min.css">
  <!-- Sweetalert2 -->
  <link rel="stylesheet" href="../Util/Css/sweetalert2.min.css">

<style>
    /* Estilo para manejar submenús anidados */
  .dropdown-submenu {
      position: relative;
  }

  .dropdown-submenu > .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -1px;
      display: none; /* Ocultar inicialmente */
  }

  .dropdown-submenu:hover > .dropdown-menu {
      display: block; /* Mostrar cuando se hace hover */
  }

  .navbar-nav .dropdown-menu {
      margin-top: 0;
  }
</style>
  
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Brand -->
    <a class="navbar-brand" href="../Views/index.php" style="margin-left: -50px;">
        <!-- Icono de la empresa -->
        <img src="../Util/Img/logoGrupoNOR.png" alt="Company Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: 30px;">
        <span class="brand-text font-weight-light">Grupo NOR</span>
    </a>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul id="categorias" class="navbar-nav">
            <!-- Categorías se insertarán aquí -->
        </ul>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li id="notificacion" class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <!-- icono carrito -->
          <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu">
          <table class="table table-hover text-nowrap p-0">
            <thead class="table-success">
              <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="lista">

            </tbody>
          </table>
          <a href="#" class="btn btn-warning btn-block">Finalizar compra</a>
          <a href="#" class="btn btn-danger btn-block">Vaciar carrito</a>
        </div>
      </li>
      <li class="nav-item" id="nav_register">
        <!-- Ruta a registrarse -->
        <a class="nav-link"  href="register.php" role="button">
          <!-- Icono de registrarse -->
          <i class="fas fa-user-plus"></i> Registrarse 
        </a>
      </li>
      <li class="nav-item" id="nav_login">
        <!-- Ruta al LogIn -->
        <a class="nav-link"  href="login.php" role="button">
          <!-- Icono de usuarios -->
          <i class="far fa-user"></i> Iniciar sesión 
        </a>
      </li>
      <li class="nav-item dropdown" id="nav_usuario">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <!-- avatar del usuario -->
          <img id="avatar_nav" src="" width="30" height="30" class="img-fluid img-circle">
          <span id="usuario_nav"> Usuario logueado</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="mi_perfil.php"><i class="fas fa-user-cog"></i> Mi perfil</a>
          <a class="dropdown-item" href="#"><i class="fas fa-shopping-basket"> </i> Mis pedidos</a>
          <!-- Controlador para cerrar sesion -->
          <a class="dropdown-item" href="../Controllers/logout.php"><i class="fas fa-user-times"></i> Cerrar sesión</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Footer -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../Util/Js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../Util/Js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../Util/Js/adminlte.min.js"></script>
<!-- Sweetalert2 -->
<script src="../Util/Js/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="../Util/Js/select2.min.js"></script>
</body>
</html>

<style>
  #categorias
</style>