<?php
    include_once 'Layouts/General/header.php';
?>

<!-- Aquí puedes agregar cualquier otra sección de encabezado específica para la página de stock -->

<section class="content">
    <div class="container-fluid">
        <!-- Aquí comienza el contenido de la página de stock -->
        <div class="row">
            <!-- Aquí puedes agregar cualquier columna o sección específica para mostrar información de stock -->
            <div class="col-md-6">
                <!-- Por ejemplo, podrías agregar una tabla para mostrar el inventario actual -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inventario Actual</h3>
                    </div>
                    <div class="card-body">
                        <!-- Aquí iría la tabla con la información del inventario -->
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Aquí podrías agregar otros elementos relacionados con la gestión de stock, como formularios para agregar productos, ajustar cantidades, etc. -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestión de Stock</h3>
                    </div>
                    <div class="card-body">
                        <!-- Aquí irían los formularios u otros elementos para interactuar con el stock -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Aquí termina el contenido de la página de stock -->
    </div><!-- /.container-fluid -->
</section> 

<?php
    include_once 'Layouts/General/footer.php';
?>
<script src="stock.js"></script> <!-- Aquí incluyes el script específico para la página de stock -->