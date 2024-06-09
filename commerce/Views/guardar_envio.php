<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['envio'])) {
        // Guardar el costo de envío en la sesión
        $_SESSION['costo_envio'] = floor($_POST['envio']);

        // Devolver el costo de envío al cliente
        echo json_encode(['status' => 'success', 'costo_envio' => $_SESSION['costo_envio']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se recibió el costo de envío']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido']);
}
?>