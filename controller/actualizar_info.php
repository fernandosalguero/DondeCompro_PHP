<?php 

require_once("../model/base_datos_usuarios.php");
session_start();

$nombre = htmlentities(addslashes($_POST["nombre"]));
$correo = htmlentities(addslashes($_POST["correo"]));
$clave = htmlentities(addslashes($_POST["clave"]));


//---Se evalua si se ha iniciado sesión, capturando el nombre y el correo sino es así se redirige a la página con un error---//
if(htmlentities(addslashes($_SESSION["nombre"])) == $nombre && htmlentities(addslashes($_SESSION["correo"])) == $correo){

    header("location: ../index.php?page=2&conerror=40");

}elseif($nombre == "" || $correo == "" || $clave == ""){ /* Si alguna de las variables capturadas están vacías, es decir, si por
                                                            error se llega a este archivo con estas variables vacías,  
                                                            se redirige a la pàgina con un error */
    header("location: ../index.php?page=2&conerror=40");

}else{
    
/*Si se ha iniciado sesión y las variables contienen información, se procede a actualizar los datos
primero se captura la el nombre de la sesión para utilizarlo en la consulta, luego se actualizan los datos
y finalmente se evalua si hay cookies creadas, si es así, se destruyen y se vuelven a crear con los nuevos datos
y se redirige a la pagina con */

    $actualizar = new ActualizarDatos();
    $sesion_nombre = $_SESSION["nombre"];

        if($actualizar->verificarClave($sesion_nombre, $clave)){

            if($actualizar->actualizar($nombre, $correo)){

                $actualizar->nuevaConsulta($nombre, $correo);

                $registro = $actualizar->getRegistro();

                $_SESSION["nombre"] = $registro["nombre"];
                $_SESSION["correo"] = $registro["correo"];
                $_SESSION["fecha"] = $registro["fecha"];
                $_SESSION["perfil"] = $registro["perfil"];
                $_SESSION["imagen"] = $registro["imagen"];
            
                /*--Este bloque evalua si existen cookies y si es así
                    las elimina y las vuelve a crear con la información
                 actualizada--*/
                //----------------------------------------//
                if(isset($_COOKIE["nombre"])){

                    setcookie("nombre", "", time()-1, "/");
                    setcookie("correo", "", time()-1, "/");
                    setcookie("fecha", "", time()-1, "/");
                    setcookie("imagen", "", time()-1, "/");
                
                
                    if(isset($_COOKIE["perfil"])){
            
                        setcookie("perfil", "", time()-1, "/");
            
                    }else{
            
                        setcookie("ID", "", time()-1, "/");
            
                    }

                    setcookie("nombre", $registro["nombre"], time()+86400, "/");
                    setcookie("correo", $registro["correo"], time()+86400, "/");
                    setcookie("fecha", $registro["fecha"], time()+86400, "/");
                    setcookie("imagen", $registro["imagen"], time()+86400, "/");

                    if($registro["ID"] == 1){

                        setcookie("ID", $registro["ID"], time()+86400, "/");
    
                    }else{
    
                        setcookie("perfil", $registro["perfil"], time()+86400, "/");
    
                    }

                }
                //----------------------------------------//
                  

                header("location: ../index.php?page=2");
                

            }else{

                header("location: ../index.php?page=2&conerror=40");

            }

        }else{

            header("location: ../index.php?page=2&conerror=35");

        }
    }




?>