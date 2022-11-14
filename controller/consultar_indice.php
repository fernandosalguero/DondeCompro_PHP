<?php 
session_start();

if(!isset($_SESSION["numero_productos"])){

    $_SESSION["contador_productos"] = 0; 
    $_SESSION["numero_productos"] = 0;
    echo $_SESSION["numero_productos"];


}else{

    $_SESSION["contador_productos"] ++; 
    $_SESSION["numero_productos"] ++;
    echo $_SESSION["numero_productos"];

}
