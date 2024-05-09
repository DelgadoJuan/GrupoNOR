<?php

include_once 'Conexion.php';
class Detalle_pedido{
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    
}

