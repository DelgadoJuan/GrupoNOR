//aqui vamos a aplicar js al index 
$(document).ready(function() {
    var funcion;

    //funcion para verificar si existe una sesion abierta
    verificar_sesion();
    llenar_productos();
    function verificar_sesion() {
        funcion = 'verificar_sesion';
        $.post('Controllers/UsuarioController.php', {funcion}, (response) => {
            console.log(response);
            if(response != ''){
                let sesion = JSON.parse(response);
                $('#nav_login').hide();
                $('#nav_register').hide();
                $('#usuario_nav').text(sesion.user + ' #'+ sesion.id);
                $('#avatar_nav').attr('src', 'Util/Img/Users/' + sesion.avatar);
                $('#avatar_menu').attr('src', 'Util/Img/Users/' + sesion.avatar);
                $('#usuario_menu').text(sesion.user);
                $('#notificacion').show();
            }
            else{
                $('#nav_usuario').hide();
                $('#notificacion').hide();
            }
        });
    }

    //funcion para traer los productos

    async function llenar_productos(){
        funcion = "llenar_productos";
        let data = await fetch('Controllers/ProductoController.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'funcion=' + funcion
        })
        if(data.ok){
            let response = await data.text();
            try {
                let productos = JSON.parse(response);
                //console.log(productos);
                let template = '';
                productos.forEach(producto => {
                    template+= ` 
                    <!-- cards-->
                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-sm-12">
                                    <img src="Util/Img/Producto/${producto.foto}" alt="perfil" class="img-fluid">
                                </div>
                                <div class="col-sm-12">
                                    <span class="card-title float-left">${producto.nombre}</span></br></br>
                                    <a href="Views/descripcion.php?name=${producto.nombre}&&id=${producto.id}" class="float-left descripcion_producto">Descripcion del producto</a></br></br>
                                    <h4 class="mb-0 float-left">$ ${producto.precio}</h4></br></br>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- end cards -->
                    `;
                });
                $('#productos').html(template);
            } catch (error) {
                console.error(error);
                console.log(response);
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
});