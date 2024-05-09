$(document).ready(function () {
    template = '';

    $(document).on('click', '.agregar-carrito', function(e){
        const elemento = $(this).parent();
        const id = elemento.attr('prod_id');
        const nombre = elemento.attr('nombre_prod');
        const precio = elemento.attr('precio_prod');
        const producto={
            id: id,
            nombre: nombre,
            precio: precio,
        }
        template+=`
            <tr>
                <td>${producto.id}</td>
                <td>${producto.nombre}</td>
                <td>${producto.precio}</td>
                <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
            </tr>
        `;
        $('#lista').html(template);
    })

});