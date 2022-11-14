<?php 

if(isset($_GET["correo"]) && isset($_GET["verificacion"])){

    require_once("../model/base_datos_usuarios.php");

    $correo = $_GET["correo"];
    $verificacion = $_GET["verificacion"];

    $recuperar = new Recuperar();

    if($recuperar->verificarCorreoVeri($correo, $verificacion)){

        session_start();

        $_SESSION["succes"] = rand(1, 829);
        $_SESSION["correo"] = $correo;
        header("location: ../view/nueva-clave.php");
    }

}else{

    if(isset($_POST["clave"]) && $_POST["rclave"]){

        require_once("../model/base_datos_usuarios.php");
        session_start();

        $clave = htmlentities(addslashes($_POST["clave"]));
        $clave_cifrada = password_hash($clave, PASSWORD_DEFAULT);

        $correo = $_SESSION["correo"];
        $recuperar = new Recuperar();

       
        if($recuperar->insertarClave($correo, $clave_cifrada)){


            if($recuperar->borrarCorreoVeri($correo)){

                session_destroy();

                header("location: ../index.php?success=25");

            }else{

                header("location: ../view/nueva-clave?conerror=40");

            }

            

        }else{

            header("location: ../view/nueva-clave?conerror=40");

        }




    }else{

        header("location: ../index.php");

    }

}




?>