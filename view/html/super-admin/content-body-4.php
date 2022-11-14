<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<script src="view/assets/js/productos-super.js?version=1.05"></script>
<!-- Content body -->
<div class="content-body">
    <!-- Content -->
    <div class="content">

        <!--Tabla de negocios-->

        <div class="row row-super-negocios">

            <div class="col-md-12">

                <h3 class="text-center">PRODUCTOS</h3>

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">

                                    <label>Buscar:</label>

                                    <input type="text" class="form-control" id="buscar" onkeyup="filtrar()" placeholder="Buscá un producto..">
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
                                    <label>Mostrar entradas:</label>
                                    <select class="form-control" id="entradas" onchange="filtrar()">
                                        <option value="5"> 5 </option>
                                        <option value="10"> 10 </option>
                                        <option value="25" selected> 25 </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Más opciones</label>
                                    <button class="btn btn-success bn-block nuevo-producto" id="nuevo-producto" onclick="mostrarModalProducto()">Agregá un producto</button>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-body">
                                    <div class='table-responsive'>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>CÓDIGO</th>
                                                    <th>NOMBRE</th>
                                                    <th>CATEGORÍA</th>
                                                    <th>ELIMINAR</th>

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

            </div>


        </div>


        <div class="modal" tabindex="-1" id="modalNuevoProducto">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark">Añadir producto</h5>
                        <button type="button" id="btnCloseModal" class="btn" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModalProducto()"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">

                            <div class="card-body">
                                <form action="controller/agregar_producto_super.php" method="POST" onsubmit="return validarAgregar()">

                                    <div class="form-group">

                                        <label class="mb-0">NOMBRE</label>
                                        <p class="texto-gris" id='pnombre'></p>
                                        <input type="text" class="form-control" name="nombre" id='nombre' onchange="consultarNombre()" required>
                                        <p class="texto-gris" id="enombre"></p>

                                    </div>

                                    <div class="form-group">

                                        <label class="mb-0">CÓDIGO</label>
                                        <p class="texto-gris" id="pcodigo"></p>
                                        <input type="text" class="form-control" name="codigo" id='codigo' onchange="consultarCodigo()" required>
                                        <p class="texto-gris" id="ecodigo"></p>


                                    </div>

                                    <div class="form-group">
                                        <label>CATEGORIA</label>
                                        <select name="categoria" id="categoria" class="form-control" required>

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
                                    <input type="submit" class="btn btn-success btn-block" value="Agregar">

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--Termina la Tabla de negocios-->

    </div>
    <!-- ./ Content -->

</div>
<!-- ./ Content body -->