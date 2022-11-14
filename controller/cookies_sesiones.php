<?php 

/*Esta funcion devuelve un valor del 1 al 3 dependiendo
del tipo de usuario que guardo la cookie
para iniciar una sesion con sus datos nombre y perfil si es 
un usuario común o negocio y nombre y ID si es el super Admin
*/
//--------------------//
function cookies(){

    if(isset($_COOKIE["ID"])){
        
        $_SESSION["nombre"] = $_COOKIE["nombre"];
        $_SESSION["ID"] = $_COOKIE["ID"];
        $_SESSION["correo"] = $_COOKIE["correo"];
        $_SESSION["fecha"] = $_COOKIE["fecha"];
        $_SESSION["imagen"] = $_COOKIE["imagen"];
        return 1;
    
    }else{
                
        switch($_COOKIE["perfil"]){

            case 0:

                $_SESSION["nombre"] = $_COOKIE["nombre"];
                $_SESSION["perfil"] = $_COOKIE["perfil"];
                $_SESSION["correo"] = $_COOKIE["correo"];
                $_SESSION["fecha"] = $_COOKIE["fecha"];
                $_SESSION["imagen"] = $_COOKIE["imagen"];
                $_SESSION["estado"] = $_COOKIE["estado"];

                return 2;

            break;

            case 1:

                $_SESSION["nombre"] = $_COOKIE["nombre"];
                $_SESSION["perfil"] = $_COOKIE["perfil"];  
                $_SESSION["correo"] = $_COOKIE["correo"];
                $_SESSION["fecha"] = $_COOKIE["fecha"];
                $_SESSION["imagen"] = $_COOKIE["imagen"];
                $_SESSION["estado"] = $_COOKIE["estado"];

                return 3;
                        
            break;

        }
    }

}    
//--------------------//


/*Esta funcion devuelve un valor del 1 al 4 dependiendo
del tipo de usuario que inició la sesión*/

//--------------------//
function session(){

    if(isset($_SESSION["ID"])){
        
        return 1;

    }else{

        switch($_SESSION["perfil"]){

            case 0:

                return 2;

            break;

            case 1:
                return 3;
            break;
    
        }

    }

}
//--------------------//
    
    
?>