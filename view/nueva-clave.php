<?php

require_once("../controller/conerror.php");

session_start();

if (!isset($_SESSION["succes"])) {

    header("location: ../index.php");
}


?>



<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nueva Contraseña</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/media/image/favicon.png" />

    <!-- Plugin styles -->
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="assets/css/app.min.css" type="text/css">
</head>

<body class="dark form-membership">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->

    <div class="row justify-content-center d-flex">
        <div class="col-sm-12 col-lg-4">
            <div class="card bg-transparent">
                <h5 class="card-title text-center" style="color:rgba(34, 198, 38, 0.7) !important;">Establecé una nueva contraseña</h5>
                <img src="assets/media/image/ositos/3.png" style="margin-left:auto; margin-right:auto;" alt="image" width="115" height="165">
                <div class="card-body">
                    <form action="../controller/nueva_clave.php" method="POST" onsubmit="return validar();">


                        <div class="form-group">

                            <input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña" onchange="fClave();" require style="border-radius:50px;">
                            <small class="form-text" id="eclave"><i></i> </small>

                        </div>
                        <div class="form-group">

                            <input type="password" name="rclave" id="rclave" class="form-control" placeholder="Repite la contraseña" onchange="frClave();" require style="border-radius:50px;">
                            <small class="form-text" id="erclave"><i></i> </small>

                        </div>

                        <div>

                            <button class="btn btn-success btn-block" style="border-radius:50px;">Establecer</button>

                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="form-wrapper">



        <h3 class="texto-verde">ESTABLECER NUEVA CONTRASEÑA</h3>

        <div>
            <figure><img src="assets/media/image/ositos/3.png" alt="image"></figure>
        </div>

        <form action="../controller/nueva_clave.php" method="POST" onsubmit="return validar();">


            <div class="form-group">

                <input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña" onchange="fClave();" require>
                <small class="form-text" id="eclave"><i></i> </small>

            </div>
            <div class="form-group">

                <input type="password" name="rclave" id="rclave" class="form-control" placeholder="Repite la contraseña" onchange="frClave();" require>
                <small class="form-text" id="erclave"><i></i> </small>

            </div>

            <div>

                <button class="btn btn-outline-success btn-block">ESTABLECER</button>

            </div>


        </form>

    </div> -->


    <!--Validación del formulario de registro en el Front -->
    <script src="assets/js/nueva-clave.js?version=1.05"> </script>
    <!-- Plugin scripts -->
    <script src="vendors/bundle.js"></script>

    <!-- App scripts -->
    <script src="assets/js/app.min.js"></script>
</body>

</html>