<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registrarse</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="../Util/Css/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../Util/Css/adminlte.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="../Util/Css/toastr.min.css">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="../Util/Css/sweetalert2.min.css" >
</head>
<!-- Modal -->
<div class="modal fade" id="terminos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="card-title">Terminos y condiciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <p>* utilizaremos sus datos para generar publicidad de acuerdo a sus gustos</p>
                    <p>* la empresa no se hace responsable de posibles fraudes o estafas</p>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<body class="hold-transition login-page">
<div class="mt-5">
<div class="login-logo">
    <!-- logo -->
    <img src="../Util/Img/logoGrupoNOR.png" class="profile-user-img img-fluid img-circle">
    <a href="./index.php"><b>Grupo</b>NOR</a>
</div>
<!-- /.login-logo -->
<div class="card">
    <div class="card-body login-card-body">
    <p class="login-box-msg">Registrarse</p>

    <form id="form-register">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Ingrese un nombre de usuario">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" class="form-control" id="pass" placeholder="Ingrese una contraseña">
                </div>
                <div class="form-group">
                    <label for="nombres">Nombre</label>
                    <input type="text" name="nombres" class="form-control" id="nombres" placeholder="Ingrese su nombre">
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" class="form-control" id="dni" placeholder="Ingrese su DNI">
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Ingrese su telefono">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pass_repeat">Repita su contraseña</label>
                    <input type="password" name="pass_repeat" class="form-control" id="pass_repeat" placeholder="Ingrese de nuevo su contraseña">
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellido</label>
                    <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Ingrese su apellido">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Ingrese su email">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-0">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="terms" class="custom-control-input" id="terms">
                    <label class="custom-control-label" for="terms">Estoy de acuerdo con los<a href="#" data-toggle="modal" data-target="#terminos"> terminos de servicio</a>.</label>
                </div>
            </div>
        </div>
        <!-- boton enviar -->
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-lg bg-gradient-primary">Registrarme</button>
        </div>
    </form>

    </div>
    <!-- /.login-card-body -->
</div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../Util/Js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../Util/Js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../Util/Js/adminlte.min.js"></script>
<!-- Toastr js -->
<script src="../Util/Js/toastr.min.js"></script>
<!-- SweetAlert2 -->
<script src="../Util/Js/sweetalert2.min.js"></script>
<!-- Js de register -->
<script src="register.js"></script>
<!-- Js de los metodos de validacion -->
<script src="../Util/Js/additional-methods.min.js"></script>
<script src="../Util/Js/jquery.validate.min.js"></script>
</body>
</html>


