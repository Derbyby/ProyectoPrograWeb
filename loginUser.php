<?php
include 'html/header.php';
require 'php/database.php';
require_once 'php/config.php';
require 'admin/clases/clienteFunciones.php';
$db = new Database();
$con = $db->conectar();

$errors = [];

if(!empty($_POST)){
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if(esNulo([$usuario, $password])){
        $errors[] = "Debe llenar todos los campos";
    }

    if(count($errors) == 0){
        $errors[] = login($usuario, $password, $con);
    }
}

?>

<head>
    <title>WoofLandia</title>
</head>

<main class="form-login m-auto pt-4">
    <h2>Iniciar sesion</h2>

    <?php mostrarMensajaes($errors);?>

    <form class="row g-3" action="loginUser.php" method="post" autocomplete="off">

        <div class="form-floating">
            <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Usuario" requireda>
            <label for="usuario">Usuario</label>
        </div>

        <div class="form-floating">
            <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" requireda>
            <label for="contraseña">Contraseña</label>
        </div>

        <div class="col-12">
            ¿No tiene cuenta?<a href="registro.php"> Registrate aqui</a>
        </div>

        <div class="d-grid gap-3 col-12">
            <button type="submit" class="btn btn-primary"> Ingresar</button>
        </div>

    </form>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
