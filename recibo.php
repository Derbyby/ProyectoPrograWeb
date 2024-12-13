<?php
require_once('vendor/autoload.php'); // Ajusta la ruta según tu estructura de carpetas.
require 'php/database.php';
require 'php/config.php';

$db = new Database();
$con = $db->conectar();

$id_transaccion = isset($_SESSION['id_transaccion']) ? $_SESSION['id_transaccion'] : 0;

$error = "";
if($id_transaccion == ''){
    $error = 'Error al procesar la peticion';
} else {
    $sql = $con->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND estado=?");
    $sql->execute([$id_transaccion, 'COMPLETED']);

    if($sql->fetchColumn() > 0){
        $sql = $con->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND estado=? LIMIT 1");
        $sql->execute([$id_transaccion, 'COMPLETED']);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        $idCompra = $row['id'];
        $total = $row['total'];
        $fecha = $row['fecha'];

        $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
        $sqlDet->execute([$idCompra]);
    } else {
        $error = 'Error al comprobar la compra';
    }
}

// Crear una instancia de TCPDF
$pdf = new TCPDF();

// Configurar propiedades básicas del PDF
$pdf->SetCreator('Wooflandia');
$pdf->SetAuthor('Nombre del Autor');
$pdf->SetTitle('Recibo de Compra');
$pdf->SetSubject('Detalles de la compra');

// Configurar los márgenes
$pdf->SetMargins(15, 15, 15); // Izquierda, Arriba, Derecha
$pdf->SetAutoPageBreak(true, 20); // Salto automático al final de la página

// Agregar una página
$pdf->AddPage();

// Configurar fuente
$pdf->SetFont('helvetica', '', 12);

/*
$stmt = $con->prepare("
    SELECT c.fecha, c.total, cl.nombres, cl.apellidos, cl.email
    FROM compra c
    INNER JOIN clientes cl ON c.id_cliente = cl.id
    WHERE c.id = ?
");
$stmt->execute([$id_transaccion]);
$compra = $stmt->fetch(PDO::FETCH_ASSOC);

// Consultar detalles de los productos comprados
$stmt = $con->prepare("
    SELECT d.nombre AS producto, d.cantidad, d.precio
    FROM detalle_compra d
    WHERE d.id_compra = ?
");
$stmt->execute([$id_transaccion]);
$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/

// Agregar contenido al PDF
$moneda = "$";
$format = number_format($total, 2, '.', ',');
$htmlContent = '';
$htmlContent .= <<<EOD
    <div class="container">
EOD;

if (strlen($error) > 0) {
    $htmlContent .= <<<EOD
        <div class="row">
            <div class="col">
                <h3>{$error}</h3>
            </div>
        </div>
EOD;
} else {
    $htmlContent .= <<<EOD
    <div class="row">
        <div class="col">
            <b>Folio de la compra:</b> {$id_transaccion}
            <br>
            <b>Fecha de compra:</b> {$fecha}
            <br>
            <b>Total:</b> {$moneda} {$format}
            <br>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
EOD;

    while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) {
        $importe = $row_det['precio'] * $row_det['cantidad'];
        $htmlContent .= <<<EOD
            <tr>
                <td>{$row_det['cantidad']}</td>
                <td>{$row_det['nombre']}</td>
                <td>{$importe}</td>
            </tr>
EOD;
    }

    $htmlContent .= <<<EOD
                </tbody>
            </table>
        </div>
    </div>
EOD;
}

$htmlContent .= <<<EOD
</div>
EOD;


// Escribir contenido HTML en el PDF
$pdf->writeHTML($htmlContent, true, false, true, false, '');

// Generar el PDF
$pdf->Output('recibo.pdf', 'I'); // 'I' para mostrar en el navegador, 'D' para descargar
