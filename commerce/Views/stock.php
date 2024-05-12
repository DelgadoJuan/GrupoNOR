<?php
    include_once './Layouts/General/header.php';
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inventario Actual</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <!-- Agregar un input para el filtrado por nombre -->
                            <input type="text" id="filterName" class="form-control" placeholder="Filtrar por nombre">
                            <!-- Botón para abrir el modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal">
                                Agregar Producto
                            </button>
                        </div>
                        <!-- Agregar la tabla con la información del inventario -->
                        <table id="inventoryTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th data-columna="p.nombre">Nombre <i class="fas fa-sort"></i></th>
                                    <th data-columna="c.nombre">Categoría <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.precio_unitario">Precio unitario <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.costo_unidad">Costo unitario <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.sector">Sector <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.descripcion">Descripción <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.fecha_registro">Fecha de registro <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.fecha_actualizacion">Fecha de actualización <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.cantidad_disponible">Cantidad disponible <i class="fas fa-sort"></i></th>
                                    <th data-columna="p.estado">Estado <i class="fas fa-sort"></i></th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenará la tabla con la información del inventario -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Agregar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="id_categoria">Categoría:</label>
                            <select class="form-control" id="id_categoria" name="id_categoria">
                                <!-- Las opciones se llenarán con JavaScript -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="cantidad_disponible">Cantidad Disponible:</label>
                            <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible">
                        </div>
                        <div class="form-group">
                            <label for="costo_unidad">Costo por Unidad:</label>
                            <input type="number" class="form-control" id="costo_unidad" name="costo_unidad">
                        </div>
                        <div class="form-group">
                            <label for="precio_unitario">Precio por Unidad:</label>
                            <input type="number" class="form-control" id="precio_unitario" name="precio_unitario">
                        </div>
                        <div class="form-group">
                            <label for="sector">Sector:</label>
                            <input type="text" class="form-control" id="sector" name="sector">
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto principal:</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <div class="form-group">
                            <label for="fotos">Agregar fotos extras:</label>
                            <input type="file" class="form-control" id="fotos" name="fotos[]" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edición de productos -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form id="editProductForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Editar producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Campos a la izquierda -->
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="id_categoria">Categoría:</label>
                                    <select class="form-control" id="id_categoria" name="id_categoria"></select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción:</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cantidad_disponible">Cantidad Disponible:</label>
                                    <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible">
                                </div>
                                <div class="form-group">
                                    <label for="costo_unidad">Costo por Unidad:</label>
                                    <input type="number" class="form-control" id="costo_unidad" name="costo_unidad">
                                </div>
                                <div class="form-group">
                                    <label for="precio_unitario">Precio por Unidad:</label>
                                    <input type="number" class="form-control" id="precio_unitario" name="precio_unitario">
                                </div>
                                <div class="form-group">
                                    <label for="sector">Sector:</label>
                                    <input type="text" class="form-control" id="sector" name="sector">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Campos a la derecha -->
                                <div class="form-group">
                                    <label for="foto">Foto principal:</label>
                                    <img id="fotoExistente" src="" style="width: 50px; height: 50px;">
                                    <span id="nombreFoto"></span>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                </div>
                                <div id="fotos">
                                    <!-- Las fotos se llenarán con JavaScript -->
                                </div>
                                <div class="form-group">
                                    <label for="nuevasFotos">Agregar nuevas fotos:</label>
                                    <input type="file" class="form-control" id="nuevasFotos" name="fotos[]" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">Modificar cantidad disponible</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addStockForm">
                <div class="form-group">
                    <label for="cantidad">Cantidad disponible:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="0">
                </div>
                <input type="hidden" id="productId" name="productId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Guardar cambios</button>
            </div>
            </div>
        </div>
    </div>
</section> 

<?php
    include_once './Layouts/General/footer.php';
?>
<script src="./stock.js" type="module"></script>