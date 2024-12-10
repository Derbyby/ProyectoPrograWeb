<?php
require 'config/database.php';
$pageTitle = "Editar Producto";

$db = new Database();
$con = $db->conectar();

// Obtener el ID de la URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id == '') {
    $error = "Error: ID no proporcionado.";
    include 'header.php';
    echo '
    <div class="container-fluid">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $error . '
            <a href="index-admin.php" class="btn-close me-2" data-bs-dismiss="alert" aria-label="Close">Regresar</a>
        </div>
    </div>';
    include 'footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Datos básicos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $activo = isset($_POST['activo']) ? 1 : 0;
        $descuento = $_POST['descuento'];

        // Procesar la imagen
        $imagenActual = $_POST['imagen_actual']; // Imagen existente
        $rutaArchivo = $imagenActual; // Por defecto, mantener la imagen existente

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $tipoArchivo = $_FILES['imagen']['type'];
            $tempArchivo = $_FILES['imagen']['tmp_name'];
            $directorioDestino = '../imagen/';

            // Validar tipo de archivo
            $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
            if (!in_array($tipoArchivo, $extensionesPermitidas)) {
                throw new Exception('Formato de imagen no permitido. Solo JPG, PNG o GIF.');
            }

            // Generar un nuevo nombre para la imagen usando el ID
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nuevoNombre = $id . '.' . $extension;
            $rutaArchivo = $directorioDestino . $nuevoNombre;

            if (!move_uploaded_file($tempArchivo, $rutaArchivo)) {
                throw new Exception('Error al guardar la imagen en el servidor.');
            }
        }

        // Actualizar los datos del producto
        $sql = $con->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, activo = ?, descuento = ?, imagen = ? WHERE id = ?");
        $sql->execute([$nombre, $descripcion, $precio, $activo, $descuento, $rutaArchivo, $id]);

        // Redirigir con mensaje de éxito
        $_SESSION['message'] = "Producto actualizado exitosamente.";
        $_SESSION['message_type'] = "success";
        echo "<script>window.location.href = 'inventario.php';</script>";
        exit;
    } catch (Exception $e) {
        $error = "Error al actualizar el producto: " . $e->getMessage();
    }
} else {
    // Obtener los datos del producto
    $sql = $con->prepare("SELECT * FROM productos WHERE id = ?");
    $sql->execute([$id]);
    $producto = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        $error = "Error: Producto no encontrado.";
        include 'header.php';
        echo '
        <div class="container-fluid">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $error . '
                <a href="index-admin.php" class="btn-close me-2" data-bs-dismiss="alert" aria-label="Close">Regresar</a>
            </div>
        </div>';
        include 'footer.php';
        exit;
    }
}

include 'header.php';
?>

<div class="container-fluid">
    <div class="container mt-5">
        <h2 class="text-center mb-4"><?php echo $pageTitle; ?></h2>

        <!-- Mostrar mensaje de error -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <form action="editar.php?id=<?php echo $id; ?>" method="post" class="card shadow p-4" enctype="multipart/form-data">
            <input type="hidden" name="imagen_actual" value="<?php echo $producto['imagen']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" name="precio" id="precio" class="form-control" step="0.01" value="<?php echo $producto['precio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descuento" class="form-label">Descuento:</label>
                <input type="number" name="descuento" id="descuento" class="form-control" step="0.01" value="<?php echo $producto['descuento']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto:</label>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                <?php if (!empty($producto['imagen'])): ?>
                    <img src="<?php echo $producto['imagen']; ?>" alt="Imagen del Producto" class="mt-3" width="150">
                <?php endif; ?>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="activo" id="activo" class="form-check-input" <?php echo $producto['activo'] ? 'checked' : ''; ?>>
                <label for="activo" class="form-check-label">Activo</label>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
        </form>

    </div>

    <script>
        const fileInput = document.getElementById('imagen');
        const fileNameDisplay = document.getElementById('file-name');

        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = "Ningún archivo seleccionado";
            }
        });
    </script>


    <?php include 'footer.php'; ?>


