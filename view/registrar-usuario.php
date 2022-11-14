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



        <h3 class="titulos">CREÁ TU CUENTA DE USUARIO</h3>

        <div>
            <figure><img src="assets/media/image/ositos/agregar-usuario.png" alt="image"></figure>
        </div>


        <!-- form -->
        <form action="../controller/registrar_usuario.php" method="POST" onsubmit="return validar();">
            <div class="form-group">

                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de usuario" onchange="fNombre();" require autofocus>
                <small class="form-text" id="enombre"><i></i> </small>

            </div>

            <div class="form-group">

                <input type="email" name="correo" id="correo" class="form-control" placeholder="Email" onchange="fCorreo();" require>
                <small class="form-text" id="ecorreo"><i> </i> </small>

            </div>

            <div class="form-group">

                <input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña" onchange="fClave();" require>
                <small class="form-text" id="eclave"><i></i> </small>

            </div>
            <div class="form-group">

                <input type="password" name="rclave" id="rclave" class="form-control" placeholder="Repetí la contraseña" onchange="frClave();" require>
                <small class="form-text" id="erclave"><i></i> </small>

            </div>
            <div class="form-group">

                <label for="provincias">Provincia:</label>

                <select class='form-control' name='provincia-registro' id='provincias-registro' onchange="cargarMunicipios()">

                    <option selected value='seleccionar'>
                        Seleccionar
                    </option>

                </select>

            </div>


            <div class="form-group" style="display: none;" id='mMunicipios-registro'>

                <label for="municipios">Departamento:</label>
                <select class='form-control' name='municipio-registro' id='municipios-registro' onchange="cargarLocalidades()">

                    <option selected value='seleccionar'>
                        Seleccionar
                    </option>

                </select>

            </div>

            <div class="form-group" style="display: none;" id='lLocalidades-registro'>

                <label for="localidades">Localidad:</label>
                <select class='form-control' name='localidades-registro' id='localidades-registro' onchange="cargarCentroideMunicipio()">

                    <option selected value='seleccionar'>
                        Seleccionar
                    </option>

                </select>

                <input type="hidden" name="lat" id="lat" class="form-control" require>
                <input type="hidden" name="lon" id="lon" class="form-control" require>


            </div>


            <div class="form-group">
                <div class="custom-control custom-checkbox custom-checkbox-success">
                    <input type="checkbox" class="custom-control-input" id="licencia">
                    <label class="custom-control-label" for="licencia"><a href="https://dondecompro.ar/wp/legales/" target="_blank" class="terminos">Acepto los terminos de uso </a></label>
                </div>
            </div>


            <div>

                <button type="submit" class="btn btn-success btn-block">¡REGISTRATE!</button>

            </div>

        </form>
        <!-- ./ form -->


    </div>

    <!-- Plugin scripts -->
    <script src="vendors/bundle.js"></script>

    <!-- App scripts -->
    <script src="assets/js/app.min.js"></script>
    <!--Validación del formulario de registro en el Front -->
    <script src="assets/js/validar.js?version=1.05"> </script>
    <script src="assets/js/ubicacion.js?version=1.05"> </script>

</body>

</html>