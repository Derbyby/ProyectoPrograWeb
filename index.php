<?php
include 'html/header.php';
require 'php/database.php';
require_once 'php/config.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, descripcion, precio, cantidad FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<head>
    <title>WoofLandia</title>
</head>
<div class="container-slider">
    <div class="slider-frame">
        <ul>
            <li><img src="slider/corgi chiquito.jpg" alt="Corgi"></li>
            <li><img src="slider/french.jpg" alt="French"></li>
            <li><img src="slider/pastor no de iglesia.jpg" alt="Pastor"></li>
            <li><img src="slider/gran.jpg" alt="Gran"></li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="row row-cols-auto g-2"> <!-- Ajustado a 5 columnas -->
        <?php foreach ($resultado as $row) { ?>
            <div class="col"> <!-- Asegúrate de que cada producto esté dentro de un div con la clase 'col' -->
                <div class="product">
                    <?php
                    $id = $row['id'];
                    $tipos = ['jpg', 'png', 'webp', 'jpeg'];

                    $imagen = "https://via.placeholder.com/300"; // Imagen predeterminada
                    foreach ($tipos as $tipo) {
                        $ruta = "imagen/" . $id . "." . $tipo;
                        if (file_exists($ruta)) {
                            $imagen = $ruta;
                            break;
                        }
                    }
                    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
                    ?>
                    <a
                        href="detalles.php?id=<?php echo htmlspecialchars($row['id']); ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>">
                        <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de producto">
                        <p class="nombre"><?php echo $row['nombre']; ?></p>
                    </a>
                    <p class="precio"><strong><?php echo MONEDA . $row['precio']; ?></strong></p>

                    <div class="d-grid gap-3 col-10 mx-auto">
                        <a href="pago.php?id=<?php echo htmlspecialchars($id); ?>" class="btn btn-primary">Comprar ahora</a>
                        <button class="btn btn-outline-primary" type="button"
                            onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>', 
                        '<?php echo htmlspecialchars($row['nombre']); ?>', '<?php echo htmlspecialchars($imagen); ?>', <?php echo $row['precio']; ?>,)">
                            Agregar al carrito</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.ok) {
                let elemento = document.getElementById("num_cart");
                elemento.innerHTML = data.numero;
            }
        })
        .catch((error) => {
            console.error("Error al agregar al carrito:", error);
        });

</script>

<!-- Script para búsqueda -->
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchBar = document.getElementById('searchBar');
            const productTable = document.getElementById('productTable').getElementsByTagName('tbody')[0];

            searchBar.addEventListener('input', () => {
                const filter = searchBar.value.toLowerCase();
                const rows = productTable.getElementsByTagName('tr');

                for (let row of rows) {
                    const id = row.cells[0].textContent.toLowerCase();
                    const name = row.cells[1].textContent.toLowerCase();

                    if (id.includes(filter) || name.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Mostrar modal si existe un estado
            const status = "<?php echo $status; ?>";
            if (status) {
                const modal = new bootstrap.Modal(document.getElementById('statusModal'));
                modal.show();
            }
        });
    </script>
