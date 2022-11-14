<?php
require("../model/base_datos_usuarios.php");
//require_once("../logger/logger.php");


$codigo = $_POST["codigoUpd"];
$suscripcion = $_POST["suscripcionUpd"];
$descuento = $_POST["descuentoUpd"];
$fechaDesde = $_POST["fechaDesdeUpd"];
$fechaHasta = $_POST["fechaHastaUpd"];
$descripcion = $_POST["descripcionUpd"];
$acumulable_ckeck = isset($_POST["acumulableUpd"]);
$acumulable;


$actualizar = new Cupones();

if ($acumulable_ckeck != 1) {

    $acumulable = 0;
} else {
    $acumulable = 1;
}

try {
    $res = $actualizar->editar_cupones(
        $suscripcion,
        $descuento,
        $fechaDesde,
        $fechaHasta,
        $descripcion,
        $acumulable,
        $codigo
    );

    header("location: ../index.php?page=5&success=66");
    echo (json_encode($res));
} catch (\Throwable $th) {
    echo ($th);
}
