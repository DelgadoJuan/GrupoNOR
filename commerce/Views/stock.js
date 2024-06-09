import { verificar_sesion } from "./sesion.js";

$(document).ready(function() {
    let ordenar_por = null;
    let direccion = 'ASC';

    bsCustomFileInput.init();
    verificar_sesion();
    obtenerProductos();
    
    // Función para modificar el estado de un producto
    function modificarEstadoProducto(id, estado) {
        $.ajax({
            url: '../Controllers/ProductoController.php',
            method: 'POST',
            data: {
                funcion: 'modificar_estado_producto',
                id: id,
                estado: estado
            },
            success: function(response) {
                alert('Estado modificado correctamente');
                obtenerProductos(); // Actualizar la tabla

                // Encuentra el botón de estado para este producto y actualiza su estado
                let button = document.querySelector(`.toggle-status-button[data-id="${id}"]`);
                if (button) {
                    button.dataset.status = estado === 'A' ? 'I' : 'A';
                    button.innerHTML = `<i class="${estado === 'A' ? 'fas fa-toggle-off' : 'fas fa-toggle-on'}"></i>`;
                }
            }
        });
    }
    
    // Función para eliminar un producto
    function eliminarProducto(id) {
        $.ajax({
            url: '../Controllers/ProductoController.php',
            method: 'POST',
            data: {
                funcion: 'eliminar_producto',
                id: id
            },
            success: function(response) {
                alert('Producto eliminado correctamente');
                obtenerProductos(); // Actualizar la tabla
            }
        });
    }

    // Función para obtener todos los productos y llenar la tabla de stock
    function obtenerProductos() {
        $.ajax({
            url: '../Controllers/ProductoController.php',
            method: 'POST',
            data: { funcion: 'obtener_productos' },
            success: function(response) {
                let productos = JSON.parse(response);
                let tbody = document.querySelector('#inventoryTable tbody');
                tbody.innerHTML = '';
    
                productos.forEach(producto => {
                    let row = `
                        <tr>
                            <td>${producto.nombre ? producto.nombre : 'N/A'}</td>
                            <td>${producto.nombre_categoria ? producto.nombre_categoria : 'N/A'}</td>
                            <td>${producto.precio_unitario ? parseInt(producto.precio_unitario).toString().replace(/,/g, '') : 'N/A'}</td>
                            <td>${producto.costo_unidad ? parseInt(producto.costo_unidad).toString().replace(/,/g, '') : 'N/A'}</td>
                            <td>${producto.precio_envio_km ? parseInt(producto.precio_envio_km).toString().replace(/,/g, '') : 'N/A'}</td>
                            <td>${producto.sector ? producto.sector : 'N/A'}</td>
                            <td>${producto.descripcion ? producto.descripcion : 'N/A'}</td>
                            <td>${producto.fecha_registro ? new Date(producto.fecha_registro).toLocaleString() : 'N/A'}</td>
                            <td>${producto.fecha_actualizacion ? new Date(producto.fecha_actualizacion).toLocaleString() : 'N/A'}</td>
                            <td class='cantidad-column'>${producto.cantidad_disponible ? producto.cantidad_disponible : 'N/A'}</td>
                            <td data-order="${producto.estado == 'A' ? 1 : 0}">
                                <button class="btn btn-warning toggle-status-button" data-id="${producto.id}" data-status="${producto.estado}">
                                    <i class="${producto.estado == 'A' ? 'fas fa-toggle-on' : 'fas fa-toggle-off'}"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-primary add-quantity-button" data-id="${producto.id}" data-toggle="modal" data-target="#addStockModal"><i class="fas fa-plus"></i></button>
                                <button class="btn btn-info edit-button" data-id="${producto.id}" data-toggle="modal" data-target="#editProductModal"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger delete-button" data-id="${producto.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
    
                    // Agregar la fila al cuerpo de la tabla
                    tbody.innerHTML += row;
                });
    
                // Destruir la instancia existente de DataTables antes de crear una nueva
                if ($.fn.DataTable.isDataTable('#inventoryTable')) {
                    $('#inventoryTable').DataTable().destroy();
                }

                $('#inventoryTable').DataTable();
    
                // Agregar eventos a los botones de editar, eliminar, agregar cantidad y activar/desactivar
                document.querySelectorAll('.edit-button').forEach(button => {
                    button.addEventListener('click', function() {
                        obtenerProducto(this.dataset.id);
                    });
                });
    
                document.querySelectorAll('.delete-button').forEach(button => {
                    button.addEventListener('click', function() {
                        if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                            eliminarProducto(this.dataset.id);
                        }
                    });
                });
    
                document.querySelectorAll('.add-quantity-button').forEach(button => {
                    button.addEventListener('click', function() {
                        let row = this.closest('tr');
    
                        // Obtener la cantidad existente del producto de la tabla
                        let cantidadExistente = row.querySelector('.cantidad-column').textContent;
    
                        document.querySelector('#addStockModal #productId').value = this.dataset.id;
                        // Cargar la cantidad existente en el modal
                        document.querySelector('#addStockModal #cantidad').value = cantidadExistente;
                    });
                });
    
                document.querySelectorAll('.toggle-status-button').forEach(button => {
                    button.addEventListener('click', function() {
                        modificarEstadoProducto(this.dataset.id, this.dataset.status);
                    });
                });
            }
        });
    }

    document.querySelector('#addProductForm').addEventListener('submit', function(event) {
        // Prevenir la recarga de la página
        event.preventDefault();
    
        // Crear un objeto FormData con los datos del formulario
        let formData = new FormData(this);

        // Validar los datos del producto
        /*if (!validarProducto(formData)) {
            return;
        }*/
    
        // Agregar la función al objeto FormData
        formData.append('funcion', 'crear_producto');
    
        // Enviar los datos del formulario al servidor
        $.ajax({
            url: '../Controllers/ProductoController.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Ocultar el modal
                $('#productModal').modal('hide');
                alert('Producto creado correctamente');
                // Actualizar la tabla de productos
                obtenerProductos();
            }
        });
    });

    function obtenerProducto(id) {
        $.ajax({
            url: '../Controllers/ProductoController.php',
            method: 'POST',
            data: {
                funcion: 'obtener_producto',
                id: id
            },
            success: function(response) {
                var producto = JSON.parse(response)[0];
    
                // Llenar el formulario de edición con los datos del producto
                document.querySelector('#editProductForm #id').value = producto.id;
                document.querySelector('#editProductForm #id_categoria').value = producto.id_categoria;
                document.querySelector('#editProductForm #nombre').value = producto.nombre;
                document.querySelector('#editProductForm #descripcion').value = producto.descripcion;
                document.querySelector('#editProductForm #cantidad_disponible').value = producto.cantidad_disponible;
                document.querySelector('#editProductForm #costo_unidad').value = producto.costo_unidad;
                document.querySelector('#editProductForm #precio_unitario').value = producto.precio_unitario;
                document.querySelector('#editProductForm #sector').value = producto.sector;
                document.querySelector('#editProductForm #precio_envio').value = producto.precio_envio_km;
    
                // Cargar la foto principal del producto
                if (producto.foto) {
                    document.querySelector('#editProductForm #fotoExistente').src = producto.foto;
                    document.querySelector('#editProductForm #nombreFoto').textContent = producto.foto.split('/').pop();
                }
    
                // Agregar las fotos al formulario de edición
                let fotosContainer = document.querySelector('#editProductForm #fotos');
                fotosContainer.innerHTML = '';
                producto.fotos.forEach(foto => {
                    let fotoElement = document.createElement('div');
                    let nombreFoto = foto.nombre.split('/').pop();
                    fotoElement.innerHTML = `
                        <img src="${foto.nombre}" alt="Foto del producto" style="width: 50px; height: 50px;">
                        <span>${nombreFoto}</span>
                        <button type="button" class="delete-photo-button" data-id="${foto.id}">Eliminar</button>
                    `;
                    fotosContainer.appendChild(fotoElement);
    
                    // Agregar evento al botón de eliminar foto
                    fotoElement.querySelector('.delete-photo-button').addEventListener('click', function(event) {
                        eliminarFoto(this.dataset.id, event);
                    });
                });
            }
        });
    }

    document.querySelector('#editProductForm').addEventListener('submit', function(event) {
        // Prevenir la recarga de la página
        event.preventDefault();
    
        // Crear un objeto FormData con los datos del formulario
        let formData = new FormData(this);
    
        // Agregar la función al objeto FormData
        formData.append('funcion', 'editar_producto');

        // Validar los datos del producto
        /*if (!validarProducto(formData)) {
            return;
        } */  
    
        // Enviar los datos del formulario al servidor
        $.ajax({
            url: '../Controllers/ProductoController.php',
            method: 'POST',
            data: formData,
            processData: false,  // No procesar los datos
            contentType: false,  // No establecer el encabezado Content-Type automáticamente
            success: function(response) {
                alert('Producto editado correctamente');
                obtenerProductos();
                $('#editProductModal').modal('hide');
            }
        });
    });

    function eliminarFoto(id, event) {
        event.stopPropagation();
        if (confirm('¿Estás seguro de que quieres eliminar esta foto?')) {
            $.ajax({
                url: '../Controllers/ProductoController.php',
                method: 'POST',
                data: {
                    funcion: 'eliminar_foto',
                    id: id
                },
                success: function(response) {
                    obtenerProducto(document.querySelector('#editProductForm #id').value);
                    alert('Foto eliminada correctamente');
                }
            });
        }
    }
    
        $('#saveChanges').on('click', function() {
            var id = $('#addStockForm #productId').val();
            var cantidad = $('#addStockForm #cantidad').val();

            // Validar que la cantidad a añadir sea un número decimal normal
            /*if (!isDecimal(cantidad)) {
                alert('La cantidad a añadir debe ser un número');
                return;
            }*/

            $.ajax({
                url: '../Controllers/ProductoController.php',
                method: 'POST',
                data: { funcion: 'modificar_cantidad_disponible', id: id, cantidad: cantidad },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert('Cantidad modificada correctamente');
                        $('#addStockModal').modal('hide');
                        obtenerProductos();
                    } else {
                        alert(data.message);
                    }
                },
                error: function(_jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
        });

        // Función para validar los datos del producto
        /*function validarProducto(formData) {
            // Validar los campos del formulario
            for (var pair of formData.entries()) {
                if (pair[0] === 'nombre' && jQuery.validator.isEmpty(pair[1])) {
                    alert('El campo ' + pair[0] + ' no puede estar vacío');
                    return false;
                }
        
                if (pair[0] === 'cantidad_disponible' || pair[0] === 'costo_unidad' || pair[0] === 'precio_unitario') {
                    if (!isDecimal(pair[1])) {
                        alert('El campo ' + pair[0] + ' debe ser numérico');
                        return false;
                    }
                }
            }
        
            return true;
        } */

        // Función para validar que un campo sea un número decimal normal
        /*function isDecimal(value) {
            return /^\d+(\.\d+)?$/.test(value);
        } */

        function obtenerCategorias() {
            $.post('../Controllers/CategoriaController.php', { funcion: 'obtener_categorias' }, function(response) {
                const categorias = JSON.parse(response);
                
                // Cargar las categorías en el formulario de agregar producto
                let selectAgregar = $('#addProductForm #id_categoria');
                selectAgregar.empty();
                categorias.forEach(categoria => {
                    selectAgregar.append('<option value="' + categoria.id + '">' + categoria.nombre + '</option>');
                });
        
                // Cargar las categorías en el formulario de editar producto
                let selectEditar = $('#editProductForm #id_categoria');
                selectEditar.empty();
        
                // Agregar una opción base con valor null
                selectEditar.append('<option value="">Selecciona una categoría</option>');
        
                categorias.forEach(categoria => {
                    selectEditar.append('<option value="' + categoria.id + '">' + categoria.nombre + '</option>');
                });
            });
        }
        obtenerCategorias();
});