<?php
require 'config/database.php';
$pageTitle = "Edición Masiva";
include 'header.php';

$db = new Database();
$con = $db->conectar();

// Obtener todos los productos
$sql = $con->prepare("SELECT * FROM productos");
$sql->execute();
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">

    <form action="procesar_edicion_masiva.php" method="post">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="productos[]" value="<?php echo $producto['id']; ?>">
                        </td>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo $producto['precio']; ?></td>
                        <td><?php echo $producto['activo'] ? 'Sí' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Editar Seleccionados</button>
    </form>


<script>
    // Seleccionar/deseleccionar todos los checkboxes
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="productos[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

<?php include 'footer.php'; ?>
