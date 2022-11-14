<?php 

require_once("../model/base_datos_usuarios.php");
require_once("../model/base_datos_productos.php");

session_start();

/*Este archivo captura el nombre del usuario que inició sesió y su perfil
primero se evalua si el nombre de usuario está en la base de datos y si es así
se extrae el id para acceder a su tabla de productos, finalmente se captura el precio
 que sería el nuevo precio del producto y el código que corresponde al producto y se 
 actualiza el precio, si la consulta de actualización fue exitosa, imprime un "si" o un
 "no" si la consulta no fue exitosa, esto luego se utiliza en el AJAX para mostrar
 el mensaje correspondiente */

$nombre = $_SESSION["nombre"];
$perfil = $_SESSION["perfil"];

$consultar = new consultarUsuario();
$registro = $consultar->datos($nombre);
$id = $registro["ID"];

if($perfil == 1 && $id !== ""){

    $nombre_db = "productos_".$id;

    $precio = $_GET["precio"];
    $codigo = $_GET["codigo"];
    $producto = new Productos($nombre_db);

    if($producto->cambiarPrecio($precio, $codigo)){


        echo "si";

    }else{

        echo "no";

    }


}else{

    echo "no";

}



?>