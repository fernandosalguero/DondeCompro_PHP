<?php

/* Devuele un objeto que contiene
   la conexión con la base de datos*/
//-------------------------//   

class conexion_productos
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

            $this->conexion_db = new PDO("mysql:host=$name_host; dbname=$name_bd_productos", "$user_name", "$password");
            // $this->conexion_db = new PDO("mysql:host=".$_ENV['DB_HOST']."; dbname=". $_ENV['DB_PRODUCTOS_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion_db->exec("SET CHARACTER SET utf8");
        } catch (Exception $e) {

            die("Error al intentar establecer conexion con la base de") . $e->getMessage();
        }
    }
}
//-------------------------//



/*Es clase contiene los métodos necesarios para mostrar y manipular los productos
en el panel de administración de productos*/
//------------------------------------------//
class Productos extends conexion_productos
{

    public $db;

    public function __construct($nombre_db)
    {

        $this->db = $nombre_db;
        $this->conectar();
    }


    static function consultaRubro($rubro, $empezar, $entradas, $bd)
    {


        if ($rubro == "TODOS") {

            return "SELECT * FROM $bd LIMIT $empezar, $entradas";
        } else {

            return "SELECT * FROM $bd WHERE Rubro = :rubro LIMIT $empezar, $entradas";
        }
    }

    static function consultaRubroNFILAS($rubro, $db)
    {

        if ($rubro == "TODOS") {

            return "SELECT * FROM $db";
        } else {

            return "SELECT * FROM $db WHERE Rubro = :rubro";
        }
    }

    static function consultaRubroBusqueda($rubro, $empezar, $entradas, $db, $isCodigo)
    {

        if ($rubro == "TODOS") {

            if ($isCodigo) {
                return "SELECT * FROM  $db WHERE Codigo LIKE ? LIMIT $empezar, $entradas";
            } else {
                return "SELECT * FROM  $db WHERE Descripcion LIKE ? LIMIT $empezar, $entradas";
            }
        } else {
            if ($isCodigo) {
                return "SELECT * FROM  $db WHERE Codigo LIKE ? AND Rubro = ? LIMIT $empezar, $entradas";
            } else {
                return "SELECT * FROM  $db WHERE Descripcion LIKE ? AND Rubro = ? LIMIT $empezar, $entradas";
            }
        }
    }

    static function consultaRubroBusquedaNFILAS($rubro, $db)
    {

        if ($rubro == "TODOS") {

            return "SELECT * FROM  $db WHERE Descripcion LIKE ?";
        } else {


            return "SELECT * FROM  $db WHERE  Descripcion LIKE ? AND Rubro = ?";
        }
    }

    public function obtenerRubros($db)
    {

        $consulta = "SELECT distinct Rubro FROM $db ORDER BY Rubro ASC;";
        $resultado = $this->conexion_db->prepare($consulta);
        $resultado->execute();
        $registro = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $resultado->closeCursor();
        $res = array();
        foreach ($registro as $r) {
            $res[] = $r['Rubro'];
        }
        return $res;
    }

    static function bindValueRubro($rubro, $resultado)
    {

        if ($rubro == "TODOS") {

            return 1;
        } else {


            $resultado->bindValue(":rubro", $rubro);
        }
    }

    static function bindValueRubroBusqueda($rubro, $resultado, $termino)
    {

        if ($rubro == "TODOS") {


            $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        } else {

            $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
            $resultado->bindValue(2, "$rubro", PDO::PARAM_STR);
        }
    }


    public function mostrar($rubro, $empezar, $entradas)
    {

        $this->consulta = $this::consultaRubro($rubro, $empezar, $entradas, $this->db);

        $resultado = $this->conexion_db->prepare($this->consulta);
        $this::bindValueRubro($rubro, $resultado);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscar($termino, $rubro, $empezar, $entradas)
    {
        $isCodigo = false;

        if (preg_match("/^(\d)\w+/", $termino) > 0) {
            $isCodigo = true;
        }

        $this->consulta = $this::consultaRubroBusqueda($rubro, $empezar, $entradas, $this->db, $isCodigo);

        $resultado = $this->conexion_db->prepare($this->consulta);
        $this::bindValueRubroBusqueda($rubro, $resultado, $termino);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }


    public function totalFilas($rubro)
    {

        $this->consulta = $this::consultaRubroNFILAS($rubro, $this->db);

        $resultado = $this->conexion_db->prepare($this->consulta);
        $this::bindValueRubro($rubro, $resultado);
        $resultado->execute();

        return $resultado->rowCount();
    }

    public function totalFilasBusqueda($termino, $rubro)
    {

        $this->consulta = $this::consultaRubroBusquedaNFILAS($rubro, $this->db);

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $this::bindValueRubroBusqueda($rubro, $resultado, $termino);
        $resultado->execute();

        return $resultado->rowCount();
    }


    public function cambiarPrecio($precio, $codigo)
    {

        $this->consulta = "UPDATE $this->db SET Precio = :precio WHERE Codigo = :codigo";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":precio" => $precio, ":codigo" => $codigo));

        return $resultado->rowCount();
    }

    public function insertarProducto($nombre, $codigo, $categoria)
    {

        $this->consulta = "INSERT INTO productos_base (Descripcion, Codigo, Rubro) VALUES (:nombre, :codigo, :categoria)";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":nombre" => $nombre, ":codigo" => $codigo, ":categoria" => $categoria));

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function extraerProductosNC($tabla)
    {

        $this->consulta = "SELECT * FROM productos_base WHERE Codigo NOT IN (SELECT Codigo FROM $tabla)";
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

    public function insertarProductoTB($nombre, $codigo, $categoria, $tabla)
    {

        $this->consulta = "INSERT INTO $tabla (Descripcion, Codigo, Rubro) VALUES (:nombre, :codigo, :categoria)";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":nombre" => $nombre, ":codigo" => $codigo, ":categoria" => $categoria));

        if ($resultado->rowCount()) {

            $resultado->closeCursor();
            return 1;
        } else {

            $resultado->closeCursor();
            return 0;
        }
    }

    public function consultarProducto($nombre)
    {

        $this->consulta = "SELECT * FROM productos_base WHERE Descripcion = :nombre";
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

    public function consultarProductoCodigo($codigo)
    {

        $this->consulta = "SELECT * FROM productos_base WHERE Codigo = :nombre";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":nombre", $codigo);
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
//------------------------------------------//


class CrearTabla extends conexion_productos
{

    public function duplicar($nombre)
    {

        $this->consulta = "CREATE TABLE $nombre LIKE productos_base";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();

        $resultado->closeCursor();
    }

    public function insertar($nombre)
    {

        $this->consulta = "INSERT INTO $nombre SELECT * FROM productos_base";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute();
        $resultado->closeCursor();
    }

    public function copiar($tabla)
    {

        $this->consulta = "INSERT INTO $tabla SELECT * FROM productos_base";
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


class Precios extends conexion_productos
{

    public function buscar($termino, $empezar, $entradas)
    {


        $this->consulta = "SELECT *  FROM  productos_base WHERE Descripcion LIKE ?  LIMIT $empezar, $entradas";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarTodos($termino)
    {

        // $this->consulta = "SELECT *  FROM  productos_base WHERE Descripcion LIKE ? LIMIT 100";
        $this->consulta = "SELECT *  FROM  productos_base WHERE Descripcion LIKE ?";


        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalFilasBusqueda($termino)
    {


        $this->consulta = "SELECT Descripcion, Rubro  FROM  productos_base WHERE Descripcion LIKE ?";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(1, "%$termino%", PDO::PARAM_STR);
        $resultado->execute();

        return $resultado->rowCount();
    }

    public function extraerPrecio($nombre_db, $codigo)
    {

        $this->consulta = "SELECT * FROM $nombre_db where Codigo = :codigo";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->execute(array(":codigo" => $codigo));

        $registro = $resultado->fetch(PDO::FETCH_ASSOC);

        $resultado->closeCursor();

        return $registro;
    }

    public function AumentarPorcentaje($tabla, $porcentaje)
    {

        $this->consulta = "UPDATE $tabla SET Precio = Precio + ((Precio / 100)*$porcentaje)";
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

class ComparadorProductos extends conexion_productos
{

    public $precio;


    public function  extraerPrecios($tabla, $codProducto)
    {

        // $this->consulta = "SELECT Precio from $tabla WHERE Descripcion = :producto";
        $this->consulta = "SELECT Precio from $tabla WHERE Codigo = :codProducto";

        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":codProducto", $codProducto);
        $resultado->execute();
        $this->registro = $resultado->fetch(PDO::FETCH_ASSOC);
        $resultado->closeCursor();
        return $this->registro;
    }
}

class EliminarProducto extends conexion_productos
{

    public function eliminar($codigo, $db)
    {

        $this->consulta = "DELETE FROM $db WHERE Codigo = :codigo";
        $resultado = $this->conexion_db->prepare($this->consulta);
        $resultado->bindValue(":codigo", $codigo);
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
