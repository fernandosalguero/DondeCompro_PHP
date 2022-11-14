<?php 
require_once("../model/base_datos_usuarios.php");
session_start();

$usuario = new consultarUsuario();
$usuario->consultar($_SESSION["nombre"]);
$registro_usuario = $usuario->registro;
$ID = $usuario->registro["ID"];
$info = new DatosInfoNegocio();
$aux = "";
$aux4 = "";

function cImagen($a){
    
    
    if($a == null){

        return "view/assets/media/image/user/default.png";

    }else{

        return $a;

    }


}
if($registro_usuario["provincia"] != null){

    $provincia = $usuario->registro["provincia"];
    $municipio = $usuario->registro["municipio"];

    if($municipio == null){

        if($usuario->consultarProvincia($provincia)){

            $registro_negocios = $usuario->registro;
            $subscripcion = new Subscripcion();
    
            foreach($registro_negocios as $registro){
                $aux4 = "";
                $aux3 = "";
                $aux2 =  "";
                

                $ID = $registro["ID"];
                
                if($subscripcion->consultarSubscripcion($ID)){
    
                    if($info->consultarNegocio($ID)){
    
                        if($info->registro["direccion"] != null){
    
                            $aux2 .= "
                            
                                <p class = 'fa fa-street-view'> ".$info->registro["direccion"]."</p>
                            
                            ";
                    
                        }
                    
                        if($info->registro["n_telefono"] != null){
                    
                            $aux2 .= "
                            
                                <p class='fa fa-phone'> ".$info->registro["n_telefono"]." </p>
                            
                            ";
                    
                        }
                    
                        
                        $aux2 .= "
                        
                            <p class='fa fa-money'> ".strtoupper($info->registro["metodo_cobro"])."</p>
                        
                        ";


                        if($info->registro["envios"] != "no"){
                    
                            $aux2 .=  "<p class=''><label class= 'fa fa-check'>ENVÍOS</label></p>";
                      
                          }
                    
                        if($info->registro["promociones"] != null){
                    
                            $aux4 .= "
                            
                                <div class = 'card-per text-center'>
                                <h5>INFO Y PROMOCIONES:</h5>
                    
                                <p class = 'text-center'>".$info->registro["promociones"]."</p>
                                </div>
                            
                            ";
                    
                        }

                        $aux3 = "
                        <div style='padding: 0.5rem !important;'>
                            ".$aux2."
                        </div>
                        
                        ";
                    
                        $aux .= "
                            <div class = 'col-md-4'>
    
                                <div class ='card tarjeta-promo'>
                                
                                    <div class = 'card-body d-flex flex-column align-items-center'>
                                    <img src='".cImagen($registro["imagen"])."' width = 150>
                                    <h3 class = 'texto-verde m-3'>".$registro["nombre"]."</h3>
                                        ".$aux3."
                                        ".$aux4."
                                    </div>
                                </div>
    
                            </div>
                            ";
    
    
    
                    }else{
    
    
                        continue;
    
                    }
                    
    
    
                    
    
    
                }else{
    
                    continue;
    
                }
    
    
    
            }
    
    
        }else{
    
            $aux = 0;
    
        }


    }else{

        if($usuario->consultarProvinciaMunicipio($provincia, $municipio)){

            $registro_negocios = $usuario->registro;
            $subscripcion = new Subscripcion();
    
            foreach($registro_negocios as $registro){
                $aux4 = "";
                $aux3 = "";
                $aux2 =  "";
                

                $ID = $registro["ID"];
                
                if($subscripcion->consultarSubscripcion($ID)){
    
                    if($info->consultarNegocio($ID)){
    
                        if($info->registro["direccion"] != null){
    
                            $aux2 .= "
                            
                                <p class = 'fa fa-street-view'> ".$info->registro["direccion"]."</p>
                            
                            ";
                    
                        }
                    
                        if($info->registro["n_telefono"] != null){
                    
                            $aux2 .= "
                            
                                <p class='fa fa-phone'> ".$info->registro["n_telefono"]."</p>
                            
                            ";
                    
                        }
                    
                        
                        $aux2 .= "
                        
                            <p class='fa fa-money'> ".strtoupper($info->registro["metodo_cobro"])."</p>
                        
                        ";


                        if($info->registro["envios"] != "no"){
                    
                            $aux2 .=  "<p><label class= 'fa fa-check'>ENVÍOS</label></p>";
                      
                          }
                    
                        if($info->registro["promociones"] != null){
                    
                            $aux4 .= "
                            
                                <div class = 'card-per text-center'>
                                <h5>INFO Y PROMOCIONES:</h5>
                    
                                <p class = 'text-center'>".$info->registro["promociones"]."</p>
                                </div>
                            
                            ";
                    
                        }

                        $aux3 = "
                        <div style='padding: 0.5rem !important;'>
                            ".$aux2."
                        </div>
                        
                        ";
                    
                        $aux .= "
                            <div class = 'col-md-4'>
    
                                <div class ='card tarjeta-promo'>
                                
                                    <div class = 'card-body d-flex flex-column align-items-center'>
                                    <img src='".cImagen($registro["imagen"])."' width = 150>
                                    <h3 class = 'texto-verde m-3'>".$registro["nombre"]."</h3>
                                        ".$aux3."
                                        ".$aux4."
                                    </div>
                                </div>
    
                            </div>
                            ";
    
    
    
                    }else{
    
    
                        continue;
    
                    }
                    
    
    
                    
    
    
                }else{
    
                    continue;
    
                }
    
    
    
            }
    
    
    
    
        }else{
    
            $aux = 0;
    
        }



    }

    



}else{


    $aux = 0;


}


echo $aux;

?>