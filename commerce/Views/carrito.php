<?php
    ob_start(); // Activa el almacenamiento en búfer de salida
    session_start();
    include_once 'Layouts/Tienda/header.php';
    include_once '../Models/Pedido.php';
    include_once '../Models/Detalle_Pedido.php';
    include '../Util/Config/config.php';
    require_once '../Vendor/autoload.php';
    $access_token = 'APP_USR-8079791252941180-051509-311b7b8afba438b209fd53ff2b9ddc34-443110637';

    use MercadoPago\MercadoPagoConfig;
    use MercadoPago\Client\Preference\PreferenceClient;
    use MercadoPago\Client\Common\RequestOptions;
    use MercadoPago\Exceptions\MPApiException;
    MercadoPagoConfig::setAccessToken($access_token);
    MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

    $payment = isset($_GET['payment_id']) ? $_GET['payment_id'] : null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;
    $payment_type = isset($_GET['payment_type']) ? $_GET['payment_type'] : null;
    $order_id = isset($_GET['merchant_order_id']) ? $_GET['merchant_order_id'] : null;

    if ($status == 'approved') {
        $id_usuario = $_SESSION['id'];
        $fecha_registro = date('Y-m-d');
        switch($payment_type) {
            case 'credit_card':
                $metodo_pago = 'Credito';
                break;
            case 'debit_card':
                $metodo_pago = 'Debito';
                break;
            case 'account_money':
                $metodo_pago = 'Transferencia';
                break;
            default:
                $metodo_pago = 'Otro';
                break;
        }
        $total = null;
        $envio = null;
        $estado = 'Pendiente';
    
        $pedido = new Pedido();
        $idPedido = $pedido->crear_pedido($id_usuario, $fecha_registro, $total, $metodo_pago, $envio, $estado);

        $detalle_pedido = new Detalle_Pedido();
        $detalle_pedido->carritoComprado($id_usuario, $idPedido);

        header('Location: ../Views/tienda.php');
    } elseif ($status == 'rejected') {
        header('Location: ../Views/stock.php');
    }

    // Decodifica la respuesta JSON
    if(isset($_SESSION['carrito'])){
        $cartItems = $_SESSION['carrito'];
    
        // Prepara los ítems para la preferencia
        $items = [];
        foreach ($cartItems as $cartItem) {
            $item = [
                "title" => $cartItem['nombre_producto'],
                "quantity" => $cartItem['cantidad'],
                "currency_id" => "ARS", // Asegúrate de usar el código de moneda correcto
                "unit_price" => floatval($cartItem['precio'])
            ];
            $items[] = $item;
        }
    }

    $payerSession = $_SESSION['payer'];

    $payer = [
        "name" => $payerSession['nombre'],
        "surname" => $payerSession['apellido'],
        "email" => $payerSession['email'],
    ];

    // Prepara la solicitud de preferencia
    $request = [
        "items" => $items,
        "payer" => $payer,
        "back_urls" => [
            "success" => "https://1ef3-190-138-186-169.ngrok-free.app/GrupoNOR/commerce/Views/carrito.php",
            "failure" => "https://1ef3-190-138-186-169.ngrok-free.app/GrupoNOR/commerce/Views/stock.php"
        ],
        "statement_descriptor" => "NAME_DISPLAYED_IN_USER_BILLING",
        "payment_methods" => [
            "excluded_payment_types" => [],
            "installments" => 12
        ],
        "auto_return" => 'approved',
        "binary_mode" => true,
    ];

    // Crea la preferencia
    $client = new PreferenceClient();
    $request_options = new RequestOptions();
    $request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);
    try {
        $preference = $client->create($request, $request_options);
        echo "<script>var mercadoPagoUrl = '" . $preference->sandbox_init_point . "';</script>";
    } catch (MPApiException $e) {
        echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
        echo "Content: ";
        var_dump($e->getApiResponse()->getContent());
        echo "\n";
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

    ob_end_flush(); // Envía el contenido del búfer al cliente
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
                    <button class="boton-checkout"></button>
                </div>
            </div>
        </div>
        <input type="hidden" id="precio_envio_km" value="<?php echo PRECIO_ENVIO_KM; ?>">
        <div class="userData">
            <input type="hidden" id="nombre">
            <input type="hidden" id="apellido">
            <input type="hidden" id="email">
        </div>
        <div id="payment-form">
            <div id="cardNumber"></div>
            <div id="expirationDate"></div>
            <div id="securityCode"></div>
        </div>
        <!-- Incluir jQuery y Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script>
            // Agrega el SDK de Mercado Pago a tu sitio
            const mp = new MercadoPago('APP_USR-4e8da460-15bc-44db-9c85-9499cb177226', {
                locale: 'es-AR'
            });

            // Inicializa el checkout
            mp.checkout({
                preference: {
                    id: '<?php echo $preference->id ?>',
                    redirectMode: 'modal',
                },
                render: {
                    container: '.boton-checkout',  // Indica dónde se mostrará el botón
                    label: 'Pagar',  // Cambia el texto del botón
                }
            });

        </script>
        <!-- Incluir tu archivo JavaScript -->
        <script src="./carrito.js" type="module"></script>
    </body>
</html>

<?php
    include_once 'Layouts/Tienda/footer.php';
?>

<script type="module">
    import { initCarrito } from './carrito.js';
    initCarrito();
</script>