<?php

session_start();


if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];

    $_SESSION['IDX_PAG_COMP'] = $indice;

    $cardsComparador = $_SESSION['CARDS_COMPARADOR'];
    getCardsPagina($cardsComparador, $indice);
} else if (isset($_GET['incremento_decremento'])) {

    $incdec = $_GET['incremento_decremento'];
    $indice_actual = $_SESSION['IDX_PAG_COMP'];
    $cardsComparador = $_SESSION['CARDS_COMPARADOR'];
    $max_pag = ceil(count($cardsComparador) / 6);
    $indice = 0;

    if ($incdec == 1) {
        $indice = $indice_actual + 1;
        if ($indice <= $max_pag) {
            $_SESSION['IDX_PAG_COMP'] = $indice;
            getCardsPagina($cardsComparador, $indice);
        }
    } else if ($incdec == -1) {

        $indice = $indice_actual - 1;
        if ($indice >= 1) {
            $_SESSION['IDX_PAG_COMP'] = $indice;
            getCardsPagina($cardsComparador, $indice);
        }
    }
}

function getCardsPagina($arrayCards, $indiceAPaginar)
{
    $mostrarHasta = $indiceAPaginar * 6;

    $mostrarDesde = $mostrarHasta - 6;

    $cardsPaginaActual = array();

    if($mostrarHasta > count($arrayCards)){
        $mostrarHasta = count($arrayCards);
    }

    for ($i = $mostrarDesde; $i < $mostrarHasta; $i++) {
        $cardsPaginaActual[] = $arrayCards[$i];
    }

    $paginacionResult = array('cardsPaginaActual' => $cardsPaginaActual, 'cantidadProductosTotal' => count($arrayCards), 'indice' => $indiceAPaginar, 'mostrarDesde' => $mostrarDesde, 'mostrarHasta' => $mostrarHasta);

    echo (json_encode($paginacionResult));
}
