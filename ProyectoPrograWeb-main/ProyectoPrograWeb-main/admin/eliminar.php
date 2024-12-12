<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id == '') {
    echo "Error: ID no proporcionado";
    exit;
}

$sql = $con->prepare("DELETE FROM productos WHERE id = ?");
$sql->execute([$id]);

header("Location: inventario.php");
exit;
?>
