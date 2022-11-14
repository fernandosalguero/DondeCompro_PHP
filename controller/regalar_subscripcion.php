<?php

use MercadoPago\Subscription;

require("../model/base_datos_usuarios.php");

if(isset($_GET["id"]) && isset($_GET["mes"])){

    $id = $_GET["id"];
    $mes = $_GET["mes"];
    $subs = new Subscripcion();

    function regalarSubsNueva($mes){

        $ID = $_GET["id"];;
        $negocio = new Negocio();
        
        $negocio->darDeAlta($ID); //Se le da de alta al negocio.
        $infoNegocio = new InfoNegocio();
        
        $infoNegocio->actualizarSubscripcion("si", $ID);

        $subscripcion = new Subscripcion();
        $dias = $mes * 31;
        $fecha_inicio = date("Y-m-d");
        $fecha_expiracion = date("Y-m-d",strtotime($fecha_inicio."+ ".$dias." days")); 

        $subscripcion->insertarSubscripcionActiva($ID, $fecha_inicio, $fecha_expiracion);


    }

    function regalarSubs($mes){
        global $subs;

        

        $ID = $_GET["id"];;
        
        $infoNegocio = new InfoNegocio();
        $infoNegocio->actualizarSubscripcion("si", $ID);

        $subscripcion = new Subscripcion();
        $dias = $mes * 31;
        $fecha_inicio = $subs->registro["fecha_expiracion"];
        $fecha_expiracion = date("Y-m-d",strtotime($fecha_inicio."+ ".$dias." days")); 

        $subscripcion->actualizarSubscripcionActiva($ID, $fecha_expiracion);


    }

    

    if($subs->consultarSubscripcion($id)){

        switch($mes){

            case 1: 
                regalarSubs(1);
                echo "1";
            break;

            case 3: 
                regalarSubs(3);
                echo "1";
            break;

            case 6: 
                regalarSubs(6);
                echo "1";
            break;

            case 12: 
                regalarSubs(12);
                echo "1";
            break;

            default: 
                echo 0;


        }

    }else{

        switch($mes){

            case 1: 
                regalarSubsNueva(1);
                echo "1";
            break;

            case 3: 
                regalarSubsNueva(3);
                echo "1";
            break;

            case 6: 
                regalarSubsNueva(6);
                echo "1";
            break;

            case 12: 
                regalarSubsNueva(12);
                echo "1";
            break;

            default: 
                echo 0;


        }



    }


}else{

    echo "0";


}











?>