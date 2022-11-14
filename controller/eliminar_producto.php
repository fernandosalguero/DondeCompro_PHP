<?php 
require("../model/base_datos_productos.php");
require("../model/base_datos_usuarios.php");


if(isset($_GET["codigo"])){

    $codigo = $_GET["codigo"];
    $negocios = new Extraer();
    $eliminar = new EliminarProducto();

    $negocios_re = $negocios->extraerNegociosAll();

    foreach($negocios_re as $negocio){

        $db = "productos_".$negocio["ID"];
        $eliminar->eliminar($codigo, $db);

    }

    $db = "productos_base";
    $eliminar->eliminar($codigo, $db);

    echo "1";


}else{

    echo "0";

}







?>