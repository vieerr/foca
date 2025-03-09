<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "app/models/UserModel.php";
require_once "app/models/Model.php";
require_once "app/controllers/rolController.php";
require_once "app/models/Auditorias.php";
class SessionController
{
    private $userModel;
    private $roleController;
    private $auditoryModel;

    public function __construct()
    {
        $this->userModel = new Usuario();
        $this->roleController = new RolController();
        $this->auditoryModel = new Auditorias();
    }

    public function logginAuditory()
    {
        $fecha_accion = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $data=[
            "accion" => "Inicio Sesion",
            "tabla_afectada" => "Sesiones",
            "id_usuario" => $_SESSION["user_id"],
            "fecha_hora" => $fecha_accion->format('Y-m-d H:i:s'),
            "detalles" => "Accede al sistema"
        ];
        $res = $this->auditoryModel->loginAudit($data);
        if (!$res) {
            error_log("Error al registrar la auditoría de inicio de sesión para el usuario " . $_SESSION["user_id"]);
        }
    }

    public function logOutAuditory()
    {
        $fecha_accion = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $data=[
            "accion" => "Cierra Sesion",
            "tabla_afectada" => "Sesiones",
            "id_usuario" => $_SESSION["user_id"],
            "fecha_hora" => $fecha_accion->format('Y-m-d H:i:s'),
            "detalles" => "Sale del sistema"
        ];
        $res = $this->auditoryModel->loginAudit($data);
        if (!$res) {
            error_log("Error al registrar la auditoría de inicio de sesión para el usuario " . $_SESSION["user_id"]);
        }
    }
    public function login()
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = $_POST["password"];

        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user["claveHash_usuario"])) {
            $_SESSION["user_id"] = $user["id_usuario"];
            $_SESSION["username"] = $user["username_usuario"];
            $_SESSION["role"] = $user["id_rol"];
            $_SESSION["name"] = $user["nombre_usuario"];
            $_SESSION["last_name"] = $user["apellido_usuario"];
            $_SESSION["role_name"] = $this->roleController->fetchRoleName($user["id_rol"]);

            $model = new Model();
            $model->setUsuarioActivo($user["id_usuario"]);
            $this->logginAuditory();
            $this->loggedIn();
            exit();
        } else {
            $_SESSION['login_error'] = "Usuario o contraseña incorrecta";
            header('Location: index.php');
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
        $this->logOutAuditory() ;
        session_destroy();
        return header("Location: index.php");
    }

}


?>