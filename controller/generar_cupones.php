<?php

require_once("../model/base_datos_usuarios.php");

$codigo = $_POST["codigo"];
$suscripcion = $_POST["suscripcion"];
$descuento = $_POST["descuento"];
$fechaDesde = $_POST["fechaDesde"];
$fechaHasta = $_POST["fechaHasta"];
$descripcion = $_POST["descripcion"];
$acumulable_ckeck = isset($_POST["acumulable"]);
$acumulable = 1;

if ($acumulable_ckeck != 1) {

    $acumulable = 0;
} else {
    $acumulable = 1;
}

$cupon = new Cupones();


if ($cupon->insertar_cupones($codigo, $suscripcion, $descuento, $fechaDesde, $fechaHasta, $descripcion, $acumulable)) {
    header("location: ../index.php?page=5&success=60");
} else {
    header("location: ../index.php?page=5&conerror=60");
}
