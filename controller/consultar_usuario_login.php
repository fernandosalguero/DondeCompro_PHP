<?php 

require_once("../model/base_datos_usuarios.php");


/*--- Este bloque consulta si existe un usuario con el correo que el usuario digitó
      si es así, devuelve 1, sino devuelve 0 y luego en el archivo validar.js 
      está la función para hacer la acción a realizar dependiendo la respuesta ---*/
//---------------------------//
if(isset($_GET["valor"])){

    $valor = htmlentities(addslashes($_GET["valor"]));

    $consultar = new consultarUsuario();
    $consultar_correo = new consultarCorreo();

    if($consultar->consultar2($valor) || $consultar_correo->consultar($valor)){

        echo "1";

    }else{

        echo "0";

    }

}
//---------------------------//



?>