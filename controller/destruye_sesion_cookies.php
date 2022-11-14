<?php
//Destruye la sesión actual
session_start();
session_destroy();


//Evalua si existen cookies de inicio de sessión y si es así, las destruye 
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

}


header("location:../index.php"); // Redirige al index una vez se hayan eliminado las cookies y las sesiones existentes







?>