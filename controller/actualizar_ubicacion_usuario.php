<?php
require_once("../model/base_datos_usuarios.php");
session_start();

if (
    isset($_POST["provincia-registro"]) && $_POST["provincia-registro"] != "seleccionar" &&
    isset($_POST["municipio-registro"]) && $_POST["municipio-registro"] != "seleccionar" &&
    isset($_POST["localidades-registro"]) && $_POST["localidades-registro"] != "seleccionar"
) {


    $provincia = $_POST["provincia-registro"];
    $municipio = $_POST["municipio-registro"];
    $localidad = $_POST["localidades-registro"];
    $lat = $_POST["lat"];
    $lon = $_POST["lon"];
    $usuario = new consultarUsuario();
    $nombre = $_SESSION["nombre"];
    $usuario->consultar($nombre);

    $ID = $usuario->registro["ID"];
    $ubicacion = new Ubicacion();

    if ($ubicacion->actualizarProvinciaMunicipioLocalidad($ID, $provincia, $municipio, $localidad, $lat, $lon)) {
        header("location: ../index.php?page=2&success=20");
    } else {
        header("location: ../index.php?page=2&conerror=40");
    }
} else {


    header("location: ../index.php?page=2&conerror=40");
}
