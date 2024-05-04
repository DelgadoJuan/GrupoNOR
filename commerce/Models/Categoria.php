<?php
//llamamos a la conexion de la bd
    include_once 'Conexion.php';
    class Categoria{
        var $objetos;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }

        function obtener_categorias() {
            $sql = "SELECT * FROM categoria";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }
    
        function agregarCategoria($nombre, $id_padre, $fecha_creacion, $descripcion) {
            $sql = "INSERT INTO categoria(nombre, id_padre, fecha_creacion, descripcion) VALUES(:nombre, :id_padre, :fecha_creacion, :descripcion)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre' => $nombre, ':id_padre' => $id_padre, ':fecha_creacion' => $fecha_creacion, ':descripcion' => $descripcion));
        }
    
        function existe_categoria($id) {
            $sql = "SELECT id FROM categoria WHERE id=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
            $this->objetos = $query->fetchAll();
            return (bool) $this->objetos;
        }
    
        function editar_categoria($id, $nombre, $id_padre, $descripcion) {
            $sql = "UPDATE categoria SET nombre=:nombre, id_padre=:id_padre, descripcion=:descripcion WHERE id=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id, ':nombre' => $nombre, ':id_padre' => $id_padre, ':descripcion' => $descripcion));
        }
    
        function eliminar_categoria($id) {
            $sql = "DELETE FROM categoria WHERE id=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }
    
        function activar_categoria($id) {
            $sql = "UPDATE categoria SET activo=1 WHERE id=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }
    
        function desactivar_categoria($id) {
            $sql = "UPDATE categoria SET activo=0 WHERE id=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }
    }

