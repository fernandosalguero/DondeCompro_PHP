<?php

//------------------------------------------archivos del super admin----------------------------------------//
$pag_sp = ["header" => "view/html/super-admin/header.html", "navigation" => "view/html/super-admin/navigation.html"];
$pag_sp_content = [
    "content0" => "view/html/super-admin/content-body-0.html",
    "content1" => "view/html/super-admin/content-body-1.html",
    "content2" => "view/html/super-admin/content-body-2.html",
    "content3" => "view/html/super-admin/content-body-3.html",
    "content4" => "view/html/super-admin/content-body-4.php",
    "content5" => "view/html/super-admin/content-body-5.php"
];
//------------------------------------------------------------------------------------------------------------//

//------------------------------------------archivos por defecto-------------------------------------//
$pag_df = ["header" => "view/html/default/header.html", "navigation" => "view/html/default/navigation.html",];
$pag_df_content = ["content0" => "view/html/default/content-body-0.html"];
//-----------------------------------------------------------------------------------------------------//

//--------------------------------------archivos del usuario común----------------------------------//
$pag_u = ["header" => "view/html/usuario/header.html", "navigation" => "view/html/usuario/navigation.html",];
$pag_u_content = [
    "content0" => "view/html/usuario/content-body-0.html",
    "content1" => "view/html/usuario/content-body-1.html",
    "content2" => "view/html/usuario/content-body-2.html"
];
//----------------------------------------------------------------------------------------------------//

//---------------------------------------archivos del usuario-negocio-----------------------------------------------------------------//
$pag_activa = ["header" => "view/html/negocio-activa/header.html", "navigation" => "view/html/negocio-activa/navigation.html"];
$pag_activa_content = [
    "content0" => "view/html/negocio-activa/content-body-0.html",
    "content1" => "view/html/negocio-activa/content-body-1.php",
    "content2" => "view/html/negocio-activa/content-body-2.html", "content3" => "view/html/negocio-activa/content-body-3.html"
];


$pag_inactiva = ["header" => "view/html/negocio-inactiva/header.html", "navigation" => "view/html/negocio-inactiva/navigation.html"];
$pag_inactiva_content = [
    "content0" => "view/html/negocio-inactiva/content-body-0.php",
    "content1" => "view/html/negocio-inactiva/content-body-1.php",
    "content2" => "view/html/negocio-inactiva/content-body-2.html", "content3" => "view/html/negocio-inactiva/content-body-3.html"
];
//-------------------------------------------------------------------------------------------------------------------------------------//

/*Las siguientes funciones incluyen los diversos archivos html
  que contienen el header, el navigation y el contenido
  */

//----Carga el header----//
function CargarHeader()
{
    global $nav, $pag_sp, $pag_df, $pag_u, $pag_activa, $pag_inactiva;
    switch ($nav) {

        case 0:
            require_once($pag_df["header"]);
            break;

        case 1:
            require_once($pag_sp["header"]);
            break;

        case 2:
            require_once($pag_u["header"]);
            break;

        case 3:
            require_once($pag_activa["header"]);
            break;

        case 4:
            require_once($pag_inactiva["header"]);
            break;

        case 5:
            require_once($pag_inactiva["header"]);
            break;
    }
}
//----------------------//

//----Carga la navigation----//
function cargarNavegacion()
{
    global $nav, $pag_sp, $pag_df, $pag_u, $pag_activa, $pag_inactiva;
    switch ($nav) {

        case 0:
            require_once($pag_df["navigation"]);
            break;

        case 1:
            require_once($pag_sp["navigation"]);
            break;

        case 2:
            require_once($pag_u["navigation"]);
            break;

        case 3:
            require_once($pag_activa["navigation"]);
            break;

        case 4:
            require_once($pag_inactiva["navigation"]);
            break;

        case 4:
            require_once($pag_inactiva["navigation"]);
            break;

        case 5:
            require_once($pag_inactiva["navigation"]);
            break;
    }
}
//---------------------------//

//---------------------------//
function cargarContenido()
{
    global $page, $nav, $pag_df_content, $pag_sp_content, $pag_u_content, $pag_activa_content, $pag_inactiva_content;
    switch ($nav) {

        case 0:

            switch ($page) {

                case 0:
                    require_once($pag_df_content["content0"]);
                    break;
            }
            break;

        case 1:
            switch ($page) {

                case 0:
                    require_once($pag_sp_content["content0"]);
                    break;

                case 1:
                    require_once($pag_sp_content["content1"]);
                    break;

                case 2:
                    require_once($pag_sp_content["content2"]);
                    break;

                case 3:
                    require_once($pag_sp_content["content3"]);
                    break;

                case 4:
                    require_once($pag_sp_content["content4"]);
                    break;

                case 5:
                    require_once($pag_sp_content["content5"]);
                    break;
            }
            break;

        case 2:
            switch ($page) {

                case 0:
                    require_once($pag_u_content["content0"]);
                    break;

                case 1:
                    require_once($pag_u_content["content1"]);
                    break;

                case 2:
                    require_once($pag_u_content["content2"]);
                    break;
            }
            break;

        case 3:
            switch ($page) {

                case 0:
                    require_once($pag_activa_content["content0"]);
                    break;

                case 1:
                    require_once($pag_activa_content["content1"]);
                    break;

                case 2:
                    require_once($pag_activa_content["content2"]);
                    break;

                case 3:
                    require_once($pag_activa_content["content3"]);
                    break;
            }
            break;

        case 4:
            switch ($page) {

                case 0:
                    require_once($pag_inactiva_content["content0"]);
                    break;

                case 1:
                    require_once($pag_inactiva_content["content1"]);
                    break;

                case 2:
                    require_once($pag_inactiva_content["content2"]);
                    break;

                case 3:
                    require_once($pag_inactiva_content["content3"]);
                    break;
            }
            break;

        case 5:
            switch ($page) {

                case 0:
                    require_once($pag_inactiva_content["content0"]);
                    break;

                case 1:
                    require_once($pag_inactiva_content["content1"]);
                    break;

                case 2:
                    require_once($pag_inactiva_content["content2"]);
                    break;

                case 3:
                    require_once($pag_inactiva_content["content3"]);
                    break;
            }
            break;
    }
}
//---------------------------//

/*Las siguientes funciones imprimen 'class="active"' para utilizarlo en el vínculo
de las páginas de navegación (la página de inicio es la página 0)
 */

//----------para la página 0----------//
function active_0()
{
    global $page;
    switch ($page) {
        case 0:
            echo "class='active'";
            break;
        case 1:
            echo "";
            break;
        case 2:
            echo "";
            break;
        case 3:
            echo "";
            break;
    }
}
//------------------------------------//

//----------para la página 1----------//
function active_1()
{
    global $page;
    switch ($page) {
        case 0:
            echo "";
            break;
        case 1:
            echo "class='active'";
            break;
        case 2:
            echo "";
            break;
        case 3:
            echo "";
            break;
    }
}
//------------------------------------//

//----------para la página 2----------//
function active_2()
{
    global $page;
    switch ($page) {
        case 0:
            echo "";
            break;
        case 1:
            echo "";
            break;
        case 2:
            echo "class='active'";
            break;
        case 3:
            echo "";
            break;
    }
}
//------------------------------------//

//----------para la página 3----------//
function active_3()
{
    global $page;
    switch ($page) {
        case 0:
            echo "";
            break;
        case 1:
            echo "";
            break;
        case 2:
            echo "";
            break;
        case 3:
            echo "class='active'";
            break;
    }
}
//------------------------------------//

//----------para la página 4----------//
function active_4()
{
    global $page;
    switch ($page) {
        case 0:
            echo "";
            break;
        case 1:
            echo "";
            break;
        case 2:
            echo "";
            break;
        case 3:
            echo "";
            break;
        case 4:
            echo "class='active'";
            break;
    }
}
//------------------------------------//

//----------para la página 5----------//
function active_5()
{
    global $page;
    switch ($page) {
        case 0:
            echo "";
            break;
        case 1:
            echo "";
            break;
        case 2:
            echo "";
            break;
        case 3:
            echo "";
            break;
        case 4:
            echo "";
            break;
        case 5:
            echo "class='active'";
            break;
    }
}
//------------------------------------//



/*Carga la imagen correspondiente al usuario que inició sesión,
sino tiene una imagen de perfil selecciola la imagen por defecto*/
function cargarImagen()
{

    if ($_SESSION["imagen"] == null) {

        echo "view/assets/media/image/user/default.png";
    } else {

        echo $_SESSION["imagen"];
    }
}
//-------------------------//


function cargarInfoNegocio()
{

    require_once("model/base_datos_usuarios.php");
    $usuario = new consultarUsuario();
    $usuario->consultar($_SESSION["nombre"]);
    $ID = $usuario->registro["ID"];
    $info = new DatosInfoNegocio();
    $aux = "";

    if ($info->consultarNegocio($ID)) {

        $registro = $info->registro; //Contiene la informacion de la tabla info_negocios
        $info->consultarNegocioDB($ID);
        $registrodb = $info->registro; //Contiene la informacion de la tabla usuarios_bd

        if (!$registrodb["municipio"] == null) {

            $aux .= "

            <tr class = 'tr-per'>
                <td style='padding: 5px;'>PROVINCIA:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . $registrodb["provincia"] . "</small></td>
            </tr>

            <tr class = 'tr-per'>
                <td style='padding: 5px;'>MUNICIPIO:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . $registrodb["municipio"] . "</small></td>
            </tr>

            <tr class = 'tr-per'>
                <td style='padding: 5px;'>DIRECCIÓN:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . $registro["direccion"] . "</small></td>
            </tr>

            ";
        } else {


            $aux .= "
            <tr class = 'tr-per'>
                <td style='padding: 5px;'>PROVINCIA:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . $registrodb["provincia"] . "</small></td>
            </tr>
            
            <tr class = 'tr-per'>
                <td style='padding: 5px;'>DIRECCIÓN:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . $registro["direccion"] . "</small></td>
            </tr>";
        }

        if (!$registro["n_telefono"] == null) {

            $aux .= "
            
            <tr class = 'tr-per'>
                <td style='padding: 5px;'>ENVÍOS:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . strtoupper($registro["envios"]) . "</small></td>
            </tr>

            <tr class = 'tr-per'>
                <td style='padding: 5px;'>RECIBE:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . strtoupper($registro["metodo_cobro"]) . "</small></td>
            </tr>

            <tr class = 'tr-per'>
                <td style='padding: 5px;'>TELÉFONO:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . $registro["n_telefono"] . "</small></td>
            </tr>
            
            ";
        }


        $aux .= "
        <tr class = 'tr-per'>
            <td style='padding: 5px;'>SUBSCRIPCIÓN:</td>
            <td style='padding: 5px;'><small class='texto-verde'>" . strtoupper($registro["subscripcion"]) . "</small></td>
        </tr>";





        return $aux;
    } else {

        return "";
    }
}


function cargarInfoUsuario()
{
    require_once("model/base_datos_usuarios.php");
    $usuario = new consultarUsuario();
    $usuario->consultar($_SESSION["nombre"]);
    $aux = "";

    if (!$usuario->registro["provincia"] == null) {

        $aux .= "

        <tr class = 'tr-per'>
            <td style='padding: 5px;'>PROVINCIA:</td>
            <td style='padding: 5px;'><small class='texto-verde'>" . $usuario->registro["provincia"] . "</small></td>
        </tr>";
    }
    if (!$usuario->registro["municipio"] == null) {

        $aux .= "
            <tr class = 'tr-per'>
                <td style='padding: 5px;'>MUNICIPIO:</td>
                <td style='padding: 5px;'><small class='texto-verde'>" . $usuario->registro["municipio"] . "</small></td>
            </tr>
            
            ";
    }

    // if (!$usuario->registro["localidad"] == null) {
    //     $aux .= " <tr class = 'tr-per'>
    //             <td style='padding: 5px;'>LOCALIDAD:</td>
    //             <td style='padding: 5px;'><small class='texto-verde'>" . $usuario->registro["localidad"] . "</small></td>
    //             </tr>";
    // }
    return $aux;
}

function eliminarListado()
{

    if (isset($_SESSION["listado_productos"])) {

        unset($_SESSION["listado_productos"], $_SESSION["numero_productos"], $_SESSION["contador_productos"]);
    }
}
