import { verificar_sesion } from "./sesion.js";

//aqui vamos a aplicar js al index 
$(document).ready(function() {
    var funcion;

    //funcion para verificar si existe una sesion abierta
    verificar_sesion();
    llenar_productos();
    obtenerCategorias();

    //funcion para traer los productos
    async function llenar_productos(categoria = null){
        funcion = "llenar_productos";
        let body = 'funcion=' + funcion;
        if (categoria !== null) {
            body += '&id_categoria=' + categoria;
        }
        let data = await fetch('../Controllers/ProductoController.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: body
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
                                    <img src="${producto.foto}" alt="perfil" class="img-fluid">
                                </div>
                                <div class="col-sm-12">
                                    <span class="card-title float-left">${producto.nombre}</span></br></br>
                                    <a href="../Views/descripcion.php?name=${encodeURIComponent(producto.nombre)}&id=${encodeURIComponent(producto.id)}" class="float-left descripcion_producto">Descripcion del producto</a></br></br>
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

    //funcion para obtener las categorias
function obtenerCategorias() {
    $.ajax({
        url: '../Controllers/CategoriaController.php',
        method: 'POST',
        data: {
            funcion: 'obtener_categorias_activas'
        },
        success: function(response) {
            var categorias = JSON.parse(response);
            var groupedCategorias = {};
            categorias.forEach(function(categoria) {
                if (!groupedCategorias[categoria.nombre]) {
                    groupedCategorias[categoria.nombre] = {
                        nombre: categoria.nombre,
                        subcategorias: []
                    };
                }
                if (categoria.nombre_subcategoria) {
                    groupedCategorias[categoria.nombre].subcategorias.push(categoria.nombre_subcategoria);
                }
            });

            var navbarHtml = '';
            for (var nombre in groupedCategorias) {
                var categoria = groupedCategorias[nombre];
                if (categoria.subcategorias.length > 0) {
                    navbarHtml += '<li class="nav-item dropdown">';
                    navbarHtml += '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                } else {
                    navbarHtml += '<li class="nav-item">';
                    navbarHtml += '<a class="nav-link" href="#" id="navbarDropdown" role="button">';
                }
                navbarHtml += categoria.nombre;
                navbarHtml += '</a>';
                if (categoria.subcategorias.length > 0) {
                    navbarHtml += '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    categoria.subcategorias.forEach(function(subcategoria) {
                        navbarHtml += '<a class="dropdown-item" href="#">' + subcategoria + '</a>';
                    });
                    navbarHtml += '</div>';
                }
                navbarHtml += '</li>';
            }
            $('#categorias').html(navbarHtml);

            // Agregar evento click a cada categoría
            $('#categorias .nav-item').on('click', function() {
                var categoria = $(this).text();
                llenar_productos(categoria);
            });
        },
        error: function() {
            alert('Error al realizar la solicitud AJAX');
        }
    });
}

});