import { verificar_sesion } from "./sesion.js";

$(document).ready(function(){
    // Lógica para inicializar el carrito
    verificar_sesion();
    obtenerCarrito();
    obtenerDatosCliente();
    obtenerDirecciones();
    $('#pagarButton').addClass('disabled');

    // Detectar cambios en el dropdown de direcciones
    $('#direccion').change(function() {
        if ($(this).val() !== '') {
            const destino = $(this).val();
            const origen = 'Sáenz Peña, Chaco'; // Cambia esto por la dirección de origen real
            calcularEnvio(origen, destino, function(envio) {
                const subtotal = parseFloat($('#subtotalPrice').text());
                const total = subtotal + envio;
                $('#shippingPrice').text(envio);
                $('#totalPrice').text(total);
            });

            // Habilitar el botón cuando se seleccione una dirección válida
            $('#pagarButton').removeClass('disabled');
        } else {
            $('#shippingPrice').text(0);
            $('#totalPrice').text(parseFloat($('#subtotalPrice').text()));
            // Deshabilitar el botón si no hay selección
            $('#pagarButton').addClass('disabled');
        }
    }); 
});

function obtenerDirecciones() {
    $.ajax({
        url: '../Controllers/UsuarioLocalidadController.php',
        method: 'POST',
        data: {
            funcion: 'llenar_direcciones'
        },
        success: function(response) {
            var direcciones = JSON.parse(response);
            var direccionesHtml = '<option value="">Selecciona una dirección</option>';
            
            for (var i = 0; i < direcciones.length; i++) {
                var direccionCompleta = direcciones[i].direccion + ', ' + direcciones[i].localidad + ', ' + direcciones[i].provincia
                direccionesHtml += '<option value="' + direcciones[i].localidad + ', '+ direcciones[i].provincia + '">' + direccionCompleta + '</option>';
            }
            $('#direccion').html(direccionesHtml);
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
}

function obtenerCarrito() {
    $.ajax({
        url: '../Controllers/Detalle_PedidoController.php',
        method: 'POST',
        data: {
            funcion: 'obtener_carrito'
        },
        success: function(response) {
            var cartItems = JSON.parse(response);
            var cartItemsHtml = '';
            var subtotal = 0;
            var envio = 0;
            for (var i = 0; i < cartItems.length; i++) {
                var itemSubtotal = cartItems[i].precio * cartItems[i].cantidad;
                subtotal += itemSubtotal;
                cartItemsHtml += '<tr>';
                cartItemsHtml += '<td><img src="' + cartItems[i].foto + '" alt="' + cartItems[i].nombre_producto + '" style="width: 50px; height: 50px;"></td>';
                cartItemsHtml += '<td>' + cartItems[i].nombre_producto + '</td>';
                cartItemsHtml += '<td>' + cartItems[i].precio + '</td>';
                cartItemsHtml += '<td><input type="number" class="cantidadInput" value="' + cartItems[i].cantidad + '" min="1" data-id="' + cartItems[i].id + '"></td>';
                cartItemsHtml += '<td>' + itemSubtotal + '</td>';
                cartItemsHtml += '<td><button class="btn btn-danger delete-button" data-id="' + cartItems[i].id + '"><i class="fas fa-trash-alt"></i></button></td>';
                cartItemsHtml += '</tr>';
            }
            $('#cart-items').html(cartItemsHtml);
            var total = subtotal + envio;

            document.getElementById('subtotalPrice').innerText = subtotal;
            document.getElementById('shippingPrice').innerText = envio;
            document.getElementById('totalPrice').innerText = total;

            // Agregar eventos a los botones de eliminar y agregar cantidad
            document.querySelectorAll('.cantidadInput').forEach(input => {
                input.addEventListener('change', function() {
                    var id = input.getAttribute('data-id');
                    cambiarCantidad(id, input.value);
                });
            });

            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
                        eliminarDelCarrito(this.dataset.id);
                    }
                });
            });
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
}

function obtenerDatosCliente() {
    $.ajax({
        url: '../Controllers/UsuarioController.php',
        method: 'POST',
        data: {
            funcion: 'obtener_payer'
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#nombre').val(data.nombre);
            $('#apellido').val(data.apellido);
            $('#email').val(data.email);
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });

}

var cambiarCantidadTimeout;
function cambiarCantidad(id, cantidad) {
    // Cancelar el temporizador anterior si existe
    if (cambiarCantidadTimeout) {
        clearTimeout(cambiarCantidadTimeout);
    }

    // Establecer un nuevo temporizador
    cambiarCantidadTimeout = setTimeout(function() {
        $.ajax({
            url: '../Controllers/Detalle_PedidoController.php',
            method: 'POST',
            data: {
                funcion: 'cambiar_cantidad',
                id: id,
                cantidad: cantidad
            },
            success: function(response) {
                // Actualizar la tabla del carrito después de cambiar la cantidad
                obtenerCarrito();
            },
            error: function() {
                alert('Error al realizar la solicitud AJAX');
            }
        });
    }, 3000); // 3000 milisegundos = 3 segundos
}

function eliminarDelCarrito(id_detalle_pedido) {
    $.ajax({
        url: '../Controllers/Detalle_PedidoController.php',
        method: 'POST',
        data: {
            funcion: 'eliminar_carrito',
            id_detalle_pedido: id_detalle_pedido
        },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'success') {
                alert(result.message);
                // Actualizar la tabla del carrito después de eliminar un producto
                obtenerCarrito();
            } else {
                alert('Error al eliminar el producto del carrito');
            }
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
}

function calcularEnvio(origen, destino, callback) {
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
        {
            origins: [origen],
            destinations: [destino],
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
        }, 
        function(response, status) {
            if (status !== 'OK') {
                alert('Error al calcular el envío: ' + status);
                return;
            }
            var precio_envio_km = parseFloat(document.getElementById('precio_envio_km').value);
            var distancia = response.rows[0].elements[0].distance.value / 1000; // Convertimos a kilómetros

            // Obtener todos los productos del carrito para calcular el envío total
            $.ajax({
                url: '../Controllers/Detalle_PedidoController.php',
                method: 'POST',
                data: { funcion: 'obtener_carrito' },
                success: function(response) {
                    var cartItems = JSON.parse(response);
                    var costoEnvioTotal = 0;

                    cartItems.forEach(function(item) {
                        if (item.nombre_categoria === 'Tinglados') {
                            costoEnvioTotal += distancia * precio_envio_km;
                        } else {
                            costoEnvioTotal += distancia * item.precio_envio_km;
                        }
                    });

                    // Enviar el costo de envío total al servidor
                    $.ajax({
                        url: 'guardar_envio.php',
                        method: 'POST',
                        data: { envio: costoEnvioTotal },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status === 'success') {
                                callback(Math.trunc(costoEnvioTotal));
                            } else {
                                alert('Error al obtener el costo de envío del servidor');
                            }
                        },
                        error: function() {
                            alert('Error al enviar el costo de envío al servidor');
                        }
                    });
                },
                error: function() {
                    alert('Error al realizar la solicitud AJAX para obtener el carrito');
                }
            });
        }
    );
}