<?php 
session_start();

if(isset($_SESSION["contador_productos"])){


    echo $_SESSION["contador_productos"];

}else{


    echo -1;

}


?>