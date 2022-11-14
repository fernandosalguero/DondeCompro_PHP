<?php 

require("../model/base_datos_usuarios.php");

$metrica = new Metricas();
$metrica->consultarComparaciones();

foreach($metrica->registro as $registro){

    echo "<hr style='border: #DADEE1 1px solid'>";
    echo "<p class = 'mb-0'><strong class = 'texto-verde'>PROVINCIA: </strong>".$registro["provincia"]."</p>";
    echo "<p class = 'mb-0'><strong class = 'texto-verde'>NÚMERO DE COMPARACIONES: </strong>".$registro["total_comparaciones"]."</p>";

}






?>