<?php
include '../html/header-inicio.php';
require '../php/database.php';
require_once '../php/config.php';
require '../clases/clienteFunciones.php';
$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $ine = trim($_POST['ine']);
    $telefono = trim($_POST['telefono']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esNulo([$nombres, $apellidos, $email, $telefono, $ine, $usuario, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es valida";
    }

    if (!validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (usuarioExiste($usuario, $con)) {
        $errors[] = "El usuario  $usuario ya existe";
    }

    if (emailExiste($email, $con)) {
        $errors[] = "El correo electronico $email ya existe";
    }

    if (count($errors) == 0) {

        $id = registrarCliente([$nombres, $apellidos, $email, $telefono, $ine], $con);

        if ($id > 0) {
            //$pass_has = password_hash($password, PASSWORD_DEFAULT);//Cifra la contraseña
            $token = generarToken();
            if (!registrarUsuario([$usuario, $password, $token, $id], $con)) {
                $errors = "error al registrar usuario";
            }
        } else {
            $errors[] = "error al registrar cliente";
        }
    }
}

?>

<head>
    <title>Registrar cuenta</title>
</head>

<main class="registro">
    <div class="container">
        <h2>Datos del cliente</h2>

        <?php mostrarMensajaes($errors); ?>

        <form class="row g-3" action="registro.php" method="post" autocomplete="off">

            <div class="form-floating">
                <label for="nombres"><span class="text-danger">*</span> Nombres</label>
                <input type="text" name="nombres" id="nombres" class="form-control" required>
                <span id="error-nombres" class="text-danger"></span>
            </div>

            <div class="form-floating">
                <label for="apellidos"><span class="text-danger">*</span> Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                <span id="error-apellidos" class="text-danger"></span>
            </div>

            <div class="form-floating">
                <label for="email"><span class="text-danger">*</span> Correo electronico</label>
                <input type="email" name="email" id="email" class="form-control" required>
                <span id="error-email" class="text-danger"></span>
                <span id="validaEmail" class="text-danger"></span>
            </div>

            <div class="form-floating">
                <label for="telefono"><span class="text-danger">*</span> Telefono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control" required>
                <span id="error-telefono" class="text-danger"></span>
            </div>

            <div class="form-floating">
                <label for="ine"><span class="text-danger">*</span> INE</label>
                <input type="text" name="ine" id="ine" class="form-control" required>
                <span id="error-ine" class="text-danger"></span>
            </div>

            <div class="form-floating">
                <label for="usuario"><span class="text-danger">*</span> Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" required>
                <span id="error-usuario" class="text-danger"></span>
                <span id="validaUsuario" class="text-danger"></span>
            </div>

            <div class="form-floating">
                <label for="password"><span class="text-danger">*</span> Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span id="error-password" class="text-danger"></span>
            </div>

            <div class="form-floating">
                <label for="repassword"><span class="text-danger">*</span>Confirmar contraseña</label>
                <input type="password" name="repassword" id="repassword" class="form-control" required>
                <span id="error-repassword" class="text-danger"></span>
            </div>

            <div class="col-12">
                <i><b>Nota:</b> Los campos con asterisco son obligatorios</i>
            </div>

            <div class="d-grid gap-3 col-12">
                <button type="submit" class="btn btn-primary"> Registrar</button>
            </div>

        </form>
    </div>

    <footer>
        <p>&copy; 2024 WoofLandia. Todos los derechos reservados.</p>
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

<script src="../js/validaciones.js"></script>

<script>
    let txtUsuario = document.getElementById('usuario')
    txtUsuario.addEventListener("blur", function () {
        existeUsuario(txtUsuario.value)
    }, false)

    let txtEmail = document.getElementById('email')
    txtEmail.addEventListener("blur", function () {
        existeEmail(txtEmail.value)
    }, false)


    function existeUsuario(usuario) {
        let url = "../clases/clienteAjax.php"
        let formData = new FormData()
        formData.append("action", "existeUsuario")
        formData.append("usuario", usuario)

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    document.getElementById('usuario').value = ""
                    document.getElementById('validaUsuario').innerHTML = "Usuario no disponible"
                } else {
                    document.getElementById('validaUsuario').innerHTML = ''
                }
            })
    }

    function existeEmail(email) {
        let url = "../clases/clienteAjax.php"
        let formData = new FormData()
        formData.append("action", "existeEmail")
        formData.append("email", email)

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    document.getElementById('email').value = ""
                    document.getElementById('validaEmail').innerHTML = "Email no disponible"
                } else {
                    document.getElementById('validaEmail').innerHTML = ''
                }
            })
    }
</script>