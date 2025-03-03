<?php

require_once "app/models/RegistroModel.php";
class IncomeController
{

    private $regModel;
    public function __construct()
    {
        $this->regModel = new Registro();
    }
    public function index()
    {
        require "app/views/ingresos.php";
    }

    public function fetchAllIncome()
    {
        $income = $this->regModel->getAllIncome();
        header("Content-Type: application/json");
        echo json_encode($income);
        exit();
    }

}
?>
