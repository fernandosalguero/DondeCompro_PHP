<?php
if (isset($_POST['ip-address'])) {
    $url = "https://www.cualesmiip.com/localizar-ip";

    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

    $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
        'Origin: https://www.cualesmiip.com',
        'Referer: https://www.cualesmiip.com/localizar-ip'
    );

    $ip = $_POST['ip-address'];
    // $ip = '181.9.136.149';


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'ip-address=' . $ip);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    try {
        $dom = new DOMDocument();

        @$dom->loadHTML($result);
        $xpath = new DOMXpath($dom);

        $tables = $xpath->query("//table[contains(@class,'tabla-politicas')]");
        $count = $tables->length;

        $value = '';

        foreach ($tables as $tnode) {
            $value = $tnode->textContent;
        }

        $value = str_replace(' ', '', $value);
        $value = str_replace("\n", '', $value);

        $strs = explode(' ', $value);

        // var_dump($value);

        // var_dump($strs);

        $latIdx = stripos($value, 'Latitud');
        $lat = substr($value, $latIdx + 7, 8);
        $lonIdx = stripos($value, 'Longitud');
        $lon = substr($value, $lonIdx + 8, 8);

        $latlon = array('latitud' => $lat, 'longitud' => $lon);
        // var_dump($latlon);

        echo json_encode($latlon);
        exit;
    } catch (Exception $e) {
    }
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        fetch("https://jsonip.com")
            .then((val) => val.json())
            .then((json) => {
                console.log(json)
                const data = new URLSearchParams();
                data.append('ip-address', json.ip);

                fetch('https://web.dondecompro.ar/controller/geolocalization/localization.php', {
                // fetch('http://localhost/geolocalization/localization.php', {

                        method: 'POST', // *GET, POST, PUT, DELETE, etc.
                        mode: 'no-cors', // no-cors, *cors, same-origin
                        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                        credentials: 'omit', // include, *same-origin, omit
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: data
                    })
                    .then((val) => val.json())
                    .then((val) => {
                        console.log(val)
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            })
            .catch((err) => console.log(err));


    });
</script>