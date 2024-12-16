<?php
ob_start();
require_once 'php/config.php';
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-..." crossorigin="anonymous" />
    <link rel="preload" href="/css/style.css" as="style" />
    <!-- <link href="/css/style.css" rel="stylesheet"> -->
    <link href="../css/style.css" rel="stylesheet" />
</head>

<body>
    <header>
        <a href="../index.php" class="logo">
            <img class="logo" src="../imagen/logo.png" alt="WoofLandia">
        </a>
        <div class="search-bar">
            <input type="text" placeholder="Buscar productos..." />
            <button>Buscar</button>
        </div>

                <!-- Cart icon -->
                <i class="bx bx-shopping-bag me-1" title="Carrito" id="cart-icon"></i>

                <!-- Cart -->
                <div class="cart">
                    <h2 class="cart-title">Carrito</h2>

                    <!-- Contenido del carrito (cart) -->
                    <div class="cart-content"></div>

                    <!-- Total del carro -->
                    <div class="total">
                        <!-- Si no ha iniciado siesion lo manda a iniciarla -->
                        <?php if(isset($_SESSION['user_cliente'])){ ?>
                        <a href="pago.php" class="btn-buy">Comprar ahora</a>

                        <?php } else { ?>

                        <a href="comprarSinUser.php?pago" class="btn-buy">Comprar ahora</a>
                        <?php } ?>

                        <!-- <button type="button" class="btn-buy">Comprar Ahora</button> -->
                        <div class="total-title">Total</div>
                        <div class="total-price">$0</div>
                    </div>

                    <!-- Cierre del carrito -->
                    <i class="bx bx-x" id="cart-close"></i>
                </div>

                <!-- Si no inicio sesion muestra para iniciar -->
                <?php if(isset($_SESSION['user_id'])){ ?>
                <!-- Menu desplegable -->
                <div class="dropdown">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        id="btn_session" aria-expanded="false">
                        <i class="bx bx-user" id="user-icon"><a></i>
                        <?php echo $_SESSION['user_name'];?></a>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="btn_session">
                        <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>
                    </ul>
                </div>
                            
                <?php } else {?>
                    <a href="loginUser.php" title="Iniciar sesion" class="bx bx bxs-user" id="user-icon"><a>
                    <a href="../admin/sesion/inicio.php" title="Iniciar sesion Administrador" class="bx bx bxs-user-badge" id="admin-icon"><a>
                <?php } ?>
    </header>
    <nav>
        <a href="#">Razas</a>
        <a href="#">Ofertas</a>
        <a href="#">Contacto</a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-..."
        crossorigin="anonymous"></script>
    <script src="/app.js"></script>
    <script src="/slider.js"></script>

    <footer>
        <p>&copy; 2024 WoofLandia. Todos los derechos reservados.</p>
    </footer>
</body>

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
        let status = "<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>";

        if (status) {
            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }
    });
</script>

</html>
