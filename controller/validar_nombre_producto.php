<?php 

require_once("../model/base_datos_productos.php");
require_once("../model/config.php");

if(isset($_GET["nombre"])){

    

    $producto = new Productos($name_bd_productos);

    if($producto->consultarProducto($_GET["nombre"])){

        echo 1;

    }else{

        echo 0;

    }


}else{

    echo 1;


}









?>