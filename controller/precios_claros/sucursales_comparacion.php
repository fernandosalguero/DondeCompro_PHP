<?php

session_start();

$_SESSION['resultadoComparacionPreciosClaros'] = $_POST['resultadoComparacionPreciosClaros'];
$_SESSION['sucursalesPreciosClaros'] = $_POST['sucursalesPreciosClaros'];
echo 1;
