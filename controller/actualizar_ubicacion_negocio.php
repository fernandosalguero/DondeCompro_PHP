<?php
require_once("../model/base_datos_usuarios.php");
session_start();

if (
    isset($_POST["provincia-registro"]) && $_POST["provincia-registro"] != "seleccionar" &&
    // isset($_POST["municipio-registro"]) && $_POST["municipio-registro"] != "seleccionar" &&
    // isset($_POST["localidades-registro"]) && $_POST["localidades-registro"] != "seleccionar" &&
    isset($_POST["direccion"])
) {


    $provincia = $_POST["provincia-registro"];
    $municipio = $_POST["municipio-registro"];
    $localidad = $_POST["localidades-registro"];
    $direccion = $_POST["direccion"];
    $nombre = $_SESSION["nombre"];
    $centroide_localidad_lat = $_POST["lat"];
    $centroide_localidad_lon = $_POST["lon"];
    $usuario = new consultarUsuario();
    $usuario->consultar($nombre);

    $ID = $usuario->registro["ID"];
    $ubicacion = new Ubicacion();

    if ($provincia != "Ciudad Autónoma de Buenos Aires") {
        $municipio = $_POST["municipio-registro"];

        if ($ubicacion->actualizarProvinciaMunicipioLocalidad($ID, $provincia, $municipio, $localidad, $centroide_localidad_lat, $centroide_localidad_lon)) {

            if ($ubicacion->consultarInfoNegocio($ID)) {

                $ubicacion->actualizarDireccion($ID, $direccion);
                header("location: ../index.php?page=2&success=20");
            } else {
                $ubicacion->InsertarDireccion($ID, $direccion);
                header("location: ../index.php?page=2&success=20");
            }
        } else {


            header("location: ../index.php?page=2&conerror=40");
        }
    } else {
        if ($ubicacion->actualizarProvincia($ID, $provincia)) {

            if ($ubicacion->consultarInfoNegocio($ID)) {

                $ubicacion->actualizarDireccion($ID, $direccion);
                $ubicacion->actualizarLocalidad($ID, $localidad);
                $ubicacion->actualizarCentroides($ID, $centroide_localidad_lat, $centroide_localidad_lon);
                $ubicacion->eliminarMunicipio($ID);
        
                header("location: ../index.php?page=2");
            } else {

                $ubicacion->InsertarDireccion($ID, $direccion);
                $ubicacion->actualizarLocalidad($ID, $localidad);
                $ubicacion->actualizarCentroides($ID, $centroide_localidad_lat, $centroide_localidad_lon);
                $ubicacion->eliminarMunicipio($ID);

                header("location: ../index.php?page=2&success=20");
            }
        } else {

            header("location: ../index.php?page=2&conerror=50");
        }
    }



    // if (
    //     $provincia == "Ciudad Autónoma de Buenos Aires" ||
    //     $provincia == "Entre Ríos" ||
    //     $provincia == "Santa Cruz" ||
    //     $provincia == "Santiago del Estero"
    // ) {

    //     if ($ubicacion->actualizarProvincia($ID, $provincia)) {

    //         if ($ubicacion->consultarInfoNegocio($ID)) {

    //             $ubicacion->actualizarDireccion($ID, $direccion);
    //             $ubicacion->eliminarMunicipio($ID);
    //             $ubicacion->actualizarLocalidad($ID, $localidad); //poner centroides luego
    //             header("location: ../index.php?page=2");
    //         } else {

    //             $ubicacion->InsertarDireccion($ID, $direccion);
    //             $ubicacion->eliminarMunicipio($ID);
    //             $ubicacion->actualizarLocalidad($ID, $localidad);
    //             header("location: ../index.php?page=2&success=20");
    //         }
    //     } else {

    //         header("location: ../index.php?page=2&conerror=50");
    //     }
    // } else {

    //     $municipio = $_POST["municipio-registro"];

    //     if ($ubicacion->actualizarProvinciaMunicipioLocalidad($ID, $provincia, $municipio, $localidad, $centroide_localidad_lat, $centroide_localidad_lon)) {

    //         if ($ubicacion->consultarInfoNegocio($ID)) {

    //             $ubicacion->actualizarDireccion($ID, $direccion);
    //             header("location: ../index.php?page=2&success=20");
    //         } else {
    //             $ubicacion->InsertarDireccion($ID, $direccion);
    //             header("location: ../index.php?page=2&success=20");
    //         }
    //     } else {


    //         header("location: ../index.php?page=2&conerror=40");
    //     }
    // }


    // // if ($ubicacion->actualizarProvinciaMunicipioLocalidad($ID, $provincia, $municipio, $localidad, $centroide_localidad_lat, $centroide_localidad_lon)) {

    // //     if ($ubicacion->consultarInfoNegocio($ID)) {
    // //         $ubicacion->actualizarDireccion($ID, $direccion);
    // //         // $ubicacion->eliminarMunicipio($ID);
    // //         header("location: ../index.php?page=2");
    // //     } else {
    // //         $ubicacion->InsertarDireccion($ID, $direccion);
    // //         // $ubicacion->eliminarMunicipio($ID);
    // //         header("location: ../index.php?page=2&success=20");
    // //     }
    // // } else {

    // //     header("location: ../index.php?page=2&conerror=50");
    // // }



} else {


    header("location: ../index.php?page=2&conerror=40");
}
