<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM productos");
$sql->execute();
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);

$status = isset($_GET['status']) ? $_GET['status'] : null;
$message = isset($_GET['message']) ? $_GET['message'] : null;

$pageTitle = "Inventario";
include 'header.php';
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <input type="text" id="searchBar" class="form-control" placeholder="Buscar por ID o nombre...">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="productTable" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Activo</th>
                            <th>Descuento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) { ?>
                            <tr>
                                <td><?php echo $producto['id']; ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                                <td><?php echo $producto['precio']; ?></td>
                                <td><?php echo $producto['activo'] ? 'Sí' : 'No'; ?></td>
                                <td><?php echo $producto['descuento']; ?></td>
                                <td class="text-center">
                                    <a href="editar.php?id=<?php echo $producto['id']; ?>"
                                        class="btn btn-warning btn-sm mb-2">Editar</a>
                                    <a href="eliminar.php?id=<?php echo $producto['id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Está seguro de eliminar este producto?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar mensajes -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">
                        <?php echo $status === "success" ? "Operación Exitosa" : "Error"; ?>
                    </h5>
                </div>
                <div class="modal-body">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" href="inventario.php">Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const status = "<?php echo $status; ?>";
            if (status) {
                const modal = new bootstrap.Modal(document.getElementById('statusModal'));
                modal.show();
            }
        });
    </script>


    <?php include 'footer.php'; ?>