<?php

session_start();

if (isset($_POST['tipo']) && $_POST['tipo'] ==  'set') {
    $_SESSION['PRODUCTOS_BUSQUEDA_PC'] = $_POST['productos_busqueda'];
    echo 1;
}


if (isset($_GET['tipo']) && $_GET['tipo'] ==  'get') {
    $productos_busqueda = $_SESSION['PRODUCTOS_BUSQUEDA_PC'];
    echo ($productos_busqueda);
}
