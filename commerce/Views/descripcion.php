<?php
    if(!empty($_GET['id']) && $_GET['name']){
        session_start();
        $_SESSION['product-verification'] = $_GET['id'];
        //echo $_SESSION['product-verification'];
        include_once './Layouts/Tienda/header.php';
    }
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
            <li class="breadcrumb-item"><a href="./tienda.php">Home</a></li>
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
                <div class="mt-4">
                    <h4>Cantidad</h4>
                    <input type="number" id="product_quantity" min="1" value="1">
                </div>
                <div class="mt-4">
                    <span id="warningStock" class="text-danger"></span>
                </div>

                <div id="product_options" class="mt-4"></div>

                <div class="bg-gray py-2 px-3 mt-4 border">
                    <h2 class="mb-0" id="precio_producto">
                    </h2>
                </div>

                <div class="mt-4">
                    <button class="agregar-carrito btn btn-primary btn-flat">
                        <i class="fas fa-cart-plus fa-lg mr-2"></i>
                        Agregar al carrito
                    </button>                            
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
    include_once 'Layouts/Tienda/footer.php';
    
?>

<script src="./descripcion.js" type="module"></script>
