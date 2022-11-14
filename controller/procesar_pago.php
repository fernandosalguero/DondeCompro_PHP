<?php
session_start();

require("../controller/vendor/autoload.php");
require_once("../model/base_datos_usuarios.php");


$_SESSION["subs"] = array();

// Agrega credenciales
MercadoPago\SDK::setAccessToken('APP_USR-7301311272520732-112113-b2fe308a3d6054f86f1ae61a2c835f28-168994202');

if (isset($_POST['suscripcion']) && isset($_POST['importe'])) {

    $_SESSION['SUSCRIPCION'] = $_POST['suscripcion'];

    $preference = new MercadoPago\Preference();
    $item = new MercadoPago\Item();
    $importe = (float)$_POST['importe'];

    switch ($_POST['suscripcion']) {
        case 'Mensual': {
                // preferencia para la subscripción de un mes
                //---------------------------------------------------------------------------------------------//

                $_SESSION["subs"][0] = base64_encode(rand(0, 555));

                $item->title = 'Subscripción por 1 mes';
                $item->quantity = 1;
                $item->unit_price = $importe;
                $item->currency_id = "ARS";
                $preference->items = array($item);
                $preference->back_urls = array(
                    "success" => "https://app.dondecomproargentina.com.ar/controller/pago_aprobado.php?mes=739&subs=" . $_SESSION["subs"][0],
                    "failure" => "https://app.dondecomproargentina.com.ar/index.php?conerror=100",
                    "pending" => "https://app.dondecomproargentina.com.ar/index.php?conerror=110"
                );
                $preference->auto_return = "approved";
                $preference->save();

                //----------------------------------------------------------------------------------------------//

                break;
            }
        case 'Trimestral': {
                // preferencia para la subscripción de 3 meses
                //---------------------------------------------------------------------------------------------//

                $_SESSION["subs"][1] = base64_encode(rand(0, 555));

                $item->title = 'Subscripción por 3 meses';
                $item->quantity = 1;
                $item->unit_price = $importe;
                $item->currency_id = "ARS";
                $preference->items = array($item);
                $preference->back_urls = array(
                    "success" => "https://app.dondecomproargentina.com.ar/controller/pago_aprobado.php?mes=435&subs=" . $_SESSION["subs"][1],
                    "failure" => "https://app.dondecomproargentina.com.ar/index.php?conerror=100",
                    "pending" => "https://app.dondecomproargentina.com.ar/index.php?conerror=110"
                );
                $preference->auto_return = "approved";
                $preference->save();

                //------------------------------------------------------------------------------------------------//
                break;
            }
        case 'Semestral': {
                // preferencia para la subscripción de 6 meses
                //---------------------------------------------------------------------------------------------//

                $_SESSION["subs"][2] = base64_encode(rand(0, 555));

                $item->title = 'Subscripción por 6 meses';
                $item->quantity = 1;
                $item->unit_price = $importe;
                $item->currency_id = "ARS";
                $preference->items = array($item);
                $preference->back_urls = array(
                    "success" => "https://app.dondecomproargentina.com.ar/controller/pago_aprobado.php?mes=890&subs=" . $_SESSION["subs"][2],
                    "failure" => "https://app.dondecomproargentina.com.ar/index.php?conerror=100",
                    "pending" => "https://app.dondecomproargentina.com.ar/index.php?conerror=110"
                );
                $preference->auto_return = "approved";
                $preference->save();

                //------------------------------------------------------------------------------------------------//
                break;
            }
        case 'Anual': {
                // preferencia para la subscripción de 1 año
                //---------------------------------------------------------------------------------------------//

                $_SESSION["subs"][3] = base64_encode(rand(0, 555));

                $item->title = 'Subscripción por 1 año';
                $item->quantity = 1;
                $item->unit_price = $importe;
                $item->currency_id = "ARS";
                $preference->items = array($item);
                $preference->back_urls = array(
                    "success" => "https://app.dondecomproargentina.com.ar/controller/pago_aprobado.php?mes=7312&subs=" . $_SESSION["subs"][3],
                    "failure" => "https://app.dondecomproargentina.com.ar/index.php?conerror=100",
                    "pending" => "https://app.dondecomproargentina.com.ar/index.php?conerror=110"
                );
                $preference->auto_return = "approved";
                $preference->save();
                //---------------------------------------------------------------------------------------------//
                break;
            }
        default: {
                $data = array(
                    'status' => 'error',
                    'message' => 'los parámetros post no están presentes'
                );
                echo json_encode($data);
            }
    }
}


if (isset($_SESSION["subs"])) {

    $_SESSION["subs_2"] = array();

    for ($i = 0; $i < 4; $i++) {

        $_SESSION["subs_2"][$i] = (rand(0, 555));
        $_SESSION["subs"][$i] = $_SESSION["subs_2"][$i];
    }

    $data = array(
        'status' => 'success',
        'init_point' => $preference->init_point,
        // 'subs' => $_SESSION["subs"]
    );
    echo json_encode($data);
} else {
    $data = array(
        'status' => 'error',
        'message' => 'error al generar subs'
    );
    echo json_encode($data);
}

//------------------------------------------------------------------------------------------------//
