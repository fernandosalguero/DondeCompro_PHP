<?php

require_once("../model/base_datos_usuarios.php");

if (isset($_GET["id"])) {

    $id = (int) $_GET["id"];
    $usuario_bd = new estadoUsuario();
    $result = $usuario_bd->bloquearUsuario($id);
    echo ($result);
}
