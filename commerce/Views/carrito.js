import { verificar_sesion } from "./sesion.js";

$(document).ready(function() {
    verificar_sesion();
    obtenerCarrito();
});


$('#btn-carrito').click(function() {
    var id_producto = $('#id_producto').text();
    var cantidad = $('#product_quantity').val();
    var precio = $('#precio_producto').text().trim().substring(2); 

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
});

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
            var impuestos = 0.15; // Tasa de impuestos del 15%
            var envio = 10; // Costo de envío fijo de 10
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

            var impuestos = subtotal * impuestos;
            var total = subtotal + impuestos + envio;
            $('#cart-summary').html(`
                <p>Subtotal: ${subtotal}</p>
                <p>Impuestos: ${impuestos}</p>
                <p>Envío: ${envio}</p>
                <p>Total: ${total}</p>
            `);

            // Agregar eventos a los botones de editar, eliminar, agregar cantidad y activar/desactivar
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