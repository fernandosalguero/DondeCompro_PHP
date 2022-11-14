<?php 
require_once("../model/base_datos_usuarios.php");
session_start();

$usuario = new consultarUsuario();
$usuario->consultar($_SESSION["nombre"]);
$ID = $usuario->registro["ID"];
$info = new DatosInfoNegocio();
$aux = "";
$aux2 = "";
$aux3 = "";

function cargarImagen(){

    if($_SESSION["imagen"] == null){

        return "view/assets/media/image/user/default.png";

    }else{

        return $_SESSION["imagen"];

    }

}




if($info->consultarNegocio($ID)){

    

    if($info->registro["direccion"] != null){

        $aux .= "
        
            <h3><strong class = 'fa fa-street-view texto-gris'> ".$info->registro["direccion"]."</strong></h3>
        
        ";

    }

    if($info->registro["n_telefono"] != null){

        $aux .= "
        
            <h3> <strong class='fa fa-phone texto-gris'> ".$info->registro["n_telefono"]." </strong></h3>
        
        ";

    }

    

    $aux .= "
    
        <h3><strong class='fa fa-money texto-gris'> ".ucfirst($info->registro["metodo_cobro"])."</strong> </h3>
    
    ";

    if($info->registro["envios"] != "no"){

        $aux .=  "<h3 class='texto-gris'><strong class= 'fa fa-check'>ENVÍOS</strong></h3>";
  
      }

    if($info->registro["promociones"] != null){

        $aux3 .= "
        
            <div class = 'card-per text-center'>
            <h5>INFO Y PROMOCIONES:</h5>

            <p class = 'texto-gris text-center'>".$info->registro["promociones"]."</p>
            </div>
        
        ";

    }

}else{

    echo "
    
        <h5 class = 'texto-azul'>ESTA ES LA INFORMACIÓN DISPONIBLE DEL NEGOCIO</h5>
    
    ";


}

$aux2 = "
    
    <img src='".cargarImagen()."' width = '150'>
    <h3 class = 'texto-verde'>".$usuario->registro["nombre"]."</h3>
    <div style='padding: 0.5rem !important;'>
        ".$aux."
     </div>
     ".$aux3."

";



echo $aux2;



?>