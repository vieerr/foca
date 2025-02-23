
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require $_SERVER["DOCUMENT_ROOT"] . "/foca" . "/app/models/UserModel.php";
session_start();

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user["claveHash_usuario"])) {
            $_SESSION["user_id"] = $user["id_usuario"];
            $_SESSION["username"] = $user["username_usuario"];
            $_SESSION["role"] = $user["id_rol"];
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
        return header("Location: ../../main.php");
    }

    public function logout()
    {
        session_destroy();
        echo json_encode(["success" => true, "redirect" => "/login"]);
        exit();
    }
}
$con = new AuthController();
$con->login();


?>
