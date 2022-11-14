<?php

require_once("../model/base_datos_usuarios.php");


/*Este código evalua si se ha pasado por la url los datos correctos para 
activar la cuenta, si se han pasado las super globales (por el metodo get)
"activacion" y "correo" entonces procede a crear una instancia de la clase
consultarCoreo, luego evalua si existe un usuario en la tabla de usuarios
y si es así es porque la cuenta está activada y por lo tanto redirige a la pagina
activada.php, si el usuario no tiene una cuenta activada, entonces procede a 
activarla y pra esto crea una instancia llamada $activar de la clase VerificacionActivacion
que recibe como parametro lo que se capturó en $activacion y luego se evalua si
el correo coincide con la activacion con el método verificar y si es así, 
llamada a dos métodos, el primero (insertarDB) inserta la información de la tabla temporal
a la tabla de usuarios y el segundo (eliminarDB) elimina los datos de la tabla temporal,
finalmente lo redirige a la pagina activada.php, si ocurre un error en el proceso de registro
redirige al usuario a la pagina activaerror.php*/


/*actualizacion: Cuando la cuenta que se está por activar es de negocio, se crea 
una tabla de productos con el ID de esa cuenta*/
//----------------------------------------------------------//
if (!isset($_GET["activacion"]) || !isset($_GET["correo"])) {

    header("location: ../index.php");
} else {

    $correo = $_GET["correo"];
    $activacion = $_GET["activacion"];

    $consultar_db = new consultarCorreo();

    if ($consultar_db->consultar($correo)) {

        header("location: activada.php");
    } else {

        $activar = new VerificacionActivacion($activacion);

        if ($activar->verificar($correo)) {

            $activar->insertarDB();
            // $activar->eliminarTMP();
            $verificar_perfil = new consultarCorreo();
            $registro = $verificar_perfil->datos($correo);

            if ($registro["perfil"] == 1) {

                require_once("../model/base_datos_productos.php");
                $id = $registro["ID"];
                $nombre = "productos_" . $id;
                $infoNegocio = new InfoNegocio();

                try {
                    $infoNegocio->updateComercioReferido($id, $correo, $activacion);
                } catch (Exception $e) {
                }

                if ($infoNegocio->insertarInfo($id, $activacion)) {

                    $nueva_tabla = new CrearTabla();
                    $nueva_tabla->duplicar($nombre);
                    $nueva_tabla->insertar($nombre);

                    $activar->eliminarTMP();

                    header("location: activada.php");
                } else {

                    echo "OCURRIÓ UN ERROR AL REGISTRAR EL NEGOCIO EN LA BASE DE DATOS,
                    POR FAVOR CONTÁCTENOS PARA RESOLVER EL PROBLEMA";
                }
            } else {
                $activar->eliminarTMP();
                header("location: activada.php");
            }
        } else {

            header("location: activa-error.php");
        }
    }
}
//----------------------------------------------------------//
