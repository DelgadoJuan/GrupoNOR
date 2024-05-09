<?php
if(!empty($_GET['id']) && $_GET['name']){
    session_start();
    $_SESSION['product-verification'] = $_GET['id'];
    //echo $_SESSION['product-verification'];
    include_once '../Views/Layouts/General/header.php';

?>
    
    <title> <?php echo $_GET['name'] ?> </title>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 id="nombre_producto"></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $_GET['name'] ?></li>
            </ol>
        </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
    <!-- Main content -->
    <section class="content">

    <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div id="imagenes" class="col-12 col-sm-6">            
                </div>
            <div class="col-12 col-sm-6">
                <h4  id="id_producto" class="my-3"></h2>
                <hr>
                <div class="card card-light">
                    <div id="informacion_envio" class="card-body">
                        <!-- ver esto despues -->
                        <h4>Envio</h4>
                    </div>
                </div>               
                <!-- Ver esto despues -->
                <h4 class="mt-3">Tamaño</h4>
                <div class="btn-group btn-group-toggle " data-toggle="buttons">
                <label class="btn btn-default text-center">
                    <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                    <span class="text-xl">S</span>
                    <br>
                    Small
                </label>
                <label class="btn btn-default text-center">
                    <input type="radio" name="color_option" id="color_option_b2" autocomplete="off">
                    <span class="text-xl">M</span>
                    <br>
                    Medium
                </label>
                <label class="btn btn-default text-center">
                    <input type="radio" name="color_option" id="color_option_b3" autocomplete="off">
                    <span class="text-xl">L</span>
                    <br>
                    Large
                </label>
                <label class="btn btn-default text-center">
                    <input type="radio" name="color_option" id="color_option_b4" autocomplete="off">
                    <span class="text-xl">XL</span>
                    <br>
                    Xtra-Large
                </label>
                </div>

                <div class="bg-gray py-2 px-3 mt-4 border">
                    <h2 class="mb-0" id="precio_producto">
                    </h2>
                </div>

                <div id="btn-carrito" class="mt-4">
                    
                </div>

                </div>
            </div>
            <div class="row mt-4">
                <nav class="w-100">
                <div class="nav nav-tabs" id="product-tab" role="tablist">
                    <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Descripcion</a>
                </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                    Aqui va la descripcion
                </div>
                </div>
            </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->




<?php
include_once 'Layouts/General/footer.php';
}else{
    header('Location: ../index.php');
}
?>

<script src="descripcion.js"></script>
<script src="carrito.js"></script>
