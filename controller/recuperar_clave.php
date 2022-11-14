<?php

require_once("../model/base_datos_usuarios.php");
require_once("../controller/email.sendgrid.php");


if (!isset($_POST["correo"])) {

    header("location: ../index.php");
}

$correo = $_POST["correo"];

$consultar_correo = new consultarCorreo($correo);

if ($consultar_correo->consultar($correo)) {

    $verificacion = rand(1, 15000);
    $verificacion_con = password_hash($verificacion, PASSWORD_DEFAULT);

    $recuperar = new Recuperar();

    if ($recuperar->insertarVerificacion($verificacion_con, $correo)) {

        $para = $correo;
        $titulo = 'RESTABLECER CONTRASEÑA';
        $mensaje = "¡Hola! ABRÍ EL SIGUIENTE LINK PARA ESTABLECER UNA NUEVA CONTRASEÑA: " . $_SERVER["SERVER_NAME"] . "/controller/nueva_clave.php?correo=$correo&verificacion=$verificacion_con";
        $cabeceras = 'From: contacto@web.dondecompro.ar' . "\r\n" .
            'Reply-To: contacto@web.dondecompro.ar' . "\r\n" .
            "Content-Type: text/html;charset=utf-8" . "\r\n";

        $email = new EmailSendgrid();
        $emailResult = $email->send2($para, '', $titulo, $mensaje);

        if ($emailResult['code'] > 200 && $emailResult['code'] < 300) {

            header("location: ../view/verificacion-2.php");
        } else {

            header("location: ../index.php?conerror=40");
        }
    } else {

        header("location: ../view/recuperar-clave.php?conerror=40");
    }
} else {


    header("location: ../view/recuperar-clave.php?conerror=3312");
}
