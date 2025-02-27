
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "app/models/UserModel.php";
class SessionController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Usuario();
    }

    public function login()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user["claveHash_usuario"])) {
            $_SESSION["user_id"] = $user["id_usuario"];
            $_SESSION["username"] = $user["username_usuario"];
            $_SESSION["role"] = $user["id_rol"];
            $_SESSION["name"] = $user["nombre_usuario"];
            $_SESSION["last_name"] = $user["apellido_usuario"];

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

    public function logout()
    {
        session_destroy();
        echo json_encode(["success" => true, "redirect" => "/index.php"]);
        exit();
    }
}


?>
