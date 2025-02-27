<?php
require_once 'Model.php';

class Rol extends Model{
    private $conn;

    public function __construct(){
        $this->conn = self::getConn();
    }

    public function createRol($nombre_rol, $descripcion_rol) {
        $stmt = $this->conn->prepare(
            "INSERT INTO Roles (nombre_rol, descripcion_rol) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $nombre_rol, $descripcion_rol);

        $success = $stmt->execute();
        $stmt->close();
        return $success;
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
    
}

?>