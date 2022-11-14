<?php 

session_start();

if(isset($_SESSION["listado_productos"]))

foreach($_SESSION["listado_productos"] as $listado){

    echo "
    
    <div class='list-group-item list-group-item-success'> 
         
        $listado
 
    </div>
    
    
    
    ";

}else{

    echo "SE HA ELIMINADO EL LISTADO DE PRODUCTOS";


}





?>