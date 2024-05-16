<?php
    include_once('Layouts/Tienda/header.php');
    $categoria = null;
    $path = explode('/', $_SERVER['REQUEST_URI']);
    if (count($path) > 2) {
        $categoria = $path[2];
    }
?>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Productos</h3>
        </div>

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
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
    <?php
    include_once('Layouts/Tienda/footer.php');
    if ($categoria) {
?>
      <script src="/tienda.js" type="module"></script>
<?php
    }
?>
<!-- Js del index -->
<script src="./tienda.js" type="module"></script>
