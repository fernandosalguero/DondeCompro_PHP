<?php 
require_once("../model/base_datos_productos.php");
require_once("../model/base_datos_usuarios.php");
session_start();

if(isset($_POST["porcentaje"])){

    $porcentaje = $_POST["porcentaje"];

    if(empty($porcentaje)){

        header("location: ../index.php?conerror=63");

    }else{

        $nombre = $_SESSION["nombre"];
        $usuario = new consultarUsuario();
        $usuario->consultar($nombre);
        $ID = $usuario->registro["ID"];
        $nombre_tabla = "productos_".$ID;

        $negocio = new Precios();

        if($negocio->AumentarPorcentaje($nombre_tabla, $porcentaje)){

            header("location: ../index.php?success=123");

        }else{

            header("location: ../index.php?conerror=63");

        }
    }


}else{

    header("location: ../index.php?conerror=63");

}


?>