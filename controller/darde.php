<?php 

require_once("../model/base_datos_usuarios.php");

session_start();

/*Se evalua si el usuario que inicio sesión es el super admin
si no es así, no ejecutará el código y devolverá un "no", si es 
el usuario superadmin entonces se captura el id y el estado
de la cuenta a la que se dará de baja o de alta, si*/

if(isset($_SESSION["ID"]) && isset($_GET["ID"]) && isset($_GET["estado"])){

    $ID = $_GET["ID"];
    $estado = $_GET["estado"];

    $darde = new Negocio();

    if($estado == 1){

        if($darde->darDeBaja($ID)){

            echo "si";

        }else{

            echo "no";

        }

    }else{

        if($darde->darDeAlta($ID)){

            echo "si";

        }else{

            echo "no";

        }


    }

}




?>