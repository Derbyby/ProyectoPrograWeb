<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$modalMessage = "";
$modalType = ""; // success o error

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productos'])) {
    try {
        foreach ($_POST['productos'] as $producto) {
            $id = $producto['id'];
            $nombre = $producto['nombre'];
            $precio = $producto['precio'];
            $activo = isset($producto['activo']) ? 1 : 0;

            $sql = $con->prepare("UPDATE productos SET nombre = ?, precio = ?, activo = ? WHERE id = ?");
            $sql->execute([$nombre, $precio, $activo, $id]);
        }

        $modalMessage = "Cambios guardados exitosamente.";
        $modalType = "success";
    } catch (Exception $e) {
        $modalMessage = "Error al guardar cambios: " . $e->getMessage();
        $modalType = "error";
    }
} else {
    $modalMessage = "No se enviaron datos para guardar.";
    $modalType = "error";
}
?>
