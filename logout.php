<?php 
require 'php/config.php';

//Cerrar sesion 
session_destroy();

header("Location: index.php");

?>
