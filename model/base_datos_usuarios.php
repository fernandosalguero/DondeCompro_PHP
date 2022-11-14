<?php

/* Devuele un objeto que contiene
   la conexión con la base de datos*/
//--------------//   
class conexion
{

    public $conexion_db;
    public $consulta;

    public function __construct()
    {
        $this->conectar();
    }


    public function conectar()
    {
        require("config.php");
        try {

            $this->conexion_db = new PDO("mysql:host=$name_host; dbname=$name_bd", "$user_name", "$password");
            // $this->conexion_db = new PDO("mysql:host=" . $_ENV['DB_HOST'] . "; dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion_db->exec("SET CHARACTER SET utf8");
        } catch (Exception $e) {
            print_r($e->getMessage());
            //die("Error al intentar establecer conexion con la base de datos").$e->getMessage();


        }
    }
}
//--------------//


//---Establece una conexión y métodos para validar el login---//
class login extends conexion
{

    /*En esta propieda se almacena el recurso que se obtiene
    de una consulta*/
    //----------------//
    private $registro;
    //----------------//

    /*Este método recibe dos parametros, $valor que puede ser el nombre de usuario o correo
    y $clave, luego llama a dos métodos privados que se encargan de evaluar si existe el nombre de usuario
    o correo y si es así, evaluan si la contraseña ($clave) coincide con la de la base de datos y
    retorna un valor (0, 1, 2) dependiendo del resultado de la consulta */
    //-------------------------------------------//
    public function validate($valor, $clave)
    {

        /*--Llama al método prueba_nombre y si retorna un valor mayor a 0
            entonces evalua con un switch las dos posibilidades*/
        if ($nombre = $this->prueba_nombre($valor, $clave)) {

            if ($this->isActivo($valor) == 0) {
                return 0;
            }

            switch ($nombre) {

                case 1:
                    return 1;
                    break;
                case 2:
                    return 2;
                    break;
            }

            /*Si el método prueba_nombre retorna cero
              se evalua si el método prueba_correo
              retorna un valor mayor a 0 y si es así
              se evalua las dos posibilidades con un switch */
        } else if ($correo = $this->prueba_correo($valor, $clave)) {

            if ($this->isActivo($valor) == 0) {
                return 0;
            }

            switch ($correo) {

                case 1:
                    return 1;
                    break;
                case 2:
                    return 2;
                    break;
            }
        } else {

            /*Si tanto el método prueba_nombre y prueba_correo retornan cero, 
              entonces se retorna 0*/
            return 0;
        }
    }
    //-------------------------------------------//


    /*Este método evalua si el nombre está en la base de datos
    sino es así retorna 0, si es así evalua si la contraseña
    coincide y sino es así, retorna 0, si es así
    evalua si el el ID es igual a 1 y si es así
    retorna 2 y si no es así, retorna 1*/
    //----------------------------------------------//
    private function prueba_nombre($nombre, $clave)
    {
        try {



            $this->consulta = "SELECT * FROM usuarios_bd WHERE nombre = :nombre";
            $resultado = $this->conexion_db->prepare($this->consulta);
            $resultado->bindValue(":nombre",  $nombre);
            $resultado->execute();

            if ($resultado->rowCount()) {

                $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

                if (strcmp($nombre, $this->registro["nombre"]) == 0) {

                    if (password_verify($clave, $this->registro["clave"])) {

                        if ($this->registro["ID"] == 1) {

                            return 2;
                        } else {
                            session_start();
                            $_SESSION["ID_USER"] = $this->registro["ID"];
                            return 1;
                        }
                    }
                } else {

                    return 0;
                }
            } else {

                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }
    //----------------------------------------------//

    /*Este método evalua si el correo está en la base de datos
    sino es así retorna 0, si es así evalua si la contraseña
    coincide y sino es así, retorna 0, si es así
    evalua si el el ID es igual a 1 y si es así
    retorna 2 y si no es así, retorna 1*/
    //----------------------------------------------//
    private function prueba_correo($correo, $clave)
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE correo = :correo";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":correo",  $correo);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

            if (strcmp($correo, $this->registro["correo"]) == 0) {

                if (password_verify($clave, $this->registro["clave"])) {

                    if ($this->registro["ID"] == 1) {

                        return 2;
                    } else {
                        session_start();
                        $_SESSION["ID_USER"] = $this->registro["ID"];
                        return 1;
                    }
                }
            } else {

                return 0;
            }
        } else {

            return 0;
        }
    }
    //----------------------------------------------//

    private function isActivo($valor)
    {

        $this->consulta = "SELECT activo FROM usuarios_bd WHERE correo = :valor OR nombre = :valor";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":valor",  $valor);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultadoActivo = $resultado->fetch(PDO::FETCH_ASSOC);
            // echo  $resultadoActivo['activo'];
            return $resultadoActivo['activo'];
        } else {

            return 0;
        }
    }

    //Devuelve el registro (recurso)
    public function getRegistro()
    {

        return $this->registro;
    }
}
//--------------------------------------------------------------//


/*Tiene el método para insertar un usuario nuevo
  con los difentes datos obtenidos del formulario*/
//--------------------------------------//
class insertarUsuario extends conexion
{


    public function insertar_db($nombre, $correo, $clave, $perfil, $estado, $fecha, $provincia, $municipio, $direccion, $localidad, $latitud, $longitud)
    {

        $this->consulta = "INSERT INTO usuarios_bd (nombre, correo, clave, perfil, estado, fecha, provincia, municipio, localidad, centroide_localidad_lat, centroide_localidad_lon) values (:nombre, :correo, :clave, :perfil, :estado, :fecha, :provincia, :municipio, :localidad, :latitud, :longitud)";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(
            ":nombre" => $nombre, ":correo" => $correo, ":clave" => $clave,
            ":perfil" => $perfil, ":estado" => $estado, ":fecha" => $fecha,
            ":provincia" => $provincia, ":municipio" => $municipio,
            ":localidad" => $localidad, ":latitud" => $latitud, ":longitud" => $longitud,
        ));

        $resultado->closeCursor();

        return 1;

        if (!$direccion == null) {
            $this->consulta = "INSERT INTO info_negocios (ID,direccion) values ((select ID from usuarios_bd where correo=:correo), :direccion)";

            $resultado = $this->conexion_db->prepare($this->consulta);

            $resultado->execute(array(":correo" => $correo, ":direccion" => $direccion));

            $resultado->closeCursor();

            return 1;
        }
    }

    public function insertar_temp($nombre, $correo, $clave, $perfil, $estado, $fecha, $activacion, $provincia, $municipio, $direccion, $localidad, $latitud, $longitud)
    {

        $this->consulta = "INSERT INTO usuarios_temp (nombre, correo, clave, perfil, estado, fecha, activacion, provincia, municipio, direccion, localidad, centroide_localidad_lat, centroide_localidad_lon) values (:nombre, :correo, :clave, :perfil, :estado, :fecha, :activacion, :provincia, :municipio, :direccion, :localidad, :latitud, :longitud)";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(
            ":nombre" => $nombre, ":correo" => $correo, ":clave" => $clave,
            ":perfil" => $perfil, ":estado" => $estado, ":fecha" => $fecha,
            ":activacion" => $activacion, ":provincia" => $provincia,
            ":municipio" => $municipio, ":direccion" => $direccion,
            ":localidad" => $localidad, ":latitud" => $latitud, ":longitud" => $longitud
        ));

        $resultado->closeCursor();

        return 1;
    }
}
//--------------------------------------//


/*Estas clases contienen los métodos necesarios
para consultar si existe un usuario con el nombre o correo
escritos*/
//---------------------------------------//
class consultarUsuario extends conexion
{

    public $registro;
    protected $db = "usuarios_bd";


    public function consultar($nombre)
    {

        $consulta = "SELECT * FROM " . $this->db . " where nombre = :nombre";
        $resultado = $this->conexion_db->prepare($consulta);

        $resultado->bindValue(":nombre", $nombre);

        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function consultarDatosIncompletos($nombre)
    {

        $consulta = "SELECT provincia, municipio, localidad, imagen from usuarios_bd where nombre = :nombre and id > 1";
        $resultado = $this->conexion_db->prepare($consulta);

        $resultado->bindValue(":nombre", $nombre);

        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function consultar2($nombre)
    {

        $consulta = "SELECT * FROM " . $this->db . " where nombre = :nombre";
        $resultado = $this->conexion_db->prepare($consulta);

        $resultado->bindValue(":nombre", $nombre);

        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

            if (strcmp($nombre, $this->registro["nombre"]) == 0) {

                $resultado->closeCursor();
                return 1;
            }

            $resultado->closeCursor();
            return 0;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function consultarID($ID)
    {

        $consulta = "SELECT * FROM " . $this->db . " where ID = $ID";
        $resultado = $this->conexion_db->prepare($consulta);


        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function verificarClave($clave)
    {

        if (password_verify($clave, $this->registro["clave"])) {

            return 1;
        } else {

            return 0;
        }
    }

    public function setDB($db)
    {

        $this->db = $db;
    }

    public function consultarEstado($nombre)
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE perfil = 1 AND nombre = :nombre";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":nombre", $nombre);
        $resultado->execute();

        $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

        return $this->registro["estado"];
    }

    public function datos($nombre)
    {

        $this->consulta = "SELECT * FROM " . $this->db . " where nombre = :nombre";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":nombre", $nombre);
        $resultado->execute();

        $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

        $resultado->closeCursor();

        return $this->registro;
    }

    public function consultarProvinciaMunicipio($provincia, $municipio)
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE perfil = 1 AND provincia =" . "'" . $provincia . "'" . "  AND municipio =" . "'" . $municipio . "'" . "";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function consultarProvincia($provincia)
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE perfil = 1 AND provincia =" . "'" . $provincia . "'" . "  AND municipio is null";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }
}

class estadoUsuario extends conexion
{

    public function bloquearUsuario($id)
    {
        $this->consulta = "UPDATE usuarios_bd SET activo = 0 WHERE id = $id;";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return true;
        } else {

            $resultado->closeCursor();
            return false;
        }
    }

    public function desbloquearUsuario($id)
    {
        $this->consulta = "UPDATE usuarios_bd SET activo = 1 WHERE id = $id;";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return true;
        } else {

            $resultado->closeCursor();
            return false;
        }
    }

    public function eliminarUsuario($id)
    {
        $this->consulta = "DELETE FROM usuarios_bd WHERE id = $id;";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return true;
        } else {

            $resultado->closeCursor();
            return false;
        }
    }
}

class consultarCorreo extends consultarUsuario
{


    public function consultar($correo)
    {

        $consulta = "SELECT * FROM " . $this->db . " where correo = :correo";

        $resultado = $this->conexion_db->prepare($consulta);

        $resultado->bindValue(":correo", $correo);

        $resultado->execute();

        if ($resultado->rowCount() > 0) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

            if (strcmp($correo, $this->registro["correo"]) == 0) {

                $resultado->closeCursor();
                return 1;
            }

            $resultado->closeCursor();
            return 0;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function datos($correo)
    {

        $this->consulta = "SELECT * FROM " . $this->db . " where correo = :nombre";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":nombre", $correo);
        $resultado->execute();

        $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

        $resultado->closeCursor();

        return $this->registro;
    }

    public function consultarNombreCorreo($correo, $nombre)
    {

        $consulta = "SELECT * FROM " . $this->db . " where nombre = :nombre AND correo = :correo";

        $resultado = $this->conexion_db->prepare($consulta);

        $resultado->bindValue(":correo", $correo);
        $resultado->bindValue(":nombre", $nombre);

        $resultado->execute();

        if ($resultado->rowCount() > 0) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

            if (strcmp($correo, $this->registro["correo"]) == 0) {

                $resultado->closeCursor();
                return 1;
            }

            $resultado->closeCursor();
            return 0;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }
}
//---------------------------------------//


/*Esta clase contiene los métodos necesarios para 
verificar en link de activación de la cuenta*/
//------------------------------------------------/
class VerificacionActivacion extends conexion
{

    private $registro;
    public $activacion;

    public function __construct($activacion)
    {

        $this->conectar();
        $this->activacion = $activacion;
    }


    public function verificar($correo)
    {

        $this->consulta = "SELECT * FROM usuarios_temp WHERE activacion = :activacion AND correo = :correo";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->bindValue(":activacion", $this->activacion);
        $resultado->bindValue(":correo", $correo);

        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

            $resultado->closeCursor();

            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function eliminarTMP()
    {

        $this->consulta = "DELETE from usuarios_temp WHERE activacion = :activacion";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->bindValue(":activacion", $this->activacion);

        $resultado->execute();
    }


    public function insertarDB()
    {

        $this->consulta = "INSERT INTO usuarios_bd (nombre, correo, clave, perfil, estado, fecha, provincia, municipio, localidad, centroide_localidad_lat, centroide_localidad_lon) VALUES (:nombre, :correo, :clave, :perfil, :estado, :fecha, :provincia, :municipio, :localidad, :latitud, :longitud)";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(
            ":nombre" => $this->registro["nombre"], ":correo" => $this->registro["correo"],
            ":clave" => $this->registro["clave"], ":perfil" => $this->registro["perfil"],
            ":estado" => $this->registro["estado"], ":fecha" => $this->registro["fecha"],
            ":provincia" => $this->registro["provincia"], ":municipio" => $this->registro["municipio"],
            ":localidad" => $this->registro["localidad"], ":latitud" => $this->registro["centroide_localidad_lat"], ":longitud" => $this->registro["centroide_localidad_lon"]
        ));
    }

    public function getRegistro()
    {

        return $this->registro;
    }
}
//------------------------------------------------/


/*Estas clases contienen los métodos necesarios para 
 actualizar los datos de cuenta*/
//---------------------------------------------//
class ActualizarDatos extends conexion
{

    private $registro;

    public function verificarClave($nombre, $clave)
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE nombre = :nombre";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":nombre", $nombre);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);

            if (password_verify($clave, $this->registro["clave"])) {

                $resultado->closeCursor();
                return 1;
            } else {

                $resultado->closeCursor();
                return 0;
            }
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizar($nombre, $correo)
    {

        $oldnombre = $this->registro["nombre"];
        $this->consulta = "UPDATE usuarios_bd SET nombre = :nombre, correo = :correo WHERE nombre = :oldnombre";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":nombre" => $nombre, ":correo" => $correo, ":oldnombre" => $oldnombre));

        if ($resultado->rowCount() > 0) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function nuevaConsulta($nombre, $correo)
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE nombre = :nombre AND correo = :correo";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":nombre" => $nombre, ":correo" => $correo));

        if ($resultado->rowCount() > 0) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function getRegistro()
    {

        return $this->registro;
    }
}


class CambiarImagen extends conexion
{

    public function cambiar($nombre, $rutaimagen)
    {

        $this->consulta = "UPDATE usuarios_bd SET imagen = :imagen WHERE nombre = :nombre";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(":imagen" => $rutaimagen, ":nombre" => $nombre));

        if ($resultado->rowCount() > 0) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function eliminar($nombre)
    {

        $this->consulta = "UPDATE usuarios_bd SET imagen = NULL where nombre = :nombre";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":nombre", $nombre);
        $resultado->execute();


        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }
}


class CambiarClave extends ActualizarDatos
{

    public function actualizar($nombre, $clave)
    {

        $this->consulta = "UPDATE usuarios_bd SET clave = :clave WHERE nombre = :nombre";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":nombre", $nombre);
        $resultado->bindValue(":clave", $clave);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }
}

class Ubicacion extends conexion
{

    public function consultarInfoNegocio($ID)
    {

        $this->consulta = "SELECT * FROM info_negocios WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {


            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizarProvinciaMunicipioLocalidad($ID, $provincia, $municipio, $localidad, $centroide_localidad_lat, $centroide_localidad_lon)
    {

        $this->consulta = "UPDATE usuarios_bd SET provincia = :provincia, municipio = :municipio, localidad = :localidad, centroide_localidad_lat = :centroide_localidad_lat, centroide_localidad_lon = :centroide_localidad_lon WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(
            array(
                ":provincia" => $provincia,
                ":municipio" => $municipio,
                ":localidad" => $localidad,
                ":centroide_localidad_lat" => $centroide_localidad_lat,
                ":centroide_localidad_lon" => $centroide_localidad_lon
            )
        );

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizarProvinciaMunicipio($ID, $provincia, $municipio)
    {

        $this->consulta = "UPDATE usuarios_bd SET provincia = :provincia, municipio = :municipio WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":provincia" => $provincia, ":municipio" => $municipio));

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizarCentroides($ID, $centroide_localidad_lat, $centroide_localidad_lon)
    {

        $this->consulta = "UPDATE usuarios_bd SET centroide_localidad_lat = :centroide_localidad_lat, 
        centroide_localidad_lon = :centroide_localidad_lon WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":centroide_localidad_lat" => $centroide_localidad_lat, ":centroide_localidad_lon" => $centroide_localidad_lon));

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizarProvincia($ID, $provincia)
    {

        $this->consulta = "UPDATE usuarios_bd SET provincia = :provincia WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":provincia", $provincia);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizarDireccion($ID, $direccion)
    {

        $this->consulta = "UPDATE info_negocios SET direccion = :direccion where ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":direccion", $direccion);
        $resultado->execute();
        $resultado->closeCursor();
    }

    public function actualizarLocalidad($ID, $localidad)
    {

        $this->consulta = "UPDATE usuarios_bd SET localidad = :localidad where ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":localidad", $localidad);
        $resultado->execute();
        $resultado->closeCursor();
    }


    public function InsertarDireccion($ID, $direccion)
    {

        $this->consulta = "INSERT INTO info_negocios (direccion, ID) VALUES (:direccion, $ID)";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":direccion", $direccion);
        $resultado->execute();
        $resultado->closeCursor();
    }

    public function eliminarMunicipio($ID)
    {

        $this->consulta = "UPDATE usuarios_bd SET municipio = null where ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();
        $resultado->closeCursor();
    }
}

class InfoNegocio extends conexion
{

    public function insertarInfo($ID, $activacion)
    {

        $querySelect = "SELECT direccion, telefono FROM usuarios_temp WHERE activacion = :activacion LIMIT 1";
        $resultadoSelect = $this->conexion_db->prepare($querySelect);
        $resultadoSelect->execute(
            array(":activacion" => $activacion)
        );

        if ($resultadoSelect->rowCount() > 0) {
            $res = $resultadoSelect->fetch(PDO::FETCH_ASSOC);
            $direccionSelect = $res["direccion"];
            $n_telefono = $res["telefono"];
        }

        $this->consulta = "INSERT INTO info_negocios (ID, direccion, n_telefono) VALUES (:id, :direccion, :n_telefono)";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(
            array(
                ":id" => $ID,
                ":direccion" => $direccionSelect,
                ":n_telefono" => $n_telefono
            )
        );

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function updateComercioReferido($ID, $correo, $token)
    {
        try {

            $this->consulta = "SELECT * FROM usuarios_temp ut INNER JOIN referidos_negocios rn ON ut.ID = rn.idNegocioTemp WHERE ut.activacion = :activacion AND ut.correo = :correo";

            $resultado = $this->conexion_db->prepare($this->consulta);

            $resultado->bindValue(":activacion", $token);
            $resultado->bindValue(":correo", $correo);

            $resultado->execute();

            if ($resultado->rowCount() > 0) {

                $usuarioTemp = $resultado->fetch(PDO::FETCH_ASSOC);

                $resultado->closeCursor();

                $this->consulta = "UPDATE referidos_negocios SET idNegocio = :ID, idNegocioTemp = 0 WHERE cod_registro = :cod_registro;";
                $resultado1 = $this->conexion_db->prepare($this->consulta);
                $resultado1->bindValue(":cod_registro", $usuarioTemp['cod_registro']);
                $resultado1->bindValue(":ID", $ID);
                $resultado1->execute();

                if ($resultado1->rowCount() > 0) {
                    $resultado1->closeCursor();
                    return true;
                } else {
                    $resultado1->closeCursor();
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {

            return false;
        }
    }
    // public function insertarDireccionInfo($ID)
    // {



    //     $query = "UPDATE info_negocios SET direccion = :direccion WHERE ID = :id;";
    //     $resultado = $this->conexion_db->prepare($query);
    //     $resultado->execute(
    //         array(":direccion" => $direccionSelect)
    //     );

    //     if ($resultado->rowCount()) {

    //         $resultado->closeCursor();
    //         return 1;
    //     } else {

    //         $resultado->closeCursor();
    //         return 0;
    //     }
    // }



    public function actualizarInfo($telefono, $envios, $cobro, $ID)
    {

        $this->consulta = "UPDATE info_negocios SET n_telefono = :telefono, envios = :envios, metodo_cobro = :cobro WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":telefono" => $telefono, ":envios" => $envios, ":cobro" => $cobro));

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizarPromos($ID, $promos)
    {

        $this->consulta = "UPDATE info_negocios SET promociones = :promos WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":promos", $promos);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function actualizarSubscripcion($sino, $ID)
    {

        $this->consulta = "UPDATE info_negocios SET subscripcion = :sino WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":sino", $sino);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 1;
        }
    }

    public function eliminarSubscripcion($ID)
    {

        $this->consulta = "UPDATE info_negocios SET subscripcion = 'no' WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }
}
//--------------------------------------------//


class DatosInfoNegocio extends conexion
{

    public function consultarNegocio($ID)
    {

        $this->consulta = "SELECT * FROM info_negocios WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {


            $resultado->closeCursor();
            return 0;
        }
    }

    public function consultarNegocioDB($ID)
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {


            $resultado->closeCursor();
            return 0;
        }
    }
}


class Subscripcion extends conexion
{

    public function consultarSubscripcion($ID)
    {

        $this->consulta = "SELECT * FROM subscripcion_activa where ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function insertarSubscripcionActiva($ID, $fecha_inicio, $fecha_expiracion)
    {

        $this->consulta = "INSERT INTO subscripcion_activa (ID, fecha_inicio, fecha_expiracion) VALUES ($ID, :fecha_i, :fecha_e)";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":fecha_i" => $fecha_inicio, ":fecha_e" => $fecha_expiracion));

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function insertarSubscripcion($ID, $nombre, $fecha_inicio, $fecha_expiracion)
    {

        $this->consulta = "INSERT INTO subscripcion (ID, nombre, fecha_inicio, fecha_expiracion) VALUES ($ID, :nombre, :fecha_i, :fecha_e)";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":fecha_i" => $fecha_inicio, ":fecha_e" => $fecha_expiracion, ":nombre" => $nombre));

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function isComercioReferido($ID)
    {
        try {
            $this->consulta = "SELECT * FROM referidos_negocios WHERE idNegocio = :ID;";
            $resultado = $this->conexion_db->prepare($this->consulta);
            $resultado->execute(array(":ID" => $ID));

            if ($resultado->rowCount()) {

                $resultado->closeCursor();
                return 1;
            } else {

                $resultado->closeCursor();
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }

    public function insertarSubscripcionReferido($ID, $desde, $hasta, $importe, $tipo)
    {

        $this->consulta = "SELECT * FROM referidos_negocios WHERE idNegocio = :ID;";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":ID" => $ID));

        if ($resultado->rowCount()) {

            $refNegocio = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();

            $this->consulta = "INSERT INTO referido_negocio_suscripcion (idNegocio, idReferido, importe, tipo, desde, hasta, fechaPago) VALUES (:ID, :idReferido, :importe, :tipo, :desde, :hasta, NOW());";

            $resultado1 = $this->conexion_db->prepare($this->consulta);
            $resultado1->execute(array(":ID" => $ID, ":idReferido" => $refNegocio['idReferido'], ":importe" => $importe, ":tipo" => $tipo, ':desde' => $desde, ':hasta' => $hasta));

            if ($resultado1->rowCount()) {
                $resultado1->closeCursor();
                return 1;
            } else {
                $resultado1->closeCursor();
                return 0;
            }
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }


    public function eliminarSubscripcion($ID)
    {

        $this->consulta = "DELETE FROM subscripcion_activa WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 1;
        }
    }

    public function actualizarSubscripcionActiva($ID, $fecha_expiracion)
    {

        $this->consulta = "UPDATE subscripcion_activa SET fecha_expiracion = :fecha_expiracion WHERE ID = $ID";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":fecha_expiracion", $fecha_expiracion);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 1;
        }
    }
}

class Comparador extends conexion
{

    public function extraerNegociosProvincia($provincia)
    {

        $this->consulta = "SELECT * FROM usuarios_bd where perfil = 1 AND provincia = :provincia AND activo = 1";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":provincia", $provincia);
        $resultado->execute();
        $this->registro = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $resultado->closeCursor();
        return $this->registro;
    }

    public function extraerNegociosProvinciaMunicipio($provincia, $municipio)
    {

        $this->consulta = "SELECT * FROM usuarios_bd where perfil = 1 AND provincia = :provincia AND municipio = :municipio AND activo = 1";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":provincia", $provincia);
        $resultado->bindValue(":municipio", $municipio);
        $resultado->execute();
        $this->registro = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $resultado->closeCursor();
        return $this->registro;
    }
}


/*Estas clases contienen los métodos necearios para mostrar y manipular los negocios
en el panel de administración de negocios */
//--------------------------------//
class Negocio extends conexion
{



    public function mostrar($ordenar, $empezar, $entradas)
    {

        $this->consulta = "SELECT ID, nombre, correo, estado, imagen FROM  usuarios_bd WHERE perfil = 1 ORDER BY nombre $ordenar LIMIT $empezar, $entradas";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function darDeAlta($ID)
    {

        $this->consulta = "UPDATE usuarios_bd SET estado = 1 WHERE ID = $ID";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            return 1;
        } else {

            return 0;
        }
    }

    public function darDeBaja($ID)
    {

        $this->consulta = "UPDATE usuarios_bd SET estado = 0 WHERE ID = $ID";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {

            return 1;
        } else {

            return 0;
        }
    }

    public function buscar($termino, $ordenar, $empezar, $entradas)
    {


        $this->consulta = "SELECT ID, nombre, correo, estado, imagen FROM  usuarios_bd WHERE perfil = 1 AND nombre LIKE ? ORDER BY nombre $ordenar LIMIT $empezar, $entradas";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalFilas()
    {

        $this->consulta = "SELECT * FROM usuarios_bd where perfil = 1";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute();

        return $resultado->rowCount();
    }

    public function totalFilasBusqueda($termino)
    {

        $this->consulta = "SELECT ID, nombre, correo, estado, imagen FROM  usuarios_bd WHERE perfil = 1 AND nombre LIKE ?";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $resultado->execute();

        return $resultado->rowCount();
    }
}


class Usuario extends conexion
{

    public function mostrar($ordenar, $empezar, $entradas, $activo)
    {
        $isActivo = $activo == true ? 1 : 0;
        // var_dump($isActivo);
        // var_dump($activo);

        $this->consulta = "SELECT ID, nombre, correo, estado, imagen FROM  usuarios_bd WHERE perfil = 0 AND activo = $isActivo ORDER BY nombre $ordenar LIMIT $empezar, $entradas";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($termino, $ordenar, $empezar, $entradas)
    {


        $this->consulta = "SELECT ID, nombre, correo, estado, imagen FROM  usuarios_bd WHERE perfil = 0 AND nombre LIKE ? ORDER BY nombre $ordenar LIMIT $empezar, $entradas";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalFilas()
    {

        $this->consulta = "SELECT * FROM usuarios_bd where perfil = 0";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute();

        return $resultado->rowCount();
    }

    public function totalFilasBusqueda($termino)
    {

        $this->consulta = "SELECT ID, nombre, correo, estado, imagen FROM  usuarios_bd WHERE perfil = 0 AND nombre LIKE ?";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $resultado->execute();

        return $resultado->rowCount();
    }
}


class Extraer extends conexion
{

    public $registro;


    public function extraerNegocios()
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE perfil = 1 AND estado = 1";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute();

        $this->registro = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $this->registro;
    }

    public function extraerNegociosAll()
    {

        $this->consulta = "SELECT * FROM usuarios_bd WHERE perfil = 1";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute();

        $this->registro = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $this->registro;
    }
}
//--------------------------------//

class Recuperar extends conexion
{

    public function insertarVerificacion($verificacion, $correo)
    {

        $this->consulta = "INSERT INTO recuperar_clave (verificacion, correo) values (:verificacion, :correo)";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":verificacion", $verificacion);
        $resultado->bindValue(":correo", $correo);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return  0;
        }
    }

    public function verificarCorreoVeri($correo, $verificacion)
    {

        $this->consulta = "SELECT * FROM recuperar_clave where correo = :correo AND verificacion = :verificacion";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":correo", $correo);
        $resultado->bindValue(":verificacion", $verificacion);

        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return  0;
        }
    }

    public function insertarClave($correo, $clave)
    {

        $this->consulta = "UPDATE usuarios_bd SET clave = :clave WHERE correo = :correo";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(":correo" => $correo, ":clave" => $clave));

        if ($resultado->rowCount() > 0) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function borrarCorreoVeri($correo)
    {

        $this->consulta = "DELETE FROM recuperar_clave WHERE correo = :correo";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":correo", $correo);
        $resultado->execute();

        if ($resultado->rowCount() > 0) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }
}

class Metricas extends conexion
{

    public function incrementarContador($provincia)
    {

        $this->consulta = "UPDATE comparaciones SET total_comparaciones = total_comparaciones + 1 WHERE provincia = :provincia";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":provincia", $provincia);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return  0;
        }
    }

    public function consultarComparaciones()
    {

        $this->consulta = "SELECT * FROM comparaciones";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        if ($resultado->rowCount()) {

            $this->registro = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return  0;
        }
    }
}
class Cupones extends conexion
{
    /*En esta propieda se almacena el recurso que se obtiene
    de una consulta*/
    //----------------//
    // private $registro;
    //----------------//

    public function insertar_cupones($codigo, $suscripcion, $descuento, $fecha_desde, $fecha_hasta, $descripcion, $acumulable)
    {

        $this->consulta = "INSERT INTO cupones (codigo, suscripcion, descuento, fecha_desde, fecha_hasta, descripcion, acumulable) values (:codigo, :suscripcion, :descuento, :fecha_desde, :fecha_hasta, :descripcion, :acumulable)";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(":codigo" => $codigo, ":suscripcion" => $suscripcion, ":descuento" => $descuento, ":fecha_desde" => $fecha_desde, ":fecha_hasta" => $fecha_hasta, ":descripcion" => $descripcion, ":acumulable" => $acumulable));


        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return true;
        } else {

            $resultado->closeCursor();
            return false;
        }
    }

    public function ver_cupones()
    {

        $this->consulta = "SELECT * FROM cupones";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute();

        if ($resultado->rowCount()) {

            return $resultado->fetchAll(PDO::FETCH_ASSOC);

            $resultado->closeCursor();
        } else {

            $resultado->closeCursor();
            return false;
        }
    }

    public function ver_cupon($codigo)
    {

        $this->consulta = "SELECT * FROM cupones WHERE codigo= :codigo";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(":codigo" => $codigo));

        if ($resultado->rowCount()) {

            return $resultado->fetchAll(PDO::FETCH_ASSOC);

            $resultado->closeCursor();
        } else {

            $resultado->closeCursor();
            return false;
        }
    }

    public function eliminar_cupones($codigo)
    {
        $res_cupones = null;
        $this->consulta = "DELETE FROM cupones WHERE codigo= :codigo;
        DELETE FROM negocios_descuentos WHERE id_cupon= :codigo;";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(":codigo" => $codigo));

        if ($resultado->rowCount()) {

            //si elimino llamo a la consulta de cupones nuevamente para recargar la tabla
            $resultado->closeCursor();
            $res_cupones = $this->ver_cupones();
            return $res_cupones;
        } else {

            $resultado->closeCursor();
        }
    }

    public function editar_cupones($suscripcion, $descuento, $fecha_desde, $fecha_hasta,  $descripcion, $acumulable, $codigo)
    {
        $res_cupones = null;
        $this->consulta = "UPDATE cupones SET 
        `suscripcion`= :suscripcion,
        `descuento`= :descuento,
        `fecha_desde`= :fecha_desde,
        `fecha_hasta`= :fecha_hasta,
        `descripcion`= :descripcion,
        `acumulable`= :acumulable
        WHERE codigo= :codigo;";


        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(
            ":suscripcion" => (string)$suscripcion,
            ":descuento" => (float)$descuento,
            ":fecha_desde" => $fecha_desde,
            ":fecha_hasta" => $fecha_hasta,
            ":descripcion" => (string)$descripcion,
            ":acumulable" => (int)$acumulable,
            ":codigo" => $codigo
        ));

        if ($resultado->rowCount() > 0) {
            $resultado->closeCursor();
            $res_cupones = $this->ver_cupones();
            return $res_cupones;
        } else {

            $resultado->closeCursor();
        }
    }




    public function agregar_cupon_comercio($codigo, $idUsuario)
    {
        // verifico que exista el cupon
        $this->consulta = "SELECT * FROM cupones WHERE codigo = :codigo LIMIT 1";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(
            ':codigo' => $codigo
        ));

        if ($resultado->rowCount() > 0) {

            $resArray = $resultado->fetchAll(PDO::FETCH_ASSOC);

            $resultado->closeCursor();

            if (!$resArray[0]['acumulable']) { // si el cupon que intenta insertar es no acumulable sólo lo insertará si es el primer cupón que ingresa

                $this->consulta = "SELECT * FROM cupones_usuarios WHERE idUsuario = :idUsuario;";

                $resultadoAcu = $this->conexion_db->prepare($this->consulta);

                $resultadoAcu->execute(array(
                    ':idUsuario' => $idUsuario
                ));
                // tiene otros cupones por lo que no puede insertar un no acumulable
                if ($resultadoAcu->rowCount() > 0) {
                    return false;
                }
            }

            $this->consulta = "SELECT * FROM cupones_usuarios WHERE idCupon = :idCupon;";

            $resultado2 = $this->conexion_db->prepare($this->consulta);

            $resultado2->execute(array(
                ':idCupon' => $resArray[0]['ID']
            ));

            if ($resultado2->rowCount() > 0) { //cupon ya utilizado por el usuario

                $resultado2->closeCursor();
                return false;
            } else {
                // agrego el cupon y lo vinculo al usuario comercio
                // $resArray2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

                $resultado2->closeCursor();

                $this->consulta = "INSERT INTO cupones_usuarios (idCupon, idUsuario, fechaAgregado, usado) VALUES(:idCupon, :idUsuario, :fechaAgregado, false);";

                $resultado3 = $this->conexion_db->prepare($this->consulta);

                $resultado3->execute(array(
                    ':idCupon' => $resArray[0]['ID'],
                    ':idUsuario' => $idUsuario,
                    ':fechaAgregado' => date_format(new DateTime(), 'Y-m-d H:i:s')
                ));
                if ($resultado3->rowCount() > 0) {
                    $resultado3->closeCursor();
                    return true;
                } else {
                    $resultado3->closeCursor();
                    return false;
                }

                return true;
            }
        } else {

            $resultado->closeCursor();
            return false;
        }
    }

    public function marcar_uso_cupon_comercio($idCupon, $idUsuario, $descuento)
    {
        // trae los cupones activos de un usuario por fecha de caducidad del cupon en si

        $this->consulta = "UPDATE cupones_usuarios SET usado = 1 , fechaUso = :fechaUso, descuento = :descuento WHERE idCupon = :idCupon AND idUsuario = :idUsuario;";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(
            ":idCupon" => $idCupon,
            ":idUsuario" => $idUsuario,
            ":fechaUso" => date_format(new DateTime(), 'Y-m-d H:i:s'),
            ":descuento" => $descuento
        ));

        $resultado->closeCursor();

        if ($resultado->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }



    public function ver_cupones_activos_comercio($idUsuario, $suscripcion)
    {
        // trae los cupones activos de un usuario por fecha de caducidad del cupon en si

        $this->consulta = "SELECT * FROM cupones_usuarios cu INNER JOIN cupones c ON c.id = cu.idCupon WHERE idUsuario = :idUsuario AND c.suscripcion = :suscripcion AND date(NOW()) <= c.fecha_hasta AND cu.usado IS NOT TRUE;";

        $resultado = $this->conexion_db->prepare($this->consulta);

        $resultado->execute(array(
            ":idUsuario" => $idUsuario,
            ":suscripcion" => $suscripcion
        ));


        $res = $resultado->fetchAll(PDO::FETCH_ASSOC);

        $resultado->closeCursor();

        return $res;
    }
}
