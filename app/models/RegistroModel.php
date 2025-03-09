<?php
require_once "Model.php";

class Registro extends Model
{

    public static $table = "registros";

    public function getAllIncome()
    {
        return self::select(table: self::$table, conditions: [
            "tipo_registro" => "ingreso",
            // "estado_registro" => "activo"
        ]);
    }

    public function getAllExpenses()
    {
        return self::select(table: self::$table, conditions: [
            "tipo_registro" => "egreso",
            // "estado_registro" => "activo"
        ]);
    }

    public function getAll()
    {
        return self::select(table: self::$table, columns: [
            "estado_registro" => "activo"
        ]);
    }

    public function editReg($id, $fields)
    {
        return self::update(table: self::$table, data: $fields, conditions: ["id_registro" => $id]);
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

    public function createReg($data)
    {
        return self::insert(self::$table, $data);
    }

    public function findOne($id)
    {
        return self::select(table: self::$table, conditions: ["id_registro" => $id]);
    }

}


?>