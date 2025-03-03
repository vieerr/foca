<?php
require_once "app/models/UserModel.php";
require_once "app/models/RolModel.php";
class UsuarioController
{
    private $userModel;
    private $rolModel;

    public function __construct()
    {
        $this->userModel = new Usuario();
        $this->rolModel = new Rol();
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

    public function fetchRoles()
    {
        $users = $this->rolModel->getRoles();
        header("Content-Type: application/json");
        echo json_encode($users);
    
        // echo $users;
        exit();
    }

    public function createUser()
    {
        header('Content-Type: application/json');
        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $rol = trim($_POST['rol']);

        $result = $this->userModel->createUser($nombre, $apellido, $username, $password, $rol);
        if ($result) {
            echo json_encode(['success'=> true,'message'=> 'Usuario creado Exitosamente']);
            exit();
        }else{
            echo json_encode(['success'=> false,'message'=> 'Error al crear Usuario']);
            exit();
        }
    }
}

?>