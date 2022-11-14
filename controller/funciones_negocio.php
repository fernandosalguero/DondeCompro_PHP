<?php 
require_once("model/base_datos_productos.php");
require_once("model/base_datos_usuarios.php");
require_once("model/config.php");
$GLOBALS['name_bd_productos'] = $name_bd_productos;

/*La siguiente función extrae los datos de la tabla de productos base y se los agrega
a la tabla de productos del comercio */
//------------------------------//
function guardarProductos(){

    $name_bd_productos = $GLOBALS['name_bd_productos'];

    $producto = new Productos($name_bd_productos);
    $usuario = new consultarUsuario();
    $nombre = $_SESSION["nombre"];
    $usuario->consultar($nombre);
    $ID = $usuario->registro["ID"];
    $nombre_tabla = "productos_".$ID;

    if($producto->extraerProductosNC($nombre_tabla)){

        $registro = $producto->registro;
        
        foreach($registro as $registro){

           $producto->insertarProductoTB($registro["Descripcion"], $registro["Codigo"], $registro["Rubro"], $nombre_tabla);

        }

        return;


    }else{

        return;

    }
}
//------------------------------//


function darBajaSubscripcion(){


    $usuario = new consultarUsuario();
    $nombre = $_SESSION["nombre"];
    $usuario->consultar($nombre);

    if($usuario->registro["estado"] == 1){

        $subscripcion = new Subscripcion();
        $ID = $usuario->registro["ID"];

        if($subscripcion->consultarSubscripcion($ID)){

            $hoy = date("Y-m-d");

            if($hoy > $subscripcion->registro["fecha_expiracion"]){

                $subscripcion->eliminarSubscripcion($ID);

                $datos_n = new InfoNegocio();
                $datos_n->eliminarSubscripcion($ID);

                $negocio = new Negocio();
                $negocio->darDeBaja($ID);

                header("location: index.php?conerror=105");


            }else{

                return;

            }


        }else{

            return;

        }


    }else{

        return;

    }

}
