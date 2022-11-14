<?php
session_start();

if (isset($_GET["producto"]) && isset($_GET["codigo"])) {

    $producto = str_replace("_", " ", $_GET["producto"]);

    $codigo = $_GET["codigo"];

    if (isset($_SESSION["listado_productos"])) {

        $_SESSION["listado_productos"][$_SESSION["numero_productos"]] = $producto;
        $_SESSION["listado_codigo"][$_SESSION["numero_productos"]] = $codigo;

        echo 1;
    } else {

        $_SESSION["listado_productos"] = array();
        $_SESSION["listado_codigo"] = array();
        $_SESSION["listado_productos"][$_SESSION["numero_productos"]] = $producto;
        $_SESSION["listado_codigo"][$_SESSION["numero_productos"]] = $codigo;

        $_SESSION["contador_productos"]++;

        echo 1;
    }
} else {

    echo 0;
}
