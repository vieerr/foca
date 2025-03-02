
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

if (isset($_SESSION["user_id"])) {
    require_once "app/models/Model.php";
    Model::setUsuarioActivo($_SESSION["user_id"]);
}

require_once "app/controllers/sessionController.php";
require_once "app/controllers/userController.php";
require_once "app/controllers/dashboardController.php";
require_once "app/controllers/profileController.php";
require_once "app/controllers/incomeController.php";
require_once "app/controllers/rolController.php";
require_once "app/controllers/expenseController.php";
require_once "app/controllers/reportController.php";
require_once "app/controllers/auditoryController.php";

$incomeController = new IncomeController();
$profileController = new ProfileController();
$sessionController = new SessionController();
$userController = new UsuarioController();
$dashboardController = new DashboardController();
$rolController = new RolController();
$expenseController = new ExpenseController();
$reportController = new ReportController();
$auditoryController = new AuditoryController();
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

        case "crear-usuario":
            $userController->createUser();
            break;

        case "get-permisos":
            $rolController->fetchPermisos();
            break;
        
        case "get-roles":
            $userController->fetchRoles();
            break;

        case "crear-rol":
            $rolController->crearRol();
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
    case "perfil":
        $profileController->index();
        exit();
    case "usuarios":
        $userController->index();
        exit();
    case "ingresos":
        $incomeController->index();
        exit();
    case "gastos":
        $expenseController->index();
        exit();
    case "roles":
        $rolController->index();
        exit();
    case "reportes":
        $reportController->index();
        exit();
    case "auditorias":
        $auditoryController->index();
        exit();
    default:
        echo "404 Not Found";
        exit();
}


?>
