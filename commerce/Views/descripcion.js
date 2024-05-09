$(document).ready(function(){
    var funcion;
    verificar_sesion();
    verificar_productos();

    function verificar_sesion() {
        funcion = 'verificar_sesion';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response) => {
            console.log(response);
            if(response != ''){
                let sesion = JSON.parse(response);
                $('#nav_login').hide();
                $('#nav_register').hide();
                $('#usuario_nav').text(sesion.user + ' #'+ sesion.id);
                $('#avatar_nav').attr('src', '../Util/Img/Users/' + sesion.avatar);
                $('#avatar_menu').attr('src', '../Util/Img/Users/' + sesion.avatar);
                $('#usuario_menu').text(sesion.user);
                $('#notificacion').show();
            }
            else{
                $('#nav_usuario').hide();
                $('#notificacion').hide();
            }
        });
    }

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
                            <img class="img-fluid" id="imagen_principal" src="../Util/Img/Producto/${producto.imagenes[0].nombre}">

                        </div>
                        <div class="col-12 product-image-thumbs">
                        `;
                        producto.imagenes.forEach(imagen => {
                            template +=`
                                <button prod_img="${imagen.nombre}" class="imagen_pasarelas product-image-thumb">
                                    <img src="../Util/Img/Producto/${imagen.nombre}">
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
                            <img class="product-image img-fluid" id="imagen_principal" src="../Util/Img/Producto/${producto.foto}">

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
                    location.href = '../index.php'; 
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
        $('#imagen_principal').attr('src', '../Util/Img/Producto/' + img);
    });

    
});

