<?php
    include_once('Layouts/Tienda/header.php');
?>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Productos</h3>
        </div>
        <select id="sortSelect" class="form-control">
            <option value="">Ordenar por</option>
            <option value="precio_ascendente">Precio: menor a mayor</option>
            <option value="precio_descendente">Precio: mayor a menor</option>
            <option value="nombre_ascendente">Nombre: A - Z</option>
            <option value="nombre_descendiente">Nombre: Z - A</option>
            <option value="mas_vendido">Más vendido</option>
            <option value="nuevo">Más nuevo a más viejo</option>
            <option value="viejo">Más viejo a más nuevo</option>
        </select>
        <div class="card-body">
          <div id="productos" class="row">
            <!-- cards-->
            <div class="col-sm-2">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <img src="../Util/Img/perfil_negro.jpg" alt="perfil" class="img-fluid">
                    </div>
                    <div class="col-sm-12">
                      <!-- Se añaden los productos mediante JS -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end cards -->
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button id="loadMoreButton" class="btn btn-primary">Cargar más</button>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
<?php
    include_once('Layouts/Tienda/footer.php');
?>

<!-- Js del index -->
<script src="./tienda.js" type="module"></script>
