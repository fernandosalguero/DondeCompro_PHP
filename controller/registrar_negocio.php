<?php

require_once("../model/base_datos_usuarios.php");
require_once("../controller/email.sendgrid.php");


$nombre = htmlentities(addslashes($_POST["nombre"]));
$correo = htmlentities(addslashes($_POST["correo"]));
$clave = htmlentities(addslashes($_POST["clave"]));
$perfil = 1;
$estado = 0;
$a_fecha = getdate();
$fecha = $a_fecha["year"] . "-" . $a_fecha["mon"] . "-" . $a_fecha["mday"];
$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT);
$activacion_sin = rand(0, 99999);
$activacion_con = password_hash($activacion_sin, PASSWORD_DEFAULT);
$provincia = $_POST["provincia-registro"];
$municipio = '';
$direccion = '';
$localidad = '';
$latitud = $_POST["lat"];
$longitud = $_POST["lon"];

if (isset($_POST["municipio-registro"])) {
    $municipio = $_POST["municipio-registro"];
    if ($municipio == "seleccionar") {
        $municipio = "";
    }
}
if ($_POST["localidades-registro"]) {
    $localidad = $_POST["localidades-registro"];
    if ($localidad == "seleccionar") {
        $localidad = "";
    }
}

$usuario = new consultarUsuario();
$conexion = new insertarUsuario();


/*si el método insertar_temp devuelve true es porque guardó correctamente los datos en la tabla
temporal, por lo tanto se procede a mandar el correo de verificación */

if (!$usuario->consultar($nombre)) {

    if ($conexion->insertar_temp($nombre, $correo, $clave_cifrada, $perfil, $estado, $fecha, $activacion_con, $provincia, $municipio, $direccion, $localidad, $latitud, $longitud)) {

        $para = $correo;
        $titulo = 'Verificación y activación de la cuenta';
        $mensaje = "
    
        <div id = 'cuerpo' style='text-align: center;'>
        
        <h3>$nombre</h3>
    
        <p>Para activar tu cuenta, hacé click acá </p><br>
    
        <a href='" . "https://" . $_SERVER["SERVER_NAME"] . "/view/activacion.php?correo=$correo&activacion=$activacion_con" . "' id='activar' style='padding:10px; background-color: #22C622; text-decoration: none; color: white;'>ACTIVÁ TU CUENTA</a>
    
        <p>Si el link no funciona, copiá y pegá el siguiente enlace en tu navegador:</p>
    
        <p>https://" . $_SERVER["SERVER_NAME"] . "/view/activacion.php?correo=$correo&activacion=$activacion_con</p>
    
        <p><strong>¡Gracias y bienvenid@ a DóndeCompro?!</strong></p>
        
        </div>
    
        <style>
    
        *{
    
            margin: 0xp;
            paddig: 0px;
    
    
        }
    
        p{
    
            margin: 10px;
            padding: 10px;
    
    
        }
    
        a, a:visited{
    
    
            text-decoration: none;
            color: white;
    
    
        }
    
    
        #activar{
    
            width: fit-content;
            padding: 10px;
            color: white;
            font-style: bold;
            text-decoration: none;
            background: #22c622;
    
    
        }
    
        #cuerpo{
    
    
            text-align: center;
    
    
        }
    
    
        </style>
        
        
        ";

        $cabeceras = 'From: contacto@web.dondecompro.ar' . "\r\n" .
            'Reply-To: contacto@web.dondecompro.ar' . "\r\n" .
            "Content-Type: text/html;charset=utf-8" . "\r\n";

        // mail($para, $titulo, $mensaje, $cabeceras);
        $email = new EmailSendgrid();
        $emailResult = $email->send2($para, $nombre, $titulo, $mensaje);

        if ($emailResult['code'] > 200 && $emailResult['code'] < 300) {

            header("location: ../view/verificacion.php");
        } else {

            echo 'Problemas al realizar la acción solicitada, intentalo nuevamente';
        }
    } else {


        echo 'Problemas al realizar la acción solicitada, intentalo nuevamente';
    }
} else {

    header("location: ../view/registrar-negocio.php");
}
