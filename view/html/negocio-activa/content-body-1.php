<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="view/assets/js/productos.js?version=1.05"></script>
<script src="view/assets/js/agregar-producto.js?version=1.05"></script>
<!-- Content body -->
<div class="content-body">
    <!-- Content -->

    <div class="content ">

        <div class="page-header">
            <div>
                <h3 class="text-center">MI CATÁLOGO</h3>
                <h5 class="text-center text-dark">Buscá, añadí y poné precio a tus productos</h5>

            </div>
        </div>

        <!-- menu collapse acordion agregar productos  -->
        <div class="accordion" id="accordionExample" style="padding-right: 50px !important;">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Añadir producto nuevo a nuestro catálogo
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <form action="controller/agregar_producto.php" method="POST" onsubmit="return validarAgregar()">

                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-success" id="basic-addon1" style="color:white;border-top-left-radius: 50px !important;
                                                border-bottom-left-radius: 50px !important;">Nombre</span>
                                        <p class="texto-gris" id='pnombre'></p>
                                        <input type="text" class="form-control" name="nombre" id='nombre' onchange="consultarNombre()" required style="border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;">
                                        <p class="texto-gris" id="enombre"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-success" id="basic-addon1" style="color:white;border-top-left-radius: 50px !important;border-bottom-left-radius: 50px !important;">Código</span>
                                        <p class="texto-gris" id="pcodigo"></p>
                                        <input type="text" class="form-control" name="codigo" id='codigo' onchange="consultarCodigo()" required style="border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;">
                                        <p class="texto-gris" id="ecodigo"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-success" id="basic-addon1" style="color:white;border-top-left-radius: 50px !important;border-bottom-left-radius: 50px !important;">Categoría</span>
                                        <select name="categoria" id="categoria" class="form-control" required style="border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;">

                                            <option value="Almacén">Almacén</option>
                                            <option value="Bebes y niños">Bebes y niños</option>
                                            <option value="Bebidas">Bebidas</option>
                                            <option value="Carnes">Carnes</option>
                                            <option value="Electricidad">Electricidad</option>
                                            <option value="Ferretería">Ferretería</option>
                                            <option value="Herramientas eléctricas">Herramientas eléctricas</option>
                                            <option value="Herramientas manuales">Herramientas manuales</option>
                                            <option value="Plomería">Plomería</option>
                                            <option value="Congelados">Congelados</option>
                                            <option value="Frutas y verduras">Frutas y verduras</option>
                                            <option value="Lácteo">Lácteos</option>
                                            <option value="Librería">Librería</option>
                                            <option value="Limpieza">Limpieza</option>
                                            <option value="Mascotas">Mascotas</option>
                                            <option value="Perfumería">Perfumería</option>

                                        </select>
                                    </div>
                                </div>
                               
                            </div>

                            <button class="btn btn-info" style="float: right; margin-right:70px;"> AÑADIR </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Tabla de negocios-->
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">

                            <label>BUSCAR:</label>

                            <input type="text" class="form-control" id="buscar" onkeyup="filtrar()" placeholder="Buscá productos...">
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">

                            <label>Filtrar por categoría:</label>
                            <select class="form-control" id="rubro" onchange="filtrar()">
                                <option value="TODOS" selected>TODOS</option>
                                <?php

                                include_once('model/base_datos_productos.php');
                                include_once('model/base_datos_usuarios.php');


                                $nombre = $_SESSION["nombre"];
                                $consultar = new consultarUsuario();
                                $registro = $consultar->datos($nombre);
                                $id = $registro["ID"];
                                $nombre_db = "productos_" . $id;

                                if ($id == 1) {
                                    $nombre_db = "productos_base";
                                }

                                $productosObj = new Productos($nombre_db);
                                $rubros = $productosObj->obtenerRubros($nombre_db);

                                foreach ($rubros as $rubro) {
                                    echo ("<option value='" . $rubro . "'>" . $rubro . "</option>");
                                }


                                ?>

                            </select>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>MOSTRAR ENTRADAS:</label>
                            <select class="form-control" id="entradas" onchange="filtrar()">
                                <option value="5" selected> 5 </option>
                                <option value="10"> 10 </option>
                                <option value="25"> 25 </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <form action="controller/aumentar_porcentaje.php" method="POST" onsubmit="return validarPorcentaje()" style="margin:0 !important;">
                                <label>Aumentar por %</label>
                                <div class="input-group" style="margin:0 !important;">
                                    <input type="number" class="form-control" name="porcentaje" id="porcentaje" aria-describedby="button-addon2" style="border-right: none;
                                    border-top-right-radius: 0px !important;
                                    border-bottom-right-radius: 0px !important;">
                                    <button class="btn btn-success btn-block" id="button-addon2" style="width:50px;border-top-left-radius: 0px !important;
                                    border-bottom-left-radius: 0px !important;">
                                        <i class="fas fa-check" style="color:white !important;"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-scroll" style="height: 100%;">
                            <div class='table-responsive'>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>CÓDIGO</th>
                                            <th>NOMBRE</th>
                                            <th>CATEGORÍA</th>
                                            <th>PRECIO</th>

                                        </tr>
                                    </thead>

                                    <tbody id='productos'>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--Termina la Tabla de negocios-->

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