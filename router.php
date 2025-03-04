<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

if (isset($_SESSION["user_id"])) {
    require_once "app/models/Model.php";
    Model::setUsuarioActivo($_SESSION["user_id"]);
}

require("config/includes/controllers.php");

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
            $permitController->fetchPermisos();
            break;
        case "get-roles":
            $rolController->fetchRoles();
            break;
        case "crear-rol":
            $rolController->crearRol();
            break;
        case "get-all-income":
            $incomeController->fetchAllIncome();
            break;
        case "get-all-expense":
            $expenseController->fetchAllExpense();
            break;
        case "get-all-regs":
            $regController->fetchAllRegs();
            break;
        case "edit-reg":
            $regController->updateReg();
            break;

        case "create-income":
            $incomeController->createIncome();
            break;
        case "get-all-regs-with-cats":
            $regController->fetchAllRegsWithCats();
            break;
        case "get-all-categories":
            $categoryController->fetchAllCategories();
            break;
        case "get-all-income-categories":
            $categoryController->fetchAllIncomeCategories();
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
        $auditController->index();
        exit();
    default:
        echo "404 Not Found";
        exit();
}


?>