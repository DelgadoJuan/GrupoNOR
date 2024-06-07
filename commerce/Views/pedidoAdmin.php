<?php
    ob_start(); // Inicia el búfer de salida
    //session_start();
    include '../Util/Config/config.php';
    //include '../Models/Usuario.php';
  
    // Specify the allowed roles for this page
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
                        <h3 class="card-title">Pedidos Actuales</h3>
                    </div>
                    <div class="card-body">
                        <!-- Agregar la tabla con la información de los pedidos -->
                        <table id="ordersTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nro. Pedido</th>
                                    <th>Nombre del Cliente</th>
                                    <th>DNI</th>
                                    <th>Fecha del Pedido</th>
                                    <th>Envío</th>
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

<!-- Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOrderModalLabel">Editar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editOrderForm">
          <div class="form-group">
            <label for="orderStatus">Estado del Pedido</label>
            <input type="hidden" id="orderId">
            <select class="form-control" id="orderStatus">
                <option value="Pendiente">Pendiente</option>
                <option value="Procesando">Procesando</option>
                <option value="Completado">Completado</option>
                <option value="Entregado">Entregado</option>
                <option value="Cancelado">Cancelado</option>
            </select>
          </div>
          <div class="form-group">
            <label for="orderInvoice">Factura del Pedido</label>
            <input type="file" class="form-control-file" id="orderInvoice" accept=".pdf">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="saveChanges">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

<?php
    include_once('Layouts/General/footer.php');
?>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="./pedidoAdmin.js" type="module"></script>