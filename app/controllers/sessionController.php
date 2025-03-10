<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "app/models/UserModel.php";
require_once "app/models/Model.php";
require_once "app/controllers/rolController.php";
class SessionController
{
    private $userModel;
    private $roleController;

    public function __construct()
    {
        $this->userModel = new Usuario();
        $this->roleController = new RolController();
    }

    public function login()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $this->userModel->getUserByUsername($username);

        // TODO - refactor, model shouldnt be used here
        if ($user && password_verify($password, $user["claveHash_usuario"])) {
            $_SESSION["user_id"] = $user["id_usuario"];
            $_SESSION["username"] = $user["username_usuario"];
            $_SESSION["role"] = $user["id_rol"];
            $_SESSION["name"] = $user["nombre_usuario"];
            $_SESSION["last_name"] = $user["apellido_usuario"];
            $_SESSION["role_name"] = $this->roleController->fetchRoleName($user["id_rol"]);
            $model = new Model();
            $model->setUsuarioActivo($user["id_usuario"]);
            $this->loggedIn();
            exit();
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid username or password.",
            ]);
            exit();
        }
    }
    public function loggedIn()
    {
        return header("Location: main.php");
    }

    public static function isAuth()
    {
        return isset($_SESSION["user_id"]);

    }

    public function isAdmin()
    {
        echo json_encode(isset($_SESSION["role"]) && $_SESSION["role"] == 1);
    }

    public function logout()
    {
        session_destroy();
        return header("Location: index.php");
    }
}


?>