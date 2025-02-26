<?php
session_start();
// require_once "../models/AuthModel.php";
require_once "app/models/UserModel.php";
class UsuarioController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Usuario();
    }
    // public function create()
    // {
    //     error_reporting(E_ALL);
    //     ini_set("display_errors", 1);
    //     $autorizacion = new Autorizacion();
    //     $permissions = $autorizacion->getPermissionsByRole($_SESSION["id_rol"]);
    //     $user = new Usuario();

    //     if (!isset($_SESSION["id_usuario"])) {
    //         header("Location: index.php?page=login");
    //         exit();
    //     }

    //     $users = $user->getInfoUsers();

    //     if (empty($users)) {
    //     } else {
    //     }

    //     if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //         $nombre_usuario = trim($_POST["nombre_usuario"]);
    //         $apellido_usuario = trim($_POST["apellido_usuario"]);
    //         $username_usuario = trim($_POST["username_usuario"]);
    //         $password_plain = trim($_POST["password_plain"]);
    //         $id_rol = trim($_POST["id_rol"]);

    //         if (empty($username_usuario)) {
    //             $error = "El nombre del usuario es obligatorio.";
    //             require_once __DIR__ .
    //                 "/../views/crear_usuario/crear_usuario.php";
    //             return;
    //         }
    //         $result = $user->createUser(
    //             $nombre_usuario,
    //             $apellido_usuario,
    //             $username_usuario,
    //             $password_plain,
    //             $id_rol
    //         );

    //         if ($result) {
    //             header("Location: index.php?page=home");
    //             exit();
    //         } else {
    //             $error = "Error al crear el rol.";
    //             echo $error;
    //         }
    //     }
    //     require_once __DIR__ . "/../views/crear_usuario/crear_usuario.php";
    // }
    public function fetchUsers()
    {
        $users = $this->userModel->fetchAllUsers();
        header("Content-Type: application/json");
        echo json_encode($users);
        exit();
    }
}

?>
