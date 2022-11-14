<?php
session_start();

if (isset($_GET["indice"])) {

    $codProducto = $_SESSION["listado_codigo"][$_GET["indice"]];

    unset($_SESSION["listado_productos"][$_GET["indice"]]);
    unset($_SESSION["listado_codigo"][$_GET["indice"]]);

    $_SESSION["contador_productos"]--;

    echo (json_encode(array('producto' => $codProducto, 'result' => 1)));
} else {

    echo (json_encode(array('result' => 0)));
}
