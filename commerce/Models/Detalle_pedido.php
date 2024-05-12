<?php

include_once 'Conexion.php';
class Detalle_pedido{
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    // Funcion para obtener el carrito del usuario
    function obtenerDetallesPedido($id_usuario){
        $sql = "SELECT detalles_pedido.*, producto.nombre AS nombre_producto, producto.foto AS producto_foto 
            FROM detalles_pedido 
            INNER JOIN producto ON detalles_pedido.id_producto = producto.id 
            WHERE detalles_pedido.id_usuario=:id_usuario AND detalles_pedido.id_pedido IS NULL";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario'=>$id_usuario));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function agregarDetallePedido($id_pedido, $id_producto, $cantidad, $precio_unitario, $id_usuario){
        $precio_unitario = floatval($precio_unitario); // Convert the price to a float
        $sql = "INSERT INTO detalles_pedido (id_pedido, id_producto, id_usuario, cantidad, precio_unitario) VALUES (:id_pedido, :id_producto, :id_usuario, :cantidad, :precio_unitario)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_pedido'=>$id_pedido, ':id_producto'=>$id_producto, ':id_usuario'=>$id_usuario,':cantidad'=>$cantidad, ':precio_unitario'=>$precio_unitario));
    }

    public function cambiarCantidad($id, $cantidad) {
        $sql = "UPDATE detalles_pedido SET cantidad = :cantidad WHERE id = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':cantidad'=>$cantidad, ':id'=>$id));
    }
    
    public function eliminarDetallePedido($id_detalle_pedido) {
        $sql = "DELETE FROM detalles_pedido WHERE id = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_detalle_pedido));
    }
    
}

