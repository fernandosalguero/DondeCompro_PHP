<?php 

require_once("../model/base_datos_usuarios.php");

session_start();

/*Se captura el nombre del usuario, el tamaño del archivo y el tipo
se establece la carpeta de destino que será en donde se guardará
la imagen que el usuario haya subido y luego se genera un número
pseudoaleatorio y para concatenarlo con el nombre del usuario y así
guardar la imagen con un nombre único, evitando posibles errores  
si el archivo es una imagen de tipo jpeg, se cambia a jpg para evitar conflictos,
finalmente seevalua si el archivo pesa más de 2000000 bytes (2MB), si es así,
se retorna a la página con un error, si su tamaño es menor, se evalua si el archivo es 
de tipo imagen (jpg, png, gif) y si es así, se procede a guardar el nombre de la imagen que se generó
en la base de datos y se mueve la imagen que el usuario subió al servidor, cada vez que el usuario
cambia la imagen, se elimina la que tenía y finalmente se destruye las cookies que habían (si habían) y se 
crean otras con los datos nuevos*/

$nombre = $_SESSION["nombre"];
$tamano = $_FILES["imagen"]["size"];
$tipo = $_FILES["imagen"]["type"];
$carpeta_destino = $_SERVER["DOCUMENT_ROOT"]."/view/assets/media/image/user/";
$ran = rand(0, 100000);

//--Establece la extensión de la imagen a jpg--//
if($tipo == "image/jpeg"){

    $extension = "jpg";

}else{

    $extension = substr($tipo, 6);

}
//---------------------------------------------//

$aux_nombre_imagen = rand(0, 9999999999);

$nombre_imagen = $aux_nombre_imagen."_imagen_".$ran.".".$extension;

$nombre_imagen = str_replace(" ", "", $nombre_imagen);

if($tamano < 2000000){
    
    if($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png" || $tipo == "image/gif"){

        $ruta_imagen = "view/assets/media/image/user/".$nombre_imagen; /*La carpeta donde se almacenan las imagenes
                                                                          difiere de carpeta_destino porque la carpeta_destino almacena
                                                                          la ubicación de la imagen desde cualquier archivo
                                                                          y ruta_imagen desde este archivo*/
        $cambiar = new CambiarImagen();
        
        if($cambiar->cambiar($nombre, $ruta_imagen)){

            //este es el bloque que elimina la imagen anterior//
            if(isset($_SESSION["imagen"]) !== null){

                $eliminar = "../".$_SESSION["imagen"];
                unlink($eliminar);
            }
            //-------------------------------------------------//
            

            move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta_destino.$nombre_imagen);

            $_SESSION["imagen"] = $ruta_imagen;

            if(isset($_COOKIE["nombre"])){

                setcookie("imagen", "", time()-1, "/");

            }

            setcookie("imagen", $ruta_imagen, time()+86400, "/");
            
            header("location: ../index.php?page=2");

        }else{

            header("location: ../index.php?page=2&conerror=45");

        }
        

    }else{

        header("location: ../index.php?page=2&conerror=45");

    }



}else{

    header("location: ../index.php?page=2&conerror=45");

}






?>