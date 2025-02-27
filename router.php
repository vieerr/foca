
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require_once "app/controllers/sessionController.php";
require_once "app/controllers/userController.php";
require_once "app/controllers/dashboardController.php";
require_once "app/controllers/profileController.php";
require_once "app/controllers/incomeController.php";

$incomeController = new IncomeController();
$profileController = new ProfileController();
$sessionController = new SessionController();
$userController = new UsuarioController();
$dashboardController = new DashboardController();

$page = isset($_GET["page"]) ? $_GET["page"] : "dashboard";
$route = isset($_GET["route"]) ? $_GET["route"] : "";
if (isset($_GET["route"])) {
    switch ($route) {
        case "login":
            $sessionController->login();
            break;
        case "logout":
            $sessionController->logout();
            break;
        case "get-users":
            $userController->fetchUsers();
            break;

        case "crear_usuario":
            require_once "app/controllers/UsuarioController.php";
            $controller = new UsuarioController();
            $controller->create();
            break;
        default:
            echo "404 Not Found";
            break;
    }
}

switch ($page) {
    case "dashboard":
        $dashboardController->index();
        exit();
        break;
    case "perfil":
        $profileController->index();
        exit();
        break;
    case "usuarios":
        $userController->index();
        exit();
        break;
    case "ingresos":
        $incomeController->index();
        exit();
        break;
    default:
        echo "404 Not Found";
        exit();
        break;
}


?>
