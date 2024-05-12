<?php
include_once '../Models/Detalle_Pedido.php';
include '../Util/Config/config.php';
//esta variable esta siendo instanciada en Producto.php y a la vez en Conexion.php
$detalle_pedido = new Detalle_Pedido();
//sirve para saber cuando el usuario entra en su sesion
session_start();

    if($_POST['funcion']=='agregar_carrito'){
        $id_producto =openssl_decrypt($_SESSION['product-verification'], CODE, KEY);
        $cantidad = $_POST['cantidad'];
        $precio = floatval($_POST['precio']); // Convert the price to a float
        $id_usuario = $_SESSION['id'];
        $detalle_pedido->agregarDetallePedido(null, $id_producto, $cantidad, $precio, $id_usuario);
        echo json_encode(['message' => 'Producto agregado al carrito', 'status' => 'success']);
    }

    if($_POST['funcion']=='obtener_carrito'){
        $id_usuario = $_SESSION['id'];
        $detalle_pedido->obtenerDetallesPedido($id_usuario);
        $json=array();
        foreach($detalle_pedido->objetos as $objeto){
            $json[]=array(
                'id'=>$objeto->id,
                'nombre_producto'=>$objeto->nombre_producto,
                'foto'=>$objeto->producto_foto, // 
                'id_producto'=>$objeto->id_producto,
                'cantidad'=>$objeto->cantidad,
                'precio'=>$objeto->precio_unitario
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    if($_POST['funcion']=='eliminar_carrito'){
        $id_detalle_pedido = $_POST['id_detalle_pedido'];
        $detalle_pedido->eliminarDetallePedido($id_detalle_pedido);
        echo json_encode(['message' => 'Producto eliminado del carrito', 'status' => 'success']);
    }

    if ($_POST['funcion'] == 'cambiar_cantidad') {
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];
    
        $detalle_pedido = new Detalle_Pedido();
        $detalle_pedido->cambiarCantidad($id, $cantidad);
    }