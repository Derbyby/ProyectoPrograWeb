<?php
include '../html/header.php';
require '../php/database.php';
require_once '../php/config.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : null;
$productos = null;

if ($id) {
    $sql = $con->prepare("SELECT id, nombre, precio, descuento, 1 AS cantidad FROM productos WHERE id = ? AND activo = 1");
    $sql->execute([$id]);
    $productos = [$sql->fetch(PDO::FETCH_ASSOC)];
    $_SESSION['comprar_ahora'] = $productos;
} else {
    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
}

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        if (is_array($cantidad)) {
            $lista_carrito[] = $cantidad; // Si ya viene como un arreglo (por el carrito)
        } else {
            $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo = 1");
            $sql->execute([$clave]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Contenido -->
    <main>
        <div class="container">

            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id=paypal-button-container></div>
                </div>

                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($lista_carrito == null) {
                            echo '<tr><td colspan="5" class="test-center"><b>Lista vacia</b></td></tr>';
                            }else{
                                $total = 0;
                                foreach($lista_carrito as $producto){
                                    $_id = $producto['id'];
                                    $nombre = $producto['nombre'];
                                    $precio = $producto['precio'];
                                    $descuento = $producto['descuento'];
                                    $cantidad = $producto['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;

                                ?>
                                <tr>
                                    <td><?php echo $nombre; ?></td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . 
                                                number_format($subtotal, 2, '.', ','); ?></div>
                                    </td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td colspan="2">
                                        <p class="h3 text-end" id="total">
                                            <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
                                        </p>
                                    </td>
                                </tr>

                            </tbody>
                            <?php } ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script
        src="https://sandbox.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&amp;currency=<?php echo CURRENCY; ?>&amp;locale=es_MX&amp;components=buttons"
        data-uid-auto="uid_fhbvmixthzieuaiissdjhttpumbzdh"></script>

    <script>
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $total; ?> //base de datos obteniendo el precio
                    }
                }]
            });
        },

        onApprove: function(data, actions) {
            let url = '../clases/captura.php'
            actions.order.capture().then(function(detalles) {
                console.log(detalles);

                return fetch(url, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        detalles: detalles
                    })
                }).then(function(response){
                    window.open("recibo.php", "Recibo de Compra");
                    window.location.href="../index.php";
                })
            });
        },

        onCancel: function(data) {
            alert("Pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
    </script>

</body>

</html>
<?