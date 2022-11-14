<?php 

require_once("../model/base_datos_usuarios.php");

$valor = htmlentities(addslashes($_POST["nombre_u"]));
$clave = htmlentities(addslashes($_POST["clave_u"]));

$usern = new consultarUsuario();
$userc = new consultarCorreo();

$usern->setDB("usuarios_temp");
$userc->setDB("usuarios_temp");

if($usern->consultar($valor) || $userc->consultar($valor)){

    if($usern->verificarClave($clave) || $userc->verificarClave($clave)){

        header("location:../view/verificacion.php");
    }

}



$conexion = new login(); //Objeto que tiene los métodos necesarios para validar y almacenar datos del login


/*--Inicia sesión a función del valor devuelto 
por el método validate del objeto conexion--*/

switch($conexion->validate($valor, $clave)){

//--------Para cuando haya un error en los datos--------//
    case 0: 

        
    header("location:../index.php?conerror=30");
        

    break;
//------------------------------------------------------//
        

//----------Para un usuario común o negocio---------//
    case 1:

        $registro = $conexion->getRegistro();

        /*---Este bloque evalua si se ha marcado la casilla de recordar
             y si es así crea una cookie para almacenar la información
             que luego se a a utilizar para que después no tenga que 
             hacer el login nuevamente---*/
        if(isset($_POST["recordar"])){

            setcookie("nombre", $registro["nombre"], time()+86400, "/");
            setcookie("perfil", $registro["perfil"], time()+86400, "/");
            setcookie("correo", $registro["correo"], time()+86400, "/");
            setcookie("fecha", $registro["fecha"], time()+86400, "/");
            setcookie("imagen", $registro["imagen"], time()+86400, "/");
            setcookie("estado", $registro["estado"], time()+86400, "/");


        }

        //---------------------------------/
        
        session_start();
        $_SESSION["nombre"] = $registro["nombre"];
        $_SESSION["perfil"] = $registro["perfil"];
        $_SESSION["correo"] = $registro["correo"];
        $_SESSION["fecha"] = $registro["fecha"];
        $_SESSION["imagen"] = $registro["imagen"];
        $_SESSION["estado"] = $registro["estado"];
        header("location:../index.php");

    break;
//-------------------------------------------------//

//--------------Para el super admin---------------//
    case 2:

        $registro = $conexion->getRegistro();

        /*---Este bloque evalua si se ha marcado la casilla de recordar
             y si es así crea una cookie para almacenar la información
             que luego se a a utilizar para que después no tenga que 
             hacer el login nuevamente---*/
        if(isset($_POST["recordar"])){

            setcookie("ID", $registro["ID"], time()+86400, "/");
            setcookie("nombre", $registro["nombre"], time()+86400, "/");
            setcookie("correo", $registro["correo"], time()+86400, "/");
            setcookie("fecha", $registro["fecha"], time()+86400, "/");
            setcookie("imagen", $registro["imagen"], time()+86400, "/");

        }
        //---------------------------------/
        
        session_start();
        $_SESSION["nombre"] = $registro["nombre"];
        $_SESSION["ID"] = $registro["ID"];
        $_SESSION["correo"] = $registro["correo"];
        $_SESSION["fecha"] = $registro["fecha"];
        $_SESSION["imagen"] = $registro["imagen"];
        $_SESSION["lat"] = $registro["centroide_localidad_lat"];
        $_SESSION["long"] = $registro["centroide_localidad_lon"];
        $_SESSION["localidad"] = $registro["localidad"];
        
        header("location:../index.php");

    break;
//------------------------------------------------//

    
}
