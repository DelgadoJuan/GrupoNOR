<?php
//llamamos a la conexion de la bd
    include_once 'Conexion.php';
    class Producto{
        var $objetos;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }

        //consultas a la bd
        public function crear_producto($nombre, $id_categoria, $descripcion, $precio_unitario, $cantidad_disponible, $fecha_registro, $sector, $costo_unidad, $foto = null) {
            $this->acceso->beginTransaction();
            try {
                if ($foto) {
                    $sql = "INSERT INTO producto(nombre, id_categoria, descripcion, precio_unitario, cantidad_disponible, fecha_registro, sector, costo_unidad, foto) 
                            VALUES(:nombre, :id_categoria, :descripcion, :precio_unitario, :cantidad_disponible, :fecha_registro, :sector, :costo_unidad, :foto)";
                    $query = $this->acceso->prepare($sql); 
                    $query->execute(array(':nombre'=>$nombre, ':id_categoria'=>$id_categoria, ':descripcion'=>$descripcion, ':precio_unitario'=>$precio_unitario, ':cantidad_disponible'=>$cantidad_disponible, ':fecha_registro'=>$fecha_registro, ':sector'=>$sector, ':costo_unidad'=>$costo_unidad, ':foto'=>$foto));
                } else {
                    $sql = "INSERT INTO producto(nombre, id_categoria, descripcion, precio_unitario, cantidad_disponible, fecha_registro, sector, costo_unidad) 
                            VALUES(:nombre, :id_categoria, :descripcion, :precio_unitario, :cantidad_disponible, :fecha_registro, :sector, :costo_unidad)";
                    $query = $this->acceso->prepare($sql); 
                    $query->execute(array(':nombre'=>$nombre, ':id_categoria'=>$id_categoria, ':descripcion'=>$descripcion, ':precio_unitario'=>$precio_unitario, ':cantidad_disponible'=>$cantidad_disponible, ':fecha_registro'=>$fecha_registro, ':sector'=>$sector, ':costo_unidad'=>$costo_unidad));
                }
                $id_producto = $this->acceso->lastInsertId();
                $this->acceso->commit();
                return $id_producto;
            } catch (Exception $e) {
                $this->acceso->rollBack();
                throw $e;
            }
        }

        public function obtener_productos(){

            $sql ="SELECT p.id, p.nombre, p.descripcion, p.precio_unitario, p.fecha_registro, p.fecha_actualizacion, p.costo_unidad, p.cantidad_disponible, p.sector, p.estado, c.nombre AS nombre_categoria 
            FROM producto p 
            INNER JOIN categoria c ON p.id_categoria = c.id";
            $query = $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }

        public function obtener_producto($id){
            $sql ="SELECT * FROM producto WHERE id=:id";
            $query = $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }

        public function modificar_cantidad_disponible($id, $cantidad) {
            $sql = "UPDATE producto SET cantidad_disponible = :cantidad WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id, ':cantidad'=>$cantidad));
        }
        
        public function editar_producto($id, $nombre, $id_categoria, $descripcion, $cantidad_disponible, $precio_unitario, $fecha_actualizacion, $sector, $costo_unidad, $foto = null) {
            if ($foto) {
                $sql = "UPDATE producto SET nombre = :nombre, id_categoria = :id_categoria, descripcion = :descripcion, cantidad_disponible = :cantidad_disponible, precio_unitario = :precio_unitario, fecha_actualizacion = :fecha_actualizacion, sector = :sector, costo_unidad = :costo_unidad, foto = :foto WHERE id = :id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id' => $id, ':nombre' => $nombre, ':id_categoria' => $id_categoria, ':descripcion' => $descripcion, ':cantidad_disponible' => $cantidad_disponible, ':precio_unitario' => $precio_unitario, ':fecha_actualizacion' => $fecha_actualizacion, ':sector' => $sector, ':costo_unidad' => $costo_unidad, ':foto' => $foto));
            } else {
                $sql = "UPDATE producto SET nombre = :nombre, id_categoria = :id_categoria, descripcion = :descripcion, cantidad_disponible = :cantidad_disponible, precio_unitario = :precio_unitario, fecha_actualizacion = :fecha_actualizacion, sector = :sector, costo_unidad = :costo_unidad WHERE id = :id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id' => $id, ':nombre' => $nombre, ':id_categoria' => $id_categoria, ':descripcion' => $descripcion, ':cantidad_disponible' => $cantidad_disponible, ':precio_unitario' => $precio_unitario, ':fecha_actualizacion' => $fecha_actualizacion, ':sector' => $sector, ':costo_unidad' => $costo_unidad));
            }
        }

        public function eliminar_producto($id) {
            $sql = "DELETE FROM producto WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }

        public function existe($id) {
            $sql = "SELECT COUNT(*) FROM producto WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
            return $query->fetchColumn() > 0;
        }

        public function obtener_fotos($id_producto) {
            // Prepara la consulta SQL
            $sql = "SELECT * FROM imagen WHERE id_producto = :id_producto";
            $query = $this->acceso->prepare($sql);
            // Ejecuta la consulta con el id_producto como parámetro
            $query->execute([':id_producto' => $id_producto]);
            // Obtiene todas las filas que coinciden con la consulta
            $fotos = $query->fetchAll(PDO::FETCH_ASSOC);
            // Devuelve las fotos
            return $fotos;
        }

        public function agregar_imagen($id_producto, $nombre) {
            $sql = "INSERT INTO imagen (id_producto, nombre) VALUES (:id_producto, :nombre)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_producto' => $id_producto, ':nombre' => $nombre));
        }

        public function eliminar_foto($id) {
            $sql = "DELETE FROM imagen WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }

        public function obtener_ruta($id) {
            $sql = "SELECT nombre FROM imagen WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }

        public function existe_imagen($id) {
            $sql = "SELECT COUNT(*) FROM imagen WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
            return $query->fetchColumn() > 0;
        }

        public function activar_producto($id) {
            $sql = "UPDATE producto SET estado = 'A' WHERE id = :id";
            $stmt = $this->acceso->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        
        public function desactivar_producto($id) {
            $sql = "UPDATE producto SET estado = 'I' WHERE id = :id";
            $stmt = $this->acceso->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        
    }