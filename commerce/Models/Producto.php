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
        public function crear_producto($nombre, $descripcion, $cantidad_disponible, $imagen) {
            $sql = "INSERT INTO producto(nombre, descripcion, cantidad_disponible, imagen) 
                    VALUES(:nombre, :descripcion, :stock, :imagen)";
            $query = $this->acceso->prepare($sql); 
            $query->execute(array(':nombre'=>$nombre, ':descripcion'=>$descripcion, ':cantidad_disponible'=>$cantidad_disponible, ':imagen'=>$imagen));
        }

        function obtener_productos(){
            /*$sql ="SELECT * FROM producto";
            $query = $this->acceso->prepare($sql); 
            $query->execute(array());
            $this->objetos = $query->fetchAll();
            return $this->objetos; */

            $stmt = $db->query('SELECT * FROM producto');

            // Fetch all products and return them
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        }

        function obtener_producto($id){
            $sql ="SELECT * FROM producto WHERE id=:id";
            $query = $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }
        
        function actualizar_producto($id_producto,$nombre, $cantidad_disponible, $precio_unitario, $id_categoria, $nombre){
            if($nombre != ''){
                $sql ="UPDATE producto SET nombre=:nombre, cantidad_disponible=:cantidad_disponible, precio_unitario=:precio_unitario, id_categoria=:id_categoria, foto=:foto
                WHERE  id=:id_producto";
                $query = $this->acceso->prepare($sql); 
                $variables = array(
                ':id_producto'=>$id_producto,
                ':nombre'=>$nombre,
                ':cantidad_disponible'=>$cantidad_disponible,
                ':precio_unitario'=>$precio_unitario,
                ':id_categoria'=>$id_categoria,
                ':foto'=>$nombre
                );
                $query->execute($variables);
            }
            else{   
                $sql ="UPDATE producto SET nombre=:nombre, cantidad_disponible=:cantidad_disponible, precio_unitario=:precio_unitario, id_categoria=:id_categoria
                WHERE  id=:id_producto";
                $query = $this->acceso->prepare($sql); 
                $variables = array(
                    ':id_producto'=>$id_producto,
                    ':nombre'=>$nombre,
                    ':cantidad_disponible'=>$cantidad_disponible,
                    ':precio_unitario'=>$precio_unitario,
                    ':id_categoria'=>$id_categoria,
                );
                $query->execute($variables);
            }
        }

        public static function eliminar_producto($id) {
            $sql = "DELETE FROM producto WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id' => $id));
        }

        public static function existe($id) {
            // Conéctate a la base de datos
            $sql = "SELECT COUNT(*) FROM products WHERE id = :id";
            $query = $this->acceso->prepare($sql);
        
            // Prepara una consulta para verificar si existe un producto con el ID dado
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
        
            // Si el conteo es mayor que 0, el producto existe
            return $stmt->fetchColumn() > 0;
        }
    }