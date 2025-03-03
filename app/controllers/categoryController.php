<?php

include_once "app/models/CategoriaModel.php";
class CategoryController
{
    private $catModel;
    public function __construct()
    {
        $this->catModel = new Categoria();
    }

    public function fetchAllCategories()
    {
        $res = $this->catModel->getAllCategories();
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }


}
?>