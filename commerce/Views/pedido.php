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
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="box-shadow: none;border:none;">
                    <div class="card-header mb-0" style="box-shadow: none;border:none;">
                        <h1 class="card-title mb-0" style="font-weight: 700; font-size:1.75em; ">Pedidos Actuales</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-5">
                            <!-- Agregar un input para el filtrado por nombre -->
                            <input type="text" id="filterName" class="form-control" style="width:100%; max-width: 25em; border:none; background: rgba(200,200,200,.3)" placeholder="Filtrar por nombre">
                        </div>
                        <!-- Agregar la tabla con la información de los pedidos -->
                        <table id="ordersTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th><p style="opacity: .4">Nombre del Cliente</p></th>
                                    <th><p style="opacity: .4">Fecha del Pedido</p></th>
                                    <th><p style="opacity: .4">Productos</p></th>
                                    <th><p style="opacity: .4">Total</p></th>
                                    <th><p style="opacity: .4">Forma de Pago</p></th>
                                    <th><p style="opacity: .4">Estado</p></th>
                                    <th><p style="opacity: .4">Acciones</p></th>
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