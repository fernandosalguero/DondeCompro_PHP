<?php 
require_once("../model/base_datos_usuarios.php");
session_start();

if(isset($_POST["promos"]) && $_POST["promos"] != ""){

    $usuario = new consultarUsuario();
    $usuario->consultar($_SESSION["nombre"]);
    $ID = $usuario->registro["ID"];
    $info = new DatosInfoNegocio();
    $promos = $_POST["promos"];
    $promo = new InfoNegocio();


    if($promo->actualizarPromos($ID, $promos)){

        header("location: ../index.php");


    }else{

        header("location: ../index.php?conerror=406");

    }


}else{

    header("location: ../index.php?conerror=40");

}






?>