import { verificar_sesion } from "./sesion.js";

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

$(document).ready(function(){
    var funcion;
    verificar_sesion();
    verificar_productos();

    async function verificar_productos(){
        funcion = "verificar_productos";
        let data = await fetch('../Controllers/ProductoController.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'funcion=' + funcion
        })
        if(data.ok){
            let response = await data.text();
            try {
                let producto = JSON.parse(response);
                //console.log(producto);
                let template ='';
                let template2 ='';
                if (producto.imagenes.length > 0) {
                    template += `
                        <div "></div>
                        <div class="col-12">
                            <img class="img-fluid" id="imagen_principal" src="${producto.foto}">

                        </div>
                        <div class="col-12 product-image-thumbs">
                        <button prod_img="${producto.foto}" class="imagen_pasarelas product-image-thumb">
                            <img src="${producto.foto}">
                        </button>
                        `;
                        producto.imagenes.forEach(imagen => {
                            template +=`
                                <button prod_img="${imagen.nombre}" class="imagen_pasarelas product-image-thumb">
                                    <img src="${imagen.nombre}">
                                </button>
                            ` ;
                        });
                    template += `
                        </div>
                    `;
                }
                else{
                    template += `
                        <div class="col-12">
                            <img class="product-image img-fluid" id="imagen_principal" src="${producto.foto}">

                        </div>
                        `;
                }

                for (let i = 1; i <= producto.stock; i++) {
                    template2 += `
                        <option value='${i}'>${i}</option>
                    `;
                }

                let template3 = ` 
                <div prod_id="${producto.id}" nombre_prod="${producto.nombre}" precio_prod="${producto.precio}" class="input-group mb-3 card-footer">                   
                    <button class="agregar-carrito btn btn-primary btn-flat">
                        <i class="fas fa-cart-plus fa-lg mr-2"></i>
                        Agregar al carrito
                    </button>                            
                </div>
                `;

                
                
                $('#btn-carrito').html(template3);
                $('#imagenes').html(template);
                $('#id_producto').text(producto.nombre + " #" + producto.id);
                $('#precio_producto').text("$ "+producto.precio);
                $('#product-desc').text(producto.descripcion);
                $('#nombre_producto').text(producto.nombre);

                
            } catch (error) {
                console.error(error);
                console.log("La respuesta del servidor no es un JSON válido:", response);
                if(response == 'error'){
                    location.href = './tienda.php'; 
                }

            }
        }
        else{
            Swal.fire({
                icon: "error",
                title: data.statusText,
                text: "Hubo conflicto de codigo: " + data.status,
            });
        }

        
    }

    $(document).on('click', '.imagen_pasarelas', (e)=>{
        let elemento = $(this)[0].activeElement;
        let img = $(elemento).attr('prod_img');
        $('#imagen_principal').attr('src', img);
    });

    
});

$('#btn-carrito').click(function() {
    var id_producto = $('#id_producto').text();
    var cantidad = $('#product_quantity').val();
    var precio = $('#precio_producto').text().trim().substring(2); 

    agregar_carrito(id_producto, cantidad, precio);
});
