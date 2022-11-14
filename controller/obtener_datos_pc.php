<?php

require_once("../model/base_datos_usuarios.php");
session_start();

$usuario = new consultarUsuario();
$nombre = $_SESSION["nombre"];
$usuario->consultar($nombre);
$usuarioRegistro = $usuario->registro;

if (!isset($_SESSION["listado_productos"]))
    $listado_productos = array();
else
    $listado_productos = array_values( $_SESSION["listado_productos"]);

if (!isset($_SESSION["listado_codigo"]))
    $listado_codigo = array();
else
    $listado_codigo =array_values( $_SESSION["listado_codigo"]);

echo json_encode(array(
    'usuario' => $usuarioRegistro,
    'listado_productos' => $listado_productos,
    'listado_codigo' => $listado_codigo
));
