<?php 

require_once("../model/base_datos_usuarios.php");

/*--- Este bloque consulta si existe un usuario con el nombre que el usuario digitó
      si es así, devuelve 1, sino devuelve 0 y luego en el archivo validar.js 
      está la función para hacer la acción a realizar dependiendo la respuesta ---*/
//---------------------------//
if(isset($_GET["nombre"])){

    $nombre = htmlentities(addslashes($_GET["nombre"]));
    $consulta = new consultarUsuario();
    $respuesta = $consulta->consultar($nombre);

    echo $respuesta;

}
//--------------------------//



/*--- Este bloque consulta si existe un usuario con el correo que el usuario digitó
      si es así, devuelve 1, sino devuelve 0 y luego en el archivo validar.js 
      está la función para hacer la acción a realizar dependiendo la respuesta ---*/
//---------------------------//
if(isset($_GET["correo"])){

    $correo = $_GET["correo"];

    $consulta = new consultarCorreo();

    $respuesta = $consulta->consultar($correo);

    echo $respuesta;

}
//---------------------------//




/*--- Este bloque consulta si existe un usuario con el correo que el usuario digitó
      si es así, devuelve 1, sino devuelve 0 y luego en el archivo validar.js 
      está la función para hacer la acción a realizar dependiendo la respuesta ---*/
//---------------------------//
if(isset($_GET["valor"])){

    $valor = $_GET["valor"];

    $consultaN = new consultarUsuario();
    $consultaC = new consultarCorreo();

    if($consultaN->consultar($valor) > 0 || $consultaC->consultar($valor) > 0){

        echo "1";

    }else{

        echo "0";

    }

}
//---------------------------//



?>