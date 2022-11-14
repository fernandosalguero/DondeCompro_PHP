<?php 

require_once("../model/base_datos_usuarios.php");

if(isset($_GET["id"])){

    $ID = $_GET["id"];

    $info_negocio = new DatosInfoNegocio();
    

    if($info_negocio->consultarNegocio($ID)){

        $info_registro = $info_negocio->registro;
        
        $info_negocio->consultarNegocioDB($ID);

        $db_registro = $info_negocio->registro;

        $aux_registro_1 = "";
        $aux_registro_2 = "";

        function cargarImagen($a){

            if($a == null){

                return "view/assets/media/image/user/default.png";

            }

            else{

                return $a;

            }

        }

        function infComer($a){

            if($a != null){

                return $a;

            }else{

                return "No establecido";

            }

        }


        $aux_registro_1 .= "

        <div class = 'd-flex flex-column p-3'>
            <figure class = 'text-center'><img src='".cargarImagen($db_registro["imagen"])."' alt = 'Imagen Usuario' width = 150> </figure>
            <h3 class = 'texto-verde text-center'>".$db_registro["nombre"]."</h3>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>PROVINCIA:</strong></p> <p>".infComer($db_registro["provincia"])."</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>MUNICIPIO:</strong></p> <p>".infComer($db_registro["municipio"])."</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>DIRECCIÓN:</strong></p><p>".infComer($info_registro["direccion"])."</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>TELÉFONO:</strong></p><p>".infComer($info_registro["n_telefono"])."</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>REGALAR SUBSCRIPCIÓN:</strong></p>
            <div class = 'form-group'>
                <select class = 'form-control' id='mes'>
                    <option value='1'>1 Mes</option>
                    <option value='3'>3 Meses</option>
                    <option value='6'>6 Meses</option>
                    <option value='12'>1 Año</option>
                </select>
                <button class = 'btn btn-success btn-block boton-info' onclick='regalar(".$db_registro["ID"].")'>Regalar</button>
            </div>
        </div>
        ";
        
        echo $aux_registro_1;

    }



}else{


    echo "Hubo un error al cargar la información, por favor, recarga la página";


}



?>