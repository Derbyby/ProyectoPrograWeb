<?php
require 'config/database.php';

// Título de la página
$pageTitle = "Registrar Producto";
include 'header.php';

$db = new Database();
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Datos básicos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $activo = isset($_POST['activo']) ? 1 : 0;

        // Paso 1: Insertar el producto sin la imagen
        $sql = $con->prepare("INSERT INTO productos (nombre, descripcion, precio, activo) VALUES (?, ?, ?, ?)");
        $sql->execute([$nombre, $descripcion, $precio, $activo]);

        // Obtener el ID del producto insertado
        $idProducto = $con->lastInsertId();

        // Validar y guardar la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $tipoArchivo = $_FILES['imagen']['type'];
            $tamañoArchivo = $_FILES['imagen']['size'];
            $tempArchivo = $_FILES['imagen']['tmp_name'];
            $directorioDestino = '../imagen/';

            // Validar tipo de archivo
            $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
            if (!in_array($tipoArchivo, $extensionesPermitidas)) {
                throw new Exception('Formato de imagen no permitido. Solo JPG, PNG o GIF.');
            }

            // Generar un nuevo nombre para la imagen usando el ID
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nuevoNombre = $idProducto . '.' . $extension;
            $rutaArchivo = $directorioDestino . $nuevoNombre;

            if (!move_uploaded_file($tempArchivo, $rutaArchivo)) {
                throw new Exception('Error al guardar la imagen en el servidor.');
            }

            $sql = $con->prepare("UPDATE productos SET imagen = ? WHERE id = ?");
            $sql->execute([$rutaArchivo, $idProducto]);
        } else {
            throw new Exception('No se proporcionó una imagen válida.');
        }

        // Redirigir al inventario con un mensaje de éxito
        $_SESSION['message'] = "Producto agregado exitosamente.";
        $_SESSION['message_type'] = "success";
        echo "<script>window.location.href = 'inventario.php';</script>";

        exit;
    } catch (Exception $e) {
        $error = "Error al registrar el producto: " . $e->getMessage();
    }
}

?>

<div class="container-fluid">
    <div class="container col-lg-7">

        <!-- Mostrar mensaje de error -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Formulario de registro -->
        <form action="registrar.php" method="post" class="card shadow p-4" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Collar para perros"
                    required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"
                    placeholder="Ej. Collar ajustable para perros de talla mediana." required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" name="precio" id="precio" class="form-control" step="0.01" placeholder="Ej. 20.99"
                    required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto:</label>
                <div class="custom-file-upload">
                    <!-- <label for="imagen" class="custom-label" id="file-label">Seleccionar Imagen</label> -->
                    <input type="file" name="imagen" id="imagen" class="custom-input" accept="image/*" required>
                </div>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="activo" id="activo" class="form-check-input">
                <label for="activo" class="form-check-label">Activo</label>
            </div>
            <div class="mb-3">
                <label for="descuento" class="form-label">Descuento:</label>
                <input type="money" name="descuento" id="descuento" class="form-control" step="0.01"
                    placeholder="Ej. 0.5" required>
            </div>
            <div class="text-center justify-content-center">
                <button type="submit" class="btn btn-primary mb-3" style="width:150px">Registrar Producto</button>
                <a href="inventario.php" class="btn btn-secondary mb-3" style="width:150px">Cancelar</a>
            </div>
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