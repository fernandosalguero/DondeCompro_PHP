<?php

require_once("../model/base_datos_usuarios.php");
session_start();

$usuarioDatosIncompletos = new consultarUsuario();
$nombre = $_SESSION["nombre"];
$usuarioDatosIncompletos->consultarDatosIncompletos($nombre);


echo json_encode(array(
    'datos' => $usuarioDatosIncompletos,
));
