<?php
require("../model/base_datos_usuarios.php");
session_start();
$codigo = $_POST["codigo"];
$idUsuario = $_SESSION['ID_USER'];

$cupones = new Cupones();

try {
    $res = $cupones->agregar_cupon_comercio(
        $codigo,
        $idUsuario
    );

    echo (json_encode($res));
    header("location: ../index.php?page=5&success=66");
} catch (\Throwable $th) {
    echo ($th);
}
