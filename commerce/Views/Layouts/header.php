<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="Util/Css/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Util/Css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="Util/Css/sweetalert2.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

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
      <li  id= "notificacion" class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <!-- icono carrito -->
          <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
        </div>
      </li>
      <li class="nav-item" id="nav_register">
        <!-- Ruta a registrarse -->
        <a class="nav-link"  href="Views/register.php" role="button">
          <!-- Icono de registrarse -->
          <i class="fas fa-user-plus"></i> Registrarse 
        </a>
      </li>
      <li class="nav-item" id="nav_login">
        <!-- Ruta al LogIn -->
        <a class="nav-link"  href="Views/login.php" role="button">
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
          <a class="dropdown-item" href="Views/mi_perfil.php"><i class="fas fa-user-cog"></i> Mi perfil</a>
          <a class="dropdown-item" href="#"><i class="fas fa-shopping-basket"> </i> Mis pedidos</a>
          <!-- Controlador para cerrar sesion -->
          <a class="dropdown-item" href="Controllers/logout.php"><i class="fas fa-user-times"></i> Cerrar sesión</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">