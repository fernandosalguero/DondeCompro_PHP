<?php

require_once("../model/base_datos_usuarios.php");
require_once("../model/base_datos_productos.php");
require_once("../controller/precios_claros/buscar_precios.php");

session_start();


class ComparadorPrecios
{
    private $usuario;
    private $sucursalesInfo = array();
    private $negocios_p;
    private  $provincia = null;
    private $municipio = '';

    function __construct()
    {
        $this->usuario = new consultarUsuario();
        // $this->ID = $this->usuario->registro["ID"];
        // $this->info = new DatosInfoNegocio();
        $this->negocios_p = new ComparadorProductos();
        $this->negocios  = new Comparador();
    }


    function cImagen($a)
    {

        if ($a == null) {

            return "view/assets/media/image/user/default.png";
        } else {

            return $a;
        }
    }

    function comparar()
    {
        $metricasResult = $this->setMetricas();
        if ($metricasResult['status'] != 'success') {

            return $metricasResult['errMetricasMessage'];
        }

        $arrSucursalesDondeCompro = $this->getPreciosSucursalesDondeCompro();
        $arrSucursalesPreciosClaros = $this->getPreciosSucursalesPreciosClaros();

        $totales = array_merge($arrSucursalesDondeCompro['totales'], $arrSucursalesPreciosClaros['totales']);
        $preciosSucursalesTotalOrdenados = array_merge($arrSucursalesDondeCompro['ordenados'], $arrSucursalesPreciosClaros['ordenados']);

        $htmlCards =  $this->renderCards($totales, $preciosSucursalesTotalOrdenados);
        $_SESSION['CARDS_COMPARADOR'] = $htmlCards;
        echo (json_encode($htmlCards)); // retorna las cards creadas en la comparacion
    }

    function setMetricas()
    {
        $this->usuario->consultar($_SESSION["nombre"]);
        $registro_usuario = $this->usuario->registro;

        if ($registro_usuario["provincia"] != null) {

            $this->provincia = $this->usuario->registro["provincia"];
            $this->Amunicipio = $this->usuario->registro["municipio"];
            $this->localidad = $this->usuario->registro["localidad"];

            $metrica = new Metricas();
            $metrica->incrementarContador($this->provincia);

            return array('status' => 'success');
        } else {
            $errMetricasMessage = "
    
                <p> Debes establecer tu ubicación para poder utilizarel comparador, esto 
                lo puedes hacer desde la sección ADMINISTRAR CUENTA";

            return array('status' => 'error',  'errMetricasMessage' => $errMetricasMessage);
        }
    }

    // funcion que ordena por cantidad de coincidencias con la busqueda de 1..n productos y por el precio de producto y total
    function ordenarSucursalesPorProductosPrecios($arrSucursalesPrecios)
    {
        $totales = array();
        $mayorCantidadSinCero = 0;
        $agrupados = array();
        $productosBusqueda = count($_SESSION["listado_productos"]);


        foreach ($arrSucursalesPrecios as $negocio => $precio) {

            $auxMayorCantidadSinCero = 0;

            for ($i = 0; $i < $productosBusqueda; $i++) {
                if ((float)$precio[$i] > 0.00) {
                    $auxMayorCantidadSinCero++;
                }
            }
            if ($auxMayorCantidadSinCero > $mayorCantidadSinCero) {
                $mayorCantidadSinCero = $auxMayorCantidadSinCero;
            }
        }
        // guardo los menores y mayores precios de cada grupo
        $menoresPreciosGrupos = array();
        $mayoresPreciosGrupos = array();


        for ($i = $mayorCantidadSinCero; $i > 0; $i--) {

            $auxMenorPrecioGrupo = 0;
            $auxMayorPrecioGrupo = 0;


            foreach ($arrSucursalesPrecios as $negocio => $precio) {

                $auxProductosSinCero = 0;


                for ($j = 0; $j < $productosBusqueda; $j++) {
                    if ((float)$precio[$j] > 0.00) {
                        $auxProductosSinCero++;
                    }
                }
                if ($auxProductosSinCero == $i) {
                    $indiceGrupoActual = $mayorCantidadSinCero - $i;
                    $agrupados[$indiceGrupoActual][] = array($negocio => $arrSucursalesPrecios[$negocio]);
                    // obtengo el menor precio para cada grupo
                    if (end($precio) > 0 && $auxMenorPrecioGrupo < 1) {
                        $auxMenorPrecioGrupo = end($precio);
                    } else if (end($precio) > 0 && $auxMenorPrecioGrupo > 0 && end($precio) < $auxMenorPrecioGrupo) {
                        $auxMenorPrecioGrupo = end($precio);
                    }

                    // obtengo el mayor precio para cada grupo
                    if (end($precio) > 0 && $auxMayorPrecioGrupo < 1) {
                        $auxMayorPrecioGrupo = end($precio);
                    } else if (end($precio) > 0 && $auxMayorPrecioGrupo > 0 && end($precio) > $auxMayorPrecioGrupo) {
                        $auxMayorPrecioGrupo = end($precio);
                    }
                }
            }
            $menoresPreciosGrupos[] = $auxMenorPrecioGrupo;
            $mayoresPreciosGrupos[] = $auxMayorPrecioGrupo;
        }

        $ordenados = array();
        $indiceActualGrupoMenorPrecio = 0;

        foreach ($agrupados as $grupo) {

            for ($i = ceil($menoresPreciosGrupos[$indiceActualGrupoMenorPrecio]); $i <= ceil($mayoresPreciosGrupos[$indiceActualGrupoMenorPrecio]); $i++) {

                foreach ($grupo as $agrup) {

                    foreach ($agrup as $negocioNombre => $preciosNegocio) { //una sola iteracion, es un array asociativo de un negocio => array de precios

                        if (ceil(end($preciosNegocio)) == $i) {

                            $ordenados[$negocioNombre] = $preciosNegocio;
                            $totales[] = end($preciosNegocio);
                        }
                    }
                }
            }
            $indiceActualGrupoMenorPrecio++;
        }


        return array('totales' => $totales, 'ordenados' => $ordenados);
    }

    // realiza la busqueda por donde compro
    function getPreciosSucursalesDondeCompro()
    {
        $aux_suma = 0;
        $precios = array();

        $preciosUbicacion = null;

        if ($this->municipio != null) {

            $preciosUbicacion = $this->negocios->extraerNegociosProvinciaMunicipio($this->provincia, $this->municipio);
        } else {

            $preciosUbicacion = $this->negocios->extraerNegociosProvincia($this->provincia);
        }

        foreach ($preciosUbicacion as $negocio) {

            $nombre_tabla = "productos_" . $negocio["ID"];

            foreach ($_SESSION["listado_codigo"] as $codProducto) {

                $precio = $this->negocios_p->ExtraerPrecios($nombre_tabla, $codProducto);

                // var_dump($precio);
                if (!isset($precio["Precio"]))
                    $precios[$negocio["nombre"]][] = "0";
                else
                    $precios[$negocio["nombre"]][] = $precio["Precio"];
            }

            foreach ($precios[$negocio["nombre"]] as $valor) {
                $aux_suma += (float) $valor;
            }

            // $totales[] = $aux_suma;
            $precios[$negocio["nombre"]][] = $aux_suma; // coloca el total al final del array precios por key de negocio
            $aux_suma = 0;
        }

        $preciosSucursalesDondeComproOrdenados = $this->ordenarSucursalesPorProductosPrecios($precios);

        return $preciosSucursalesDondeComproOrdenados;
    }

    // realiza la busqueda por precios claros
    function getPreciosSucursalesPreciosClaros()
    {

        // $preciosClaros = new BuscarPreciosClaros(null, null);

        // $comparacionProductosPreciosClaros = array();
         $sucursalesProductosPreciosClarosNormalizados = array();

        // // var_dump($_SESSION["listado_codigo"]);

        // foreach ($_SESSION["listado_codigo"] as $productoCodigo) {
        //     $comparacionProductosPreciosClaros[] = $preciosClaros->getProductoComparacion($productoCodigo);
        // }
        $comparacionProductosPreciosClaros = json_decode($_SESSION['resultadoComparacionPreciosClaros'], true);

        //  var_dump($comparacionProductosPreciosClaros);

        // $precios = array_merge($precios, $sucursalesProductosPreciosClarosNormalizados);

        $sucursalesMetadata =  json_decode($_SESSION['sucursalesPreciosClaros'], true);
        //  var_dump($sucursalesMetadata);

        // Normalizacion de array para obtener cards
        foreach ($comparacionProductosPreciosClaros as $productoComparacion) {

            // var_dump($productoComparacion);

            $idxSucursal = 0;

            foreach ($productoComparacion['sucursales'] as $sucursal) {

                if (isset($sucursal['message']) && $sucursal['message'] == "La sucursal no contiene el producto.") {
                    // continue;
                    if (isset($sucursalesProductosPreciosClarosNormalizados[$idxSucursal])) {
                        //  echo('is set : ' . $idxSucursal);
                        // $infoSucursal = $sucursalesMetadata[$idxSucursal];
                        // var_dump($sucursal);
                        $idSucursal = '' . $sucursal['comercioId'] . '-' . $sucursal['banderaId'] . '-' . $sucursal['id'];
                        $nombreSucursalProductoFaltante = '';
                        foreach ($sucursalesMetadata as $sucursalMetadata) {
                            if ($sucursalMetadata['id'] == $idSucursal) {
                                $nombreSucursalProductoFaltante = $sucursalMetadata['sucursalNombre']  . " · " .  $sucursalMetadata['banderaDescripcion'];
                            }
                        }
                        // var_dump($nombreSucursalProductoFaltante);
                        $sucursalesProductosPreciosClarosNormalizados[$nombreSucursalProductoFaltante][] = "0";
                    } else {
                        //  echo('is not set : ' . $idxSucursal);
                        $idSucursal = '' . $sucursal['comercioId'] . '-' . $sucursal['banderaId'] . '-' . $sucursal['id'];
                        $nombreSucursalProductoFaltante = '';
                        foreach ($sucursalesMetadata as $sucursalMetadata) {
                            if ($sucursalMetadata['id'] == $idSucursal) {
                                $nombreSucursalProductoFaltante = $sucursalMetadata['sucursalNombre']  . " · " .  $sucursalMetadata['banderaDescripcion'];
                            }
                        }
                        // var_dump($nombreSucursalProductoFaltante);
                        $sucursalesProductosPreciosClarosNormalizados[$nombreSucursalProductoFaltante][] = "0";
                    }
                } else {

                    if (!isset($this->sucursalesInfo[$sucursal['sucursalNombre'] . " · " . $sucursal['banderaDescripcion']])) {
                        $this->sucursalesInfo[$sucursal['sucursalNombre'] . " · " . $sucursal['banderaDescripcion']] = array(
                            'direccion' => $sucursal['direccion'],
                            'url' => "https://imagenes.preciosclaros.gob.ar/comercios/" . $sucursal['comercioId'] . "-" . $sucursal['banderaId'] . ".jpg"
                        );
                    }

                    if (isset($sucursalesProductosPreciosClarosNormalizados[$sucursal['sucursalNombre'] . " · " . $sucursal['banderaDescripcion']])) {
                        $sucursalesProductosPreciosClarosNormalizados[$sucursal['sucursalNombre']  . " · " .  $sucursal['banderaDescripcion']][] = (string) $sucursal['preciosProducto']['precioLista'];
                    } else {
                        $sucursalesProductosPreciosClarosNormalizados[$sucursal['sucursalNombre']  . " · " .  $sucursal['banderaDescripcion']] = array();
                        $sucursalesProductosPreciosClarosNormalizados[$sucursal['sucursalNombre']  . " · " .  $sucursal['banderaDescripcion']][] = (string)$sucursal['preciosProducto']['precioLista'];
                    }
                }
                $idxSucursal++;
            }
        }
        // var_dump($sucursalesProductosPreciosClarosNormalizados);

        foreach ($sucursalesProductosPreciosClarosNormalizados as $sucursal => $preciosNormalizados) {
            $total = 0;
            foreach ($preciosNormalizados as $precioNormalizado) {
                $total += $precioNormalizado;
            }
            $sucursalesProductosPreciosClarosNormalizados[$sucursal][] = $total;
        }



        $preciosSucursalesPreciosClarosOrdenados = $this->ordenarSucursalesPorProductosPrecios($sucursalesProductosPreciosClarosNormalizados);

        return $preciosSucursalesPreciosClarosOrdenados;
    }

    // realiza el render para devolverlo al js que lo inserta en el html
    function renderCards($totales, $precios)
    {
        // echo (count($precios));
        $cards = '';
        $cardsArrayElements = array();
        $aux_nombre = array();

        foreach ($totales as $mejor_precio) {

            $aux_activa = false;

            foreach ($precios as $nombre => $precio) {

                if ($mejor_precio === end($precio)) { //end($precio) es el total de la suma de los precios por negocio

                    foreach ($aux_nombre as $a_nombre) {  // busca entre los nombres de negocios anteriormente agregados

                        if ($a_nombre == $nombre) { // si el nombre del negocio ya esta mostrado lo ignora y rompe el loop

                            $aux_activa = true;
                            break;
                        }
                    }

                    if ($aux_activa) {
                        break;
                    }

                    $cargaPrecioClaro = false;
                    // var_dump($nombre);

                    foreach ($this->sucursalesInfo as $nombreSuc => $sucursalInfo) {
                        if ($nombre == $nombreSuc) {
                            $cargaPrecioClaro = true;
                        }
                    }

                    $auxDireccion = "";
                    $auxTEMC = "";
                    $aux2 = "";
                    $aux4 = "";
                    $aux5 = "";


                    if ($cargaPrecioClaro) {


                        if ($this->sucursalesInfo[$nombre]["direccion"] != null) {

                            $auxDireccion .= "
        
                                <p style='color:black; font-size: 12px !important;'><span style='margin-right:5px;'><i class='fa fa-street-view'></i></span>" . $this->sucursalesInfo[$nombre]["direccion"] . "</p>
        
                            ";
                        }
                    } else {


                        $usuario = new consultarUsuario();
                        $usuario->consultar($nombre);
                        $ID = $usuario->registro["ID"];
                        $info = new DatosInfoNegocio();


                        if ($info->consultarNegocio($ID)) {


                            if ($info->registro["direccion"] != null) {

                                $auxDireccion .= "
                                
                                <p style='color:black; font-size: 12px !important;'><span style='margin-right:5px !important;'><i class='fa fa-street-view'></i></span>" . $info->registro["direccion"]  . "</p>
                            ";
                            }

                            if ($info->registro["n_telefono"] != null) {

                                $auxTEMC .= "
                                <div style='margin-top:20px;'>
                                <p style='color:black; font-size: 12px !important;'><span style='margin-right:5px !important;'><i class='fas fa-phone-alt'></i></span>" . $info->registro["n_telefono"] . "</p>
                                </div>
                            ";
                            }



                            $auxTEMC .= "
                            <div style='margin-top:20px;'>
                            <p class='px-3' style='color:black; font-size: 12px !important;'><span style='margin-right:5px !important;'><i class='fa fa-money'></i></span> " . ucfirst($info->registro["metodo_cobro"]) . "</p>
                            </div>
                            ";

                            if ($info->registro["envios"] != "no") {

                                $auxTEMC .=  "
                                <div style='margin-top:20px;'>
                                <p class='px-3' style='color:black; font-size: 12px !important;'><span style='margin-right:5px !important;'><i class='fa fa-check'></i></span>Envíos</p>
                                </div>
                                ";
                            }
                        } else {
                            echo "

                            <h5 class = 'texto-verde'>ESTA ES TODA LA INFORMACIÓN DISPONIBLE DEL NEGOCIO</h5>

                        ";
                        }
                    }

                    if ($cargaPrecioClaro) {
                        $aux2 = "
                        <small style='float: left !important; margin-top:15px !important; margin-left:15px !important;'><img src='view/assets/media/image/unnamed.jpg' width = '80'></small>
                        <div class='accordion accordion-flush' id='accordionFlushExample1' style='margin-top:35px;'>
                            <div class='accordion-item'>
                                <h2 class='accordion-header' id='flush-headingOne1'>
                                    <button class='accordion-button collapsed btn btn-sm btn-info' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseOne1' aria-expanded='false' aria-controls='flush-collapseOne1' style='margin-bottom:10px; float: right !important;'>
                                        Más Info
                                    </button>
                                </h2>
                                <div id='flush-collapseOne1' class='accordion-collapse collapse' aria-labelledby='flush-headingOne1' data-bs-parent='#accordionFlushExample1'>
                                    <div class='accordion-body' style='border: white solid 1px;'>$auxTEMC</div>
                                </div>
                            </div>
                        </div>             
                        <div style='margin-top: 60px; margin-bottom:10px;'>
                        <img src='" . $this->sucursalesInfo[$nombre]["url"] . "' width = '100'' style='position: absolute; left: 0; right: 0; margin-left: auto; margin-right: auto;'>
                        </div>
                        <div class='px-3' style='margin-top:20px;'>
                        <span>" . $nombre . "</span>
                        </div>
                        <div class='px-3' style='margin-top:20px; max-width: 40% !important'>
                                " . $auxDireccion . "
                        </div>
                        ";
                    } else {
                        $aux2 = "
                        <small style='float: left !important; margin-top:15px !important; margin-left:15px !important;'><img src='view/assets/media/image/logo-2.png' width = '40'></small>
                        <div class='accordion accordion-flush' id='accordionFlushExample' style='margin-top:35px;'>
                            <div class='accordion-item'>
                                <h2 class='accordion-header' id='flush-headingOne'>
                                    <button class='accordion-button collapsed btn btn-sm btn-info' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseOne' aria-expanded='false' aria-controls='flush-collapseOne' style='margin-bottom:10px; float: right !important;'>
                                        Más Info
                                    </button>
                                </h2>
                                <div id='flush-collapseOne' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample' style=''>
                                    <div class='accordion-body' style='border: white solid 1px;'>$auxTEMC</div>
                                </div>
                            </div>
                        </div>                    
                        <div style='margin-top: 80px; margin-bottom:10px;'>
                        <img src='" . $this->cImagen($usuario->registro["imagen"]) . "' width = '100' style='position: absolute; left: 0; right: 0; margin-left: auto; margin-right: auto;'>
                        </div>
                         <div class='px-3' style='margin-top:30px;'>
                        <span>" . $usuario->registro["nombre"] . "</span>
                        </div>
                         <div class='px-3' style='margin-top:20px; max-width: 40% !important'>
                            " . $auxDireccion . "
                        </div>
                        ";
                    }


                    $aux_for2 = 0;
                    $indiceProducto = 1;
                    // ACA CARGA LOS PRODUCTOS CON LOS PRECIOS
                    foreach ($_SESSION["listado_productos"] as $listado) {

                        if ((float)$precio[$aux_for2] != 0.00) {
                            $aux5 .= "

                            <ul class='list-group' style='margin-top: 10px;'>
                            <li class='list-group-item d-flex justify-content-between' style='color:black;'>
                            $listado
                              <span class='badge bg-default rounded-pill'> $ " . $precio[$aux_for2] . "</span>
                            </li>
    
                          </ul>
                        ";
                            $indiceProducto++;
                        }
                        $aux_for2++;
                    }

                    // CARGA EL TOTAL DE TODO 
                    $aux5 .= "
                    <ul class='list-group'>
                    <li class='list-group-item d-flex justify-content-between' style='color:black;'>
                    TOTAL
                      <span class='badge bg-secondary rounded-pill'> $ " . end($precio) . "</span>
                    </li>

                  </ul>
                    
                   
                    ";

                    $cardClass = 'card-comparador-dc';
                    if ($cargaPrecioClaro)
                        $cardClass = 'card-comparador-pc';

                    $aux4 = "
                   
                    <div class='card d-flex flex-column tarjeta-resultado-producto contenedor_tarjeta $cardClass' style='position:relative;'>

                    <div>
                        " . $aux2 . "
                    </div>
                
                    <div class='card-body' style='padding:0px !important;'>
                
                        <div>
                            " . $aux5 . "
                        </div>
                
                
                    </div>
                
                </div>
                </div>
                        
                    
                    ";
                    $aux5 = "";

                    // echo $aux4;

                    $cards = $cards . $aux4;

                    $cardsArrayElements[] = $aux4;

                    $aux_nombre[] = $nombre;
                }
            }
        }

        // return $cards;
        // echo($cardsArrayElements);
        return $cardsArrayElements;
    }
}


$comparador = new ComparadorPrecios();
$comparador->comparar();
