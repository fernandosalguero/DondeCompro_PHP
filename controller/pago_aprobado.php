<?php

require_once("../model/base_datos_productos.php");
require_once("../model/base_datos_usuarios.php");

session_start();

if (isset($_GET["mes"]) && isset($_GET["subs"]) && isset($_SESSION["subs_2"])) {


    if (!$_SESSION["subs"] == $_SESSION["subs_2"]) {

        header("location: ../index.php?conerror=40");
    }


    function darAlta($mes)
    {

        $usuario = new consultarUsuario();
        $nombre = $_SESSION["nombre"];
        $usuario->consultar($nombre);
        $ID = $usuario->registro["ID"];
        $negocio = new Negocio();

        $negocio->darDeAlta($ID); //Se le da de alta al negocio.
        $infoNegocio = new InfoNegocio();

        $infoNegocio->actualizarSubscripcion("si", $ID);

        $subscripcion = new Subscripcion();
        $dias = $mes * 31;
        $fecha_inicio = date("Y-m-d");
        $fecha_expiracion = date("Y-m-d", strtotime($fecha_inicio . "+ " . $dias . " days"));

        $subscripcion->insertarSubscripcionActiva($ID, $fecha_inicio, $fecha_expiracion);
        $subscripcion->insertarSubscripcion($ID, $nombre, $fecha_inicio, $fecha_expiracion);

        // actualiza el estado del cupon como usado solo cuando se realiza correctamente el pago, sino aun podra usarlo
        $cupones = new Cupones();

        $idUsuario = $_SESSION['ID_USER'];
        $suscripcion = $_SESSION['SUSCRIPCION'];
        $cuponesUsados = array();
        $descuentos = array();

        switch ($suscripcion) {
            case 'Mensual':
                $cuponesUsados = $_SESSION['CUPONES_MENSUALES'];
                $descuentos = $_SESSION['DESCUENTO_MENSUAL'];
                // Creacion de un registro de suscripcion nueva para usuario negocio por mes para deposito comisionado
                try {
                    $subscripcion->insertarSubscripcionReferido($ID, $fecha_inicio, $fecha_expiracion, 999.00, 'MENSUAL');
                } catch (Exception $e) {
                }
                break;
            case 'Trimestral':
                $cuponesUsados = $_SESSION['CUPONES_TRIMESTRALES'];
                $descuentos = $_SESSION['DESCUENTO_TRIMESTRAL'];
                break;
            case 'Semestral':
                $cuponesUsados = $_SESSION['CUPONES_SEMESTRALES'];
                $descuentos = $_SESSION['DESCUENTO_SEMESTRAL'];
                break;
            case 'Anual':
                $cuponesUsados = $_SESSION['CUPONES_ANUALES'];
                $descuentos = $_SESSION['DESCUENTO_ANUAL'];
                break;
            default:
                break;
        }
        $idx = 0;
        foreach ($cuponesUsados as $cuponPorMarcar) {
            $cupones->marcar_uso_cupon_comercio($cuponPorMarcar['idCupon'], $idUsuario, $descuentos[$idx]);
            $idx++;
        }

        unset($_SESSION["subs"]);
        unset($_SESSION["subs_2"]);

        header("location: ../index.php?success=310");
    }


    $mes = $_GET["mes"];

    switch ($mes) { // Se itera a través de cada una de las posibles subsripciones

        case 739:

            darAlta(1);

            break;

        case 435:

            darAlta(3);

            break;

        case 890:

            darAlta(6);

            break;

        case 7312:

            darAlta(12);

            break;

        default:

            header("location: ../index.php?conerror=40");
    }
} else {

    header("location: ../index.php?conerror=40");
}
