<?php
require_once "Model.php";

class Categoria extends Model
{

    public static $table = "categorias";
    public function getAllCategories()
    {
        return self::select(table: self::$table);
    }

}


?>