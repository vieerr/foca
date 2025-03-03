<?php
require_once "Model.php";

class Permiso extends Model{
    private $conn;

    public function __construct(){
        $this->conn = self::getConn();
    }

    public function get_permiso() {
        $query = "SELECT * FROM permisos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }
}

?>