<?php
require_once "app/controllers/auth.php";
require_once "app/controllers/userController.php";

$page = isset($_GET["page"]) ? $_GET["page"] : "login";

switch ($page) {
    case "login":
        $controller = new AuthController();
        $controller->login();
        break;
    case "logout":
        $controller = new AuthController();
        $controller->logout();
        break;
    case "get-users":
        $controller = new UsuarioController();
        $controller->fetchUsers();
        break;

    // case "home":
    //     require_once "app/controllers/HomeController.php";
    //     $controller = new HomeController();
    //     $controller->index();
    //     break;
    // case "crear_rol":
    //     require_once "app/controllers/RoleController.php";
    //     $controller = new RoleController();
    //     $controller->create();
    //     break;
    case "crear_usuario":
        require_once "app/controllers/UsuarioController.php";
        $controller = new UsuarioController();
        $controller->create();
        break;
    default:
        echo "404 Not Found";
}
?>
