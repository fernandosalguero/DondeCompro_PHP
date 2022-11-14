<?php

require_once("../model/base_datos_usuarios.php");

if (isset($_GET["id"])) {

    $ID = $_GET["id"];

    $usuario = new consultarUsuario();


    if ($usuario->consultarID($ID)) {

        $info_usuario = $usuario->registro;

        function cargarImagen($a)
        {

            if ($a == null) {

                return "view/assets/media/image/user/default.png";
            } else {

                return $a;
            }
        }

        function infoUser($a)
        {

            if ($a != null) {

                return $a;
            } else {

                return "No establecido";
            }
        }

        function isActivo($activo)
        {
            if ($activo == null || $activo == false) return false;
            return true;
        }

        function nombreMeses($a)
        {

            switch ($a) {

                case 1:
                    return "Enero";
                    break;

                case 2:
                    return "Febrero";
                    break;

                case 3:
                    return "Marzo";
                    break;

                case 4:
                    return "Abril";
                    break;

                case 5:
                    return "Mayo";
                    break;

                case 6:
                    return "Junio";
                    break;

                case 7:
                    return "Julio";
                    break;

                case 8:
                    return "Agosto";
                    break;

                case 9:
                    return "Septiembre";
                    break;

                case 10:
                    return "Octubre";

                case 11:
                    return "Noviembre";
                    break;

                case 12:
                    return "Diciembre";
                    break;
            }
        }

        function fechaText($a)
        {

            $fecha = strtotime($a);

            $anio = date("Y", $fecha);
            $mes = date("m", $fecha);
            $dia = date("d", $fecha);

            return "$dia de " . nombreMeses($mes) . " de $anio";
        }

        $aux_usuario = "";

        $idUsuario = $info_usuario['ID'];

        $aux_usuario .= "

        <div class = 'd-flex flex-column p-3'>
            <figure class = 'text-center'><img src='" . cargarImagen($info_usuario["imagen"]) . "' alt = 'Imagen Usuario' width = 150> </figure>
            <h3 class = 'texto-verde text-center'>" . $info_usuario["nombre"] . "</h3>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>ACTIVO:</strong></p> <p>" . (isActivo($info_usuario["activo"]) == true
            ? "Sí<a style=\"margin-left: 20px; color: orange !important; cursor: pointer;\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Bloquear Usuario\" onclick=\"bloquearUsuario($idUsuario)\"><i style=\"font-size: 18px;\" class=\"fas fa-lock\"></i></a> </p> "
            : "No <a style=\"margin-left: 8px; color: green !important; cursor: pointer;\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Desbloquear Usuario\" onclick=\"desbloquearUsuario($idUsuario)\"><i style=\"font-size: 18px;\" class=\"fas fa-lock-open\"></i></a><a style=\"margin-left: 20px;margin-right: 8px; color: tomato !important; cursor: pointer;\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Eliminar Usuario (Cuidado!! es irreversible)\" onclick=\"eliminarUsuario($idUsuario)\">Eliminar Usuario<i style=\"font-size: 18px; margin-left: 8px;\" class=\"fas fa-trash-alt\"></i></a>") . "</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>PROVINCIA:</strong></p> <p>" . infoUser($info_usuario["provincia"]) . "</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>MUNICIPIO:</strong></p> <p>" . infoUser($info_usuario["municipio"]) . "</p>
            <p class = 'text-start mb-0'><strong class = 'texto-verde'>FECHA DE REGISTRO: </strong></p><p>" . fechaText($info_usuario["fecha"]) . "</p>

        </div>
        ";

        echo $aux_usuario;
    }
} else {


    echo "Hubo un error al cargar la información, por favor, recarga la página";
}
