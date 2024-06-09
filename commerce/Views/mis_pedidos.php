<?php
    ob_start(); // Inicia el búfer de salida

    $require_login = true;
    $allowed_roles = ['Administrador', 'Repositor', 'Empleado', 'Cliente'];

    include_once 'Layouts/Tienda/header.php'; // Mover esta línea después de las llamadas a header()
    include '../Util/Config/config.php';
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['id'])) {
        header('Location: ./index.php');
        exit();
    }
    ob_end_flush(); // Vacía (envía) el búfer de salida
?>

<!--<style>
    .dataTables_length label {
        color: black; /* Cambia el color del texto */
    }
    .dataTables_length select {
        color: black; /* Cambia el color del texto */
    }

    /* Estilo para el campo de búsqueda */
    .dataTables_filter input {
        color: black; /* Cambia el color del texto */
    }
    .dataTables_filter label {
        color: black; /* Cambia el color del texto */
    }
    .dataTables_info {
        color: black; /* Cambia el color del texto */
    }
</style> -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-dark">Pedidos Actuales</h3>
                    </div>
                    <div class="card-body">
                        <!-- Agregar la tabla con la información de los pedidos -->
                        <table id="ordersTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-dark">Nro. Pedido</th>
                                    <th class="text-dark">Fecha del Pedido</th>
                                    <th class="text-dark">Envío</th>
                                    <th class="text-dark">Total</th>
                                    <th class="text-dark">Forma de Pago</th>
                                    <th class="text-dark">Estado</th>
                                    <th class="text-dark">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenará la tabla con la información de los pedidos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php
    include_once('Layouts/Tienda/footer.php');
?>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="./mis_pedidos.js" type="module"></script>