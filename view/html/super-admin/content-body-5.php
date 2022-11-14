<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

<style>
    @media (min-width: 480px) {

        .card-cupon {
            max-width: 20vw;
        }
    }

    @media (max-width: 480px) {
        .card-cupon {
            max-width: 100vw;
        }
    }
    @media (max-width: 1200px) {
        .card-cupon {
            max-width: 100vw;
        }
    }
</style>
<!-- Content body -->
<div class="content-body">
    <!-- Content -->
    <div class="content ">

        <div class="page-header titulo-menu">

            <h3 class="text-center">CUPONES DE DESCUENTO</h3>

        </div>


        <div class="row menu-cupones">

            <div class="col-md-2">

                <figure class="text-center"> <img src="view/assets/media/image/ositos/ajustes.png" class="configuracion-imagen"></figure>

                <div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    <a class="nav-item nav-link active gen-cupones" id="a-per-2" id="v-pills-cupones-tab1" data-toggle="pill" href="#v-pills-cupones" role="tab" aria-controls="v-pills-cupones" aria-selected="false">GENERAR
                        CUPONES</a>

                    <a class="nav-item nav-link ver-cupones" id="a-per-2" id="v-pills-cupones-tab2" data-toggle="pill" href="#v-pills-ver" role="tab" aria-controls="v-pills-ver" aria-selected="false">VER
                        CUPONES</a>
                </div>

            </div>

            <div class="col-md-10">

                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="v-pills-cupones" role="tabpanel" aria-labelledby="v-pills-cupones-tab">
                        <div class="card">

                            <div class="card-body">
                                <div class="card align-items-center">
                                    <h6 class="card-title texto-verde text-left">GENERAR CUPONES DE DESCUENTOS</h6>
                                </div>
                                <div class="card">
                                    <h6 class="card-title texto-verde">INGRESAR DATOS DE CUPONES</h6>
                                    <form method="POST" action="controller/generar_cupones.php">


                                        <div class="form-group">

                                            <label>Código</label>
                                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código">
                                            <!-- <p class="form-text text-center" id="ecodigo"></p> -->

                                        </div>


                                        <div class="form-group">

                                            <label>Suscripción</label>
                                            <select class='form-control' name='suscripcion' id='suscripcion'>

                                                <option selected value='seleccionar'>
                                                    Seleccionar una opción
                                                </option>
                                                <option value='mensual'>
                                                    Mensual
                                                </option>
                                                <option value='trimestral'>
                                                    Trimestral
                                                </option>
                                                <option value='semestral'>
                                                    Semestral
                                                </option>
                                                <option value='anual'>
                                                    Anual
                                                </option>

                                            </select>

                                        </div>

                                        <div class="form-group">

                                            <label>Acumulable</label>
                                            <input type="checkbox" checked name="acumulable" id="acumulable">

                                        </div>

                                        <div class="form-group">

                                            <label>Descuento</label>
                                            <input type="number" class="form-control" name="descuento" id="descuento">
                                            <!-- <p class="form-text text-center" id="edescuento"></p> -->

                                        </div>

                                        <div class="form-group">

                                            <label>Fecha desde</label>
                                            <input type="date" class="form-control" name="fechaDesde" id="fechaDesde">
                                            <!-- <p class="form-text text-center" id="efechaD"></p> -->

                                        </div>

                                        <div class="form-group">

                                            <label>Fecha hasta</label>
                                            <input type="date" class="form-control" name="fechaHasta" id="fechaHasta">
                                            <!-- <p class="form-text text-center" id="efechaH"></p> -->

                                        </div>

                                        <div class="form-group">

                                            <label>Descripción</label>
                                            <textarea class="form-control text-area" name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
                                            <!-- <p class="form-text text-center" id="edescripcion"></p> -->

                                        </div>

                                        <input type="submit" class="btn btn-success btn-block" value="GENERAR CUPÓN">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-ver" role="tabpanel" aria-labelledby="v-pills-ver-tab">

                        <div class="row" style="height: 75vh !important; overflow-y: scroll; justify-content: center;">

                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                <?php

                                require_once('model/base_datos_usuarios.php');

                                $cupones = new Cupones();
                                $acumulable = "";

                                $cupones_array = $cupones->ver_cupones();
                                if ($cupones_array) {
                                    $count = 0;
                                    foreach ($cupones_array as $registro) {


                                        if ($registro["acumulable"] == 1) {
                                            $acumulable = "SI";
                                        } else {
                                            $acumulable = "NO";
                                        }
                                        if ($count == 0 || $count % 3 == 0) {
                                            echo "<div class='card-group'>";
                                        }
                                        $count++;

                                        echo "<div class='card tarjeta-cupones card-cupon' style='border: 1px solid black; margin: 3px !important'>";
                                        echo "<div class='card-header p-1'>" . $registro["codigo"] . "</div>";
                                        echo " <div class='card-body'>";
                                        echo "<ul class='list-group list-group-flush'>";
                                        echo "<li class='list-group-item texto-negro p-1' style='font-size: 20px;'><span class='text-muted' style=' font-size: 16px;'>Suscripción:</span>  <label style='font-size:16px;'>" . $registro["suscripcion"] . "</label></li>";
                                        echo "<li class='list-group-item texto-negro p-1'><span class='text-muted' style=' font-size: 16px;'>Descuento:</span> <label style='font-size:16px;'>" . $registro["descuento"] . "%</label></li>";
                                        echo "<li class='list-group-item texto-negro p-1'><span class='text-muted' style=' font-size: 16px;'>Desde:</span> <label style='font-size:16px;'>" . $registro["fecha_desde"] . "</label></li>";
                                        echo "<li class='list-group-item texto-negro p-1'><span class='text-muted' style=' font-size: 16px;'>Hasta:</span> <label style='font-size:16px;'>" . $registro["fecha_hasta"] . "</label></li>";
                                        echo "<li class='list-group-item texto-negro p-1'><span class='text-muted' style=' font-size: 16px;'>Acumulable:</span> <label style='font-size:16px;'>" . $acumulable . "</label></li>";
                                        echo "</ul>";
                                        echo " </div>";
                                        echo "<div class='card-body p-0'>";
                                        echo "<ul style='float: right;'>";
                                        echo "<li style='position: absolute; margin-right: 40px;'><button class='btn btn-default' onclick='return mostrar_modal(`" . $registro["codigo"] . "`)'><i class='fas fa-pencil-alt'></i></button></li>";
                                        echo "<li style='position: relative; margin-left: 40px;'><button class='btn btn-default' onclick='return eliminar(`" . $registro["codigo"] . "`)'><i class='fas fa-trash-alt'></i></button></li>";
                                        echo "</ul>";
                                        echo "</div>";
                                        echo "</div>";
                                        if ($count % 3 == 0) {
                                            echo "</div>";
                                        }
                                    }
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>

    <!-- Modal actualizar -->

    <div class="modal" tabindex="-1" id="modalUpdate">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Cupón de descuento</h5>
                    <button type="button" id="btnCloseModal" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="card">

                        <div class="card-body">
                            <div class="card">
                                <h6 class="card-title texto-verde">INGRESAR DATOS DE CUPONES</h6>
                                <form method="post" action="controller/actualizar_cupones.php" id="formulario_update">


                                    <div class="form-group">

                                        <label>Código</label>
                                        <input type="text" class="form-control" name="codigoUpd" id="codigoUpd">
                                        <!-- <p class="form-text text-center" id="ecodigo"></p> -->

                                    </div>


                                    <div class="form-group">

                                        <label>Suscripción</label>
                                        <select class='form-control' name='suscripcionUpd' id='suscripcionUpd'>

                                            <option value='mensual'>
                                                Mensual
                                            </option>
                                            <option value='trimestral'>
                                                Trimestral
                                            </option>
                                            <option value='semestral'>
                                                Semestral
                                            </option>
                                            <option value='anual'>
                                                Anual
                                            </option>

                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label>Acumulable</label>
                                        <input type="checkbox" name="acumulableUpd" id="acumulableUpd">

                                    </div>

                                    <div class="form-group">

                                        <label>Descuento</label>
                                        <input type="number" class="form-control" name="descuentoUpd" id="descuentoUpd">
                                        <!-- <p class="form-text text-center" id="edescuento"></p> -->

                                    </div>

                                    <div class="form-group">

                                        <label>Fecha desde</label>
                                        <input type="date" class="form-control" name="fechaDesdeUpd" id="fechaDesdeUpd">
                                        <!-- <p class="form-text text-center" id="efechaD"></p> -->

                                    </div>

                                    <div class="form-group">

                                        <label>Fecha hasta</label>
                                        <input type="date" class="form-control" name="fechaHastaUpd" id="fechaHastaUpd">
                                        <!-- <p class="form-text text-center" id="efechaH"></p> -->

                                    </div>

                                    <div class="form-group">

                                        <label>Descripción</label>
                                        <textarea class="form-control text-area" name="descripcionUpd" id="descripcionUpd" cols="30" rows="10"></textarea>
                                        <!-- <p class="form-text text-center" id="edescripcion"></p> -->

                                    </div>

                                    <input type="submit" class="btn btn-success btn-block" onsubmit="editar();" value="ACTUALIZAR CUPÓN">

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- ./ Content -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="view/assets/js/cupones.js?version=1.05"></script>

</div>
<!-- ./ Content body -->