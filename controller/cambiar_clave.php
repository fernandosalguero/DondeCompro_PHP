<?php 

require_once("../model/base_datos_usuarios.php");

/*Se captura la contraseña actual, la nueva y repite (que es la confirmación de la nueva contraseña)
luego se evalua, si cualquiera de las 3 variables está vacía se retorna con un error,
sino es así, se evalua: si la contraseña nueva y repite coinciden, si no es así, se retorna con un error,
si coinciden, se evalua si la contraseña actual coincide con el usuario que ha iniciado sesión,
si no es así se retorna un eror, si es así, se procede a actualizar la contraseña y a redirigr al 
usuario al la página con un mensaje de éxito*/

//------------------------//
$clave = $_POST["clave"];
$nueva = $_POST["nueva"];
$repite = $_POST["repite"];
//------------------------//

//--------------------------------------------------- //
if($clave !== "" && $nueva !== "" && $repite !== ""){

    if($nueva == $repite){

        session_start();

        $cambiar = new CambiarClave();



        if($cambiar->verificarClave($_SESSION["nombre"], $clave)){

            $encriptada = password_hash($nueva, PASSWORD_DEFAULT);

            if($cambiar->actualizar($_SESSION["nombre"], $encriptada)){

                header("location: ../index.php?page=2&success=10");

            }else{

                echo $_SESSION["nombre"];

            }

        }else{

            header("location: ../index.php?page=2&conerror=35");

        }

    }else{

        header("location: ../index.php?page=2&conerror=40");

    }

}else{

    header("location: ../index.php?page=2&conerror=40");

}
//----------------------------------------------------//

?>