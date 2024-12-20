<?php
require '../../php/database.php';
require '../../php/config.php';
$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);
print ($datos);

if(is_array($datos)){

    $idCliente = $_SESSION['user_cliente'];

    $sql = $con->prepare("SELECT email FROM clientes WHERE id=? AND estado = 1");
    $sql->execute([$idCliente]);
    $row_cliente = $sql->fetch(PDO::FETCH_ASSOC);

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $row_cliente['email'];
    //$email = $datos['detalles']['payer']['email_address'];
    //$id_cliente = $datos['detalles']['payer']['payer_id'];

    $sql = $con->prepare('INSERT INTO compra(id_transaccion, fecha, estado, email, id_cliente, total) VALUES(?,?,?,?,?,?)');
    $sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $idCliente, $total]);
    $id = $con->lastInsertId();

    if($id > 0){
        session_start();  // Inicia la sesión
        $_SESSION['id_transaccion'] = $id_transaccion;  // Almacena el id en la sesión

        if (isset($_SESSION['comprar_ahora']) && !empty($_SESSION['comprar_ahora'])) {
            $productos_comprar_ahora = $_SESSION['comprar_ahora'];

            foreach ($productos_comprar_ahora as $producto) {
                $clave = $producto['id'];
                $cantidad = $producto['cantidad'];

                // Consultar los datos del producto desde la base de datos
                $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo = 1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                // Calcular el precio con descuento
                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                // Insertar el producto de 'comprar_ahora' en detalle_compra
                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) 
                VALUES (?,?,?,?,?)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad]);
            }
        } else {
            $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

            if($productos != null){
                foreach ($productos as $clave => $cantidad){
                    $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo = 1");
                    $sql->execute([$clave]);
                    $row_prod = $sql->fetch(PDO::FETCH_ASSOC);
    
                    $precio = $row_prod['precio'];
                    
                    $descuento = $row_prod['descuento'];
                    $precio_desc = $precio - (($precio * $descuento) / 100);
    
                    $sql_insert =  $con->prepare("INSERT INTO  detalle_compra (id_compra, id_producto, nombre, precio, cantidad) 
                    VALUES (?,?,?,?,?)");
                    $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad]);
    
                }
            }
        }

        unset($_SESSION['carrito']);
        unset($_SESSION['comprar_ahora']);
        // Redirige a la página de recibo con la transacción
        header("Location: /recibo.php");
        exit; 
    }
}
?>