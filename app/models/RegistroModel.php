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
        return self::select(table: self::$table, conditions: [
            "tipo_registro" => "ingreso",
            "estado_registro" => "activo"
        ]);
    }

    public function getAllExpenses()
    {
        return self::select(table: self::$table, conditions: [
            "tipo_registro" => "egreso",
            "estado_registro" => "activo"
        ]);
    }

    public function getAll()
    {
        return self::select(table: self::$table, conditions: [
            "estado_registro" => "activo"
        ]);
    }

}


?>