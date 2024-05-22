<?php
    define("CLIENT_ID", "Ad7IMXOaBDm9Rti8M3nHRqSW3gsrwo_4NmWbdzH7QKBtP6czf5PN6wUEEVlKMpHpWP80sfTtMr_CSlXj"); 
    define("CURRENCY", "MXN"); 
    define("KEY_TOKEN", "APR.wqc-354*"); 
    define("MONEDA", "$");

    session_start();

    $num_cart = 0;
    if(isset($_SESSION['carrito']['productos'])){
        $num_cart = count($_SESSION['carrito']['productos']);
    }
?>