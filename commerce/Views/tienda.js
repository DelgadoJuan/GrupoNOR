import { verificar_sesion } from "./sesion.js";

$(document).ready(function() {
    var funcion;
    let limit = 20;

    verificar_sesion();
    let urlSegments = window.location.href.split('/');
    let id_categoria = urlSegments[urlSegments.length - 1] === 'tienda' ? null : urlSegments[urlSegments.length - 1];
    llenar_productos(id_categoria, 'mas_vendido');
    obtenerCategorias();

    async function llenar_productos(id_categoria = null, searchValue = null, sortValue = null){
        funcion = "llenar_productos";
        let body = 'funcion=' + funcion + '&limit=' + limit;
        let urlSegments = window.location.href.split('/');
        let urlBase;

        if (urlSegments[urlSegments.length - 2] === 'tienda') {
            // If the current URL does not contain a category
            urlBase = urlSegments.slice(0, -3).join('/');
        } else {
            // If the current URL contains a category
            urlBase = urlSegments.slice(0, -2).join('/');
        }

        if (id_categoria !== null) {
            body += '&id_categoria=' + id_categoria;
        }

        if (sortValue !== null) {
            body += '&sortValue=' + sortValue;
        }

        let url = `${urlBase}/Controllers/ProductoController.php`;
        let data = await fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: body
        })
        if(data.ok){
            let response = await data.text();
            try {
                let productos = JSON.parse(response);
                let template = '';
                productos.forEach(producto => {
                    // Si la categoría no es null, agregarla a la URL de la imagen
                    let fotoUrl = id_categoria !== null ? `../${producto.foto}` : producto.foto;
                    template+= ` 
                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-sm-12">
                                    <img src="${fotoUrl}" alt="perfil" class="img-fluid">
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
                    `;
                });
                $('#productos').html(template);

                if (productos.length < limit) {
                    document.getElementById('loadMoreButton').style.display = 'none';
                } else {
                    document.getElementById('loadMoreButton').style.display = 'block';
                }

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

    document.getElementById('loadMoreButton').addEventListener('click', function() {
        limit += 20;
        llenar_productos(id_categoria);
    });

    document.getElementById('sortSelect').addEventListener('change', function() {
        llenar_productos(id_categoria, null, this.value);
    });

    function obtenerCategorias() {
        $.ajax({
            url: '../Controllers/CategoriaController.php',
            method: 'POST',
            data: {
                funcion: 'obtener_categorias_activas'
            },
            success: function(response) {
                var categorias = JSON.parse(response);
                var navbarHtml = '';
    
                function generateCategoryHtml(categoria, isSubcategory = false) {
                    var html = '';
                    if (isSubcategory) {
                        html += '<li class="dropdown-submenu"><a href="#" class="dropdown-item subcategoria" data-id="' + categoria.id + '">' + categoria.nombre + '</a>';
                    } else {
                        html += '<li class="nav-item dropdown">';
                        html += '<a href="#" class="nav-link categoria ' + ((categoria.subcategorias && categoria.subcategorias.length > 0) ? 'dropdown-toggle' : '') + '" role="button" aria-haspopup="true" aria-expanded="false" data-id="' + categoria.id + '">';
                        html += categoria.nombre;
                        html += '</a>';
                    }
    
                    if (categoria.subcategorias && categoria.subcategorias.length > 0) {
                        html += '<ul class="dropdown-menu">';
                        categoria.subcategorias.forEach(function(subcategoria) {
                            html += generateCategoryHtml(subcategoria, true);
                        });
                        html += '</ul>';
                    }
                    html += '</li>';
                    return html;
                }
    
                categorias.forEach(function(categoria) {
                    navbarHtml += generateCategoryHtml(categoria, false);
                });
    
                $('#categorias').html(navbarHtml);
    
                function handleItemClick(event) {
                    event.preventDefault();
                    let $this = $(this);
                    let id_categoria = $this.data('id');
                    let nombre_categoria = $this.text();
                    limit = 20; // Resetear el límite
                    llenar_productos(id_categoria);
    
                    // Cambiar la URL
                    let base_url = window.location.origin + window.location.pathname;
                    let nuevaUrl = '';
                    if (base_url.endsWith('tienda')) {
                        nuevaUrl = base_url + '/' + nombre_categoria;
                    } else {
                        nuevaUrl = base_url.replace(/\/[^\/]*$/, '/') + nombre_categoria;
                    }
                    history.pushState({id_categoria: id_categoria}, '', nuevaUrl);
                }
    
                function handleMouseEnter() {
                    $(this).children('.dropdown-menu').stop(true, true).slideDown();
                }
    
                function handleMouseLeave() {
                    $(this).children('.dropdown-menu').stop(true, true).slideUp();
                }
    
                $('#categorias').off('click', '.categoria, .subcategoria', handleItemClick);
                $('#categorias').off('mouseenter', '.nav-item', handleMouseEnter);
                $('#categorias').off('mouseleave', '.nav-item', handleMouseLeave);
    
                $('#categorias').on('click', '.categoria, .subcategoria', handleItemClick);
                $('#categorias').on('mouseenter', '.nav-item', handleMouseEnter);
                $('#categorias').on('mouseleave', '.nav-item', handleMouseLeave);
            },
            error: function() {
                alert('Error al realizar la solicitud AJAX');
            }
        });
    }
});