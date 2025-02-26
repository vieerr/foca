<?php
// require '../models/TransactionModel.php';

class PerfilController
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

        require "../views/perfil.php";
    }
}

// Instantiate the controller and call the index method
$controller = new PerfilController();
$controller->index();
?>
