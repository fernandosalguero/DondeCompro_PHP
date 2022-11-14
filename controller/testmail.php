<?php

require_once("./email.sendgrid.php");


$para = 'gerquino@gmail.com';
$activacion_con = 'abdc123abcd1234asdass1244a';
$nombre = 'German Quiroga';
$titulo = 'Verificación y activación de la cuenta [*TEST*]';
$mensaje = "

  <div id = 'cuerpo' style='text-align: center;'>

  <h3>$nombre</h3>

  <p>Para activar tu cuenta, hacé click acá </p><br>

  <a href='" . "https://" . $_SERVER["SERVER_NAME"] . "/view/activacion.php?correo=$para&activacion=$activacion_con" . "' id='activar' style='padding:10px; background-color: #22C622; text-decoration: none; color: white;'>ACTIVÁ TU CUENTA</a>

  <p>Si el link no funciona, copiá y pegá el siguiente enlace en tu navegador:</p>

  <p>https://" . $_SERVER["SERVER_NAME"] . "/view/activacion.php?correo=$para&activacion=$activacion_con</p>

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

// mail($para, $titulo, $mensaje, $cabeceras);
$email = new EmailSendgrid();
$emailResult = $email->send2($para, $nombre, $titulo, $mensaje);

if ($emailResult['code'] > 200 && $emailResult['code'] < 300) {

    echo("Email enviado exitosamente");
} else {

    echo('Problemas al realizar la acción solicitada, intentalo nuevamente');
}
