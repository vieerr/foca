<?php

include_once "app/models/RegistroModel.php";
class ExpenseController
{
    private $regModel;
    public function __construct()
    {
        $this->regModel = new Registro();
    }
    public function index()
    {
        require "app/views/gastos.php";
    }

    public function fetchAllExpense()
    {
        $expense = $this->regModel->getAllIncome();
        header("Content-Type: application/json");
        echo json_encode($expense);
        exit();
    }


}
?>