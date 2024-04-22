<?php
include_once '../Models/Usuario.php';
include_once '../Util/Config/config.php';
require '../vendor/autoload.php';
//esta variable esta siendo instanciada en Usuasrio.php y a la vez en Conexion.php
$usuario = new Usuario();
//sive para saber cuando el usuario entra en su sesion
session_start();
//este controlador interactua con el modelo usuario y la tabla usuario
    //aca recibo la contraseña y el usuario
    //el if verifica que sea la funcion de login y no otra funcion
    if($_POST['funcion']=='login'){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $usuario->verificar_usuario($user);
        if($usuario->objetos!=null){
            $pass_bd = openssl_decrypt($usuario->objetos[0]->pass,CODE,KEY);
            if($pass_bd == $pass){
                    $_SESSION['id']=$usuario->objetos[0]->id;
                    $_SESSION['user']=$usuario->objetos[0]->user;
                    $_SESSION['tipo_usuario']=$usuario->objetos[0]->id_tipo;
                    $_SESSION['avatar']=$usuario->objetos[0]->avatar;
                echo 'logueado';
            } 
        }
    }
    //aqui manejo la funcion de verificar sesion, verificando si existe un SESSION id
    if($_POST['funcion']=='verificar_sesion'){
        if(!empty($_SESSION['id'])){
            $json[] = array(
                'id' => $_SESSION['id'],
                'user' => $_SESSION['user'],
                'tipo_usuario' => $_SESSION['tipo_usuario'],
                'avatar' => $_SESSION['avatar']	
            );
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
        else{
            echo '';
        }
    }

    if($_POST['funcion']=='verificar_usuario'){
        $username = $_POST['value'];
        $usuario->verificar_usuario($username);
        if($usuario->objetos!=null){
            echo 'success';        
        }
    }

    if($_POST['funcion']=='registrar_usuario'){
        $username = $_POST['username'];
        $pass = openssl_encrypt($_POST['pass'],CODE,KEY);
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];	
        $dni = $_POST['dni'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $usuario->registrar_usuario($username, $pass, $nombres, $apellidos, $dni, $email, $telefono);
        echo 'success';
        
    }

    if($_POST['funcion']=='obtener_datos'){
        $usuario->obtener_datos($_SESSION['id']);
        foreach($usuario->objetos as $objeto){
            $json[]=array(
                'username'=>$objeto->user,
                'nombres'=>$objeto->nombres,
                'apellidos'=>$objeto->apellidos,
                'dni'=>$objeto->dni,
                'email'=>$objeto->email,
                'telefono'=>$objeto->telefono,
                'avatar'=>$objeto->avatar,
                'tipo_usuario'=>$objeto->tipo,
            );
        }
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }

    if($_POST['funcion']=='editar_datos'){
        $id_usuario = $_SESSION['id'];
        $nombres = $_POST['nombres_mod'];
        $apellidos = $_POST['apellidos_mod'];	
        $dni = $_POST['dni_mod'];
        $email = $_POST['email_mod'];
        $telefono = $_POST['telefono_mod'];
        $avatar = $_FILES['avatar_mod']['name'];
        if($avatar != ''){
            $nombre = uniqid().'-'.$avatar;
            $ruta = '../Util/Img/Users/'.$nombre;
            //move_uploaded_file($_FILES['avatar_mod']['tmp_name'],$ruta);
            $archivo = $nombre;
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $nombre_base = basename($archivo, '.'.PATHINFO_EXTENSION);
            $handle = new \Verot\Upload\Upload($_FILES['avatar_mod']);
            if ($handle->uploaded) {
                $handle->file_new_name_body   = $nombre_base;
                $handle->image_resize         = true;
                $handle->image_x              = 200;
                $handle->image_y        = 200;
                $handle->process('../Util/Img/Users/');
                if ($handle->processed) {
                    //echo 'image resized';
                    $handle->clean();
            } 
            else {
                echo 'error : ' . $handle->error;
            }
            }
            $usuario->obtener_datos($id_usuario);
            foreach($usuario->objetos as $objeto){
                $avatar_actual = $objeto->avatar;
                if($avatar_actual != 'default.png'){
                    unlink('../Util/Img/Users/'.$avatar_actual);
                }
            }
            $_SESSION['avatar']=$nombre;
        }
        else{
            $nombre = '';
        }
        $usuario->editar_datos($id_usuario,$nombres, $apellidos, $dni, $email, $telefono, $nombre);
        echo 'success';
        
    }


    if($_POST['funcion']=='cambiar_contra'){
        $id_usuario = $_SESSION['id'];
        $user = $_SESSION['user'];
        $pass_old = $_POST['pass_old'];
        $pass_new = $_POST['pass_new'];
        $usuario->verificar_usuario($user);
        if(!empty($usuario->objetos)){
            $pass_bd = openssl_decrypt($usuario->objetos[0]->pass,CODE,KEY);
            if($pass_bd == $pass_old){
                $pass_new_encriptada = openssl_encrypt($_POST['pass_new'],CODE,KEY);
                $usuario->cambiar_contra($id_usuario, $pass_new_encriptada);
                echo 'success';
            }
            else{
                echo 'error';   
            }
        }
        else{
            echo 'error';
        }
    }