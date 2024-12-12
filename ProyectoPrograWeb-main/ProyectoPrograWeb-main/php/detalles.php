<?php
include '../html/header.html';
require 'database.php';
require 'config.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    include '../html/error.html';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if (hash_equals($token_tmp, $token)) {
        $sql = $con->prepare("SELECT nombre, descripcion, descuento, precio FROM productos WHERE id = ? AND activo = 1");
        $sql->execute([$id]);

        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_des = $precio - (($precio * $descuento) / 100);

            $dir_images = '../imagen/';
            $rutaImg = "https://via.placeholder.com/300";

            // Verificar si existe una imagen con los tipos de archivo especificados
            $tipos = ['jpg', 'png', 'webp', 'jpeg'];
            foreach ($tipos as $tipo) {
                $ruta = $dir_images . $id . '.' . $tipo;
                if (file_exists($ruta)) {
                    $rutaImg = $ruta;
                    break; // Detener el bucle al encontrar una imagen válida
                }
            }

            // Obtener todas las imágenes en la carpeta del producto
            $imagenes = [];
            if (is_dir($dir_images)) {
                $dir = opendir($dir_images);
                while (($archivo = readdir($dir)) !== false) {
                    if (strpos($archivo, $id) === 0 && in_array(pathinfo($archivo, PATHINFO_EXTENSION), $tipos)) {
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                closedir($dir);
            }
        } else {
            include '../html/error.html';
            exit;
        }
    } else {
        include '../html/error.html';
        exit;
    }
}
?>

<head>
    <title><?php echo htmlspecialchars($nombre); ?></title>
</head>

<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">
                <img src="<?php echo $ruta ?>" class="img-product" alt="https://via.placeholder.com/300">
            </div>
            <div class="col-md-6 order-md-2"> <!-- Corrigido de order-md-3 a order-md-2 -->
                <h2><?php echo htmlspecialchars($nombre); ?></h2>
                <!-- Uso de htmlspecialchars para mayor seguridad -->
                <h3><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h3>
                <p class="lead"><?php echo htmlspecialchars($descripcion); ?></p>

                <div class="d-grid gap-3 col-10 mx-auto">
                    <a href="php/paypal.php" class="btn btn-primary">Comprar ahora</a>
                    <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo
                        $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function addProducto(id, token) {
        let url = 'php/carrito.php';
        let formData = new FormData();
        formData.append('id', $id)
        formData.append('token', token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero;
                }
            })
    }
</script>