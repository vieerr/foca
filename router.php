<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

if (isset($_SESSION["user_id"])) {
    require_once "app/models/Model.php";
    Model::setUsuarioActivo($_SESSION["user_id"]);
}

require("config/includes/controllers.php");

$page = isset($_GET["page"]) ? $_GET["page"] : "";
$route = isset($_GET["route"]) ? $_GET["route"] : "";
if (isset($_GET["route"])) {
    switch ($route) {
        case "login":
            $sessionController->login();
            break;
        case "logout":
            $sessionController->logout();
            break;
        case "is-admin":
            $sessionController->isAdmin();
            break;
        case "get-rol-perms":
            $authController->fetchRolPerms();
            break;
        case "get-all-audits":
            $auditController->fetchAllAudits();
            break;
        case "get-users":
            $userController->fetchUsers();
            break;
        case "crear-usuario":
            $userController->createUser();
            break;
        case "edit-user":
            $userController->updateUser();
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
        case "edit-rol":
            $rolController->editRol();
            break;
        case "get-one-expense":
            $expenseController->getOneExpense();
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
        case "create-expense":
            $expenseController->createExpense();
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
        case "get-all-expense-categories":
            $categoryController->fetchAllExpenseCategories();
            break;
        default:
            echo "404 Not Found";
            break;
    }
}

if (isset($_GET["page"])) {

    switch ($page) {
        case "dashboard":
            $dashboardController->index();
            break;
        case "perfil":
            $profileController->index();
            break;
        case "usuarios":
            $userController->index();
            break;
        case "ingresos":
            $incomeController->index();
            break;
        case "gastos":
            $expenseController->index();
            break;
        case "roles":
            $rolController->index();
            break;
        case "reportes":
            $reportController->index();
            break;
        case "auditorias":
            $auditController->index();
            break;
        default:
            echo "404 Not Found";
            break;
    }
}
?>