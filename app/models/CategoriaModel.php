<?php
require_once "Model.php";

class Categoria extends Model
{

    public static $table = "categorias";
    public function getAllCategories()
    {
        return self::select(table: self::$table);
    }

    public function getAllIncomeCategories()
    {
        return self::select(table: self::$table, conditions: ["tipo_categoria" => "ingreso"]);
    }
    public function getCategoryByName($name)
    {
        return self::select(table: self::$table, conditions: ["nombre_categoria" => $name]);
    }

}


?>