import { verificar_sesion } from "./sesion.js";

$(document).ready(function() {
    verificar_sesion();
});

document.getElementById('largo').addEventListener('input', calcular);
document.getElementById('ancho').addEventListener('input', calcular);
document.getElementById('altura').addEventListener('input', calcular);

function calcular() {
    var largo = document.getElementById('largo').value;
    var ancho = document.getElementById('ancho').value;
    var altura = document.getElementById('altura').value;
    var precioBase = document.getElementById('precioBase').value;

    var volumen = largo * ancho * altura;
    var resultado = volumen * precioBase;

    document.getElementById('resultado').textContent = '$' + resultado;
}

$('#tingladoForm').on('submit', function(e) {
    e.preventDefault();
    var largo = $('#largo').val();
    var ancho = $('#ancho').val();
    var altura = $('#altura').val();
    var tipo_techo = $('#tipoTecho').val();
    var color = $('#color').val();
    var precio = $('#resultado').text().trim().substring(1);

    $.ajax({
        url: '../Controllers/ProductoController.php',
        method: 'POST',
        data: {
            funcion: 'crear_tinglado',
            largo: largo,
            ancho: ancho,
            altura: altura,
            tipo_techo: tipo_techo,
            color: color,
            precio: precio
        },
        success: function(response) {
            var data = JSON.parse(response);
            var id_producto = data.producto_id;
            alert(id_producto);
            agregar_tinglado(id_producto, precio);
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
});

function agregar_tinglado(id_producto, precio) {
    $.ajax({
        url: '../Controllers/Detalle_PedidoController.php',
        method: 'POST',
        data: {
            funcion: 'agregar_carrito_tinglado',
            id_producto: id_producto,
            cantidad: 1,
            precio: precio
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert('Error al agregar el tinglado al carrito');
            }
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
}