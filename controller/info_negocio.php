<?php
require_once("../model/base_datos_usuarios.php");
session_start();

if(isset($_POST["envios"]) && isset($_POST["pago"]) && isset($_POST["telefono"])){

    $envios = $_POST["envios"];
    $cobro = $_POST["pago"];
    $telefono = $_POST["telefono"];
    $nombre = $_SESSION["nombre"];
    $usuario = new consultarUsuario();
    $usuario->consultar($nombre);
    $ID = $usuario->registro["ID"];

    $actualizar = new InfoNegocio();

    if($actualizar->actualizarInfo($telefono, $envios, $cobro, $ID)){

        header("location: ../index.php?page=2&success=20");

    }else{

        header("location: ../index.php?page=2&conerror=45");

    }

}else{

    header("location: ../index.php?page=2&conerror=40");


}



?>