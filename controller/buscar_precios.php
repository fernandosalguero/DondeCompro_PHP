<?php

require_once("../model/base_datos_productos.php");
require_once("../model/base_datos_usuarios.php");
require_once("../controller/precios_claros/buscar_precios.php");

session_start();
$busqueda = new Precios();


$termino = $_GET["termino"]; // El termino de la busqueda.
$GLOBALS['termino'] = $termino;
// var_dump($termino);
$entradas = 7; // El total de entradas que se verán en pantalla.
$pagina = $_GET["pagina"]; // la pagina en la que se encuentre en la paginación.
$total_filas = $busqueda->totalFilasBusqueda($termino); //El total de filas que devuelve la consulta.


if (isset($_SESSION['PRODUCTOS_BUSQUEDA_PC'])) {
    $productosSessionPreciosClaros = $_SESSION['PRODUCTOS_BUSQUEDA_PC'];
    $productosSucursales = json_decode($productosSessionPreciosClaros, true);
} else // no vienen productos desde sesion por posible error en la obtendcion de productos desde precios claros
    $productosSucursales = null;


$arrProductosPrecClarosNormalizado = array();
if (isset($productosSucursales)) {
    foreach ($productosSucursales as $producto) {
        $arrProductosPrecClarosNormalizado[] = array(
            'Codigo' => $producto['id'],
            'Descripcion' => $producto['nombre'],
            'origen' => 'PC'
        );
    }
}

$arrProductosBase = $busqueda->buscarTodos($termino);

$arrProdAFiltrar = $arrProductosBase;

// Filtrar para eliminar duplicados entre donde compro y precios claros (por codigo de producto)
$productosNoDuplicados = array();

foreach ($arrProductosPrecClarosNormalizado as $prodPreciosClarosNormalizado) {
    $count = 0;
    foreach ($arrProductosBase as $prodBase) {

        if ($prodBase['Codigo'] == $prodPreciosClarosNormalizado['Codigo']) {

            $arrProdAFiltrar = array_slice($arrProdAFiltrar, $count, 1);
        }
        $count++;
    }
}

$exactMatchArray = array();
$restantesContienenTermino = array();
$arrProductosBaseExactMatchMasContieneTermino = array();

foreach ($arrProdAFiltrar as $prodBase) {
    $terminosDescripcionA = explode(' ', $prodBase['Descripcion']);
    if (strtolower($terminosDescripcionA[0]) == strtolower($termino)) {
        array_push($exactMatchArray, $prodBase);
    } else {
        array_push($restantesContienenTermino, $prodBase);
    }
}

// Ordenar array de exactmatch
uasort(
    $exactMatchArray,
    function ($a, $b) {
        $terminosDescripcionA = explode(' ', $a['Descripcion']);
        $terminosDescripcionB = explode(' ', $b['Descripcion']);
        $primerTerminoA = $terminosDescripcionA[0];
        $primerTerminoB = $terminosDescripcionB[0];

        if (strtolower($primerTerminoA) == strtolower($primerTerminoB)) {
            return 0;
        }
        return (strtolower($primerTerminoA) < strtolower($primerTerminoB)) ? -1 : 1;
    }
);

// Ordenar array de contiene termino
uasort(
    $restantesContienenTermino,
    function ($a, $b) {
        $terminosDescripcionA = explode(' ', $a['Descripcion']);
        $terminosDescripcionB = explode(' ', $b['Descripcion']);
        $primerTerminoA = $terminosDescripcionA[0];
        $primerTerminoB = $terminosDescripcionB[0];

        if (strtolower($primerTerminoA) == strtolower($primerTerminoB)) {
            return 0;
        }
        return (strtolower($primerTerminoA) < strtolower($primerTerminoB)) ? -1 : 1;
    }
);

$arrProductosBaseExactMatchMasContieneTermino = array_merge($exactMatchArray, $restantesContienenTermino);


$unionProductos = array_merge($arrProductosPrecClarosNormalizado, $arrProductosBaseExactMatchMasContieneTermino);

if (count($unionProductos) < 1) {
    echo ('<h5 style="color: white; padding: 5px; background: #0F7F3A; border-radius: 6px; text-align: center;">No encontramos el producto que buscás, intentá con otra descripción</h5>');
    return;
}

$total_paginas = ceil(count($unionProductos) / $entradas); // El total de paginas que va a tener la paginación.
$empezar = ($pagina - 1) * $entradas; // Determina desde donde empieza la consulta para mostrar las entradas de página (paginación).
for ($i = $empezar; $i < ($empezar + $entradas); $i++) {
    if ($i < count($unionProductos)) {
        $registro = $unionProductos[$i];

        echo "
        <div id=\"card_" . $registro["Codigo"] . "\" class = 'card tarjeta-resultado-producto card-available' data-bs-toggle='tooltip' data-bs-placement='top' onClick ='anadirListado(" . $registro["Codigo"] . ")'>   
            <img style=\"margin: 0 auto;\" width=\"200px\" src=\"https://imagenes.preciosclaros.gob.ar/productos/" . $registro["Codigo"] . ".jpg\" onerror='this.src = \"view/assets/media/image/product_default.png\";'>
            <div class = 'card-body body-resultados'>
                <div id = 'an" . $registro["Codigo"] . "' class='card-description-available' style=\"border-radius: 5px; padding: 5px;\">
        
                    <p id = '" . $registro["Codigo"] . "'>" . $registro["Descripcion"] . "<i id=\"ok_" . $registro["Codigo"] . "\" style=\"font-weight: 500 !important; font-size: 30px; background: #fe5a82; border: solid 4px white; color:white !important; border-radius: 50%; height: 37px; width: 38px;\" class='fas fa-plus boton-anadir-listado'></i></p>
              
                    <div id = '" . $registro["Codigo"] . "'> 
                    </div>
                </div>
            </div>
        </div>";
    }
}
//----------------------------------------------------------------------//




//-------------------------------Paginación----------------------------------------//
$pagina = (int) $pagina;
if ($pagina <= 0) {

    $pagina = 1;
}

$activa =  $pagina;

if (($pagina + 2) % 3 == 0) {
    // var_dump($activa);
    $primera_pagina = $pagina;
    $segunda_pagina = $primera_pagina + 1;
    $tercera_pagina = $primera_pagina + 2;
} else if (($pagina + 1) % 3 == 0) {

    $segunda_pagina = $pagina;
    $primera_pagina = $segunda_pagina - 1;
    $tercera_pagina = $segunda_pagina + 1;
} else {

    $tercera_pagina = $pagina;
    $primera_pagina = $tercera_pagina - 2;
    $segunda_pagina = $tercera_pagina - 1;
}

function active($pagina)
{
    global $activa;

    if ($pagina == $activa) {
        return "page-item active";
    } else {

        return "page-item";
    }
}

if ($total_paginas == 0) {

    echo "<td colspan = 3>
    <div aria-label='...' class='d-flex justify-content-center' style='margin-bottom: 100px !important;'>
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
} else if ($total_paginas <= 3) {

    switch ($total_paginas) {

        case 1:

            echo "<td colspan=3>

                    <div aria-label='...' class='d-flex justify-content-center' style='margin-bottom: 100px !important;'>
                        <ul class='pagination pagination-rounded d-flex align-self-baseline'>
    
                            <li class='" . active($primera_pagina) . "'btn-outline-youtube>
                                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $primera_pagina . ")'>" . $primera_pagina . "</a>
                            </li>
    
                        </ul>
                    </div>
    
                    </td>";
            break;

        case 2:

            echo "<td colspan=3>

            <div aria-label='...' class='d-flex justify-content-center' style='margin-bottom: 100px !important;'>
                <ul class='pagination pagination-rounded d-flex align-self-baseline'>
    
                    <li class='" . active($primera_pagina) . "'btn-outline-youtube>
                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $primera_pagina . ")'>" . $primera_pagina . "</a>
                    </li>
    
                    <li class='" . active($segunda_pagina) . "'>
                        <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $segunda_pagina . ")'>" . $segunda_pagina . "</a>
                    </li>
    
                </ul>
            </div>
    
            </td>";

            break;

        case 3:

            echo "<td colspan=3>

                    <div aria-label='...' class='d-flex justify-content-center' style='margin-bottom: 100px !important;'>
                        <ul class='pagination pagination-rounded d-flex align-self-baseline'>
    
                            <li class='" . active($primera_pagina) . "'btn-outline-youtube>
                                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $primera_pagina . ")'>" . $primera_pagina . "</a>
                            </li>
    
                            <li class='" . active($segunda_pagina) . "'>
                                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $segunda_pagina . ")'>" . $segunda_pagina . "</a>
                            </li>
    
                            <li class='" . active($tercera_pagina) . "'>
                                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $tercera_pagina . ")'>" . $tercera_pagina . "</a>
                            </li>
    
                        </ul>
                    </div>
    
                </td>";
            break;
    }
} else {

    echo "<td colspan=3>

    <div aria-label='...' class='d-flex justify-content-center' style='margin-bottom: 100px !important;'>
        <ul class='pagination pagination-rounded d-flex align-self-baseline'>
            <li class='page-item' >
                <a class='page-link' href='#' id='a-per-3' onClick='anterior(" . $total_paginas . ")'>
                    <i class='ti-angle-left'></i>
                </a>
            </li>
            
    
            <li class='" . active($primera_pagina) . "'>
                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $primera_pagina . ")'>" . $primera_pagina . "</a>
            </li>
    
            <li class='" . active($segunda_pagina) . "'>
                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $segunda_pagina . ")'>" . $segunda_pagina . "</a>
            </li>
    
            <li class='" . active($tercera_pagina) . "'>
                <a class='page-link' href='#' id='a-per-3' onClick = 'pagina(" . $tercera_pagina . ")'>" . $tercera_pagina . "</a>
            </li>
    
    
    
            <li class='page-item' >
                <a class='page-link' href='#' id='a-per-3' onClick='siguiente(" . $total_paginas . ")'>
                <i class='ti-angle-right'></i>
                </a>
            </li>
    
        </ul>
    </div>
    
    </td>";
}

//----------------------------------------------------------------------------------//
