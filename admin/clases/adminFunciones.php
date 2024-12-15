<?php
function esNulo(array $parametros): bool
{
    foreach ($parametros as $parametro) {
        if (strlen(trim($parametro)) < 1) {
            return true;
        }
    }
    return false;
}

function usuarioExiste($usuario, $con): bool
{
    $sql = $con->prepare("SELECT id FROM admin WHERE usuario = ? LIMIT 1");
    $sql->execute([$usuario]);
    return $sql->fetchColumn() > 0;
}

function login($usuario, $contraseña, $con): array
{
    $errors = [];

    $sql = $con->prepare("SELECT * FROM admin WHERE usuario = ? LIMIT 1");
    $sql->execute([$usuario]);
    $admin = $sql->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // if (password_verify($contraseña, $admin['contraseña'])) {
        if ($admin['contraseña'] == $contraseña) {
            session_start();
          
            $_SESSION['id'] = $admin['id'];
            $_SESSION['nombre'] = $admin['nombre'];
            $_SESSION['sexo'] = $admin['sexo'];
            $_SESSION['user_type'] = 'admin';

            header("Location: ../index-admin.php");
            exit;
        } else {
            $errors[] = "Contraseña incorrecta.";
        }
    } else {
        $errors[] = "Usuario no encontrado.";
    }

    return $errors;
}

function mostrarMensajes($errors)
{
    if (!empty($errors)) {
        echo '<div class="alert alert-danger">';
        foreach ($errors as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
    }
}


?>
