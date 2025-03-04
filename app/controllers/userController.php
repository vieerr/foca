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
    //todo - improve data security (no post data)
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
            echo json_encode(['success' => true, 'message' => 'Usuario creado Exitosamente']);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear Usuario']);
            exit();
        }
    }


    public function updateUser()
    {
        $input = file_get_contents("php://input");
        parse_str($input, $data);
    
        
        $id = $data['id_usuario'] ?? null;
        if (!$id) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "ID is required"]);
            exit();
        }

        $allowedFields = [
            "username_usuario" => "username",
            "apellido_usuario" => "apellido",
            "claveHash_usuario" => "password",
            "estado_registro" => "estado",
            "nombre_usuario" => "nombre",
            "id_rol"=>"rol"
        ];
    
        
        $fields = [];
        foreach ($allowedFields as $dbField => $requestField) {
            if (isset($data[$requestField])) {
                $fields[$dbField] = $data[$requestField];
            }
        }
        if(isset($data['password'])){
            $fields['claveHash_usuario'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
    
        
        if (empty($fields)) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "No fields provided to update"]);
            exit();
        }
    
        
        $res = $this->userModel->editUser($id, $fields);
    
        
        if ($res) {
            header("Content-Type: application/json");
            echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
        } else {
            header("Content-Type: application/json");
            echo json_encode(["status" => "error", "message" => "Failed to update record"]);
        }
        exit();
    }

}

?>