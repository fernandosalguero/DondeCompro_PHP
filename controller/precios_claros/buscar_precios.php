<?php
set_time_limit(60); // un minuto de ejecucion
class BuscarPreciosClaros
{
    private $lat;
    private $lng;
    private $producto;
    private $productos;

    public function __construct($lat, $lng)
    {
        if ($lat != null && $lng != null) {
            $this->lat = $lat;
            $this->lng = $lng;
        }
    }



    // public $mainUrl = 'https://d3e6htiiul5ek9.cloudfront.net/prod';
    public $mainUrl = 'http://localhost';


    public function getSucursales()
    {

        if (isset($this->lat) && $this->lat != '' && isset($this->lng) && $this->lng != '') {

            // https://d3e6htiiul5ek9.cloudfront.net/prod/sucursales?lat=-32.8981644&lng=-68.84596909999999&limit=30&

            $url = $this->mainUrl . "/sucursales?lat=" . $this->lat . "&lng=" . $this->lng . "&limit=30&";

            echo($url);

            $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 45); // 45 segundos de timeout
            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            // echo $info["http_code"];
            // var_dump($info["http_code"]);
            if ($info["http_code"] != 200) {
                return array(
                    "sucursales" => array()
                );
            }

            $objSucursales = json_decode($result, true);

            $_SESSION['SUCURSALES'] = $objSucursales;

            return $objSucursales;
        } else {

            return array(
                "sucursales" => array()
            );
        }
    }

    public function getProductos($producto)
    {

        $offset = 0;
        $limit = 100;
        $productosTotal = array();
        $agentes = array(
            /*'chrome' =>  */
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36',
            /*'firefox' => */ 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:85.0) Gecko/20100101 Firefox/85',
            /*'edge' =>    */ 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Edg/88.0.705.68',
            /*'safari' =>  */ 'Mozilla/5.0 (Macintosh; Intel Mac OS X 11_2_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.2 Safari/605.1.15',
            /*'opera' =>   */ 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 OPR/74.0.3911.107',
            /*'vivaldi' => */ 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Vivaldi/3.6',
            /*'yandex' =>  */ 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 YaBrowser/21.2.0 Yowser/2.5 Safari/537.36'
        );


        $sucursales = $this->getSucursales();
        $idSucursales = "";
        $sucursales = $sucursales['sucursales'];



        // var_dump($sucursales);

        if (count($sucursales) < 1) {

            return null;
        }

        for ($i = 0; $i < count($sucursales); $i++) {

            $idSucursales =  $idSucursales . $sucursales[$i]['id'] . ($i < count($sucursales) - 1 ? "," : "");
        }


        $productoUrlEncode = '';

        for ($i = 0; $i < strlen($producto); $i++) {
            $charActual = $producto[$i];
            // var_dump($charActual);
            if ($charActual  == ' ') {
                $charActual = '%20';
            }
            $productoUrlEncode = $productoUrlEncode . $charActual;
        }

        // var_dump($productoUrlEncode);


        $url = $this->mainUrl . "/productos?string=" . $productoUrlEncode . "&array_sucursales=" . $idSucursales . "&offset=" . $offset . "&limit=" . $limit . "&sort=-cant_sucursales_disponible";

        // var_dump($url);

        // $randomIdx = random_int(0, 5);
        // $agent = $agentes[$randomIdx];

        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);

        $productos = json_decode($result, true);

        $productosTotal = $productos['productos'];

        $total = $productos['total'];
        $iteraciones = ceil($total / $limit);
        for ($i = 0; $i < $iteraciones; $i++) {
            $offset += $limit;
            $url = $this->mainUrl . "/productos?string=" . $productoUrlEncode . "&array_sucursales=" . $idSucursales . "&offset=" . $offset . "&limit=" . $limit . "&sort=-cant_sucursales_disponible";

            $randomIdx = random_int(0, 5);
            // $agent = $agentes[$randomIdx];
            $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);

            $productos = json_decode($result, true);
            $productosArr = $productos['productos'];
            for ($i = 0; $i < count($productosArr); $i++) {
                $productosTotal[] = $productosArr[$i];
            }
        }
        return $productosTotal;
    }

    // pide la comparacion de precios entre sucursales de precios claros
    public static function getProductoComparacion($codigo)
    {


        $agentes = array(
            /*'chrome' =>  */
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36',
            /*'firefox' => */ 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:85.0) Gecko/20100101 Firefox/85',
            /*'edge' =>    */ 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Edg/88.0.705.68',
            /*'safari' =>  */ 'Mozilla/5.0 (Macintosh; Intel Mac OS X 11_2_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.2 Safari/605.1.15',
            /*'opera' =>   */ 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 OPR/74.0.3911.107',
            /*'vivaldi' => */ 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Vivaldi/3.6',
            /*'yandex' =>  */ 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 YaBrowser/21.2.0 Yowser/2.5 Safari/537.36'
        );


        $sucursales = $_SESSION['SUCURSALES'];

        // var_dump($sucursales);
        $idSucursales = "";
        $sucursales = $sucursales['sucursales'];

        for ($i = 0; $i < count($sucursales); $i++) {

            $idSucursales =  $idSucursales . $sucursales[$i]['id'] . ($i < count($sucursales) - 1 ? "," : "");
        }

        $url =  "https://d3e6htiiul5ek9.cloudfront.net/prod/producto?limit=30&id_producto=" . $codigo . "&array_sucursales=" . $idSucursales;
        //$url =  "http://localhost/producto?limit=30&id_producto=" . $codigo . "&array_sucursales=" . $idSucursales;

        // var_dump($url);

        // $randomIdx = random_int(0, 5);
        // $agent = $agentes[$randomIdx];

        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        $producto = null;

        $producto = json_decode($result, true);
        if (!isset($producto)) {
            $producto = array(
                'producto' => array(),
                'sucursales' => array()
            );
        }

        // var_dump($producto);


        $productoTotal = array('producto' => $producto['producto'], 'sucursales' =>  $producto['sucursales']);

        return $productoTotal;
    }
}
