<?php
require_once("../model/base_datos_productos.php");
require_once("../model/config.php");


if (isset($_POST["nombre"]) && isset($_POST["codigo"]) && isset($_POST["categoria"])) {

    $producto = new Productos($name_bd_productos);
    $nombre = $_POST["nombre"];
    $codigo = $_POST["codigo"];
    $categoria = $_POST["categoria"];
    $aux_categoria = 0;

    if (empty($codigo) || empty($nombre)) {

        header("location: ../index.php?page=3&conerror=96");
    } else {

        /*Se almacena en una array todas las categorias, de esta manera se recorre con un for
    y si el usuario por error introdujo una categoria que no pertenece a este array se enviará
    devuelta a la página de inicio con un error */

        //----------------------------------------------------------------------------------------//
        // $categorias = ["Almacén", "Bebes y niños", "Bebidas", "Carnes", "Electricidad",
        // "Ferretería", "Herramientas eléctricas", "Herramientas manuales", "Plomería", "Congelados",
        // "Frutas y verduras", "Lácteo", "Librería", "Limpieza", "Mascotas", "Perfumería"];

        $nombre_db = "productos_base";
        $categorias = $producto->obtenerRubros($nombre_db);

        //-----------------------------------------------------------------------------------------//

        foreach ($categorias as $categoria_a) {

            if ($categoria_a == $categoria) {

                $aux_categoria++;
            }
        }

        if ($aux_categoria > 0) {

            if ($producto->insertarProducto($nombre, $codigo, $categoria)) {


                header("location: ../index.php?page=0&success=55");
            } else {

                header("location: ../index.php?page=0&conerror=40");
            }
        } else {

            header("location: ../index.php?page=0&conerror=96");
        }
    }
} else {

    header("location: ../index.php?page=0&conerror=40");
}
