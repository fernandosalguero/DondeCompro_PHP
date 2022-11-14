<?php 

require_once("../model/base_datos_productos.php");
require_once("../model/base_datos_usuarios.php");

session_start();

/*Se toma el nombre del usuario (negocio que inició sesión)
  se consulta si existe en la base de datos y si tiene una cuenta activa sí es así
  se extrae el ID para poder acceder a su tabla de productos
  si no es así retornará retornará un error*/

//------------------------------------------//
    $nombre = $_SESSION["nombre"];
    $consultar = new consultarUsuario();
    $registro = $consultar->datos($nombre);
    $id = $registro["ID"];
//------------------------------------------//

if($id != ""){ // If global, solo se ejecutará todo el código si se cumple este criterio

$nombre_db = "productos_".$id; //Nombre de la tabla de productos del usuario que hace la petición.

/*Variables y objeto que sirven para manipular la consulta que se hace a la base de datos */
//------------------------------------------//
    $busqueda = new Productos($nombre_db); // Este objeto es el que tiene los diferentes métodos para mostrar la tabla de negocios al cargar el documento.

    $termino = $_GET["termino"];//El termino de la busqueda.
    $rubro = $_GET["rubro"]; //Se captura "ordenar" que se utilizará para ordenar la consulta de manera ascendiente o descendiente.
    $entradas = $_GET["entradas"];// Se Captura el numero de entradas que va a tener la pagina de la tabla
    $pagina = $_GET["pagina"];// la pagina en la que se encuentre en la paginación.

    $total_filas = $busqueda->totalFilasBusqueda($termino, $rubro); //El total de filas que devuelve la consulta.
    $total_paginas = ceil($total_filas/$entradas);// El total de paginas que va a tener la paginación.
    $empezar = ($pagina - 1) * $entradas;//Esta es la variable que se encarga de indicarle a la consulta donde debe empezar (Se utiliza en el primer parametro del LIMIT)

//------------------------------------------//

/*Este bucle itera sobre el recurso devuelto por el método buscar y almacena en registro cada uno de los negocios */
//----------------------------------------------------------------------//
foreach($busqueda->buscar($termino, $rubro, $empezar, $entradas) as $registro){

    echo "<tr>";
    echo "<td> <p class = 'texto-negro'><small>".$registro["Codigo"]."</small></p></td>";
    echo "<td><p class = 'texto-negro'>".$registro["Descripcion"]."</p></td>";
    echo "<td><p class = 'texto-negro'>".$registro["Rubro"]."</p></td>";
    echo "<td>"; 
    echo "<div class='row'>";
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'>";
    echo "<input type='text' class='form-control' placeholder='".$registro["Precio"]."' id='".$registro["Codigo"]."' onChange='cambioPrecio()'>";
    echo "</div>";
    echo "</div>";
    echo "<div class='col-md-4'>";
    echo "<div class='form-group'>";
    echo "<input type='submit' value = 'CAMBIAR' onClick='cambiar(".$registro["Codigo"].")'class='btn btn-success btn-sm'>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</td>";    
    echo "</tr>";
}
//----------------------------------------------------------------------//


//-------------------------------Paginación----------------------------------------//

if($pagina <= 0){

    $pagina = 1;

}

$activa = $pagina;

if(($pagina + 2) % 3 == 0){

    $primera_pagina = $pagina;
    $segunda_pagina = $primera_pagina + 1;
    $tercera_pagina = $primera_pagina + 2;

}else if(($pagina + 1) % 3 == 0){

    $segunda_pagina = $pagina;
    $primera_pagina = $segunda_pagina - 1;
    $tercera_pagina = $segunda_pagina + 1;

}else{

    $tercera_pagina = $pagina;
    $primera_pagina = $tercera_pagina - 2;
    $segunda_pagina = $tercera_pagina - 1;

}

function active($pagina){
    global $activa;

    if($pagina == $activa){

        return "page-item active";

    }else{

        return "page-item";

    }


}

if($total_paginas == 0){

    echo "<td colspan = 3>
    <div aria-label='...' class='d-flex justify-content-center'>
        <ul class='pagination pagination-rounded d-flex align-self-baseline'>
            <li class='page-item' >
                <a class='page-link' id='a-per-3' href='#'>
                    <i class='ti-angle-left'></i>
                </a>
            </li>

            <li class='page-item' >
                <a class='page-link' id='a-per-3' href='#' >
                <i class='ti-angle-right'></i>
                </a>
            </li>

        </ul>
    </div>

    </td>";


}else if($total_paginas <= 3){

    switch($total_paginas){

        case 1: 

            echo "<td colspan=5>

                    <div aria-label='...' class='d-flex justify-content-center'>
                        <ul class='pagination pagination-rounded d-flex align-self-baseline'>
    
                            <li class='".active($primera_pagina)."'btn-outline-youtube>
                                <a class='page-link active' href='#' id='a-per-3' onClick = 'pagina(".$primera_pagina.")'>".$primera_pagina."</a>
                            </li>
    
                        </ul>
                    </div>
    
                    </td>";
        break;

        case 2:

            echo "<td colspan=5>

            <div aria-label='...' class='d-flex justify-content-center'>
                <ul class='pagination pagination-rounded d-flex align-self-baseline'>
    
                    <li class='".active($primera_pagina)."'btn-outline-youtube>
                <a class='page-link active' href='#' id='a-per-3' onClick = 'pagina(".$primera_pagina.")'>".$primera_pagina."</a>
                    </li>
    
                    <li class='".active($segunda_pagina)."'>
                        <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(".$segunda_pagina.")'>".$segunda_pagina."</a>
                    </li>
    
                </ul>
            </div>
    
            </td>";

        break;

        case 3:

            echo "<td colspan=5>

                    <div aria-label='...' class='d-flex justify-content-center'>
                        <ul class='pagination pagination-rounded d-flex align-self-baseline'>
    
                            <li class='".active($primera_pagina)."'btn-outline-youtube>
                                <a class='page-link active' href='#' id='a-per-3' onClick = 'pagina(".$primera_pagina.")'>".$primera_pagina."</a>
                            </li>
    
                            <li class='".active($segunda_pagina)."'>
                                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(".$segunda_pagina.")'>".$segunda_pagina."</a>
                            </li>
    
                            <li class='".active($tercera_pagina)."'>
                                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(".$tercera_pagina.")'>".$tercera_pagina."</a>
                            </li>
    
                        </ul>
                    </div>
    
                </td>";
        break;


    }
    

}else{

    echo "<td colspan=5>

    <div aria-label='...' class='d-flex justify-content-center'>
        <ul class='pagination pagination-rounded d-flex align-self-baseline'>
            <li class='page-item' >
                <a class='page-link' href='#' id='a-per-3' onClick='anterior(".$total_paginas.")'>
                    <i class='ti-angle-left'></i>
                </a>
            </li>
    
            
    
            <li class='".active($primera_pagina)."'btn-outline-youtube>
                <a class='page-link active' href='#' id='a-per-3' onClick = 'pagina(".$primera_pagina.")'>".$primera_pagina."</a>
            </li>
    
            <li class='".active($segunda_pagina)."'>
                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(".$segunda_pagina.")'>".$segunda_pagina."</a>
            </li>
    
            <li class='".active($tercera_pagina)."'>
                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(".$tercera_pagina.")'>".$tercera_pagina."</a>
            </li>
    
    
    
            <li class='page-item' >
                <a class='page-link' href='#' id='a-per-3' onClick='siguiente(".$total_paginas.")'>
                <i class='ti-angle-right'></i>
                </a>
            </li>
    
        </ul>
    </div>
    
    </td>";

}

//----------------------------------------------------------------------------------//


}else{ //Else del if global

    echo "TU CUENTA ESTÁ INACTIVA";


}

?>