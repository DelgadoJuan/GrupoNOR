<?php
    ob_start(); // Inicia el búfer de salida
    session_start();
    include '../Util/Config/config.php';
    include '../Models/Usuario.php';
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['id'])) {
        header('Location: ./index.php');
        exit();
    }
    include_once 'Layouts/General/header.php'; // Mover esta línea después de las llamadas a header()
    ob_end_flush(); // Vacía (envía) el búfer de salida
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pedidos Actuales</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <!-- Agregar un input para el filtrado por nombre -->
                            <input type="text" id="filterName" class="form-control" placeholder="Filtrar por nombre">
                        </div>
                        <!-- Agregar la tabla con la información de los pedidos -->
                        <table id="ordersTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre del Cliente</th>
                                    <th>Fecha del Pedido</th>
                                    <th>Productos</th>
                                    <th>Total</th>
                                    <th>Forma de Pago</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
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
    include_once('Layouts/General/footer.php');
?>