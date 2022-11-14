<?php

require_once("../controller/conerror.php");

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperar Contraseña</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/media/image/favicon.png" />

    <!-- Plugin styles -->
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="assets/css/app.min.css" type="text/css">

    <!-- personal styles -->
    <link rel="stylesheet" href="assets/css/recuperar-clave.css">
</head>

<body class="dark form-membership">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->

    <div class="d-flex flex-column align-items-center">

        <div class="col-sm-12 col-md-6 col-xl-4">

            <div class="card card-reset">

                <figure class="text-center m-4">

                    <img src="assets/media/image/ositos/recuperar-clave.png" alt="image">

                </figure>

                <div class="card-body">

                    <h5 class="card-title text-center">Restablecé tu Contraseña</h5>
                    <p>Te enviaremos un link a tu correo para verificar tus datos
                        y luego podrás establecer otra contraseña.
                    </p>

                    <!-- form -->
                    <form action="../controller/recuperar_clave.php" method="POST">
                        <div class="form-group">
                            <input type="email" name="correo" class="form-control" placeholder="Email" required autofocus>
                        </div>
                        <input type="submit" class="btn btn-sm btn-success btn-block opciones" value="ENVIAR">


                    </form>
                    <!-- ./ form -->

                </div>

                <div class="card-footer">

                    <div>
                        <p>También podés</p>
                        <div class="row">
                            <div class="col">
                                <a href="registrar-usuario.php" class="btn btn-sm btn-success btn-block opciones">Registrarte</a>
                            </div>
                            <div class="col">
                                <a href="../index.php" class="btn btn-sm btn-success btn-block opciones">Volver al Login</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Plugin scripts -->
    <script src="vendors/bundle.js"></script>

    <!-- App scripts -->
    <script src="assets/js/app.min.js"></script>
</body>

</html>