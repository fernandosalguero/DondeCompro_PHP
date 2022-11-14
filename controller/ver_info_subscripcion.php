<?php 

require_once("../model/base_datos_usuarios.php");

if(isset($_GET["id"])){

    $ID = $_GET["id"];

    $subscripcion = new Subscripcion();

    if($subscripcion->consultarSubscripcion($ID)){

        $registro_subs = $subscripcion->registro;

        function nombreMeses($a){

            switch($a){

                case 1: 
                    return "Enero";
                break;
                
                case 2: 
                    return "Febrero";
                break;
                    
                case 3: 
                    return "Marzo";
                break;

                case 4: 
                    return "Abril";
                break;

                case 5: 
                    return "Mayo";
                break;

                case 6: 
                    return "Junio";
                break;

                case 7: 
                    return "Julio";
                break;

                case 8: 
                    return "Agosto";
                break;

                case 9: 
                    return "Septiembre";
                break;

                case 10: 
                    return "Octubre";

                case 11: 
                    return "Noviembre";
                break;

                case 12: 
                    return "Diciembre";
                break;

            }



        }

        function fechaText($a){

            $fecha = strtotime($a);

            $anio = date("Y", $fecha);
            $mes= date("m", $fecha);
            $dia = date("d", $fecha);

            return "$dia de ".nombreMeses($mes)." de $anio";

        }

        function nombrePlanes($a){

            switch($a){

                case 31:

                    return "1 MES";
                break;

                case 93:

                    return "3 MESES";
                break;

                case 186:

                    return "6 MESES";

                break;

                case 372:

                    return "1 AÑO";

                break;

                default: 

                return "PERSONALIZADO";



            }


        }


        function plan($a, $b){

            $fecha_inicio = strtotime($a);
            $fecha_expiracion = strtotime($b);

            $plan  = $fecha_expiracion - $fecha_inicio;

            return nombrePlanes($plan/86400);

        }
        

        echo "

        <div class = 'd-flex flex-column mb-3'>
        <p class = 'text-start mb-0'><strong class = 'texto-verde'>PLAN: </strong></p><p>".plan($registro_subs["fecha_inicio"], $registro_subs["fecha_expiracion"])."</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>INICIO DE LA SUBSCRIPCIÓN: </strong></p><p>".fechaText($registro_subs["fecha_inicio"])."</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>FECHA DE EXPIRACIÓN: </strong></p><p>".fechaText($registro_subs["fecha_expiracion"])."</p>
        <div>

        ";


    }else{


        echo "
            <p class = 'texto-rojo text-center'>Este comercio no tiene una subscripcion paga<p>
        
        ";

    }
    

  



}else{


    echo "Hubo un error al cargar la información, por favor, recarga la página";


}




?>