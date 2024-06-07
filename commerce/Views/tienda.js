import { verificar_sesion } from "./sesion.js";

$(document).ready(function() {
    var funcion;
    let limit = 20;

    verificar_sesion();
    obtenerCategorias();

    let urlParams = new URLSearchParams(window.location.search);
    let id_categoria = urlParams.get('id');
    llenar_productos(id_categoria, 'mas_vendido', null);

    async function llenar_productos(id_categoria = null, sortValue = null, searchValue = null){
        funcion = "llenar_productos";
        let body = 'funcion=' + funcion + '&limit=' + limit;
        let urlSegments = window.location.href.split('/');
        let urlBase;

        if (urlSegments[urlSegments.length - 2] === 'tienda.php') {
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

        if (searchValue !== null) {
            body += '&searchValue=' + searchValue;
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
                    //let fotoUrl = id_categoria !== null ? `../${producto.foto}` : producto.foto;
                    template+= ` 
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
        var sortValue = document.getElementById('sortSelect').value;
        var searchInput = document.getElementById('inputSearch');
        var searchValue = searchInput ? searchInput.value : null;
        llenar_productos(id_categoria, sortValue, searchValue);
    });

    document.getElementById('sortSelect').addEventListener('change', function() {
        var searchInput = document.getElementById('inputSearch');
        var searchValue = searchInput ? searchInput.value : null;
        console.log(id_categoria);
        llenar_productos(id_categoria, this.value, searchValue);
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
    
                navbarHtml += '<li class="nav-item"><a href="./calculadora.php" class="nav-link">Cotización</a></li>';
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
                    id_categoria = $this.data('id');
                    let nombre_categoria = $this.text();
                    limit = 20; // Resetear el límite
    
                    // Cambiar la URL
                    let base_url = window.location.origin + window.location.pathname;
                    let nuevaUrl = new URL(base_url);
                    nuevaUrl.searchParams.set('nombre', nombre_categoria);
                    nuevaUrl.searchParams.set('id', id_categoria);
                    history.pushState({id_categoria: id_categoria}, '', nuevaUrl.toString());
                    llenar_productos(id_categoria, 'mas_vendido');
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

    urlParams = new URLSearchParams(window.location.search);
    id_categoria = urlParams.get('id');
    if(id_categoria){
        var searchValue = $(this).find('input[name="search"]').val();
        var sortValue = $('#sortSelect').val();
        llenar_productos(id_categoria, sortValue, searchValue);
    }

    // Add event listener to the search form
    $('#searchForm').on('submit', function(e) {
        // Prevent the form from submitting normally
        e.preventDefault();

        // Get the search value
        var searchValue = $(this).find('input[name="search"]').val();
        var sortValue = $('#sortSelect').val();
        
        // Send AJAX request to the server with the search value
        llenar_productos(null, sortValue, searchValue);
    });


});