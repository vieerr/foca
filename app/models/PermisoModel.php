<?php
require_once "Model.php";

class Permiso extends Model
{
    private $conn;
    public static $table = "categorias";


    public function __construct()
    {
        $this->conn = self::getConn();
    }

    public function get_permiso()
    {
        $query = "SELECT * FROM permisos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function get_rol_perms($id_rol)
    {
        return self::select(self::$table, ['*'], ["id_rol" => $id_rol]);
    }
}

?>