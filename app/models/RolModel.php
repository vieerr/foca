<?php
require_once "Model.php";

class Rol extends Model
{

    public static $table = "roles";
    private $conn;

    public function __construct()
    {
        $this->conn = self::getConn();
    }

    public function createRol($nombre_rol, $descripcion_rol)
    {
        $data = [
            "nombre_rol" => $nombre_rol,
            "descripcion_rol" => $descripcion_rol
        ];

        return self::insert(self::$table, $data);
    }

    public function updateRol($id, $fields)
    {
        return self::update(table: self::$table, data: $fields, conditions: ["id_rol" => $id]);
    }



    public function getId($name)
    {
        $stmt = $this->conn->prepare('SELECT id_rol FROM roles WHERE nombre_rol = ?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($id_rol);
        $stmt->fetch();
        $stmt->close();
        return $id_rol ?? null;
    }

    public function getRoles()
    {
        return self::select(table: self::$table, columns: ["id_rol", "nombre_rol", "estado_rol"]);
    }

}


?>