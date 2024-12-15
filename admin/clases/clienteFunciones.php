<?php

//Validaciones
function esNulo(array $parametros){
    foreach($parametros as $parametro){
        if(strlen(trim($parametro)) < 1){
            return true;
        }
    }
    return false;
}

function esEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

function validaPassword($password, $repassword){
    if(strcmp($password, $repassword) != 0){
        return false;
    }
    return true;
}

function usuarioExiste($usuario, $con){
    $sql = $con->prepare("SELECT id FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    
    if($sql->fetchColumn() > 0){
        return true;
    }
    return false;
}

function emailExiste($email, $con){
    $sql = $con->prepare("SELECT id FROM clientes WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    
    if($sql->fetchColumn() > 0){
        return true;
    }
    return false;
}

//Funciones
function generarToken(){
    return md5(uniqid(mt_rand(), false));
}

function registrarCliente(array $datos, $con){
    $sql = $con->prepare("INSERT INTO clientes(nombres, apellidos, email, telefono, identificador, estado, fecha_alta) 
                         VALUES (?,?,?,?,?,1, now())");
    if($sql->execute($datos)){
        return $con->lastInsertId();
    }
    return 0;
}

function registrarUsuario(array $datos, $con){
    $sql = $con->prepare("INSERT INTO usuarios(usuario, contraseña, activacion,token, id_cliente) VALUES (?,?,1,?,?)");
    if($sql->execute($datos)){
        return true;
    }
    return false;
}

function mostrarMensajaes(array $errrors){
    if(count($errrors) > 0){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        foreach($errrors as $errror){
            echo '<li>' . $errror. '</li>';
        }
        echo '</ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

function login($usuario, $contraseña, $con){
    $sql = $con->prepare("SELECT id, usuario, contraseña FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);

    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
        if(esActivo($usuario, $con)){
            if($contraseña === $row['contraseña']){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['usuario'];
                header("Location: index.php");
                exit;
            } 
        } else {
            return 'El usuario no ha sido activado';
        }
    }
    return 'El usuario y/o contraseña son incorrectos';
}

function esActivo($usuario, $con){
    $sql = $con->prepare("SELECT activacion FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if ($row['activacion'] == 1){
        return true;
    }
    return false;
}