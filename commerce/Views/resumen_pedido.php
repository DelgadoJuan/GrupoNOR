<?php
    ob_start(); // Inicia el búfer de salida
    
    //include '../Util/Config/config.php';
    //include '../Models/Usuario.php';
    // Verificar si el usuario está logueado
    $allowed_roles = ['Administrador', 'Empleado'];
    include_once 'Layouts/General/header.php'; // Mover esta línea después de las llamadas a header()
    ob_end_flush(); // Vacía (envía) el búfer de salida
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detalles del pedido</h3>
                    </div>
                    <div class="card-body">
                        <h4>Número del pedido:</h4>
                        <p id="pedido-id"></p>

                        <h4>Productos:</h4>
                        <ul id="lista-productos">
                            <!-- Los productos se agregarán aquí -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    include_once 'Layouts/General/footer.php';
?>

<script src="./resumen_pedido.js" type="module"></script>