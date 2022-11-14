<?php 

require_once("../model/base_datos_usuarios.php");

session_start();

$nombre = $_SESSION["nombre"];

if($_SESSION["imagen"] !== null){

    $eliminar_a = "../".$_SESSION["imagen"];
    unlink($eliminar_a);

    $eliminar = new CambiarImagen();

    if($eliminar->eliminar($nombre)){

        if(isset($_COOKIE["imagen"])){

            setcookie("imagen", "", time()-1, "/");

        }

        $_SESSION["imagen"] = null;

        setcookie("imagen", $_SESSION["imagen"], time()+86400, "/");

        header("location: ../index.php?page=2");

    }else{

        header("location: ../index.php?page=2&conerror=80");

    }

}else{

    header("location: ../index.php?page=2&conerror=80");

}





?>