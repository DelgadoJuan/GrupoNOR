<?php
define('BASE_PATH', '/GrupoNOR/commerce/Views');

$request = str_replace(BASE_PATH, '', $_SERVER['REQUEST_URI']);

// Verificar si la ruta comienza con '/tienda/'
if (strpos($request, '/tienda') === 0) {
    require __DIR__ . '\Views\tienda.php';
} else {
    switch ($request) {
        case '/' :
            require __DIR__ . '\Views\index.php';
            break;
        case '/stock' :
            require __DIR__ . '\Views\stock.php';
            break;
        case '/categoria' :
            require __DIR__ . '\Views\categoria.php';
            break;
        case '/registro' :
            require __DIR__ . '\Views\registro.php';
            break;
        case '/login' :
            require __DIR__ . '\Views\login.php';
            break;
        case '/descripcion' :
            require __DIR__ . '\Views\descripcion.php';
            break;
        case '/carrito' :
            require __DIR__ . '\Views\carrito.php';
            break;
        // etc.
        default:
            $filename = __DIR__ . '/Views' . $_SERVER["REQUEST_URI"] . '.php';

            if (file_exists($filename)) {
                require $filename;
                break;
            }

            http_response_code(404);
            require __DIR__ . '\Views\404.php';
            break;
    }
}