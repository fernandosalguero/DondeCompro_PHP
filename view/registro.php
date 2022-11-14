<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrate</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/media/image/favicon.png" />

    <!-- Plugin styles -->
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="assets/css/app.min.css" type="text/css">
    <!-- Personal styles -->
    <link rel="stylesheet" href="assets/css/registro.css" type="text/css">
</head>

<body class="dark form-membership">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->

    <div class="form-wrapper">

        <h3 class="titulos mb-3">ELEGÍ TU TIPO DE CUENTA</h3>

        <div id="maquetaImagen">
            <figure id="saludo"><img src="assets/media/image/ositos/3.png" id="imgSaludo" alt="image"></figure>
        </div>

        <div>
            <div class="elegir-opcion">
                <a href="registrar-usuario.php" id="registroFamilia"><button class="btn btn-outline-success btn-block option opcion-familia" style="background: #d357ff !important; font-size: large;">Familia</button></a>
            </div>
            <div class="elegir-opcion">
                <a href="registrar-negocio.php" id="registroNegocio"><button class="btn btn-outline-success btn-block option opcion-comercio" style="background:  #db685e !important; font-size: large;">Comercio</button></a>
            </div>
            <div class="elegir-opcion-login">
                <a href="../index.php"><button class="btn btn-outline-success btn-block option opcion-login" style="background:  #3c92db !important">INGRESÁ</i></button></a>
            </div>
        </div>

    </div>


    <!-- Plugin scripts -->
    <script src="vendors/bundle.js"></script>

    <!-- App scripts -->
    <script src="assets/js/app.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
        $(() => {
            $("#registroFamilia").hover(function() {
                $("#maquetaImagen").empty();
                $("#maquetaImagen").append(`<figure id="familia"><img src="assets/media/image/ositos/agregar-usuario.png" id="imgFamilia" alt="image"></figure>`);
            }, function() {
                $("#maquetaImagen").empty();
                $("#maquetaImagen").append(`<figure id="saludo"><img src="assets/media/image/ositos/3.png" id="imgSaludo" alt="image"></figure>`);
            });
            $("#registroNegocio").hover(function() {
                $("#maquetaImagen").empty();
                $("#maquetaImagen").append('<figure id="negocio"><img src="assets/media/image/ositos/agregar-negocio.png" id="imgNegocio" alt="image"></figure>');

            }, function() {
                $("#maquetaImagen").empty();
                $("#maquetaImagen").append(`<figure id="saludo"><img src="assets/media/image/ositos/3.png" id="imgSaludo" alt="image"></figure>`);
            });
        });
    </script>


</body>

</html>