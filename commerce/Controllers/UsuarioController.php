<?php
include_once '../Models/Usuario.php';
//esta variable esta siendo instanciada en Usuario.php y a la vez en Conexion.php
$usuario = new Usuario();
//sive para saber cuando el usuario entra en su sesion
session_start();
//este controlador interactua con el modelo usuario y la tabla usuario
    //aca recibo la contraseña y el usuario
    //el if verifica que sea la funcion de login y no otra funcion
    if($_POST['funcion']=='login'){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $usuario->loguearse($user, $pass);
        if($usuario->objetos!=null){
            foreach($usuario->objetos as $objeto){
                $_SESSION['id']=$objeto->id;
                $_SESSION['user']=$objeto->user;
                $_SESSION['tipo_usuario']=$objeto->id_tipo;
                $_SESSION['avatar']=$objeto->avatar;
            }
            echo 'logueado';
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
        $pass = $_POST['pass'];
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
            move_uploaded_file($_FILES['avatar_mod']['tmp_name'],$ruta);
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


