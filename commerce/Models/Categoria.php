<?php
//llamamos a la conexion de la bd
    include_once 'Conexion.php';
    class Categoria{
        var $objetos;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }

        function obtener_categorias($ordenar_por = null, $nombre = null, $direccion = 'ASC') {
            $sql = "SELECT c.id, c.nombre, c.id_padre, c.fecha_creacion, c.descripcion, c.estado, cp.nombre as nombre_padre FROM categoria as c LEFT JOIN categoria as cp ON c.id_padre=cp.id";
            $params = [];
            if ($nombre) {
                $sql .= " WHERE c.nombre LIKE :nombre";
                $params[':nombre'] = '%' . $nombre . '%';
            }
            if ($ordenar_por) {
                $sql .= " ORDER BY " . $ordenar_por . " " . $direccion;
            }
            $query = $this->acceso->prepare($sql);
            $query->execute($params);
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
            $sql = "UPDATE categoria SET estado='A' WHERE id=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }
    
        function desactivar_categoria($id) {
            $sql = "UPDATE categoria SET estado='I' WHERE id=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }

        function obtener_categorias_activas() {
            $sql = "SELECT c1.id, c1.nombre, c2.nombre AS nombre_subcategoria
                    FROM categoria c1
                    LEFT JOIN categoria c2 ON c1.id = c2.id_padre
                    WHERE c1.estado='A' AND (c2.estado='A' OR c2.estado IS NULL) AND c1.id_padre IS NULL
                    ORDER BY c1.nombre";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }

    }

