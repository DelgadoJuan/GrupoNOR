<?php
    ob_start(); // Activa el almacenamiento en búfer de salida
    session_start();
    include_once 'Layouts/Tienda/header.php';
    include_once '../Models/Detalle_Pedido.php';
    include '../Util/Config/config.php';

    $detalle_pedido = new Detalle_Pedido();
    $id_usuario = $_SESSION['id'];
    $cartItems = $detalle_pedido->obtenerDetallesPedido($id_usuario);

    $total = 0;

    // Verifica si el carrito está vacío
    if (empty($cartItems)) {
        echo "El carrito está vacío.";
    } else {
        foreach ($cartItems as $cartItem) {
            $total += floatval($cartItem->precio_unitario) * $cartItem->cantidad;
        }

        $costo_envio = isset($_SESSION['costo_envio']) ? floatval($_SESSION['costo_envio']) : 0;
        $total += $costo_envio;
    }

    ob_end_flush(); // Envía el contenido del búfer al cliente
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Carrito de compras</title>
        <style>
            .disabled {
                pointer-events: none; /* No permite clics */
                opacity: 0.5; /* Se ve deshabilitado */
                cursor: not-allowed; /* Cursor de no permitido */
            }
        </style>
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
                        <p id="cart-subtotal">Subtotal: $<span id="subtotalPrice">0</span></p>
                        <div>
                            <label for="direccion">Selecciona una dirección:</label>
                            <select id="direccion" name="direccion">
                                <!-- Las direcciones del usuario serán insertadas aquí por JavaScript -->
                            </select>
                        </div>
                        <p id="cart-shipping">Envío: $<span id="shippingPrice">0</span></p>
                        <p id="cart-total">Total: $<span id="totalPrice">0</span></p>
                    </div>
                    <a id="pagarButton" href="./pago.php" class="btn btn-primary" disabled>Ir a pagar</a>
                </div>
            </div>
        </div>
        <input type="hidden" id="precio_envio_km" value="<?php echo PRECIO_ENVIO_KM; ?>">
        <!-- Incluir jQuery y Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-U1qm3w7YKbDsjPniAzE7hlGcy3i4RkY&callback=initMap"></script>
        <!-- Incluir tu archivo JavaScript -->
        <script src="./carrito.js" type="module"></script>
    </body>
</html>

<?php
    include_once 'Layouts/Tienda/footer.php';
?>