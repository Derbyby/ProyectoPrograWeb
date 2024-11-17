<?php
include 'html/header.html';
require 'php/database.php';
require 'php/config.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, descripcion, precio FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <?php foreach ($resultado as $row) { ?>
        <div class="product">
            <?php
            $id = $row['id'];
            $tipos = ['jpg', 'png', 'webp', 'jpeg'];

            foreach ($tipos as $tipo) {
                $ruta = "imagen/" . $id . "." . $tipo;
                if (file_exists($ruta)) {
                    $imagen = $ruta;
                    break; // Detenemos el bucle si encontramos una imagen
                }
            }

            if (!file_exists($imagen)) {
                $imagen = "https://via.placeholder.com/300";
            }
            ?>
            <a href="detalles.php?id=<?php echo htmlspecialchars($row['id']); ?>
&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>">
                <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de producto">
                <h3><?php echo $row['nombre']; ?></h3>
            </a>
            <p><strong><?php echo "$" . $row['precio']; ?></strong></p>
        </div>

    <?php } ?>
</div>