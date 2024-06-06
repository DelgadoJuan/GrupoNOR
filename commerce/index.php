<?php
    include_once 'Views/Layouts/header.php';
?>

    <title>Home</title>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Home</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <style>
      .descripcion_producto{
        color: #000:
      }
      .descripcion_producto:visited{
        color: #000;
      }
      .descripcion_producto:focus{
        border-bottom: 1px solid;
      }
      .descripcion_producto:hover{
        border-bottom: 1px solid;
      }
    </style>

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
                      <img src="Util/Img/perfil_negro.jpg" alt="perfil" class="img-fluid">
                    </div>
                    <div class="col-sm-12">
                      <span class="card-title float-left">Perfil negro</span></br>
                      <a href="#" class="float-left descripcion_producto">Descripcion del producto</a></br>
                      <span class="badge bg-success">Envio gratis</span></br>
                      <span class="text-muted" style="text-decoration: line-through">$ 50000</span>
                      <h4 class="mb-0">$ 35000</h4>
                      <a href="#"><i class="fas fa-shopping-cart"></i></a>
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
    include_once 'Views/Layouts/footer.php';
?>
<!-- Js del index -->
<script src="index.js"></script>