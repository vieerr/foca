<?php
require_once "Model.php";

class Rol extends Model{

    public static $table="Roles";
    private $conn;

    public function __construct(){
        $this->conn = self::getConn();
    }

    public function createRol($nombre_rol,$descripcion_rol){
        $data=[
            "nombre_rol"=>$nombre_rol,
            "descripcion_rol"=>$descripcion_rol
        ];

        return self::insert(self::$table,$data);
    }


    public function getId($name) {
        $stmt = $this->conn->prepare('SELECT id_rol FROM Roles WHERE nombre_rol = ?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($id_rol);
        $stmt->fetch();
        $stmt->close();
        return $id_rol ?? null;
    }

    public function get_rol() {
        $query = "SELECT * FROM Roles";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }
}


?>