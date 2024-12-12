<?php
// session_start();

// print_r($_SESSION['sexo']);

if (!isset($_SESSION['nombre'])) {
    $nombreAdmin = "Administrador Desconocido";
}

$nombreAdmin = $_SESSION['nombre'];

echo "<script>console.log('PHP nombreAdmin:', " . json_encode($nombreAdmin) . ");</script>";

if (!isset($_SESSION['sexo'])) {
    $_SESSION['sexo'] = "3";
}

$sexoAdmin = $_SESSION['sexo'];
// echo "<script>console.log('PHP sexoAdmin:', " . json_encode($sexoAdmin) . ");</script>";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Dashboard">
    <meta name="author" content="">

    <title>
        <?php echo isset($pageTitle) ? $pageTitle : "WoofLandia Admin"; ?>
    </title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index-admin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="inventario.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inventario</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Productos</div>

            <!-- Nav Item - Agregar Productos -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Registrar</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones de Productos:</h6>
                        <a class="collapse-item" href="registrar.php">Nuevo Producto</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Editar Productos -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Editar</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones de Edición:</h6>
                        <a class="collapse-item" href="edicion_masiva.php">Edición Masiva</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="sidebar-brand-text mx-3">
                        <?php echo isset($pageTitle) ? $pageTitle : "WoofLandia Admin"; ?>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="nombreAdmin">
                                    <!-- //echo htmlspecialchars($nombreAdmin); -->
                                    Administrador Desconocido
                                </span>
                                <img class="img-profile rounded-circle" id="imgPerfil" alt="User Image" width="30">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="sesion/cerrar.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Scripts -->
                <script src="js/jquery.js"></script>
                <script src="js/bootstrap.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const nombreAdmin = <?php echo json_encode($nombreAdmin); ?>;
                        const nombreElemento = document.getElementById("nombreAdmin").textContent = nombreAdmin;

                        // Actualiza el nombre
                        if (nombreAdmin && nombreElemento) {
                            nombreElemento.textContent = nombreAdmin;
                        } else {
                            console.warn("No se encontró el elemento o el nombre está vacío.");
                        }
                    });
                </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const sexoAdmin = parseInt(<?php echo json_encode($sexoAdmin); ?>, 10);

                        // console.log("Tipo de dato de sexoAdmin:", typeof sexoAdmin);
                        // console.log("Valor de sexoAdmin:", sexoAdmin);

                        //Imagen según sexo
                        const imgElemento = document.getElementById("imgPerfil");

                        if (imgElemento) {
                            if (sexoAdmin === 0) {
                                // console.log("Configurando imagen masculina");
                                imgElemento.src = "img/hombre.svg";
                                imgElemento.alt = "Imagen Masculina";
                            } else if (sexoAdmin === 1) {
                                // console.log("Configurando imagen femenina");
                                imgElemento.src = "img/mujer.svg";
                                imgElemento.alt = "Imagen Femenina";
                            } else {
                                // console.log("Configurando imagen por defecto");
                                imgElemento.src = "img/default.svg";
                                imgElemento.alt = "Imagen por Defecto";
                            }
                        } else {
                            console.error("No se encontró el elemento de la imagen.");
                        }
                    });

                </script>

</body>

</html>