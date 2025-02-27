<?php
require_once "app/models/UserModel.php";
class UsuarioController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Usuario();
    }
    public function index()
    {
        require "app/views/usuarios.php";
    }

    public function fetchUsers()
    {
        $users = $this->userModel->fetchAllUsers();
        header("Content-Type: application/json");
        echo json_encode($users);
        exit();
    }
}

?>
