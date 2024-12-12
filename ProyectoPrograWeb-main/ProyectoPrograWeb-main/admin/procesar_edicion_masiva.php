<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

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

        // Redirigir con mensaje de éxito
        header("Location: inventario.php?status=success&message=Cambios guardados exitosamente");
        exit;
    } catch (Exception $e) {
        // Redirigir con mensaje de error
        header("Location: inventario.php?status=error&message=" . urlencode("Error al guardar cambios: " . $e->getMessage()));
        exit;
    }
} else {
    // Redirigir si no se enviaron datos
    header("Location: inventario.php?status=error&message=" . urlencode("No se enviaron datos para guardar"));
    exit;
}
?>


<div class="container-fluid">
    <form action="guardar_edicion_masiva.php" method="post">
        <?php foreach ($productos as $producto): ?>
            <div class="card mb-3 p-3">
                <h5>Producto ID: <?php echo $producto['id']; ?></h5>
                <input type="hidden" name="productos[<?php echo $producto['id']; ?>][id]" value="<?php echo $producto['id']; ?>">
                <div class="mb-3">
                    <label for="nombre_<?php echo $producto['id']; ?>" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre_<?php echo $producto['id']; ?>" name="productos[<?php echo $producto['id']; ?>][nombre]" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                </div>
                <div class="mb-3">
                    <label for="precio_<?php echo $producto['id']; ?>" class="form-label">Precio</label>
                    <input type="number" class="form-control" id="precio_<?php echo $producto['id']; ?>" name="productos[<?php echo $producto['id']; ?>][precio]" value="<?php echo $producto['precio']; ?>" step="0.01">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="activo_<?php echo $producto['id']; ?>" name="productos[<?php echo $producto['id']; ?>][activo]" <?php echo $producto['activo'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="activo_<?php echo $producto['id']; ?>">Activo</label>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>

<?php include 'footer.php'; ?>
