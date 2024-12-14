<?php
include 'html/header.html';
require 'php/database.php';
require 'php/config.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, descripcion, imagen, precio FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<head>
    <title>WoofLandia</title>
</head>
<div class="container-slider">
    <div class="slider-frame">
        <ul>
            <li><img src="slider/slider.png" alt="Corgi"></li>
            <li><img src="slider/slideer.png" alt="French"></li>
            <li><img src="slider/slider1.png" alt="Pastor"></li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4"> <!-- Ajustado a 5 columnas -->
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
                        href="php/detalles.php?id=<?php echo htmlspecialchars($row['id']); ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>">
                        <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de producto">
                        <p class="nombre"><?php echo $row['nombre']; ?></p>
                    </a>
                    <p class="precio"><strong><?php echo MONEDA . $row['precio']; ?></strong></p>

                    <div class="d-grid gap-3 col-10 mx-auto">
                        <a href="php/paypal.php" class="btn btn-primary">Comprar ahora</a>
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