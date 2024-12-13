<?php
session_start();
require 'config.php';

// Verifica si los datos se están recibiendo
if (isset($_POST['id']) && isset($_POST['token'])) {
    $id = $_POST['id'];
    $token = $_POST['token'];

    // Imprime los datos recibidos para depurar
    error_log("ID recibido: " . $id);
    error_log("Token recibido: " . $token);

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if (hash_equals($token_tmp, $token)) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = ['productos' => []];
        }

        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] += 1;
        } else {
            $_SESSION['carrito']['productos'][$id] = 1;
        }
        
        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
    } else {
        $datos['ok'] = false;
        error_log("Token inválido");
    }
} else {
    $datos['ok'] = false;
    error_log("Datos no recibidos");
}

echo json_encode($datos);

