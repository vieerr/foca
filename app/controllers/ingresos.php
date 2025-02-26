<?php
// require '../models/TransactionModel.php';

class IngresosController
{
    // private $registerModel;

    public function __construct()
    {
        // $this->registerModel = new RegisterModel();
    }

    public function index()
    {
        // Fetch data from the model
        // $transactions = $this->transactionModel->getAll();

        require "../views/ingresos.php";
    }
}

// Instantiate the controller and call the index method
$controller = new IngresosController();
$controller->index();
?>
