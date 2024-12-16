<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$query = isset($_GET['query']) ? $_GET['query'] : '';
$sql = $con->prepare("SELECT * FROM productos WHERE nombre LIKE :query");
$sql->execute(['query' => '%' . $query . '%']);
$resultados = $sql->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Resultados de búsqueda";
include 'header.php';
?>

<div class="container">
    <h1>Resultados de búsqueda para "<?php echo htmlspecialchars($query); ?>"</h1>
    <?php if (count($resultados) > 0) { ?>
        <ul>
            <?php foreach ($resultados as $producto) { ?>
                <li><?php echo htmlspecialchars($producto['nombre']); ?> - $<?php echo $producto['precio']; ?></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No se encontraron resultados.</p>
    <?php } ?>
</div>

<?php include 'footer.php'; ?>
