import { verificar_sesion } from "./sesion.js";

$(document).ready(function() {
    verificar_sesion();
    var id_pedido = new URLSearchParams(window.location.search).get('id');
    if (id_pedido) {
        obtenerDetallesPedido(id_pedido);
    } else {
        alert('No se ha proporcionado un ID de pedido');
    }
});

function obtenerDetallesPedido($id_pedido) {
    $.ajax({
        url: '../Controllers/Detalle_PedidoController.php',
        method: 'POST',
        data: {
            funcion: 'obtener_Detalle_Pedido_Id',
            id_pedido: $id_pedido
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.length > 0) {

                document.getElementById('pedido-id').textContent = $id_pedido;

                // Rellenar la lista de productos
                var listaProductos = document.getElementById('lista-productos');
                // Limpiar la lista de productos existente
                listaProductos.innerHTML = '';
                data.forEach(function(producto) {
                    var li = document.createElement('li');
                    li.style.fontSize = '20px'; // Hacer las letras más grandes

                    // Agregar la foto al inicio
                    var img = document.createElement('img');
                    if (producto.nombre_producto === 'Tinglado Personalizado') {
                        producto.producto_foto = '../Util/Assets/tinglado3.jpeg';
                    }
                    img.src = producto.producto_foto;
                    img.style.width = '100px'; // Ajustar el tamaño de la imagen según sea necesario
                    img.style.height = '100px'; // Asegurarse de que la imagen sea cuadrada
                    img.style.objectFit = 'cover'; // Asegurarse de que la imagen cubra todo el espacio disponible
                    li.appendChild(img);

                    // Agregar los detalles del producto
                    var span = document.createElement('span');
                    span.textContent = ' - ' + producto.nombre_producto + ' - ' + producto.cantidad + ' - ' + producto.precio_unitario;
                    // Si el producto es un tinglado, añadir tipo de techo y color
                    if (producto.tipo_techo && producto.color) {
                        span.textContent += ' - Tipo de techo: ' + producto.tipo_techo + ' - Color: ' + producto.color;
                    }
                    li.appendChild(span);

                    listaProductos.appendChild(li);
                });
            } else {
                alert('Error al obtener los detalles del pedido');
            }
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
}