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
    public function fetchAllIncomeCategories()
    {
        $res = $this->catModel->getAllIncomeCategories();
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }

    public function fetchAllExpenseCategories()
    {
        $res = $this->catModel->getAllExpenseCategories();
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }

    public function fetchCategoryByName($name)
    {
        $res = $this->catModel->getCategoryByName($name);
        header("Content-Type: application/json");
        echo json_encode($res);
        exit();
    }
    


}
?>