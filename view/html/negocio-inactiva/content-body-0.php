<?php

require_once("model/base_datos_usuarios.php");

$cupones_activos = array();
$idUsuario = $_SESSION["ID_USER"];
$cupones =  null;
$cuponesMensualesActivos = array();
$cuponesTrimestralesActivos = array();
$cuponesSemestralesActivos = array();
$cuponesAnualesActivos = array();

if (isset($idUsuario)) {
    $cupones = new Cupones();
    $cuponesMensualesActivos = $cupones->ver_cupones_activos_comercio($idUsuario, 'Mensual');
    $cuponesTrimestralesActivos = $cupones->ver_cupones_activos_comercio($idUsuario, 'Trimestral');
    $cuponesSemestralesActivos = $cupones->ver_cupones_activos_comercio($idUsuario, 'Semestral');
    $cuponesAnualesActivos = $cupones->ver_cupones_activos_comercio($idUsuario, 'Anual');
}

$_SESSION['CUPONES_MENSUALES'] = $cuponesMensualesActivos;
$_SESSION['CUPONES_TRIMESTRALES'] = $cuponesTrimestralesActivos;
$_SESSION['CUPONES_SEMESTRALES'] = $cuponesSemestralesActivos;
$_SESSION['CUPONES_ANUALES'] = $cuponesAnualesActivos;

$_SESSION['DESCUENTO_TRIMESTRAL'] = $cuponesTrimestralesActivos;
$_SESSION['DESCUENTO_SEMESTRAL'] = $cuponesSemestralesActivos;
$_SESSION['DESCUENTO_ANUAL'] = $cuponesAnualesActivos;


$costoMensual = 999;
$costoTrimestral = 1999;
$costoSemestral = 3850;
$costoAnual = 7400;

// verificacion si comercio fue referido por comisionado (sistema referidos);

$suscripcion = new Subscripcion();
$isComercioReferido = $suscripcion->isComercioReferido($idUsuario);

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
<script src="view/assets/js/subs.js?version=1.05"></script>
<script src="view/assets/js/procesar_pago.js?version=1.05"></script>

<style type="text/css">
    .suscripcionHighLight {

        border: solid 2px #F0235E !important;
        border-radius: 16px !important;
        background: #00000012 !important;
    }
    .suscripcionHighLight2 {
        border-radius: 16px !important;
        background: #00000012 !important;
    }

    /* @media (max-width: 480px) {
      .content{ width: 76%;}
        
    } */

    @media (min-width: 1200px) {
      .content{ width: 76%;}
    }

</style>

<script>
    $(() => {
        var vueApp = new Vue({
            el: '#suscripcion-opciones',
            data: {
                isComercioReferido: <?php echo ($isComercioReferido); ?>
            },
            methods: {}

        });
    });
</script>

<link rel="stylesheet" href="view/assets/css/content-body-0.css">
<!-- Content body -->
<div class="content-body" id="resRow">
    <!-- Content -->
    <div class="content">

        <h1 class="text-center mb-40" id="inicio">¡ANUCIÁ TUS PRODUCTOS Y PROMOCIONES!</h1>
        <div class="row p-0 resRow">

            <div class="col-md-12">
                <p class="text-center">
                    Te invitamos a crear tu catálogo de productos y generar promociones para aumentar tus ventas
                </p>

            </div>

            <div class="col-md-6">


                <div class="col-md-12">

                    <div class="card d-flex flex-column align-items-center">

                        <div class="card-body">
                            <p class="btn btn-success btn-block text-center m-0" id="brecom" onclick="mostrarRecomendaciones()" style="display: none;">Mostrar las recomendaciones</p>
                            <p class="btn btn-danger btn-block text-center m-0" id="brecom2" onclick="ocultarRecomendaciones()">Ocultar recomendaciones</p>
                        </div>

                    </div>
                </div>


                <div>
                    <div class="card">

                        <div class="card-body" id="recomendaciones" class="d-flex flex-column align-items-center">

                            <p class="text-center">

                                Para una experiencia más satisfactoria con el pago de la subscripción a nuestro sistema de publicidad,
                                preparamos 2 recomendaciones para vos:

                            </p>

                            <p class="text-center"><strong>1.</strong> Cuando acredites el pago, es muy importante que le des click en el botón 'Volver al sitio'
                                o dejar que Mercado Pago te redireccione automáticamente a la App.

                                De esta manera, la App procesará tu alta automáticamente y de manera inmediata.
                            </p>
                            <figure class="text-center">
                                <img src="view/assets/media/image/recomendaciones.jpg" class="recomendaciones text-center">
                            </figure>

                            <p class="text-center">Si por algún motivo realizaste el pago correctamente y no le das click en 'Volver al sitio' o
                                cierras la ventana antes que Mercado Pago te redireccione automáticamente a la App, ¡No te preocupes!,
                                mandanos un email con tu nombre de usuario de la App y el numero de pago (Operación) y nosotros el mismo día te enviaremos un link a tu correo para que la App habilite tu
                                sistema de publicidad.
                            </p>

                            <p class="text-center"><strong>2.</strong> Si al momento de realizar el pago te manda a la ventana de 'Estamos procesando tu pago',
                                hacé click en 'Ok, entendido', te redireccionará a la página de inicio de la plataforma. Lo ideal es que vayás
                                a tu cuenta de Mercado Pago y cancelés el pago para luego abrir el formulario de pago nuevamente, de esta
                                manera la plataforma procesará tu alta de manera automática e inmediata.
                            </p>
                            <figure class="text-center">
                                <img src="view/assets/media/image/recomendaciones2.jpg" class="recomendaciones text-center">
                            </figure>
                            <p class="text-center">Si por algún motivo no podés cancelar el pago y luego de unas horas se acredita ¡No te preocupes!,
                                mandanos un email con tu nombre de usuario de la App y el numero de pago (Operación) y nosotros el mismo día te enviaremos un link a tu correo para que la App habilite tu
                                sistema de publicidad.
                            </p>

                            <a href="#inicio" class="texto-gris text-center" onclick="ocultarRecomendaciones()">Ocultar recomendaciones.</a>

                        </div>
                    </div>

                </div>

            </div>



            <div class="col-md-6" id="suscripcion-opciones">

                <div v-if="isComercioReferido == 1" class="row justify-content-center my-3" style="color: #F0235E;">
                    <h4 class="text-center">
                        Comercio Referido
                    </h4>
                </div>


                <div>
                    <!-- SUSCRIPCIÓN MENSUAL -->
                    <div class="card suscripcionHighLight2" :class="isComercioReferido == 1 ? 'suscripcionHighLight' : ''">
                        <div class="card-body">
                            <h6 class="card-title text-center">SUSCRIPCIÓN POR UN MES.</h6>
                            <?php
                            $aplicaDescuentoMensual = false;
                            $costoMensualConDescuento = $costoMensual;
                            $porcentajeDescuentoMensual = 0;
                            $descuentoMensual = array();
                            if (isset($cuponesMensualesActivos) && count($cuponesMensualesActivos) > 0) {
                                foreach ($cuponesMensualesActivos as $cuponMensualActivo) {
                                    $porcentajeDescuentoMensual += (float)$cuponMensualActivo['descuento'];
                                    $descuentoMensual[] = ($costoMensual * (float)$cuponMensualActivo['descuento'] / 100);
                                }
                                if ($porcentajeDescuentoMensual > 0) {
                                    $costoMensualConDescuento = $costoMensualConDescuento - (($costoMensualConDescuento * $porcentajeDescuentoMensual) / 100);
                                    $aplicaDescuentoMensual = true;
                                }
                            }

                            $_SESSION['DESCUENTO_MENSUAL'] = $descuentoMensual;

                            ?>

                            <p class="text-center">Accedé a los beneficios de la suscripción durante un mes.</p>
                            <!-- <h4 class="text-center">Costo: <strong class="texto-verde">$ 999 ARS</strong></h4> -->
                            <div>

                                <h4 class="text-center">Costo: <span style="position:relative"> <?php if ($aplicaDescuentoMensual) {
                                                                                                    echo ("<span class='line'></span><span class='line2'></span>");
                                                                                                } ?> <strong class="texto-verde">$ 999 ARS</strong> </span></h4>

                                <?php

                                if ($porcentajeDescuentoMensual > 0 && $costoMensualConDescuento < $costoMensual) {

                                    echo ("<h4 class='text-center'>Pagás: <strong class='texto-verde'>$ $costoMensualConDescuento ARS</strong></h4>");
                                }
                                ?>


                            </div>

                            <p v-if="isComercioReferido == 0" class="" style="color:gray;">PLAN BÁSICO</p>
                            <hr>
                            <?php

                            if (isset($cuponesMensualesActivos) && count($cuponesMensualesActivos) > 0) {
                                echo ("<div class='row justify-content-center' style='margin-bottom: 10px;'>
                                            <span>
                                                <h5>Descuentos mensuales activos</h5>
                                            </span>
                                        </div>");
                            }
                            ?>
                            <div class="row justify-content-center">

                                <ul>
                                    <?php
                                    $idx = 1;
                                    if (isset($cuponesMensualesActivos) && count($cuponesMensualesActivos) > 0) {
                                        foreach ($cuponesMensualesActivos as $cuponMensualActivo) {
                                            echo ("<li> " . $idx . " - " . $cuponMensualActivo['descripcion'] . " - " . $cuponMensualActivo['descuento'] . "% - vence: " . date_format(new DateTime($cuponMensualActivo['fecha_hasta']), 'd/m/Y') . "</li><hr style='margin-top: 3px; margin-bottom:3px;'>");
                                            $idx++;
                                        }
                                    }
                                    ?>

                                </ul>
                            </div>
                            <!-- <hr> -->
                            <p style="margin-top: 20px;" class="texto-verde text-center">Para ver la opción de pago hacé click <button onclick="generarInitPointMP('mes1', <?php echo ($costoMensualConDescuento); ?>, 'Mensual' )" class="btn btn-success btn-sm">AQUÍ</button></p>
                            <a class="btn btn-success btn-block" id="mes1" style="display: none;">PAGAR</a>

                        </div>
                    </div>

                </div>


                <div v-if="isComercioReferido == 0">
                    <!-- SUSCRIPCIÓN TRIMESTRAL -->
                    <div class="card suscripcionHighLight2">
                        <div class="card-body">
                            <h6 class="card-title text-center">SUSCRIPCIÓN POR 3 MESES.</h6>
                            <?php
                            $aplicaDescuentoTrimestral = false;
                            $costoTrimestralConDescuento = $costoTrimestral;
                            $porcentajeDescuentoTrimestral = 0;
                            $descuentoTrimestral = array();
                            if (isset($cuponesTrimestralesActivos) && count($cuponesTrimestralesActivos) > 0) {
                                foreach ($cuponesTrimestralesActivos as $cuponTrimestralActivo) {
                                    $porcentajeDescuentoTrimestral += (float)$cuponTrimestralActivo['descuento'];
                                    $descuentoTrimestral[] = ($costoTrimestral * (float)$cuponTrimestralActivo['descuento'] / 100);
                                }
                                if ($porcentajeDescuentoTrimestral > 0) {
                                    $costoTrimestralConDescuento = $costoTrimestralConDescuento - (($costoTrimestralConDescuento * $porcentajeDescuentoTrimestral) / 100);
                                    $aplicaDescuentoTrimestral = true;
                                }
                            }
                            $_SESSION['DESCUENTO_TRIMESTRAL'] = $descuentoTrimestral;

                            ?>

                            <p class="text-center">Accede a los beneficios de la suscripción durante 3 meses.</p>
                            <div>

                                <h4 class="text-center">Costo: <span style="position:relative"> <?php if ($aplicaDescuentoTrimestral) {
                                                                                                    echo ("<span class='line'></span><span class='line2'></span>");
                                                                                                } ?> <strong class="texto-verde">$ 1999 ARS</strong> </span></h4>

                                <?php

                                if ($porcentajeDescuentoTrimestral > 0 && $costoTrimestralConDescuento < $costoTrimestral) {

                                    echo ("<h4 class='text-center'>Pagás: <strong class='texto-verde'>$ $costoTrimestralConDescuento ARS</strong></h4>");
                                } else {
                                    echo (" <p class='texto-gris text-center'>¡TE AHORRAS $ 1.000 ARS!</p>");
                                }
                                ?>


                            </div>

                            <hr>
                            <?php

                            if (isset($cuponesTrimestralesActivos) && count($cuponesTrimestralesActivos) > 0) {
                                echo ("<div class='row justify-content-center' style='margin-bottom: 10px;'>
                                            <span>
                                                <h5>Descuentos trimestrales activos</h5>
                                            </span>
                                        </div>");
                            }
                            ?>
                            <div class="row justify-content-center">

                                <ul>
                                    <?php
                                    $idx2 = 1;
                                    if (isset($cuponesTrimestralesActivos) && count($cuponesTrimestralesActivos) > 0) {
                                        foreach ($cuponesTrimestralesActivos as $cuponTrimestralActivo) {
                                            echo ("<li> " . $idx2 . " - " . $cuponTrimestralActivo['descripcion'] . " - " . $cuponTrimestralActivo['descuento'] . "% - vence: " . date_format(new DateTime($cuponTrimestralActivo['fecha_hasta']), 'd/m/Y') . "</li><hr style='margin-top: 3px; margin-bottom:3px;'>");
                                            $idx2++;
                                        }
                                    }
                                    ?>

                                </ul>
                            </div>
                            <!-- <hr> -->
                            <p style="margin-top: 20px;" class="texto-verde text-center">Para ver la opción de pago hacé click <button onclick="generarInitPointMP('mes2', <?php echo ($costoTrimestralConDescuento); ?>, 'Trimestral' )" class="btn btn-success btn-sm">AQUÍ</button></p>
                            <a class="btn btn-success btn-block" id="mes2" style="display: none;">PAGAR</a>

                        </div>
                    </div>

                </div>

                <div v-if="isComercioReferido == 0">
                    <!-- SUSCRIPCIÓN SEMESTRAL -->
                    <div class="card suscripcionHighLight2">
                        <div class="card-body">
                            <h6 class="card-title text-center">SUSCRIPCIÓN POR 6 MESES.</h6>
                            <?php
                            $aplicaDescuentoSemestral = false;
                            $costoSemestralConDescuento = $costoSemestral;
                            $porcentajeDescuentoSemestral = 0;
                            $descuentoSemestral = array();
                            if (isset($cuponesSemestralesActivos) && count($cuponesSemestralesActivos) > 0) {
                                foreach ($cuponesSemestralesActivos as $cuponSemestralActivo) {
                                    $porcentajeDescuentoSemestral += (float)$cuponSemestralActivo['descuento'];
                                    $descuentoSemestral[] = ($costoSemestral * (float)$cuponSemestralActivo['descuento'] / 100);
                                }
                                if ($porcentajeDescuentoSemestral > 0) {
                                    $costoSemestralConDescuento = $costoSemestralConDescuento - (($costoSemestralConDescuento * $porcentajeDescuentoSemestral) / 100);
                                    $aplicaDescuentoSemestral = true;
                                }
                            }
                            $_SESSION['DESCUENTO_SEMESTRAL'] = $descuentoSemestral;

                            ?>

                            <p class="text-center">Accede a los beneficios de la suscripción durante 6 meses.</p>
                            <div>

                                <h4 class="text-center">Costo: <span style="position:relative"> <?php if ($aplicaDescuentoSemestral) {
                                                                                                    echo ("<span class='line'></span><span class='line2'></span>");
                                                                                                } ?> <strong class="texto-verde">$ 3.850 ARS</strong> </span></h4>

                                <?php

                                if ($porcentajeDescuentoSemestral > 0 && $costoSemestralConDescuento < $costoSemestral) {

                                    echo ("<h4 class='text-center'>Pagás: <strong class='texto-verde'>$ $costoSemestralConDescuento ARS</strong></h4>");
                                } else {
                                    echo (" <p class='texto-gris text-center'>¡TE AHORRAS $ 2.100 ARS!</p>");
                                }
                                ?>


                            </div>

                            <hr>
                            <?php

                            if (isset($cuponesSemestralesActivos) && count($cuponesSemestralesActivos) > 0) {
                                echo ("<div class='row justify-content-center' style='margin-bottom: 10px;'>
                                            <span>
                                                <h5>Descuentos semestrales activos</h5>
                                            </span>
                                        </div>");
                            }
                            ?>
                            <div class="row justify-content-center">

                                <ul>
                                    <?php
                                    $idx3 = 1;
                                    if (isset($cuponesSemestralesActivos) && count($cuponesSemestralesActivos) > 0) {
                                        foreach ($cuponesSemestralesActivos as $cuponSemestralActivo) {
                                            echo ("<li> " . $idx3 . " - " . $cuponSemestralActivo['descripcion'] . " - " . $cuponSemestralActivo['descuento'] . "% - vence: " . date_format(new DateTime($cuponSemestralActivo['fecha_hasta']), 'd/m/Y') . "</li><hr style='margin-top: 3px; margin-bottom:3px;'>");
                                            $idx3++;
                                        }
                                    }
                                    ?>

                                </ul>
                            </div>
                            <!-- <hr> -->
                            <p style="margin-top: 20px;" class="texto-verde text-center">Para ver la opción de pago hacé click <button onclick="generarInitPointMP('mes3', <?php echo ($costoSemestralConDescuento); ?>, 'Semestral')" class="btn btn-success btn-sm">AQUÍ</button></p>
                            <a class="btn btn-success btn-block" id="mes3" style="display: none;">PAGAR</a>

                        </div>
                    </div>

                </div>

                <div v-if="isComercioReferido == 0">
                    <!-- SUSCRIPCIÓN ANUAL -->
                    <div class="card suscripcionHighLight2">
                        <div class="card-body">
                            <h6 class="card-title text-center">SUSCRIPCIÓN POR 1 AÑO.</h6>
                            <?php
                            $aplicaDescuentoAnual = false;
                            $costoAnualConDescuento = $costoAnual;
                            $porcentajeDescuentoAnual = 0;
                            $descuentoAnual = array();
                            if (isset($cuponesAnualesActivos) && count($cuponesAnualesActivos) > 0) {
                                foreach ($cuponesAnualesActivos as $cuponAnualActivo) {
                                    $porcentajeDescuentoAnual += (float)$cuponAnualActivo['descuento'];
                                    $descuentoAnual[] = ($costoAnual * (float)$cuponAnualActivo['descuento'] / 100);
                                }
                                if ($porcentajeDescuentoAnual > 0) {
                                    $costoAnualConDescuento = $costoAnualConDescuento - (($costoAnualConDescuento * $porcentajeDescuentoAnual) / 100);
                                    $aplicaDescuentoAnual = true;
                                }
                            }
                            $_SESSION['DESCUENTO_ANUAL'] = $descuentoAnual;

                            ?>

                            <p class="text-center">Accede a los beneficios de la suscripción durante 1 año.</p>
                            <div>

                                <h4 class="text-center">Costo: <span style="position:relative"> <?php if ($aplicaDescuentoAnual) {
                                                                                                    echo ("<span class='line'></span><span class='line2'></span>");
                                                                                                } ?> <strong class="texto-verde">$ 7.400 ARS</strong> </span></h4>

                                <?php

                                if ($porcentajeDescuentoAnual > 0 && $costoAnualConDescuento < $costoAnual) {

                                    echo ("<h4 class='text-center'>Pagás: <strong class='texto-verde'>$ $costoAnualConDescuento ARS</strong></h4>");
                                } else {
                                    echo (" <p class='texto-gris text-center'>¡TE AHORRAS $ 4.650 ARS!</p>");
                                }
                                ?>


                            </div>

                            <hr>
                            <?php

                            if (isset($cuponesAnualesActivos) && count($cuponesAnualesActivos) > 0) {
                                echo ("<div class='row justify-content-center' style='margin-bottom: 10px;'>
                                            <span>
                                                <h5>Descuentos anuales activos</h5>
                                            </span>
                                        </div>");
                            }
                            ?>
                            <div class="row justify-content-center">

                                <ul>
                                    <?php
                                    $idx4 = 1;
                                    if (isset($cuponesAnualesActivos) && count($cuponesAnualesActivos) > 0) {
                                        foreach ($cuponesAnualesActivos as $cuponAnualActivo) {
                                            echo ("<li> " . $idx4 . " - " . $cuponAnualActivo['descripcion'] . " - " . $cuponAnualActivo['descuento'] . "% - vence: " . date_format(new DateTime($cuponAnualActivo['fecha_hasta']), 'd/m/Y') . "</li><hr style='margin-top: 3px; margin-bottom:3px;'>");
                                            $idx4++;
                                        }
                                    }
                                    ?>

                                </ul>
                            </div>
                            <!-- <hr> -->
                            <p style="margin-top: 20px;" class="texto-verde text-center">Para ver la opción de pago hacé click <button onclick="generarInitPointMP('mes4', <?php echo ($costoAnualConDescuento); ?>, 'Anual')" class="btn btn-success btn-sm">AQUÍ</button></p>
                            <a class="btn btn-success btn-block" id="mes4" style="display: none;">PAGAR</a>

                        </div>
                    </div>

                </div>

                <div>

                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title text-center">Ingresá un cupón de descuento</h6>
                            <div class="justify-content-center">
                                <form class="form-inline" action="controller/agregar_cupon_comercio.php" method="POST">
                                    <div class="form-group mb-2">

                                        <input type="text" class="form-control" id="codigo" name="codigo" aria-describedby="cupón mensual de descuento" placeholder="Código">

                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Agregar</button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>

    </div>
    <!-- ./ Content -->

    <!-- Footer -->
    <footer class="content-footer">

        <div class="text-center texto-blanco">
            © 2020 - <a href="https://dondecompro.ar/quienes-somos" id="a-per" target="_blank">DóndeCompro? </a>
        </div>
        <div class="text-center texto-blanco"> Todos los derechos reservados </div>
    </footer>
    <!-- ./ Footer -->
</div>
<!-- ./ Content body -->