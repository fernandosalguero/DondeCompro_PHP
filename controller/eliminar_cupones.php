<?php
require("../model/base_datos_usuarios.php");
//require_once("../logger/logger.php");


if (isset($_GET["codigo"])) {

    $codigo = $_GET["codigo"];
    $eliminar = new Cupones();

    try {
        $res = $eliminar->eliminar_cupones($codigo);
        //Monologger::log(json_encode($res), 'eliminar cupones');
        echo(json_encode($res));
    } catch (\Throwable $th) {
        echo ($th);
    }
} else {

    echo "0";
}
