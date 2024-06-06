<?php
include_once '../Models/Pedido.php';
include '../Util/Config/config.php';
//esta variable esta siendo instanciada en Producto.php y a la vez en Conexion.php
$producto = new Producto();
//sirve para saber cuando el usuario entra en su sesion
session_start();

    if($_POST['funcion']=='crear_pedido'){
        $id_usuario = $_SESSION['id_usuario'];
        $fecha_registro = date('Y-m-d');
        $total = $_POST['total'];
        $metodo_pago = $_POST['metodo_pago'];
        $envio = $_POST['envio'];
        $estado = 'Pendiente';
        $pedido = new Pedido();
        $idPedido = $pedido->crear_pedido($id_usuario, $fecha_registro, $total, $metodo_pago, $envio, $estado);
        echo json_encode(['message' => 'Pedido creado', 'status' => 'success', 'idPedido' => $idPedido]);
    }