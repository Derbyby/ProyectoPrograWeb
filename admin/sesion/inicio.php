<?php
require_once '../config/database.php';
require '../clases/adminFunciones.php';

$db = new Database();
$con = $db->conectar();

// // $password = 300505;
// // $sql = "INSERT INTO admin(usuario, contraseña, nombre, email, activo, fecha_alta)
// //         VALUES ('admin3', '$password', 'Yessenia', 'alu.22130839@gmail.com','1',NOW())";

// // $con->query($sql);

$errors = [];

if (!empty($_POST)) {
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);

    if (esNulo([$usuario, $contraseña])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        $errors = login($usuario, $contraseña, $con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Inicio de sesión</title>
    <link href="../css/sb-admin-2.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Iniciar sesion</h3>
                                </div>
                                <div class="card-body">
                                    <form action="inicio.php" method="post" autocomplete="off">
                                        <!-- <div class="form-floating mb-3">
                                            <input class="form-control" id="usuario" name="usuario" type="text"
                                                placeholder="usuario" value="admin3" autofocus />
                                            <label for="inputEmail">Usuario</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="contraseña" name="contraseña"
                                                type="password" placeholder="Contraseña" value="300505" />
                                            <label for="inputPassword">Contraseña</label>
                                        </div> -->

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="usuario" name="usuario" type="text"
                                                placeholder="Usuario" autofocus />
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="contraseña" name="contraseña"
                                                type="password" placeholder="Contraseña" />
                                        </div>

                                        <?php mostrarMensajes($errors); ?>
                                        
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <div class="text-left">
                                                <a class="small" href="/index.php">Volver a la página de inicio</a>
                                            </div>
                                            <a class="small"></a>
                                            <button type="submit" class="btn btn-primary">Iniciar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <footer class="inicio_footer">
        <div class="text-muted">Copyright &copy; WoofLandia 2024</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>