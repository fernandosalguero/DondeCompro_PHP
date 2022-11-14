<?php
require("../model/base_datos_usuarios.php");
//require_once("../logger/logger.php");


if (isset($_GET["codigo"])) {

    $codigo = $_GET["codigo"];
    $ver = new Cupones();

    try {
        $res = $ver->ver_cupon($codigo);
        //Monologger::log(json_encode($res), 'ver cupon editar');
        echo(json_encode($res));
    } catch (\Throwable $th) {
        echo ($th);
    }
} else {

    echo "0";
}
