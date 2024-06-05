import { verificar_sesion } from "./sesion.js";

$(document).ready(function() {
    verificar_sesion();
});

document.getElementById('largo').addEventListener('input', function() {
    validarMedida('largo', 5, 30);
    document.getElementById('tingladoForm').reportValidity();
    calcular();
});

document.getElementById('ancho').addEventListener('input', function() {
    validarMedida('ancho', 5, 30);
    document.getElementById('tingladoForm').reportValidity();
    calcular();
});

function validarMedida(idCampo, minimo, maximo) {
    var campo = document.getElementById(idCampo);
    var valor = parseFloat(campo.value);

    if (isNaN(valor) || valor < minimo || valor > maximo) {
        campo.setCustomValidity('El valor debe estar entre ' + minimo + ' y ' + maximo + '.');
    } else {
        campo.setCustomValidity('');
    }
}

function calcular() {
    var largo = document.getElementById('largo').value;
    var ancho = document.getElementById('ancho').value;
    var precioBase = document.getElementById('precioBase').value;
    var precio_mayor_12 = document.getElementById('precioMayor12').value;
    var precio_mayor_15 = document.getElementById('precioMayor15').value;

    var volumen = largo * ancho;
    var precio;

    // Definir los precios según el ancho del tinglado
    if (ancho <= 12) {
        precio = precioBase;
    } else if (ancho <= 15) {
        precio = precio_mayor_12;
    } else {
        precio = precio_mayor_15;
    }

    var resultado = volumen * precio;
    document.getElementById('resultado').textContent = '$' + resultado;
}

$('#tingladoForm').on('submit', function(e) {
    e.preventDefault();
    var largo = $('#largo').val();
    var ancho = $('#ancho').val();
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