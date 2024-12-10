<?php
include 'html/header.html';
require 'php/database.php';
require 'php/config.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, descripcion, precio FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

print_r($_SESSION);
?>

<head>
    <title>WoofLandia</title>
</head>

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
                    ?>
                    <a href="php/detalles.php?id=<?php echo htmlspecialchars($row['id']); ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>">
                        <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de producto">
                        <p class="nombre"><?php echo $row['nombre']; ?></p>
                    </a>
                    <p class="precio"><strong><?php echo MONEDA . $row['precio']; ?></strong></p>

                    <div class="d-grid gap-3 col-10 mx-auto">
                        <a href="php/paypal.php" class="btn btn-primary">Comprar ahora</a>
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    function addProducto(id, token) {
        let url = 'php/carrito.php';
        let formData = new FormData();
        formData.append('id', id); // Usa `id` en lugar de `$id`
        formData.append('token', token);

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    let elemento = document.getElementById("num_cart");
                    elemento.innerHTML = data.numero;
                }
            })
            .catch(error => {
                console.error('Error al agregar al carrito:', error);
            });
    }
</script>