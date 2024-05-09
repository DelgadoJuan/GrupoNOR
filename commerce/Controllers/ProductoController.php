<?php
include_once '../Models/Producto.php';
include_once '../Util/Config/config.php';

//esta variable esta siendo instanciada en Producto.php y a la vez en Conexion.php
$producto = new Producto();
//sirve para saber cuando el usuario entra en su sesion
session_start();

    if($_POST['funcion']=='llenar_productos'){
        $producto->llenar_productos();
        $json=array();
        foreach($producto->objetos as $objeto){
            $json[]=array(
                'id'=>openssl_encrypt($objeto->id,CODE,KEY),
                'nombre'=>$objeto->nombre,
                'stock'=>$objeto->stock,
                'precio'=>intval($objeto->precio),
                'foto'=>$objeto->foto,
                'descripcion'=>$objeto->descripcion,
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    if($_POST['funcion']=='verificar_productos'){
        $id_prod =openssl_decrypt($_SESSION['product-verification'], CODE, KEY);
        if (is_numeric($id_prod)) {
            $producto->llenar_productos($id_prod);
            $id_producto = $producto->objetos[0]->id;
            $nombre = $producto->objetos[0]->nombre;
            $stock = $producto->objetos[0]->stock;
            $precio = $producto->objetos[0]->precio;
            $foto = $producto->objetos[0]->foto;
            $descripcion = $producto->objetos[0]->descripcion;
            $producto->capturar_imagenes($id_producto);
            $imagenes =  array();
            foreach($producto->objetos as $objeto){
                $imagenes[]=array(
                    'id'=>$objeto->id,
                    'nombre'=>$objeto->nombre
                );
            }
                $json=array(
                    'id'=>$id_prod,
                    'nombre'=>$nombre,
                    'stock'=>$stock,
                    'precio'=>intval($precio),
                    'foto'=>$foto,
                    'descripcion'=>$descripcion,
                    'imagenes'=>$imagenes
                );
            
            $jsonstring = json_encode($json);
            echo $jsonstring; 
        }
        else {
            echo "error";
        }
        
    }

        if($_POST['funcion']=='eliminar_producto'){
        $id = $_POST['id'];
        // Verifica si el producto existe
        if (!Producto::existe($id)) {
            // Si el producto no existe, maneja este caso de error (por ejemplo, mostrando un mensaje de error al usuario)
            echo 'No existe el producto';
            return;
        }

        // Si el producto existe, procede a eliminarlo
        Producto::eliminar_producto($id);

        // Devuelve un mensaje de éxito
        echo 'Producto eliminado';
    }

    if($_POST['funcion']=='obtener_productos'){
        // Llama al método obtener_productos
        $productos = $producto->obtener_productos();
    
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }

    if($_POST['funcion']=='editar_producto'){
        $id_producto = $_POST['id_producto'];
        $nombre = $_POST['nombre_mod'];
        $descripcion = $_POST['descripcion_mod'];  
        $cantidad_disponible = $_POST['cant_disponible_mod'];
        $imagen = $_FILES['imagen_mod']['name'];
        if($imagen != ''){
            $nombre_imagen = uniqid().'-'.$imagen;
            $ruta = '../Util/Img/Products/'.$nombre_imagen;
            move_uploaded_file($_FILES['imagen_mod']['tmp_name'],$ruta);
            $producto->obtener_producto($id_producto);
            foreach($producto->objetos as $objeto){
                $imagen_actual = $objeto->imagen;
                if($imagen_actual != 'default.png'){
                    unlink('../Util/Img/Products/'.$imagen_actual);
                }
            }
        }
        else{
            $nombre_imagen = '';
        }
        $producto->actualizar_producto($id_producto, $nombre, $descripcion, $stock, $nombre_imagen);
        echo 'success';
    }
    