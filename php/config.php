<?php
    define("CLIENT_ID", "ASn3NZdlgFzkACfvTkx7k1TDb6VCFQTnDbiOrxnf9p62C-TaoVFIPQYSX9YnihfnCxc_VMKkmL7cQkiq");
    define("CURRENCY", "MXN");
    define("KEY_TOKEN", "APR.wqc-354");
    define("MONEDA", "$");

    // session_start();

    $num_cart = 0;
    if(isset($_SESSION['carrito']['productos'])){
        $num_cart = count($_SESSION['carrito']['productos']);
    }
?>