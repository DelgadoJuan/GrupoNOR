<?php
    include_once 'Layouts/General/header.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Carrito de compras</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1>Carrito de compras</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <!-- Los productos del carrito serán insertados aquí por JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <h2>Resumen del carrito</h2>
                    <div id="cart-summary">
                        <!-- El resumen del carrito será insertado aquí por JavaScript -->
                    </div>
                    <button id="checkout-button" class="btn btn-primary btn-block">Pagar</button>
                </div>
            </div>
        </div>
        <!-- Incluir jQuery y Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Incluir tu archivo JavaScript -->
        <script src="./carrito.js" type="module"></script>
    </body>
</html>

<?php
    include_once 'Layouts/General/footer.php';
?>