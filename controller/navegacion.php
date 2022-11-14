<?php
//------------------------------//
/*En este archivo están las funciones que cargan el contenido de la página
a función del usuario que haya iniciado sesión o haya guardado cookies*/
require_once("cargar.php");
//-------------------------//

/*En este archivo están las función que evalúa las sessiones que se han iniciado
o las cookies que se han guardado*/
require_once("cookies_sesiones.php");
//-----------------------------------//

//---inicia una sessión---//
session_start();
//------------------------//

/*La variablle $nav determina el tipo de usuario que navegara por el sitio
y establece el contenido que se va a visualizar en la página
(mediante el archivo cargar.php que es donde están las funciones pertinentes)
el valor de la variable se obtiene evaluando si se ha iniciado sessión o se 
han guardado cookies
el valor 0 carga el contenido por defecto.
el valor 1 carga la pantalla del Super Admin.
el valor 2 carga la pantalla del usuario común.
el valor 3 carga el contenido de la cuenta negocio activa.
el valor 4 carga el contenido la cuenta de negocio inactiva.
*/

/* Este bloque evalua si hay iniciada una sesión y si es así
estableces que $nav es igual a lo que devuelve la función session()
para cargar el contenido perteneciente al usuario que inició la sesión
del archivo cookies_sesiones.php y si no hay una sesión iniciada
evalua si hay cookies guardas y si es así, establece que $nav es igual a lo que
devuelve la función cookies() y carga el contenido pertinente.
Si no hay ni una sesión iniciada ni cookies guardadas, se establece que $nav es 
igual a 0 y carga el contenido por defecto. */

if(isset($_SESSION["nombre"]) and isset($_SESSION["correo"])){

    $nav = session();

}elseif(isset($_COOKIE["nombre"])){

    $nav = cookies();

}else{

    $nav = 0;

}

if($nav == 3){

    require_once("model/base_datos_usuarios.php");

    $nombre = $_SESSION["nombre"];

    $consultar = new consultarUsuario();

    if(!$consultar->consultarEstado($nombre)){

        $nav = 4;

    }

}


//------------------------------------//


/*Una vez se ha cargado el contenido del usuario que ha iniciado sesión
la variable $page es la encargada de navegar hacia las diferentes funcionalidades o
contenido de la plataforma, cuando su valor es 0 la página es la de inicio, 
cuando su valor es 1, la página es el panel de administración, cuando su valor 
es 2 la página es el panel de administración de la cuenta.
Lo hice así para dejar abierta la posibilidad de agregar más funcionalidades de manera más sencilla.a-0
Nótese que la variable utiliza el método GET para así pasar su valor mediante los botones de
navegación de la página, si por error ponen en la url un valor mayor a 3,
se vuelve a reestablecer a 0
*/
//-------------------------//
if(!isset($_GET["page"])){

    $page = 0;
     
 }else{
 
     $page = $_GET["page"];


 }

 if($nav < 3 && $page >= 3 && $nav != 1){
    
    $page = 0;

 }

 if($nav >= 3 && $page >= 4){

    $page = 0;

 }

 

 if($nav == 0 and $page > 0){

    $page = 0;

 }

 if($nav == 3 || $nav == 4){

    /*Este archivo se cargará cuando un usuario comercio haya iniciado sesión */
    require_once("funciones_negocio.php");
    
    guardarProductos();
    darBajaSubscripcion();

 }
 
 
 //------------------------//
