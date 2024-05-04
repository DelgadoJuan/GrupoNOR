<?php
include_once '../Models/Producto.php';
include '../Util/Config/config.php';
//esta variable esta siendo instanciada en Producto.php y a la vez en Conexion.php
$producto = new Producto();
//sirve para saber cuando el usuario entra en su sesion
session_start();

    if($_POST['funcion']=='eliminar_producto'){
        $id = $_POST['id'];
        // Verifica si el producto existe
        if (!$producto->existe($id)) {
            // Si el producto no existe, maneja este caso de error (por ejemplo, mostrando un mensaje de error al usuario)
            echo json_encode(['message' => 'El producto no existe', 'status' => 'error']);
            return;
        }

        // Si el producto existe, procede a eliminarlo
        $producto->eliminar_producto($id);

        // Devuelve un mensaje de éxito
        echo json_encode(['message' => 'Producto eliminado', 'status' => 'success']);
    }

    if($_POST['funcion']=='obtener_productos'){
        // Llama al método obtener_productos
        $productos = $producto->obtener_productos();
    
        $jsonstring = json_encode($productos);
        echo $jsonstring;
    }

    if($_POST['funcion']=='crear_producto'){
        $nombre = $_POST['nombre'];
        $id_categoria = $_POST['id_categoria'];
        $descripcion = $_POST['descripcion'];
        $precio_unitario = $_POST['precio_unitario'];
        $cantidad_disponible = $_POST['cantidad_disponible'];
        $fecha_registro = date('Y-m-d H:i:s');
        $sector = $_POST['sector'];
        $costo_unidad = $_POST['costo_unidad'];
        $foto = $_FILES['foto']['name'] ? $_FILES['foto']['name'] : null;

    
        if ($foto) {
            $ruta = '../Util/Img/Producto/' . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
        }

        $id_producto = $producto->crear_producto($nombre, $id_categoria, $descripcion, $precio_unitario, $cantidad_disponible, $fecha_registro, $sector, $costo_unidad, $ruta);
    
        if (isset($_FILES['fotos'])) {
            foreach ($_FILES['fotos']['name'] as $key => $nombre_foto) {
                // Verificar si se ha subido una foto
                if ($nombre_foto) {
                    $ruta = '../Util/Img/Producto/' . $nombre_foto;
                    $producto->agregar_imagen($id_producto, $ruta);
                    move_uploaded_file($_FILES['fotos']['tmp_name'][$key], $ruta);
                }
            }
        }
    
        echo json_encode(['message' => 'Producto creado', 'status' => 'success']);
    }
    
    if($_POST['funcion']=='editar_producto'){
        $id = $_POST['id'];
        if ($producto->existe($id)) {
            $nombre = $_POST['nombre'];
            $id_categoria = $_POST['id_categoria'];
            $descripcion = $_POST['descripcion'];
            $cantidad_disponible = $_POST['cantidad_disponible'];
            $precio_unitario = $_POST['precio_unitario'];
            $fecha_actualizacion = date('Y-m-d H:i:s');
            $sector = $_POST['sector'];
            $costo_unidad = $_POST['costo_unidad'];
            $foto = $_FILES['foto']['name'] ? $_FILES['foto']['name'] : null;
        
            if ($foto) {
                $ruta = '../Util/Img/Producto/' . $foto;
                move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
            }

            $producto->editar_producto($id, $nombre, $id_categoria, $descripcion, $cantidad_disponible, $precio_unitario, $fecha_actualizacion, $sector, $costo_unidad, $ruta);
        
            if (isset($_FILES['fotos'])) {
                foreach ($_FILES['fotos']['name'] as $key => $nombre_foto) {
                    // Verificar si se ha subido una foto
                    if ($nombre_foto) {
                        $ruta = '../Util/Img/Producto/' . $nombre_foto;
                        $producto->agregar_imagen($id, $ruta);
                        move_uploaded_file($_FILES['fotos']['tmp_name'][$key], $ruta);
                    }
                }
            }
        
            echo json_encode(['message' => 'Producto editado', 'status' => 'success']);
        } else {
            echo json_encode(['message' => 'El producto no existe', 'status' => 'error']);
        }
    }

    /* 
        if($_POST['funcion']=='editar_producto'){
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $id_categoria = $_POST['id_categoria'];
            $descripcion = $_POST['descripcion'];
            $cantidad_disponible = $_POST['cantidad_disponible'];
            $precio_unitario = $_POST['precio_unitario'];
            $fecha_actualizacion = date('Y-m-d H:i:s');
            $sector = $_POST['sector'];
            $costo_unidad = $_POST['costo_unidad'];
            $foto = $_FILES['foto']['name'] ? $_FILES['foto']['name'] : null;

            if ($foto) {
                // Obtener la foto antigua
                $producto_obj = $producto->obtener_producto($id);
                $foto_antigua = $producto_obj[0]['foto'];

                // Si la foto antigua existe, eliminarla
                if ($foto_antigua && file_exists('../Util/Img/Producto/' . $foto_antigua)) {
                    unlink('../Util/Img/Producto/' . $foto_antigua);
                }

                // Agregar la nueva foto
                $producto->agregar_imagen($id, $foto);
                move_uploaded_file($_FILES['foto']['tmp_name'], '../Util/Img/Producto/' . $foto);
            }

            $producto->editar_producto($id, $nombre, $id_categoria, $descripcion, $cantidad_disponible, $precio_unitario, $fecha_actualizacion, $sector, $costo_unidad, $foto);

            if (isset($_FILES['fotos'])) {
                foreach ($_FILES['fotos']['name'] as $key => $nombre_foto) {
                    $producto->agregar_imagen($id, $nombre_foto);
                    move_uploaded_file($_FILES['fotos']['tmp_name'][$key], '../Util/Img/Producto/' . $nombre_foto);
                }
            }

            echo 'Producto editado';
        }
    */
    
    if($_POST['funcion']=='obtener_producto'){
        $id = $_POST['id'];
        $productoData = $producto->obtener_producto($id);

        // Obtener las fotos del producto
        $fotos = $producto->obtener_fotos($id);

        // Agregar las fotos al producto
        $productoData[0]->fotos = $fotos;

        $jsonstring = json_encode($productoData);
        echo $jsonstring;
    }
    
    if($_POST['funcion']=='modificar_cantidad_disponible'){
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];
        $producto->modificar_cantidad_disponible($id, $cantidad);
        echo json_encode(['message' => 'Cantidad modificada', 'status' => 'success']);
    }
    
    if($_POST['funcion']=='agregar_imagen'){
        $id_producto = $_POST['id_producto'];
        $nombre = $_FILES['imagen']['name'];
    
        $producto->agregar_imagen($id_producto, $nombre);
        echo json_encode(['message' => 'Imagen agregada', 'status' => 'success']);
    }
    
    if($_POST['funcion']=='eliminar_foto'){
        $id = $_POST['id'];
        $producto->eliminar_foto($id);
        echo json_encode(['message' => 'Foto eliminada', 'status' => 'success']);
    }

    if ($_POST['funcion'] == 'modificar_estado_producto') {
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        if ($producto->existe($id)) {
            if ($estado == 'A') {
                $producto->desactivar_producto($id);
                echo json_encode(['status' => 'success', 'message' => 'Producto desactivado correctamente']);
            } else if ($estado == 'I') {
                $producto->activar_producto($id);
                echo json_encode(['status' => 'success', 'message' => 'Producto activado correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Estado inválido']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'El producto no existe']);
        }
    }