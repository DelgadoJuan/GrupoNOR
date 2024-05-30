import { verificar_sesion } from "./sesion.js";

$(document).ready(function(){
    $("#pay-button").click(function(){
      window.location.href = mercadoPagoUrl;
    });
});

function agregar_carrito(id_producto, cantidad, precio) {
    $.ajax({
        url: '../Controllers/Detalle_PedidoController.php',
        method: 'POST',
        data: {
            funcion: 'agregar_carrito',
            id_producto: id_producto,
            cantidad: cantidad,
            precio: precio
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert('Error al agregar el producto al carrito');
            }
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
            calcularEnvio('Sáenz Peña, Chaco', 'Resistencia, Chaco', function(envio) {
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
                $('#cart-summary').html(`
                    <p>Subtotal: ${subtotal}</p>
                    <p>Envío: ${envio}</p>
                    <p>Total: ${total}</p>
                `);

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

function obtenerCoordenadas(ciudad, callback) {
    var url = 'https://api.openrouteservice.org/geocode/search?api_key=5b3ce3597851110001cf62481ce923ec13794691a9d4a28975f20857&text=' + encodeURIComponent(ciudad);

    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            var coordenadas = response.features[0].geometry.coordinates;
            callback(coordenadas);
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
}

function calcularEnvio(origen, destino, callback) {
    obtenerCoordenadas(origen, function(coordenadasOrigen) {
        obtenerCoordenadas(destino, function(coordenadasDestino) {
            var url = 'https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf62481ce923ec13794691a9d4a28975f20857&start=' + coordenadasOrigen.join(',') + '&end=' + coordenadasDestino.join(',');

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var precio_envio_km = document.getElementById('precio_envio_km').value;
                    var distancia = response.features[0].properties.summary.distance / 1000; // La distancia se devuelve en metros, así que la convertimos a kilómetros
                    callback(distancia * precio_envio_km);
                },
                error: function() {
                    alert('Error al realizar la solicitud AJAX');
                }
            });
        });
    });
}

export function initCarrito() {
    verificar_sesion();
    obtenerCarrito();
    obtenerDatosCliente();
}

export {agregar_carrito};