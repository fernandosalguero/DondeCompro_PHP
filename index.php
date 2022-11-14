<?php

require_once("controller/navegacion.php");

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DóndeCompro?</title>

    <!-- Icono -->
    <link rel="shortcut icon" href="view/assets/media/image/favicon.png" />

    <!-- Main css -->
    <link rel="stylesheet" href="view/vendors/bundle.css" type="text/css">

    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- App css -->
    <link rel="stylesheet" href="view/assets/css/app.min.css" type="text/css">


    <!-- css login-->
    <link rel="stylesheet" href="view/assets/css/login.css" type="text/css">
    <link rel="stylesheet" href="view/assets/css/header.css" type="text/css">
    <link rel="stylesheet" href="view/assets/css/navegacion.css" type="text/css">
    <link rel="stylesheet" href="view/assets/css/menu-administrador.css" type="text/css">
    <link rel="stylesheet" href="view/assets/css/menu-usuario.css" type="text/css">


    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Meta Etiquetas para el Sw -->
    <meta name="description" content="App Para buscar y comparar precios de productos, en una amplia variedad de negocios">
    <meta name="theme-color" content="#22C622">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="shortcut icon" type="image/png" href="./view/assets/media/icons/icon_192.png">
    <link rel="apple-touch-icon" href="./view/assets/media/icons/donde_compro.png">
    <link rel="apple-touch-startup-image" href="./view/assets/media/icons/icon_256.png">
    <link rel="manifest" href="./manifest.json">

</head>

<body class="dark" id="index-body">
    <!-- Precargador de la página -->
    <div class="preloader" id="preloaderIndex">
        <div class="preloader-icon"></div>
        <span>Cargando...</span>
    </div>
    <!--Termina el Precargador de la página-->

    <!-- Layout wrapper -->
    <div class="layout-wrapper">

        <!-- Header -->
        <?php CargarHeader() ?>
        <!-- ./ Header -->

        <!-- Content wrapper -->
        <div class="content-wrapper">

            <!-- begin::navigation -->
            <?php cargarNavegacion() ?>
            <!-- end::navigation -->

            <!-- Content body -->
            <?php cargarContenido() ?>
            <!-- ./ Content body -->

        </div>
        <!-- ./ Content wrapper -->

    </div>
    <!-- ./ Layout wrapper -->

    <!-- Main scripts -->
    <script src="view/vendors/bundle.js"></script>

    <?php

    require_once("controller/conerror.php");
    require_once("controller/success.php");

    ?>


    <!-- App scripts -->
    <script src="view/assets/js/app.min.js?version=1.01"></script>
    <script src="view/assets/js/script.js?version=1.01"></script>
    <script src="view/assets/js/datos-incompletos.js"></script>

</body>


</html>