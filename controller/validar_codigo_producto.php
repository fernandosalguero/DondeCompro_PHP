<?php 

require_once("../model/base_datos_productos.php");
require_once("../model/config.php");

if(isset($_GET["codigo"])){

    $producto = new Productos($name_bd_productos);

    if($producto->consultarProductoCodigo($_GET["codigo"])){

        echo 1;

    }else{

        echo 0;

    }


}else{

    echo 1;


}



?>