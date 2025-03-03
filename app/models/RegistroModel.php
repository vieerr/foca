<?php
require_once "Model.php";

class Registro extends Model
{

    public static $table = "registros";
    // private $conn;

    // public function __construct()
    // {
    //     $this->conn = self::getConn();
    // }
    public function getAllIncome()
    {
        return self::select(table: self::$table, columns: [
            "tipo_registro" => "ingreso",
            "estado_registro" => "activo"
        ]);
    }

    public function getAllExpenses()
    {
        return self::select(table: self::$table, columns: [
            "tipo_registro" => "egreso",
            "estado_registro" => "activo"
        ]);
    }

    public function getAll()
    {
        return self::select(table: self::$table, columns: [
            "estado_registro" => "activo"
        ]);
    }

    public function getAllWithCats()
    {
        $query = "SELECT *
        FROM registros r
        JOIN categorias c ON r.id_categoria = c.id_categoria";

        $conn = self::getConn();
        $result = $conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Error fetching users: " . $conn->error);
        }
    }

}


?>