<?php
require "../models/UserModel.php";
// FOR EXMAPLE ONLY -- NOT WORKING CURRENTLY:)
class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        require "../views/auth/login.php";
    }

    public function handleLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];
            header("Location: /dashboard");
        } else {
            $error = "Invalid username or password.";
            require "../views/auth/login.php";
        }
    }
}
?>
